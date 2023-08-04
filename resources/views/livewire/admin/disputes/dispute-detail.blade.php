
@php   
    $seller = $buyer = '';
    $creator_role_id        = $dispute_data->disputeCreator->role_id;
    $disputeCreatorRole     = getRoleById($creator_role_id);
    $receiver_role_id       = $dispute_data->disputeReceiver->role_id;
    $disputeReceiverRole    = getRoleById($receiver_role_id);

    if( $disputeCreatorRole == 'seller' && $disputeReceiverRole == 'buyer'){
        $seller = $dispute_data->disputeCreator;
        $buyer  = $dispute_data->disputeReceiver;
    } else {
        $seller = $dispute_data->disputeReceiver;
        $buyer  = $dispute_data->disputeCreator;
    }
    $disputeStatus = getDisputeStatusTag($dispute_data->status);
    $initiateChatuser = $proposal_amount = $payout_type = $project_date = $project_title = '';
    $refund_amount = 0;
    $milestones = $timecards = array();
    
    if( !empty($dispute_data->proposal) ) {
        $proposal_amount = $dispute_data->proposal->proposal_amount;
        $payout_type = $dispute_data->proposal->payout_type;
            if($payout_type == 'milestone'){
                if(!$dispute_data->proposal->milestones->isEmpty())
                $milestones     = $dispute_data->proposal->milestones;
                $refund_amount = $dispute_data->proposal->milestones->sum('price');
            }elseif($payout_type == 'hourly'){
                if(!$dispute_data->proposal->timecards->isEmpty()){
                    $timecards      = $dispute_data->proposal->timecards;
                    $refund_amount = $dispute_data->proposal->timecards->sum('price');
                }
            } else {
                $refund_amount = $dispute_data->proposal->proposal_amount;
            }

        if( !empty($dispute_data->proposal->project) ){
            $project_date   = $dispute_data->proposal->project->updated_at;
            $project_title  = $dispute_data->proposal->project->project_title;
        }
    }else{
        $proposal_amount = $dispute_data->gigOrder->plan_amount; 
        $refund_amount  = $dispute_data->gigOrder->plan_amount; 
        $project_date   = $dispute_data->gigOrder->gig->updated_at;
        $project_title   = $dispute_data->gigOrder->gig->title;
    }
@endphp
<div class="tb-dbholder">
    <div class="tb-dbbox">
        <span class="{{$disputeStatus['class']}}">{{$disputeStatus['text']}}</span>
        <h5>{{$project_title}}</h5>
        <ul class="tb-infolist">
            <li>
                <span><i class="ti-calendar"></i>{{__('disputes.dispute_created_date', ['date' => date($date_format, strtotime($project_date))])}}</span>
            </li>
            <li>
                <span><i class="ti-tag"></i>{{__('disputes.reference_no', ['number' => $dispute_id])}}</span>
            </li>
        </ul>
    </div>
    <div class="tb-colapseable">
        <div class="tb-colapseableiten">
            <h5 type="button" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#demo">{{__('disputes.dispute_detail_heading')}} <i class="icon-chevron-right"></i> </h5>
            <div id="demo" class="collapse" wire:ignore.self>
                <div class="tb-dbbox">
                    <div class="tb-collapsetile">
                        <strong>{{$dispute_data->dispute_issue}}</strong>
                        <p>{!! nl2br($dispute_data->dispute_detail) !!}</p>
                    </div>
                    <div class="tb-disputesum">
                        <h6>{{__('disputes.dispute_summary')}}</h6>
                        <ul class="tl-summerylist">
                            <li>{{__('disputes.project_budget_lable')}}<span>{{ getPriceFormat($currency_symbol,$proposal_amount).($payout_type == 'hourly' ? '/hr' : '') }}</span></li>

                            @if($payout_type == 'milestone' && !empty($milestones))
                                @foreach($milestones as $milestone)
                                    <li>
                                        <h6>{{$milestone->title}}</h6>
                                        <span>{{getPriceFormat($currency_symbol, $milestone->price)}}</span>
                                    </li>
                                @endforeach
                            @elseif($payout_type == 'hourly' && !empty($timecards))
                                @foreach($timecards as $timecard)
                                    <li>
                                        <h6>{{$timecard->title}}</h6>
                                        <span>{{getPriceFormat($currency_symbol, $timecard->price)}}</span>
                                    </li>
                                @endforeach
                            @endif
                            
                            <li class="tb-sublisttotal">{{__('proposal.refund_amount_label')}} <span>{{ getPriceFormat($currency_symbol, $refund_amount) }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tb-colapseableiten">
            <h5 type="button" id="chat_collapse" data-chat_id="{{$chatId}}" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#convo">{{__('disputes.dispute_conversation')}} <i class="icon-chevron-right"></i> </h5>
            <div id="convo" class="collapse" wire:ignore.self>
                <div class="tb-dbbox">
                    @if(! $chat->isEmpty() )
                        <div id="{{$chatId}}" class="tk-conversation-holder">
                            @foreach($chat as $key => $message)
                                @php
                                    $total_attachments = 0;

                                    if(!empty($message->attachments)){
                                        $attachments        = @unserialize($message->attachments);
                                        $total_attachments  = !empty($attachments) ? count($attachments) : 0;
                                    }

                                    $chatInit = '';
                                    if($key == 0){
                                        $chatInit = $message->sender_id;
                                    }
                                    $name = $role = '';
                                    $user_img   = 'images/default-user-38x38.png';
                                    if( !$message->userInfo->isEmpty ){
                                        $name = $message->userInfo->full_name;
                                        $role = $message->userInfo->role_id;

                                        if(!empty($message->userInfo->image)){
                                            $image_path     = getProfileImageURL($message->userInfo->image, '38x38');
                                            $user_img   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                        }

                                    }
                                    $messageClass = $message->sender_id == $profile_id ? 'tk-messages-sender' : 'tk-messages-reciver';

                                @endphp
                                <div class="tk-message-wrapper">
                                    <div class="{{$messageClass}}">
                                        <div class="tk-message">
                                            <img src="{{asset($user_img)}}" alt="{{$name}}">
                                            <div class="tk-message-content">
                                                <div class="tk-message-holder">
                                                    <p>{!! nl2br($message->message) !!}</p>
                                                    @if( $total_attachments > 0 )
                                                    <div class="tk-message-attechemets">
                                                        <span><img src="{{asset('images/file-preview.png')}}" alt="" />{{ __('project.attachments_to_download', ['total_count' => $total_attachments]) }}</span>
                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments({{ $message->id }})">{{ __('project.download_files') }} </a>
                                                    </div>
                                                    @endif
                                                </div>
                                                <strong>
                                                    {{ date($date_format, strtotime( $message->created_at )) }}
                                                    @if($dispute_data->status == 'disputed')
                                                        <a href="javascript:void(0);" data-id="{{$message->id}}" class="reply-message">{{__('disputes.relpy_heading')}}</a>
                                                    @endif
                                                </strong>
                                            </div>
                                        </div>
                                        @if(!empty($message->replyMessages))
                                            @foreach($message->replyMessages as $reply)

                                            @php   
                                                $reply_total_attachments = 0;
                                                $user_img = 'images/default-user-38x38.png';
                                                if(!empty($reply->attachments)){
                                                    $reply_attachments          = @unserialize($reply->attachments);
                                                    $reply_total_attachments    = !empty($reply_attachments) ? count($reply_attachments) : 0;
                                                }

                                                if(!empty($reply->userInfo->image)){
                                                    $image_path     = getProfileImageURL($reply->userInfo->image, '38x38');
                                                    $user_img       = !empty($image_path) ? '/storage/' . $image_path : 'images/default-user-38x38.png';
                                                }
                                            @endphp
                                                <div class="tk-message tk-message-adminreply">
                                                    <img src="{{asset($user_img)}}" alt="{{$reply->userInfo->full_name}}">
                                                    <div class="tk-message-content">
                                                        <div class="tk-message-holder">
                                                            <p>{!! nl2br($reply->message) !!}</p>
                                                            @if( $reply_total_attachments > 0 )
                                                                <div class="tk-message-attechemets">
                                                                    <span><img src="{{asset('images/file-preview.png')}}" alt="" />{{ __('project.attachments_to_download', ['total_count' => $reply_total_attachments]) }}</span>
                                                                    <a href="javascript:;" wire:click.prevent="downloadAttachments({{ $reply->id }})">{{ __('project.download_files') }} </a>
                                                                </div>
                                                            @endif
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
                    @endif
                    @if($dispute_data->status == 'disputed')
                    <div class="tk-conversation-reply">
                        <h6>{{__('disputes.dispute_reply_text')}}</h6>
                        <div class="tk-placeholderholder">
                            <textarea wire:model.defer="message_text" id="reply-message-sec" class="form-control tk-themeinput @error('message_text') tk-invalid @enderror" placeholder="{{__('disputes.dispute_reply_placeholder')}}"></textarea>
                            @error('message_text') 
                                <div class="tk-errormsg">
                                    <span>{{$message}}</span> 
                                </div>
                            @enderror
                        </div>
                        <div class="tk-replybtns">
                            <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="sendMessage" class="tb-btn">
                                <b wire:loading wire:target="sendMessage"> {{__('general.sending')}} </b>
                                <b wire:loading.remove wire:target="sendMessage">{{ __('disputes.post_reply')}} </b>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="tb-colapseableiten">
            <h5 type="button" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#convoq" aria-expanded="true">{{__('disputes.dispute_resolution_label')}}<i class="icon-chevron-right"></i> </h5>
            <div id="convoq" wire:ignore.self class="collapse show">
                    <div class="tb-dbbox">
                        <form class="tb-themeform tb-loginform">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <ul class="tb-payoutmethod tb-disputetest">
                                            <li class="tb-radiobox {{ $dispute_data->status == 'refunded' ? 'tk-refunded-dispute':'' }} ">
                                                <input wire:model="favour_to" type="radio" id="{{getRoleById($buyer->role_id)}}" {{ $favour_to == 'buyer' ? 'checked' : '' }} value="buyer">
                                                <div class="tb-radiodispute">
                                                    <div class="tb-radio">
                                                        <label for="{{getRoleById($buyer->role_id)}}" class="tb-radiolist payoutlists">
                                                            <span class="tb-wininginfomain">
                                                                @php
                                                                    $buyer_img   = 'images/default-user-50x50.png';
                                                                    if(!empty($buyer->image)){
                                                                        $image_path     = getProfileImageURL($buyer->image, '50x50');
                                                                        $buyer_img   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                                                    }
                                                                @endphp
                                                                <img src="{{asset($buyer_img)}}" alt="{{$buyer->full_name}}">
                                                                <span class="tb-wininginfo">
                                                                    <i>{{$buyer->full_name}}</i>
                                                                    <em>{{getRoleById($buyer->role_id)}}</em>
                                                                </span>
                                                                @if($dispute_data->favour_to == 'buyer')
                                                                    <figure>
                                                                        <img src="{{asset('admin/images/disputes/img-1.png')}}" alt="" >
                                                                    </figure>
                                                                @endif
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="tb-radiobox {{ $dispute_data->status == 'refunded' ? 'tk-refunded-dispute':'' }}">
                                                <input type="radio" wire:model="favour_to" id="{{getRoleById($seller->role_id)}}" {{ $favour_to == 'seller' ? 'checked' : '' }} value="seller">
                                                <div class="tb-radiodispute">
                                                    <div class="tb-radio">
                                                        <label for="{{getRoleById($seller->role_id)}}" class="tb-radiolist payoutlists">
                                                            <span class="tb-wininginfomain">
                                                                @php
                                                                    $seller_image   = 'images/default-user-50x50.png';
                                                                    if(!empty($seller->image)){
                                                                        $image_path     = getProfileImageURL($seller->image, '50x50');
                                                                        $seller_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';
                                                                    }
                                                                @endphp
                                                                <img src="{{asset($seller_image)}}" alt="{{$seller->full_name}}">
                                                                <span class="tb-wininginfo">
                                                                    <i>{{$seller->full_name}}</i>
                                                                    <em>{{getRoleById($seller->role_id)}}</em>
                                                                </span>
                                                                @if($dispute_data->favour_to == 'seller')
                                                                    <figure>
                                                                        <img src="{{asset('admin/images/disputes/img-1.png')}}" alt="" >
                                                                    </figure>
                                                                @endif
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        @error('favour_to')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}<span>
                                            </div>
                                        @enderror
                                        @if($dispute_data->status == 'refunded')
                                        <div class="tb-resolved tb-disputed">
                                            <div class="tb-radiodispute">
                                                <div class="tb-radiolist payoutlists">
                                                    <span class="tb-wininginfomain">
                                                        <span class="tb-wininginfo tb-greencheck">
                                                            <span class="fas fa-check"></span>
                                                            <i>{{__('disputes.resolved_dispute_labled')}}</i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @if($dispute_data->status == 'disputed')
                                        <div class="form-group">
                                            <label class="tb-label">{{__('disputes.dispute_reply')}}</label>
                                            <textarea class="form-control @error('feedback') tk-invalid @enderror" wire:model.defer="feedback" placeholder="{{__('disputes.relpy_placeholder')}}"></textarea>
                                            @error('feedback')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}<span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group tb-email-wrapper">
                                            <label class="tb-label">{{__('disputes.upload_photo')}}</label>
                                            <div class="tb-uploadarea tb-uploadbartwo">
                                                
                                                <em>{{ __('category.image_option',['extension'=> $allowFileExt, 'size'=> $allowFileSize.'MB']) }}
                                                    <label for="attachment_files">
                                                        <span>
                                                            <input id="attachment_files" wire:model.defer="attachment_files" multiple  type="file">
                                                            {{ __('category.click_here_to_upload') }}
                                                        </span>
                                                    </label>
                                                </em>
                                                <li wire:loading wire:target="attachment_files" style="display: none" class="tb-uploading">
                                                    <span>{{ __('settings.uploading') }}</span>
                                                </li>
                                                @if(!empty($existingFiles))
                                                    @foreach($existingFiles as $key => $file)
                                                        <div class="tb-uploadel tb-upload-two">
                                                            <img src="{{ substr($file->getMimeType(), 0, 5) == 'image' ? $file->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $file->getClientOriginalName() }}">
                                                            <span>{{$file->getClientOriginalName()}} <a href="javascript:void(0);" wire:click.prevent="removeFile('{{ $key }}')"> <i class="ti-trash"></i></a> </span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            @error('attachment_files.*')
                                                <div class="tk-errormsg">
                                                   <span>{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group tb-disputebtn">
                                            <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="resolveDispute" class="tb-btn">
                                                <b wire:loading wire:target="resolveDispute"> {{__('general.sending')}} </b>
                                                <b wire:loading.remove wire:target="resolveDispute">{{ __('general.send_now')}} </b>
                                            </a>
                                            <em>{{__('disputes.feedback_btn_desc')}}</em>
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.reply-message', function(event) {
                let _this   = jQuery(this);
                let id      = _this.data('id');
                if(id){
                    @this.set('reply_message_id', id, true);
                    let target = $('#reply-message-sec');
                    target.focus();
                    target.addClass('tk-invalid').delay(1000).queue(function(next){
                        $(this).removeClass('tk-invalid');
                        next();
                    });
                }
            });
            
            jQuery(document).on('click', '#chat_collapse', function(e){
                let _this   = jQuery(this);
                let chatId  = _this.data('chat_id');
                if(chatId.length){
                    initScroll(chatId)
                }
            });

            function initScroll(sectionId = ''){
                let targetSection = sectionId ? '#'+sectionId : ".tk-conversation-holder";
                $(targetSection).mCustomScrollbar({}).mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
            }

            window.addEventListener('initializeScrollbar', event=>{
                initScroll(event.detail.chatId)
            });
        })
    </script>
@endpush