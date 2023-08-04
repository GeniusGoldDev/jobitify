<div class="col-lg-8 col-xl-9" wire:init="loadProjects">
    @if( !empty($isloadedPage) )
        <div class="row">
            <div class="col-lg-12">
                <div class="tk-section-holder" wire:loading.class="tk-section-preloader">
                    <div class="preloader-outer" wire:loading >
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                        @if(!$projects->isEmpty())
                            @foreach($projects as $single)
                                <x-project-item :favourite_projects="$favourite_projects" :project="$single" :user_role="$user_role" :currency_symbol="$currency_symbol" :list_type="'search_project'" :address_format="$address_format"/>
                            @endforeach
                        @else
                            <div class="tk-submitreview">
                                <figure>
                                    <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                                </figure>
                                <h4>{{ __('general.no_record') }}</h4>
                                @role('buyer')
                                    <a href="{{ route('create-project') }}" class="tk-btn-solid-lefticon"> {{ __('project.add_new_project') }} </a>
                                @endrole
                            </div>
                        @endif
                    
                </div>
            </div>
            @if( !$projects->isEmpty() )
                <div class="col-sm-12">
                    {{ $projects->links('pagination.custom') }}
                </div>
            @endif
        </div>
    @else
        <div class="tk-section-skeleton">
            @for($i=0; $i < 3; $i++ )
                <div class="tk-box">
                    <ul class="fixposition">
                        <li class="tk-line tk-skeletontwo"></li>
                    </ul>
                    <div class="tk-skeleton-left">
                        <div class="tk-right-sk">
                            <div class="tk-right-sk-right">
                                <div class="tk-skeltontop">
                                    <div>
                                        <ul>
                                            <li class="tk-line tk-skeletontwo"></li>
                                            <li class="tk-line tk-skeletonthree"></li>
                                        </ul>
                                        <div class="tk-righ-sk-last">
                                            <div class="tk-line tk-skeletonfour"></div>
                                            <div class="tk-line tk-skeletonfive"></div>
                                            <div class="tk-line tk-skeletonsix"></div>
                                            <div class="tk-line tk-skeletonsix"></div>
                                            <div class="tk-line tk-skeletonsix"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="tk-skeltonprice">
                                            <div class="tk-right-sk-end">
                                                <div class="tk-line tk-skeletonseven"></div>
                                                <div class="tk-line tk-skeletoneight"></div>
                                                <div class="tk-right-sk-end skeltonbtn">
                                                    <div class="tk-line tk-skeletonten"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-paraskelton">
                                    <div class="tk-line tk-skeletonfour tk-wskeletonfull"></div>
                                    <div class="tk-line tk-skeletonfour tk-wskeletonfull"></div>
                                </div>
                                <div class="tk-righ-sk-tags">
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    @endif
</div>
