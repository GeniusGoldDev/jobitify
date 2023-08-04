@extends('layouts.admin.pagebuilder-app')
@section('content')
   <!-- MAIN START -->
   <main class="at-main"> 
       <button class="at-openmenu-btn"><i class="icon-menu"></i></button>
     <div class="at-pagebuilder-holder at-openmenu" >
       <aside class="at-asidenav">
           <div class="at-asidenav_list">
               <ul class="at-pagebuilder-tab nav " id="pills-tab">
                 <li>
                   <button class="at-nav-tabs active" data-bs-toggle="tab" data-bs-target="#blocks-tab" aria-selected="true"><i class="icon-grid"></i></button>
                 </li>
                 <li>
                   <button class="at-nav-tabs" data-bs-toggle="tab" id="block-settings-tab" data-bs-target="#block-settings" aria-selected="false"><i class="icon-settings"></i></button>
                 </li>
                 <li>
                   <button class="at-nav-tabs" data-bs-toggle="tab" id="block-style-tab" data-bs-target="#style-setting" aria-selected="false"><i class="icon-edit"></i></button>
                 </li>
               </ul>
           </div>
           <div id="at-sidebar-contents" class="at-sidebar-content mCustomScrollbar">  
               <div class="tab-content">
                   <div class="tab-pane fade show active" id="blocks-tab">
                       <div class="at-pagebuilder-navs">
                           <div class="at-pagebuilder-title">
                               <div class="at-inputicon">
                                   <input type="text" class="form-control search-element" placeholder="{{ __('pages.search_elements') }}">
                                   <i class="icon-search"></i>
                               </div>
                           </div>
                           @if( !empty($page_blocks) )
                           <div class="at-template-sections">
                               <div class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#general-blocks" aria-expanded="true">
                                   <strong>{{ __('pages.general') }}</strong> 
                               </div>
                               <div id="general-blocks" class="collapse show">
                                   <div class="at-components-content">
                                       <ul class="at-component-list">
                                           @foreach( $page_blocks as $key=> $single )
                                               <li draggable="true" ondragstart="dragStart(event)" id="{{ $key }}">
                                                   <div class="at-widget-component">
                                                       <img src="{{asset('pagebuilder/images/grip.png')}}" alt="">
                                                       <strong>{{ $single }}</strong>
                                                   </div>
                                               </li>
                                           @endforeach
                                       </ul>
                                   </div>
                               </div>
                           </div>
                           @endif
                       </div>
                   </div>
                   <livewire:page-builder.block-setting         :page_id='$page_id' :page_blocks='$page_blocks'  />
                   <livewire:page-builder.block-style-setting   :page_id='$page_id' :page_blocks='$page_blocks'  />
               </div>
           </div>
           <div class="at-asidenav_btn">
                <ul class="at-btns-holder">
                    <li>
                        <a href="{{ route('SitePages') }}" class="at-back-btn"><i class="icon-corner-down-left"></i> {{__('pages.back')}}</a>
                    </li>
                    <li>
                        <a href="{{ url($page_url) }}" target="_blank" ><i class="icon-monitor"></i> {{__('pages.view')}}</a>
                    </li>
                </ul>
                @if($page_status == 'draft')
                    <a href="javascript:;"  class="at-btn publish-page">{{__('pages.publish')}}</a>
                @endif
           </div>
       </aside>
       <div class="at-pagebuilder-right">
         <livewire:page-builder.page-render :page_id='$page_id' :page_blocks='$page_blocks' />
       </div>
     </div>
   </main>
   <!-- MAIN END -->
@endsection('content')
@push('scripts')
    <script>
        setTimeout(function() {
            $('.search-element').on('keyup',function() {
                let _this   = $(this);
                let searchVal = _this.val().toUpperCase();
                let data = _this.parents('.at-pagebuilder-title').next('.at-template-sections').find('li .at-widget-component strong');
                let i;
                for (i = 0; i < data.length; i++) {
                    txtValue = data[i].textContent || data[i].innerText;
                    if (txtValue.toUpperCase().indexOf(searchVal) > -1) {
                        data[i].parentElement.parentElement.style.display = "";
                    }else{
                        data[i].parentElement.parentElement.style.display = "none";
                    }
                }
            });

            $(document).on('click','.at-openmenu-btn', function(e){
                let _this = $(this);
                _this.siblings('.at-pagebuilder-holder').toggleClass('at-openmenu');
            });
        }, 500);
    </script>   
@endpush('scripts')