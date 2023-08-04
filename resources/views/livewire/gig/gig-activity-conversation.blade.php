<div>
    @if( !$gig_activities->isEmpty() )
        <div class="tk-project-box">
            <div class="tk-project-holder">
                <div class="tk-conversation-holder">
                    <div class="tk-custom-scrollbar" id="{{$listIds[0]}}">
                        <div class="tk-conversation-wrapper">
                            @foreach($gig_activities as $single)
                                @php
                                    
                                    $total_attachments = 0;
                                    if(!empty($single->attachments)){
                                        $total_attachments = count(unserialize($single->attachments));
                                    }
                                    if(!empty($single->sender->image)){
                                        $image_url    = getProfileImageURL($single->sender->image, '38x38');
                                        $author_image   = !empty($image_url) ? 'storage/'.$image_url : 'images/default-user-38x38.png';
                                    }else{
                                        $author_image   = 'images/default-user-38x38.png';
                                    }
                                    $message_class = $profile_id == $single->sender_id ? 'tk-messages-sender' : 'tk-messages-reciver';
                                @endphp
                                <div class="tk-message-wrapper">
                                    <div class="{{$message_class}}">
                                        <div class="tk-message">
                                            <img src="{{ asset( $author_image) }}" alt="{{ $single->sender->full_name }}">
                                            <div class="tk-message-content">
                                                @if( $single->type == 'final' )
                                                    <div class="tb-statustag">
                                                        <span>
                                                            <i class="far fa-bell"></i>{{ __('gig.final_package') }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="tk-message-holder">
                                                    <p>{!! nl2br($single->description) !!}</p>
                                                    @if( $total_attachments > 0 )
                                                        <div class="tk-proactivity_file">
                                                            <img src="{{asset('images/file-preview.png') }}" alt="">
                                                            <span>{{ __('project.attachments_to_download', ['total_count' => $total_attachments]) }}</span>
                                                            <a href="javascript:;" wire:click.prevent="downloadAttachments({{ $single->id }})">{{ __('project.download_files') }} </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <strong>{{date('F j, Y, h:i a', strtotime($single->created_at) )}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            window.addEventListener('initializeScrollbar', event=>{
                initActivityScroll(event.detail[0])
                $(document).find('#'+event.detail[1]).mCustomScrollbar();
            });

            initActivityScroll();
            function initActivityScroll(sectionId = ''){
                let targetSection = sectionId ? "#"+sectionId : '.tk-custom-scrollbar';
                let objDiv = document.querySelector(targetSection);
                if(objDiv){
                    objDiv.scrollTop = objDiv.scrollHeight;
                }  
            }
        });
    </script>
@endpush