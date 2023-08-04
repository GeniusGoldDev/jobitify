<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <div class="tk-postproject-title">
            <h3>{{__('project.choose_template')}}</h3>
            <p>{{__('project.choose_template_desc')}}</p>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="tk-template-serach">
            <a href="javascript:;" wire:click.prevent="startProject"  class="tk-btnline"><i class=" icon-chevron-left"></i>{{__('project.go_back')}}</a>
            
            <div class="tk-select">
                <select wire:model="per_page" id="tk-select-perpage" class="form-control">
                    @foreach($per_page_opt as $opt )
                        <option value="{{$opt}}" @if($per_page == $opt) selected @endif >{{$opt}}</option>
                    @endforeach
                </select>
            </div>
            <div class="tk-inputicon">
                <input type="text" class="form-control" wire:model.debounce.500ms="searchProject" placeholder="{{__('general.search_with_keyword')}}">
                <i class="icon-search"></i>
            </div>
        </div>
       @if(!$projects->isEmpty())
            <ul class="tk-template-list">
                @foreach($projects as $single)
                    <li>
                        <div class="tk-template-list_content">
                            <span class="tk-project-tag-two {{ $single->project_type == 'fixed' ?  'tk-ongoing-updated' : 'tk-success-tag-updated' }}"> {{  $single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')   }} </span>
                            <div class="tk-template-info">
                                <h5>{{ $single->project_title }}</h5>
                                <ul class="tk-template-view">
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <span> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $single->updated_at)]) }} </span>
                                    </li>
                                    <li>
                                        <i class="icon-map-pin"></i>
                                        <span>{{ $single->projectLocation->id == 3 ? (!empty($single->address) ? getUserAddress($single->address, $address_format) : $single->project_country ) : $single->projectLocation->name }} </span>
                                    </li>
                                    <li>
                                        <i class="icon-briefcase"></i>
                                        <span> {{ !empty($single->expertiseLevel) ? $single->expertiseLevel->name : '' }} </span>
                                    </li>
                                    <li>
                                        <i class="{{ $single->project_hiring_seller > 1 ? 'icon-users' : 'icon-user' }}"></i>
                                        <span>{{ $single->project_hiring_seller .' '. ($single->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript:;" wire:click.prevent="cloneProject( {{ $single->id }} )" class="tk-btn-solid-lg-lefticon"> {{ __('project.use_project_template') }} </a>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $projects->links('pagination.custom') }}
        @else
            <div class="tk-submitreview">
                <figure>
                    <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                </figure>
                <h4>{{ __('general.no_record') }}</h4>
                <a href="{{ route('create-project') }}" class="tk-btn-solid-lefticon"> {{ __('project.add_new_project') }} </a>
            </div>
        @endif
    </div>
</div>
