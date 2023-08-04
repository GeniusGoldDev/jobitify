<div class="row">
    @include('livewire.project.project-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-project-wrapper">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4> {{ __('project.freelancer_skills_title') }} </h4>
                </div>
                <div class="tk-themeform__wrap">
                    <div class="form-group form-group-half">
                        <label class="tk-label tk-required">{{ __('project.no_of_freelancer') }}</label>
                        <div class="@error('no_of_freelancer') tk-invalid  @enderror">
                            <div class="tk-select" wire:ignore>
                                <select id="no_of_freelancer" data-placeholderinput="{{ __('general.search') }}" data-placeholder="{{ __('project.no_of_freelancer_placeholder') }}" class="form-control">
                                    <option label="{{ __('project.no_of_freelancer_placeholder') }}"></option>
                                        @for($i= 1; $i <= $maximum_freelancer; $i++)
                                            <option value="{{ $i }}" {{ $i == $no_of_freelancer ? 'selected' : '' }} >{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        @error('no_of_freelancer')
                            <div class="tk-errormsg">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group form-group-half">
                        <label class="tk-label @if($req_expertlevel) tk-required @endif">{{ __('project.expert_level') }}</label>
                        <div class="@error('expertise_level') tk-invalid  @enderror">
                            <div class="tk-select" wire:ignore>
                                <select id="expertise_level" data-placeholderinput="{{ __('general.search') }}" data-placeholder="{{ __('project.expert_level_placeholder') }}" class="form-control">
                                    <option label="{{ __('project.expert_level_placeholder') }}"></option>
                                    @if(!$expertise_levels->isEmpty())
                                        @foreach($expertise_levels as $single)
                                            <option value="{{ $single->id }}" {{ $single->id == $expertise_level ? 'selected' : '' }} >{{ $single->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @error('expertise_level')
                            <div class="tk-errormsg">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="tk-label @if($req_skills) tk-required @endif">{{ __('project.skill_required') }}</label>
                        <div class="@error('project_skills') tk-invalid  @enderror">
                            <div class="tk-select" wire:ignore>
                                <select id="project_skills" data-placeholderinput="{{ __('general.search') }}" data-placeholder="{{ __('project.skill_required_placeholder') }}" class="form-control" multiple>
                                    <option label="{{ __('project.skill_required_placeholder') }}"></option>
                                    @if(!$skills->isEmpty())
                                        @foreach($skills as $single)
                                            <option value="{{ $single->id }}" {{ in_array($single->id, $project_skills) ? 'selected' : '' }} >{{ $single->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @error('project_skills')
                            <div class="tk-errormsg">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="tk-label @if($req_languages) tk-required @endif">{{ __('project.select_languages') }}</label>
                        <div class="@error('project_languages') tk-invalid  @enderror">
                            <div class="tk-select" wire:ignore>
                                <select id="project_languages"  data-placeholder="{{ __('project.select_languages_placeholder') }}" class="form-control" multiple>
                                    <option label="{{ __('project.select_languages_placeholder') }}"></option>
                                    @if(!$languages->isEmpty())
                                        @foreach($languages as $single)
                                            <option value="{{ $single->id }}" {{ in_array($single->id, $project_languages) ? 'selected' : '' }} >{{ $single->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @error('project_languages')
                            <div class="tk-errormsg">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep(2)" class="tk-btnline"><i class=" icon-chevron-left"></i>{{ __('project.go_back') }}</a>
                    <div class="tk-projectbtns-holder">
                        <a href="javascript:;" wire:click.prevent="update('draft')" class="tk-edit-project">
                            {{ __('project.save_draft') }}
                        </a>
                        <a href="javascript:;" wire:click.prevent="update" class="tk-btn-solid-lg-lefticon">
                        {{ __('project.save_continue') }}
                            <i class="icon-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
