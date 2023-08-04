@if( $proposal_detail )
    <div class="tk-projectsactivity">
        <ul class="nav nav-tabs tk-nav-tabs {{ $userRole == 'buyer' ? 'm-0' : '' }}" id="myTab" role="tablist">
            <li>
                <button class="active" id="project-activity" data-bs-toggle="tab" data-bs-target="#activities" aria-controls="activities" aria-selected="true">
                    <i class="icon-folder"></i> {{ __('project.project_activity') }}
                </button>
            </li>
            <li>
                <button class="" id="project-invoice" data-bs-toggle="tab" data-bs-target="#invoices" aria-controls="invoices" aria-selected="false">
                    <i class="icon-file-text"></i>
                    {{ __('project.invoices') }}
                </button>
            </li>
        </ul>
        <div class="tab-content tk-project-type-content" id="myTabContent">
            <div class=" tab-pane fade show active" id="activities" role="tabpanel" aria-labelledby="project-activity">
                @if(!$project_activities->isEmpty())
                    <div class="tk-project-box">
                        <div class="tk-project-holder">
                            <div class="tk-conversation-holder">
                                <div class="tk-custom-scrollbar" id="{{$listIds[0]}}">
                                    <div class="tk-conversation-wrapper">
                                        @foreach($project_activities as $single)
                                            @php
                                               
                                                $total_attachments = 0;
                                                if( !empty($single->attachments) ){
                                                    $total_attachments = count(unserialize($single->attachments));
                                                }
                                                if(!empty($single->sender->image)){
                                                    $image_path     = getProfileImageURL($single->sender->image, '38x38');
                                                    $author_image   = !empty($image_path) ? 'storage/' . $image_path : '/images/default-user-38x38.png';

                                                }else{
                                                    $author_image = 'images/default-user-38x38.png';
                                                }
                                                $message_class = $profile_id == $single->sender_id ? 'tk-messages-sender' : 'tk-messages-reciver';
                                            @endphp
                                            <div class="tk-message-wrapper">
                                                <div class="{{$message_class}}">
                                                    <div class="tk-message">
                                                        <img src="{{ asset( $author_image) }}" alt="{{ $single->sender->full_name }}">
                                                        <div class="tk-message-content">
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
                @else     
                    <div class="tk-submitreview">
                        <figure>
                            <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                        </figure>
                        <h4>{{ __('general.no_record') }}</h4>
                    </div>
                @endif
                @if( $proposal_detail->status == 'hired' || $proposal_detail->status == 'rejected' )
                    <form class="tk-themeform tk-uploadfile-doc">
                        <fieldset>
                            <div class="tk-freelanerinfo form-group">
                                <h6>{{ __('project.upload_project_docs') }}</h6>
                                <div class="tk-upload-resume">
                                    @if(!empty($existingFiles))
                                        <ul class="tk-upload-list">
                                            @foreach($existingFiles as $key => $file)
                                                
                                                <li>
                                                    <div class="tk-uploaded-img">
                                                        <img src="{{ substr($file->getMimeType(), 0, 5) == 'image' ? $file->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $file->getClientOriginalName() }}">
                                                        <p>{{$file->getClientOriginalName()}}</p>
                                                    </div>
                                                    <a class="tk-remove" href="javascript:;" wire:click.prevent="removeFile('{{ $key }}')"><i class="icon-trash-2"></i></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div wire:loading wire:target="activity_files" class="text-center">
                                        <span >{{__('settings.uploading')}} </span>
                                    </div>
                                    <div class="tk-uploadphoto" wire:loading.remove wire:target="activity_files">
                                        <p>{{ __('project.project_docs_description') }}</p>
                                        <input type="file" wire:model.defer="activity_files" multiple id="activity_files" ><label for="activity_files">{{ __('project.click_here_to_upload') }}</label>
                                    </div>
                                </div>
                                @error('activity_files.*')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span> 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="tk-label">{{ __('project.add_comments') }}</label>
                                <textarea wire:loading.attr="disabled" wire:target="updateActivity" wire:model.defer="activity_description" class="form-control tk-themeinput @error('activity_description') tk-invalid @enderror"  placeholder="{{ __('project.enter_comments_here') }}"></textarea>
                                @error('activity_description')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group tk-form-btn">
                                <span>{{ __('general.click') }} <strong>“{{ __('general.send_now')}}”</strong> {{ __('project.button_to_upload_files') }}</span>
                                <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="updateActivity" class="tk-btn-solid">
                                    <span wire:loading wire:target="updateActivity"> {{__('general.sending')}} </span>
                                    <span wire:loading.remove wire:target="updateActivity">{{ __('general.send_now')}} </span>
                                </a>
                            </div>
                        </fieldset>
                    </form>
                @endif
            </div>
            <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="project-invoice">
                @if(!$invoices->isEmpty())
                    <div class="tk-proinvoices">
                        @php
                    
                            $invoice_columns = array(
                                __('general.date'),
                                __('general.title'),
                                __('general.amount'),
                            );

                            if(!$invoices->isEmpty() && $invoices[0]->TransactionDetail->transaction_type == 3){
                                $invoice_columns[] = __('general.hours');
                            } 

                            $invoice_columns[] = __('general.status'); 

                    @endphp
                    <table class="table tk-proinvoices_table">
                        <thead>
                            <tr>
                                @foreach($invoice_columns as $col)
                                    <th>{{ $col }}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="{{$listIds[1]}}">
                            @foreach($invoices as $single)
                                @php
                                        
                                $hours = 0;
                                if( $single->TransactionDetail->transaction_type == 1 ){

                                    $invoice_title = $single->TransactionDetail->InvoiceType->invoice_title;

                                }elseif( $single->TransactionDetail->transaction_type == 2 ){
                                    
                                    $invoice_title = $single->TransactionDetail->InvoiceType->project->invoice_title;

                                }elseif( $single->TransactionDetail->transaction_type == 3 ){
                                    $hours    = $single->TransactionDetail->InvoiceType->total_time;
                                    $invoice_title = $single->TransactionDetail->InvoiceType->invoice_title.' '.__('general.hourly_timecard') ;
                                } 
                                $status =  getTag( $single->status);
                                $amount = getPriceFormat($currency_symbol, $single->TransactionDetail->amount + $single->TransactionDetail->used_wallet_amt);
                            
                            @endphp
                                <tr>
                                    <td data-label="{{ __('general.date') }}" >{{ date( $date_format, strtotime( $single->created_at )) }}</td>
                                    <td data-label="{{ __('general.title') }}" ><p>{{ $invoice_title }}</p></td>
                                    <td data-label="{{ __('general.amount') }}">{{ $amount }}</td>
                                    @if( $single->TransactionDetail->transaction_type == 3 )
                                        <td data-label="{{ __('general.hours') }}">{{$hours}}</td>
                                    @endif
                                    <td data-label="{{ __('general.status') }}"><span class="{{ $status['class'] }}">{{ $status['text'] }}</span></td>
                                    <td data-label="{{__('general.actions')}}">
                                        <a href="{{route('invoice-detail', ['id' => $single->id]) }}" target="_blank">{{ __('project.view_invoices') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="tk-submitreview">
                    <figure>
                        <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                    </figure>
                    <h4>{{ __('general.no_record') }}</h4>
                </div>
            @endif
            </div>
        </div>
       
       
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
@else
    <div></div>    
@endif