<div class="tk-dbprojectwrap">
    <div class="preloader-outer" wire:loading wire:target="updateSellerProposal">
        <div class="tk-preloader">
            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
        </div>
    </div>
    @if(!empty($proposal_detail))
        @php
            if(!empty($proposal_detail->proposalAuthor->image)){
                $image_path     = getProfileImageURL($proposal_detail->proposalAuthor->image, '50x50');
                $author_image   = !empty($image_path) ? 'storage/' . $image_path : '/images/default-user-50x50.png';
            }else{
                $author_image = 'images/default-user-50x50.png';
            }
            $status =  getTag( $proposal_detail->status);
        @endphp
        <div class="tk-projectsstatus_head">
            <div class="tk-projectsstatus_info">
                <figure class="tk-projectsstatus_img">
                <img src="{{ asset( $author_image) }}" alt="{{ $proposal_detail->proposalAuthor->full_name }}">
                </figure>
                <div class="tk-projectsstatus_name">
                    <span class="{{ $status['class'] }}">{{ $status['text'] }}</span>
                    <h5>{{ $proposal_detail->proposalAuthor->full_name }}</h5>
                </div>
            </div>
            <div class="tk-projectsstatus_budget">
                <strong>
                    <span>{{ getPriceFormat($currency_symbol, $proposal_detail->proposal_amount). ($proposal_detail->payout_type == 'hourly' ? '/hr' : '')   }}</span>
                    @if( $proposal_detail->payout_type != 'hourly' )
                        {{ __('project.total_project_budget') }}
                    @else
                        {{ __('proposal.hourly_proposed_hours', [ 'payment_mode' => $proposal_detail->payment_mode,'hours' => $hourly_proposed_hours ] ) }}   
                    @endif
                </strong>
                @if( $proposal_detail->status == 'hired' )
                    <div class="tk-projectsstatus_option">
                        <a href="javascript:;"><i class="icon-more-horizontal"></i></a>
                        <ul class="tk-contract-list"> 
                            @if( $userRole == 'buyer' )
                                <li>
                                    <a href="javascript:;" class="complete-contract" >{{__('proposal.complete_contract')}}</a>
                                </li>             
                            @elseif( $userRole == 'seller' )
                                <li>
                                    <a href="javascript:;" wire:click.prevent="showDisputePopup" >{{__('proposal.raise_dispute')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="preloader-outer" wire:loading wire:target="RaiseDisputeToAdmin">
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        @if( !empty($proposal_disputed) )
            <div class="tk-notify {{$dispute_class}} {{ $userRole == 'seller' ? 'mt-4' : '' }}">
                <div class="tk-notify_title">
                    <figure>
                        <img src="{{$status_icon}}" alt=""/>
                    </figure>
                    <div class="tk-notify-content">
                        <h5>{{$dispute_status_txt}}</h5>
                        <p>{{$dispute_desc_txt}}</p>
                    </div>
                </div>
                <div class="tk-btnholder">
                    <a id="tk_diputes_detail" class="tk-redbtn" href="{{route('dispute-detail',['id' => $dispute_id])}}">{{__('proposal.view_detail')}}</a>
                </div>
            </div>
        @endif

        @php
            $total_earned_amt  = $total_rem_amount = 0;
            if( !$proposal_detail->timecards->isEmpty() ){
                foreach( $proposal_detail->timecards as $single ){
                    if( $single->status == 'completed' ){
                        $total_earned_amt += $single->price;
                    }elseif( $single->status == 'queued' || $single->status == 'processing' ){
                        $total_rem_amount += $single->price;
                    }
                }
            }
        @endphp
        <div class="tk-project-wrapper tk-timecardwraper">
            <div class="tk-counterinfo {{ $userRole == 'seller' ? 'mt-4' : '' }}">
                <ul class="tk-counterinfo_list">
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_earned"><i class="icon-briefcase"></i></strong>
                            @if($userRole == 'buyer')
                                <span>{{ __('proposal.total_paid_amount') }}</span>
                            @else
                                <span>{{ __('proposal.total_earned_amount') }}</span>    
                            @endif
                        </div>
                        <h5> {{ getPriceFormat($currency_symbol, $total_earned_amt) }} </h5>
                    </li>
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_remaining"><i class="icon-dollar-sign"></i></strong>
                            <span>{{ __('proposal.rm_hourly_amount') }}</span>
                        </div>
                        <h5> {{ getPriceFormat($currency_symbol, $total_rem_amount) }} </h5>
                    </li>
                </ul>
            </div>
            @if( $userRole == 'seller' && $proposal_detail->status == 'hired' )
                <div class="tk-timecards">
                    <div class="tk-timecards_head">
                        <h5>{{ __('proposal.add_timecard' ) }}</h5>
                        <div class="tk-timecards_total">
                            <h6>{{ __('proposal.hours_served') }} :</h6>
                            <span>{{ !empty($proposal_detail->filteredTimecard->total_time) ? $proposal_detail->filteredTimecard->total_time :'00:00' }}</span>
                            <div class="tk-calendar tk-select" wire:ignore>
                                @if( !empty($date_intervals) )
                                    <select class="form-control tk-selectprice tk-hourly-interval">
                                        @foreach($date_intervals as $key => $single )
                                            <option value="{{ $key }}" selected="{{ $single['selected'] }}">{{ $single['value'] }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    <div class="tk-timeslot">
                        @if( $proposal_detail->payment_mode == 'daily' )  
                            <ul class="tk-today-timeslot"> 
                                <li>
                                    <span>{{ $hourly_time_slots[0]['format'] }}</span>
                                    <div class="tk-today-timepopup">
                                        <input type="text" class="form-control {{ (empty($proposal_detail->filteredTimecard) || $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled')  ? 'add-hourly-timecard' : 'tk_disbale_date' }}"  placeholder="{{ __('proposal.add_time') }}" data-working_time="{{  $hourly_time_slots[0]['time'] }}" data-time_format="{{  $hourly_time_slots[0]['format'] }}" value="{{ $hourly_time_slots[0]['time'] }}" readonly>
                                    </div>
                                </li>
                            </ul>
                        @elseif( $proposal_detail->payment_mode == 'weekly' )
                            <ul class="tk-timeslot_list">
                                @foreach($hourly_time_slots as $single)
                                    <li>
                                        <span>{{ $single['day'] }}</span>
                                        <input type="text" readonly class="form-control {{ (empty($proposal_detail->filteredTimecard) || $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled') && !$single['disabled']  ? 'add-hourly-timecard' : 'tk_disbale_date' }}" data-working_time="{{  $single['time'] }}" data-time_format="{{  $single['format'] }}" {{ $single['disabled'] ? 'disabled' : ''}} value="{{  $single['time'] }}"  placeholder="{{ __('proposal.add_time') }}">
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="tk-addtime-slot">
                                @foreach($hourly_time_slots as $single)
                                    <li class="{{ (!empty($single['time']) ? 'tk-added-time' : ( !$single['disabled']  ? 'tk-edit-time' : 'tk-disable-slot' ) )}}">
                                        <span>{{ $single['day'] }}</span>
                                        <em>{{ $single['format'] }}</em>
                                        @if( (empty($proposal_detail->filteredTimecard) || $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled') && !$single['disabled'] ) 
                                            <a href="javascript:;" class="add-hourly-timecard" data-working_time="{{  $single['time'] }}" data-time_format="{{  $single['format'] }}">
                                                {{ !empty($single['time']) ? $single['time'].' '. __('general.hours') : __('proposal.add_time') }}
                                                <i class="{{ !empty($single['time']) ? 'icon-edit-3' : 'icon-plus' }}"></i>
                                            </a>
                                        @elseif(!empty($single['time']))
                                            <a href="javascript:;">{{  $single['time'].' '. __('general.hours')  }}</a>
                                        @endif
                                    </li>
                                @endforeach  
                            </ul>       
                        @endif
                        @if( !empty($proposal_detail->filteredTimecard) && ( $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled') )
                            <div class="tk-timeslot_save">
                                <div class="tk-timeslot-btn">
                                    <span>{{ __('proposal.submit_activity_desc', [ 'payment_mode' => $proposal_detail->payment_mode ]) }} </span>
                                    <a href="javascript:;" onClick="timeCardConfirm({{ $proposal_detail->filteredTimecard->id }})" class="tk-btn-solid">{{ __('proposal.submit_activity_btn', [ 'payment_mode' => $proposal_detail->payment_mode ]) }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="tk-timecards">
                <div class="tk-timecards_head">
                    <h5>{{ __('proposal.timecard_activities') }}</h5>   
                    <div class="tk-timecards_total">
                        <h6>{{ __('proposal.hours_served') }}:</h6>
                        @php
                            $total_time = $hours = $minutes = 0;
                            if( !$proposal_detail->timecards->isEmpty() ){
                                foreach($proposal_detail->timecards as $timecard){
                                    $time = explode(':', $timecard->total_time);
                                    $hours      += $time[0];
                                    $minutes    += !empty($time[1]) ? $time[1]: 0;
                                }
                                $hours      += intdiv($minutes, 60);
                                $minutes    = ($minutes % 60);
                                $hours      = $hours < 10 ? '0'.$hours : $hours;
                                $minutes    = $minutes < 10 ? '0'.$minutes : $minutes;
                                $total_time = $hours.':'.$minutes;
                            }
                        @endphp
                        <span>{{ $total_time }}</span>
                    </div>
                </div>
                @if( !$proposal_detail->timecards->isEmpty() )
                    <ul class="tk-timecard" id="timecard-accordion">
                        <li class="tk-timecard_head">
                            <h6>{{ __('general.date') }}</h6>
                            <h6>{{ __('general.description') }}</h6>
                            <h6>{{ __('general.hours') }}</h6>
                        </li>
                        @foreach($proposal_detail->timecards as $timecard)    
                            @php
                                $status = getTag( $timecard->status );
                            @endphp 
                            <li>
                                <div class="tk-timecard_toggle tk-timecard_togglevtwo">
                                    <div class="d-block w-100" data-bs-toggle="collapse" data-bs-target="#timecard-{{ $timecard->id }}" aria-expanded="false">
                                        <span class="{{ $status['class'] }}">{{ $status['text'] }}</span> 
                                        <div class="tk-timecard_info tk-timecard_infovtwo">
                                            <p>{{ $timecard->title }}</p> 
                                            <h6>
                                                <em>Hours : <p>{{ $timecard->total_time }}</p>  </em>
                                            </h6>  
                                            <div class="tk-statusvtwo">
                                                <a href="javascript:void(0);"><i class="icon-chevron-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-timecard_title" data-bs-toggle="collapse" data-bs-target="#timecard-{{ $timecard->id }}" aria-expanded="false">
                                    <p>{{ $timecard->title }}</p>
                                    <div class="tk-timecard_info">
                                        <span class="{{ $status['class'] }}">{{ $status['text'] }}</span>
                                        <p>{{ $timecard->total_time }}</p>
                                        <a href="javascript:void(0);"><i class="icon-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="collapse tk-timecard-content" id="timecard-{{ $timecard->id }}" data-bs-parent="#timecard-accordion">
                                    <ul class="tk-timecard_list {{$timecard->status == 'completed' ? 'tk-timecard-aprroved' : ''}}">
                                        @foreach($timecard->timecardDetail as $detail)
                                            <li>
                                                <span data-label="{{ __('general.date') }}">{{ date($date_format, strtotime($detail->working_date)) }}</span>
                                                <span data-label="{{ __('general.description') }}">{!! nl2br($detail->description) !!}</span>
                                                <span data-label="{{ __('general.hours') }}">{{ $detail->working_time }}</span>
                                            </li>
                                        @endforeach 
                                        @if( $userRole == 'buyer' && $timecard->status == 'queued' && $proposal_detail->status == 'hired' )
                                            <li class="tk-timecard_btns">
                                                <a href="javascript:;"   wire:click.prevent="approveHourlyTimecard({{ $timecard->id }})" class="tk-approvebtn" >{{ __('general.approve') }}</a>
                                                <a href="javascript:;"   onClick="confirmDeclineTimecard({{$timecard->id}})" class="tk-declinebtn">{{ __('general.decline') }} </a>
                                                <span>{{ __('proposal.approve_timecard_desc') }}</span>
                                            </li>
                                        @elseif( $timecard->status == 'cancelled' )
                                            <li class="tk-statusview_alert">
                                            @if( $userRole == 'seller')<span><i class="icon-info"></i>{{ __('proposal.timecard_decline_desc') }}</span>@endif
                                                <p>{!! nl2br($timecard->decline_reason) !!} </p>
                                            </li>    
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach  
                    </ul>
                @endif    
            </div>
        </div>
    @endif

    <div wire:ignore.self class="modal fade tb-addonpopup tk-declinepopup" id="tk_decline_reason" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> {{ __('proposal.decline_timecard_heading') }} </h4>
                    <a href="javascript:;" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <textarea wire:model.defer="decline_reason" class="form-control  @error('decline_reason') tk-invalid @enderror"></textarea>
                    @error('decline_reason')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span> 
                        </div>
                    @enderror
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:;" wire:click.prevent="declineTimecard" class="tb-btn">{{__('proposal.decline_timecard_req')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tk-addonpopup" id="complete-contract-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div  class="modal-dialog tk-modaldialog" role="document">
            <div class="modal-content">
                <div class="tk-popuptitle">
                    <h4> {{ __('project.complete_contract') }} </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>

                <div class="modal-body">
                    <form class="tk-themeform">
                        <fieldset>
                            <div class="form-group">
                                <label class="tk-label tk-required">{{ __('project.rating_title') }}</label>
                                <input type="text" wire:model.defer="contractRatingTitle" class="form-control @error('contractRatingTitle') tk-invalid @enderror" placeholder="{{__('project.rating_title')}}" autocomplete="off">
                                @error('contractRatingTitle')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="tk-label">{{__('project.seller_rating')}}</label>
                                <div class="tk-my-ratingholder" wire:ignore>
                                    <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                        <li class='tk-star' data-value='1'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='2'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='3'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='4' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='5'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                    </ul>
                                </div>
                                @error('contractRating')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>    
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="tk-label">{{ __('project.add_feedback') }}</label>
                                <textarea class="form-control" wire:model.defer="contractRatingDesc" placeholder="{{ __('project.add_feedback') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="tk-savebtn tk-btnwrapper">
                                    <a href="javascript:void(0);" wire:click.prevent="completeContract" class="tb-btn">{{__('project.complete_without_review')}}</a>
                                    <a href="javascript:void(0);"  wire:click.prevent="completeContract(1)" class="tb-btn">{{__('project.complete_contract')}}</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tk-workinghours-popup" id="hourly-timecard-popup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
           <div class="tk-popup_title">
               <h5>{{ __('proposal.submit_working_hours') }} </h5>
               <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                   <i class="icon-x"></i>
               </a>
           </div>
            <div class="modal-body tk-popup-content">
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                        	<div class="form-group at-slots-timedate hourly-timecard-dateformat">
                        		<h4>{{$hourly_working_time_format}}</h4>
                        	</div>
                        	<div class="form-group">
                                <label class="tk-label">{{ __('proposal.enter_time') }}</label>
                                <div class="tk-placeholderholder">
                                    <input type="text" class="form-control tk-themeinput @error('hourly_working_time') tk-invalid @enderror" placeholder="00H : 00M"  id="timecard-working-time" >
                                </div> 
                                @error('hourly_working_time')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                        	</div>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <textarea name="Description" id="hourly_working_desc" placeholder="{{ __('proposal.add_description') }}" class="form-control tk-themeinput @error('hourly_working_desc') tk-invalid @enderror" required="required"></textarea>
                                </div>
                                @error('hourly_working_desc')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group tk-btnarea">
                                <button type="button" class="updateTimecard tk-btn-solid-lg">{{ __('proposal.save_activity') }}</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
          </div>
        </div>
    </div>

    @if( $userRole == 'seller' )
        <div wire:ignore.self class="modal fade" id="dispute_popup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="tk-popup_title">
                        <h4>{{__('disputes.create_refund_req')}}</h4>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body tk-popup-content">
                        <form class="tk-themeform">
                            <fieldset>
                                <div class="form-group">
                                    <h5>{{__('disputes.choose_issue')}}</h5>
                                    <div class="tk-disputelist">
                                        @if(!empty($disputeIssues))
                                            <ul class="tk-categoriesfilter">
                                                @foreach($disputeIssues as $key => $issue)
                                                    <li>
                                                        <div class="tk-form-checkbox">
                                                            <input class="form-check-input tk-form-check-input-sm" name="distpute-issue" wire:model.defer="dispute_issue" {{ $dispute_issue == $issue ? 'checked':'' }} type="radio" id="distpute-issue-{{$key}}" value="{{$issue}}" >
                                                            <label class="form-check-label" for="distpute-issue-{{$key}}"><span>{{$issue}}</span></label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @error('dispute_issue')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span>
                                                </div>
                                            @enderror
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="tk-label">{{__('disputes.add_dispute_detail')}}</label>
                                    <textarea wire:model.defer="dispute_detail" class="form-control @error('dispute_detail') tk-invalid @enderror" placeholder="{{__('disputes.dispute_placeholder')}}"></textarea>
                                    @error('dispute_detail')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="tk-termscondition">
                                        <div class="tk-checkterm">
                                            <div class="tk-form-checkbox">
                                                <input class="form-check-input tk-form-check-input-sm" wire:model.defer="agree_term_condtion" id="check-term-condition" type="checkbox">
                                                <label for="check-term-condition"><span>{{__('disputes.accept_agreement')}}</span></label>
                                            </div>
                                            <a href="javascript:void(0);">{!! __('disputes.terms_condition') !!} </a>
                                        </div>
                                        <a href="javascript:void(0);" class="tb-btn" wire:click.prevent="createDisputeRequest" >{{__('general.submit')}} <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                                    </div>
                                    @error('agree_term_condtion')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    @push('scripts')
        <script defer src="{{ asset('js/vendor/jquery.inputmask.bundle.js') }}"></script>
        <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
        <script>
            document.addEventListener('livewire:load', function () {

                $('#timecard-working-time').inputmask(
                    'datetime',{
                    mask: 'hH : sM',
                    placeholder: '00H : 00M',
                    greedy: false,
                    insertMode: false,
                    showMaskOnHover: false,
                });

                setTimeout(() => {

                    $('.tk-hourly-interval').select2({ 
                        allowClear: true,
                        minimumResultsForSearch: -1
                    });

                    $(document).on('change', '.tk-hourly-interval', function(event) {
                        let _this            = $(this);
                        let hourly_selected_time = _this.find(':selected').val();
                        @this.set('hourly_selected_time', hourly_selected_time);
                    });

                    iniliazeSelect2Scrollbar();

                }, 50);

                
                $(document).on('click', '.add-hourly-timecard', function(event) {
                    event.preventDefault();
                    let _this            = $(this);
                    let format              = _this.attr('data-time_format');
                    let working_time        = _this.attr('data-working_time');
                    $('#hourly_working_desc').val('');
                    @this.set('hourly_working_time_format', format, true);
                    if(working_time != ''){
                        $('#timecard-working-time').val(working_time); 
                    }else{
                        $('#timecard-working-time').val('');
                    }
                    $('.hourly-timecard-dateformat h4').text(format);
                    $('#hourly-timecard-popup').modal('show');
                });

                $(document).on('click', '.complete-contract', function(event) {
                    event.preventDefault();
                    $(".tk-contract-list").slideUp();
                    $('#complete-contract-popup').modal('show');
                });

                $(document).on('click', '.tk_stars li', function(){
                    let _this       = $(this);
                    let onStar      = parseInt(_this.data('value'), 10);
                    let stars       = _this.parent().children('li.tk-star');

                    for (let i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('active');
                    }

                    for (let i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('active');
                    }

                    @this.set('contractRating', onStar, true);
                });

                $(document).on('click', '.updateTimecard', function(event) {
                    let hourly_working_time = $('#timecard-working-time').val();
                    let hourly_working_desc = $('#hourly_working_desc').val();
                    hourly_working_time = hourly_working_time.replace('H', '');
                    hourly_working_time = hourly_working_time.replace('M', '');
                    @this.set('hourly_working_time', hourly_working_time, true);
                    @this.set('hourly_working_desc', hourly_working_desc, true);
                    @this.call('updateTimecard');
                   
                });

                window.addEventListener('show-decline-reason-modal', event => {
                    $('#tk_decline_reason').modal(event.detail.modal);
                });

                window.addEventListener('hide-timecardpopup', event => {
                    $('#hourly_working_desc').val('');
                    $('#hourly-timecard-popup').modal('hide');
                });

                window.addEventListener('contract-rating-modal', event => {
                    $('#complete-contract-popup').modal(event.detail.modal);
                });

                
                window.addEventListener('dispute-popup', event=>{
                    $(".tk-contract-list").stop().slideUp(0);
                    jQuery('#dispute_popup .text-danger').remove();
                    jQuery('#dispute_popup .tk-invalid').removeClass('tk-invalid');
                    $('#dispute_popup').modal(event.detail.modal);
                });
            });

            function timeCardConfirm( id ){
        
                let title           = '{{ __("general.confirm") }}';
                let content         = '{{ __("general.confirm_content") }}';
                let action          = 'timeCardConfirm';
                let type_color      = 'green';
                let btn_class      = 'success';
                ConfirmationBox({title, content, action, id,  type_color, btn_class})
            }

            function confirmDeclineTimecard(id ){
                @this.set('decline_timecard_id', id, true);
                $('#tk_decline_reason').modal('show');
            }

        </script>
    @endpush
</div>
