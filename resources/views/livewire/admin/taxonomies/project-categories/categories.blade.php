<main class="tb-main">
    <div class ="row">
            @include('livewire.admin.taxonomies.project-categories.update')
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('category.text') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedCategories ? '' : 'd-none' }}" wire:click.prevent="deleteAllRecord">{{ __('general.delete_selected') }}</a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" class="form-control">
                                            @foreach($per_page_opt as $opt ){
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('category.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-db-categoriestable">
                @if(!empty($categories) && $categories->count() > 0)
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>
                                    <div class="tb-checkbox">
                                        <input id="checkAll" wire:model="selectAll"  type="checkbox">
                                        <label for="checkAll">{{ __('category.title') }}</label>
                                    </div>
                                </th>
                                <th>{{__('category.description')}}</th>
                                <th>{{__('general.status')}}</th>
                                <th>{{__('general.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $single)
                                <tr>
                                    <td data-label="{{ __('category.title') }}">
                                        <div class="tb-namewrapper">
                                            <div class="tb-checkbox">
                                                <input id="category_id{{ $single->id }}" wire:model="selectedCategories" value="{{ $single->id }}" type="checkbox">
                                                <label for="category_id{{ $single->id }}">
                                                    <span> 
                                                        @if(!empty($single->image))
                                                            @php 
                                                                $image_url  = ''; 
                                                                $image      = @unserialize($single->image);
                                                                if( $image == 'b:0;' || $image !== false ){
                                                                    $image_path     = $image['file_path'];
                                                                    $image_name     = $image['file_name'];
                                                                    $image_sizes    = !empty($image['sizes']) ? $image['sizes'] : null;
                                                                    $image_url      = !empty($image_sizes['40x40']) ? $image_sizes['40x40'] : $image_path;
                                                                }
                                                            @endphp
                                                            @if(!empty($image_url))
                                                                <img src="{{ asset('storage/'.$image_url) }}" alt="{{$image_name}}">
                                                            @endif
                                                        @endif

                                                        {!! $single->name !!}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="{{__('category.description')}}"><span>{!! $single->description !!}</span></td>
                                    <td data-label="{{__('general.status')}}">
                                        <em class="tk-project-tag tk-{{ $single->status == 'active' ? 'active' : 'disabled' }}">{{ $single->status }}</em>
                                    </td>
                                    <td data-label="{{__('general.actions')}}">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit({{ $single->id }})"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" wire:click.prevent="deleteRecord({{ $single->id }})" class="tb-delete"><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        {{ $categories->links('pagination.custom') }}  
                    @else
                        @include('admin.no-record')
                    @endif  
                </div>
            </div>
        </div>
    </div>
</main>
@push('styles')
    @vite([
        'public/common/css/combotree.css', 
    ])
@endpush
@push('scripts')
<script defer src="{{ asset('common/js/combotree.js')}}"></script>
    <script>
        var categoryInstance = null;
        document.addEventListener('livewire:load', function () {
            let title           = '{{ __("general.confirm") }}';
            let listenerName    = 'delete-category-confirm';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deleteConfirmRecord'; 
            confirmAlert({title,listenerName, content, action});

            window.addEventListener('initDropDown', function(event){
                let parentId = event.detail.parentId;
                if( event.detail.categories_tree.length ){
                    initDropDown(event.detail.categories_tree, parentId);
                }
            });

            if( window.categories_tree.length ){
                initDropDown(window.categories_tree);
            }

            function initDropDown(categories, parentId = null){

                $('input[id^="category_dropdown-"]').parent('.form-group').removeClass('d-none');
                if(categoryInstance != null){
                    categoryInstance.clearSelection();
                    categoryInstance.destroy();
                }

                let settings = {
                    source : categories,
                    isMultiple: false
                }

                if(parentId){
                    settings['selected'] = [parentId.toString()]
                }
                categoryInstance = $('input[id^="category_dropdown-"]').comboTree(settings);
            }

            $(document).on('change', 'input[id^="category_dropdown-"]', function(event){
                if(categoryInstance){
                    let id = categoryInstance.getSelectedIds();
                    if(id){
                        @this.set('parentId', id[0], true);
                    }
                }
            });
        });
    </script>
@endpush
