<main>
    <div class="preloader-outer" wire:loading wire:target="refundAction">
        <div class="tk-preloader">
            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
        </div>
    </div>
    @php
        $disputeStatus = getDisputeStatusTag($status);
    @endphp
    <section class="tk-main-section tk-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box tk-dispute-buyer">
                            <div class="tk-servicedetailtitle">
                                <ul class="tk-dispute-tags">
                                    <li>
                                        <span class="{{$disputeStatus['class']}}">{{$disputeStatus['text']}}</span>
                                    </li>
                                </ul>
                                <h5>{{ $dispute_title }}</h5>
                                <ul class="tk-blogviewdates tk-blogviewdatessm">
                                    <li><span><i class="icon-calendar"></i>{{__('disputes.dispute_created_date', ['date' => date( $date_format, strtotime( $dispute_created_at ))])}}</span></li>
                                    <li><span><i class="icon-tag"></i> {{__('disputes.reference_no', ['number' =>$dispute_id])}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <div class="tk-dispute">
                                <div class="tk-dispute_holder">
                                    <figure>
                                        <img src="{{asset($dispute_author_image)}}" alt="{{$dispute_author_name}}">
                                    </figure>
                                    <div class="tk-dispute_title">
                                        <h5>{{$dispute_author_name}}</h5>
                                        <span>{{$dispute_author_role}} <em>({{__('disputes.dispute_author')}})</em></span>
                                    </div>
                                </div>
                                <div class="tk-dispute_progress">
                                    <span><i class="icon-chevron-right"></i> </span>
                                </div>
                                <div class="tk-dispute_holder">
                                    <div class="tk-dispute_title">
                                        <h5>{{$disp_receiver_name}}</h5>
                                        <span class="text-right">{{$disp_receiver_role}}</span>
                                    </div>
                                    <figure>
                                        <img src="{{asset($disp_receiver_image)}}" alt="{{$disp_receiver_name}}">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <div class="tk-project-holder">
                                <div class="tk-project-title">
                                    <h4>{{$dispute_issue}}</h4>
                                </div>
                                <div class="tk-jobdescription">
                                    <p>{!! nl2br($dispute_detail) !!}</p>
                                </div>
                            </div>
                        </div>
                        @php
                            $show_chat = false;
                            if( !$chat->isEmpty() ||   $show_reply_box ){
                                $show_chat = true;
                            }
                        @endphp
                            @if( $show_chat )
                                <div class="tk-project-box">
                                    <div class="tk-project-holder">
                                            @if(! $chat->isEmpty())
                                                <div class="tk-project-title">
                                                    <h4>{{__('disputes.dispute_conversation')}}</h4>
                                                </div>
                                                <div class="tk-conversation-holder">
                                                    <div id="{{$chatId}}" class="tk-custom-scrollbar">
                                                        <div class="tk-conversation-wrapper">
                                                            @foreach($chat as $key => $message)
                                                                @php
                                                                    $image = $name = $role = '';
                                                                    if( !$message->userInfo->isEmpty ){
                                                                        $name = $message->userInfo->full_name;
                                                                        $role = $message->userInfo->role_id;

                                                                        if(!empty( $message->userInfo->image ) ){
                                                                            $image_path     = getProfileImageURL( $message->userInfo->image, '38x38');
                                                                            $image          = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                                                        } else {
                                                                            $image          = '/images/default-user-38x38.png';
                                                                        }
                                                                    }
                    
                                                                    $messageClass = $message->sender_id == $profile_id ? 'tk-messages-sender' : 'tk-messages-reciver';
                    
                                                                    $total_attachments = 0;
                    
                                                                    if( !empty($message->attachments) ){
                                                                        $attachement_data   = @unserialize($message->attachments);
                                                                        $total_attachments  = !empty($attachement_data) ? count($attachement_data) : 0;
                                                                    }
                                                                @endphp
                                                                <div class="tk-message-wrapper">
                                                                    <div class="{{$messageClass}}">
                                                                        <div class="tk-message">
                                                                            <img src="{{asset($image)}}" alt="{{$name}}">
                                                                            <div class="tk-message-content">
                                                                                <div class="tk-message-holder">
                                                                                    <p>{!! nl2br($message->message) !!}</p>
                                                                                    @if( $total_attachments > 0 )
                                                                                    <div class="tk-message-attechemets">
                                                                                        <span><img src="{{asset('images/file-preview.png')}}" alt="" />{{ __('project.attachments_to_download', ['total_count' => $total_attachments]) }}</span>
                                                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments({{ $message->id }})" >{{ __('project.download_files') }} </a>
                                                                                    </div>
                                                                                    @endif
                                                                                </div>
                                                                                <strong>{{ date($date_format, strtotime( $message->created_at )) }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        @if( !empty($message->replyMessages) )
                                                                            @foreach( $message->replyMessages as $reply )
                                                                                <div class="tk-message tk-message-adminreply">
                                                                                    @php   
                                                                                        $user_image = '/images/default-user-38x38.png';
                                                                                        if(!empty( $reply->userInfo->image ) ) {
                                                                                            $image_path = getProfileImageURL( $reply->userInfo->image, '38x38','terer');
                                                                                            $user_image = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                                                                        }
                                                                                    @endphp
                                                                                    <img src="{{asset($user_image)}}" alt="{{$reply->userInfo->full_name}}">
                                                                                    <div class="tk-message-content">
                                                                                        <div class="tk-message-holder">
                                                                                            <p>{!! nl2br($reply->message) !!}</p>
                                                                                        </div>
                                                                                        <strong>{{ date($date_format, strtotime( $reply->created_at )) }}</strong>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @if($show_reply_box)
                                            <div class="tk-conversation-reply">
                                                <h6>{{__('disputes.relpy_heading')}}</h6>
                                                <div class="tk-placeholderholder">
                                                    <textarea  wire:model.defer="reply_message" class="form-control tk-themeinput @error('reply_message') tk-invalid @enderror" placeholder="{{__('disputes.relpy_placeholder')}}" id="dispute_comment"></textarea>
                                                </div>
                                                @error('reply_message')
                                                    <div class="tk-errormsg">
                                                        <span>{{$message}}</span> 
                                                    </div>
                                                @enderror
                                                <div class="tk-replybtns">
                                                    <a href="javascript:void(0)" wire:click.prevent="refundAction('reply')" class="tk-btn-yellow-lg">{{__('disputes.post_reply')}} <i class="icon-chevron-right"></i></a>
                                                    @if($status == 'publish' && $resolved_by == 'seller' && $created_to == $profile_id)
                                                        <div class="tk-decline-btns">
                                                            <a href="javascript:void(0)" wire:click.prevent="refundAction('decline')" class="tk-btn tk-decline-btn">{{__('disputes.delined_refund')}}</a>
                                                            <a href="javascript:void(0)" wire:click.prevent="refundAction('refund')" class="tk-btn tk-allow-btn">{{__('disputes.allow_refund')}}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif                                                        
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">
                    <aside>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-ordersumery-content mt-0">
                                    <span>{{__('disputes.dispute_summary')}}</span>
                                    <ul class="tk-order-detail">
                                        @if( !empty($proposal_amount) )
                                            <li>
                                                <h6>{{__('proposal.total_project_budget')}}</h6>
                                                <span>{{getPriceFormat($currency_symbol,$proposal_amount).($payout_type == 'hourly' ? '/hr':'')}}</span>
                                            </li>
                                        @endif
                                        @if( !empty($gig_addons) )
                                            @foreach( $gig_addons as $single )
                                                <li>
                                                    <h6>{{ $single['title'] }}</h6>
                                                    <span>{{getPriceFormat($currency_symbol, $single['price'])}}</span>
                                                </li>
                                            @endforeach  
                                        @endif 
                                        @if( $payout_type == 'milestone' && !empty($milestones) )
                                            @foreach($milestones as $milestone)
                                                <li>
                                                    <h6>{{$milestone->title}}</h6>
                                                    <span>{{getPriceFormat($currency_symbol, $milestone->price)}}</span>
                                                </li>
                                            @endforeach
                                        @elseif( $payout_type == 'hourly' && !empty($timecards) )
                                            @foreach( $timecards as $timecard )
                                                <li>
                                                    <h6>{{$timecard->title}}</h6>
                                                    <span>{{getPriceFormat($currency_symbol, $timecard->price)}}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                        <li class="tk-total-amount">
                                            <h5>{{__('proposal.refund_amount_label')}}</h5>
                                            <span>{{ getPriceFormat($currency_symbol, $refund_amount) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-ordersumery-title">
                                    <h4>{{__('disputes.disputes_activities')}}</h4>
                                </div>
                                @if($showTimeLimitMsg)
                                    <div class="tk-ordersumery-content">
                                        <div class="tk-escrow">
                                            <i class="icon-alert-circle"></i>
                                            <span>{!! __('disputes.time_duration_limit_msg',['day_number' => $disputeAfterDays])!!}</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="tk-ordersumery-content">
                                    @if( !empty($dispute_log) )
                                    <ul class="tk-status-tabs">
                                        @php
                                            krsort($dispute_log);
                                        @endphp
                                        @foreach($dispute_log as $actionType => $log)
                                            @php   
                                                $log_desc = '';
                                                if($actionType == 0 ){
                                                    $log_desc = __('disputes.dispute_created_by');
                                                } elseif($actionType == 1){
                                                    $log_desc = __('disputes.dispute_declined_by');
                                                    
                                                } elseif($actionType == 2){
                                                    $log_desc = __('disputes.dispute_req_sent_to');
                                                    
                                                } elseif( $actionType == 3){
                                                    $log_desc = __('disputes.refund_approved_by');
                                                } elseif( $actionType == 4 ){
                                                    $log_desc = __('disputes.disp_resolved_in_favor');
                                                }
                                            @endphp
                                            <li>
                                                <div class="tk-status-tabs_content">
                                                    <h6>{{$log_desc}}&nbsp;<a href="javascript:void(0)"> “{{$log['username'].' ('.ucfirst( getRoleById( $log['role_id'] ) ).')'}}”</a></h6>
                                                    <span>{{date( $date_format, strtotime( $log['action_date'] ))}}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @if($showAcknowledgeBtn)                    
                                    <div class="tk-ordersumery-content">
                                        <div class="tk-acknowledge-admin">
                                            <button class="tk-btn-solid tk-decline-btn">{{__('disputes.acknowledge_to_admin')}}</button>
                                            <p>{{__('disputes.acknowledge_to_admin_desc')}}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.proposal-dispute-action', function(event) {
                let _this = $(this);
                let submit_title = _this.data('submit_title');
                if(submit_title){
                    $('#proposal-dispute-reply-btn').text(submit_title);
                }
                $('#reply-box .tb-refundform').css('display','block')
            });
            
            function initScroll(sectionId = ''){
                let targetSection = sectionId ? '#'+sectionId : ".tk-custom-scrollbar";
                let objDiv = document.querySelector(targetSection);
                if(objDiv){
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            }
            
            initScroll();
            window.addEventListener('initializeScrollbar', event=>{
                initScroll(event.detail.chatId)
            });

        });
    </script>
@endpush
