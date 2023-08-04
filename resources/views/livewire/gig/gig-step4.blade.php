<div class="row">
    @include('livewire.gig.gig-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_4">
            <div class="tk-project-box">
            <div class="tk-sectiontitle">
                    <h4>{{__('gig.faq')}}</h4>
                </div>
                <a class="tk-add-more" href="javascript:;" wire:click.prevent="addnewFaq">
                    <h6>{{ __('gig.add_faq')}} </h6>
                    <i class="icon-plus"></i>
                </a>
                @if( !empty($gig_faqs) )
                    @foreach($gig_faqs as $key => $single)
                        <div class="tk-attachments-hodler">
                            <div class="tk-attechment-wrapper">
                                <div class="tk-attechment-tittle">
                                    <h6 data-bs-toggle="collapse" data-bs-target="#faq-{{ $key }}" aria-expanded="{{ ($errors->has('gig_faqs.'.$key.'.question') || $errors->has('gig_faqs.'.$key.'.answer') ? 'true' : 'false') }}">{{ $single['question']}}</h6>
                                    <i class="icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $key }}" aria-expanded="{{ ($errors->has('gig_faqs.'.$key.'.question') || $errors->has('gig_faqs.'.$key.'.answer') ? 'true' : 'false') }}"></i>
                                </div>
                                <div id="faq-{{ $key }}" class="tk-collapse-sort-conetnt collapse {{ ($errors->has('gig_faqs.'.$key.'.question') || $errors->has('gig_faqs.'.$key.'.answer') ? 'show' : '') }}">
                                    <form class="tk-themeform @if($errors->any()) tk-form-error @endif">
                                        <fieldset>
                                            <div class="tk-themeform__wrap">
                                                <div class="form-group">
                                                    <label class="tk-label tk-required">{{__('gig.faq_question')}}</label>
                                                    <div class="tk-placeholderholder">
                                                        <input type="text" wire:model.defer="gig_faqs.{{$key}}.question"  class="form-control tk-themeinput {{ ($errors->has('gig_faqs.'.$key.'.question') ? ' is-invalid' : '') }}" required>
                                                    </div>
                                                    @if($errors->has('gig_faqs.'.$key.'.question'))
                                                        <div class="tk-errormsg">
                                                            <span> {{ $errors->first('gig_faqs.'.$key.'.question') }}</span>
                                                        </div> 
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="tk-label tk-required"> {{__('gig.faq_answer')}}  </label>
                                                    <div class="tk-placeholderholder">
                                                        <x-tinymce-input wire:model.defer="gig_faqs.{{$key}}.answer" placeholder="{{__('gig.faq_answer_placeholder')}}"/>
                                                    </div>
                                                    @if($errors->has('gig_faqs.'.$key.'.answer'))
                                                        <div class="tk-errormsg">
                                                            <span> {{ $errors->first('gig_faqs.'.$key.'.answer') }}</span>
                                                        </div> 
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <a class="tk-Remove-adon" href="javascript:;" wire:click.prevent="removeFaq({{ $key }})"><i class="icon-trash-2"></i><span>{{ __('gig.remove_faq')}}</span></a>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                <a href="javascript:;" wire:click.prevent="updateStep(3)" class="tk-btnline"><i class=" icon-chevron-left"></i>{{ __('gig.go_back') }}</a>
                    <a href="javascript:;" wire:click.prevent="update" class="tk-btn-solid-lg-lefticon">
                        @if(!empty($edit_id))
                            {{__('gig.update_gig')}}
                        @else
                            {{__('gig.create_gig')}}
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
