<div class="container {{ $block_key }} {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif>
    @if( !empty($style_css) )
        <style>{{ '.'.$block_key.$style_css }}</style>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-10">
        <div class="tk-question-section">
            @if(!empty($sub_title) || !empty($title) || !empty($description))
                <div class="tk-faq-search_title">
                    @if( !empty($sub_title) )<h5>{!! $sub_title !!}</h5>@endif
                    @if( !empty($title) )<h2>{!! $title !!}</h2>@endif
                    @if( !empty($description) )
                        <div class="tk-question_desc">
                            <p>{!! $description !!}</p>
                        </div>
                    @endif
                </div>
            @endif
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#submitquestion" class="tk-btn-solid-lg tk-btn-yellow">{!! $submit_btn_txt !!} <i class="icon-edit-3"></i> </a>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade tk-submitquestion " id="submitquestion" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="tk-popup_title">
            <h5>{{__('pages.submit_question_title')}}</h5>
            <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                <i class="icon-x"></i>
            </a>
        </div>

            <div class="modal-body tk-popup-content">
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap tk-themeform__wrapv2">
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required">{{__('pages.full_name_label')}}</label>
                                    <input type="text" wire:model.defer="full_name" placeholder="{{__('pages.full_name_plc_hldr')}}" class="form-control tk-themeinput @error('full_name') tk-invalid @enderror">
                                    @error('full_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required">{{__('pages.email_label')}}</label>
                                    <input type="email" wire:model.defer="email" placeholder="{{__('pages.email_plc_hldr')}}" class="form-control tk-themeinput @error('email') tk-invalid @enderror">
                                    @error('email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required">{{__('pages.question_subject_label')}}</label>
                                    <input type="text" wire:model.defer="question" placeholder="{{__('pages.question_subj_plc_hldr')}}" class="form-control tk-themeinput @error('question') tk-invalid @enderror">
                                    @error('question')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required">{{__('pages.desc_label')}}</label>
                                    <textarea wire:model.defer="question_desc" placeholder="{{__('pages.desc_plc_hldr')}}" class="form-control tk-themeinput @error('question_desc') tk-invalid @enderror"></textarea>
                                    @error('question_desc')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tk-popup-terms form-group">
                                <div class="tk-form-checkbox">
                                    <input wire:model.defer="accept_terms_cond" class="form-check-input form-check-input-lg" type="checkbox" value="" id="tk-check">
                                    <label class="form-check-label tk-required" for="tk-check">
                                    <span> {{__('pages.agreement_desc')}} <a href="#">{!! __('pages.terms_condition') !!}</a></span>
                                    </label>
                                </div>
                                @error('accept_terms_cond')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                                <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="sendQuestiontest" class="tk-btn-solid-lg">
                                    <span class="tk-waiting" wire:loading wire:target="sendQuestiontest"> {{__('general.waiting')}} </span>
                                    <span wire:loading.remove wire:target="sendQuestiontest">{{ __('pages.submit_question') }} <i class="icon-arrow-right"></i> </span>
                                </a>
                            </div>
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
            window.addEventListener('submitquestion-modal', event => {
                $('#submitquestion').modal(event.detail.modal);
            });
        });
    </script>
@endpush
