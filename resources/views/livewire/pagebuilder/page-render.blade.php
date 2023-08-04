
<div wire:sortable="updateBlockOrder"  wire:sortable.options="{ animation: 250 }">
    @if( !empty($page_settings) )
        @foreach($page_settings as $key=> $single)
            <div wire:sortable.item="{{ $single['block_id'].'__'.$key }}" wire:key="{{ time().'__'.$key }}" class="at-drophere-selected">
                @livewire( 'page-builder.'.$single['block_id'], [ 
                'page_id'       => $page_id,
                'block_key'     => ($single['block_id'].'__'.$key),
                'settings'      => $single['settings'],
                'style_css'     => $single['css'],
                'site_view'     => false],
                key(time().'__'.$key) )
                <ul class="at-dargsection-toltip">
                    <li wire:sortable.handle>
                        <a href="javascript:;"><img src="{{asset('pagebuilder/images/grip-two.png')}}" alt=""></a>
                    </li>
                    <li wire:click.prevent="cloneBlock({{ $key }})">
                        <a href="javascript:;"><i class="icon-copy"></i></a>
                    </li>
                    <li wire:click.prevent="deleteBlock({{ $key }})">
                        <a href="javascript:;"><i class="icon-trash-2"></i></a>
                    </li>
                </ul>
            </div>
        @endforeach
    @endif
    <section wire:key="{{now()}}"  class="at-drophere-section">
        <div ondrop="dropOver(event)" ondragover="drapOver(event)" ondragleave="dragOut(event)" class="at-drophere-preview">
            <figure>
                <img src="{{asset('images/empty-block.png') }}" >
                <figcaption>{{ __('pages.drop_section_txt') }}</figcaption>
            </figure>
        </div>
    </section>
</div>   

@push('scripts')

    <script>

        function drapOver(event){

            event.preventDefault();
            $(event.target).addClass("at-dropover");
        }

        function dragStart(event) {
            event.dataTransfer.setData("id", event.target.id);
        }

        function dragOut(event){

            event.preventDefault();
            $(event.target).removeClass("at-dropover");
        }

        function dropOver(event) {

            event.preventDefault();
            let id = event.dataTransfer.getData("id");
            $(event.target).removeClass("at-dropover");
            if( id != "" ){
                @this.set('dropped_block_id', id);
            }
        }

        document.addEventListener('livewire:load', function () {

            $(document).on('click', '.at-drophere-selected', function(e) {
                $('.at-drophere-selected').removeClass('active');
                let _this = $(this);
                _this.addClass('active');
                let widow_width = $( window ).width();
                if( widow_width <= 1680 ){
                    $('.at-pagebuilder-holder').removeClass('at-openmenu');
                }
            });

            $(document).on('click', '.publish-page', function(e) {
                Livewire.emit('publish-page');
            });
            
        });
    
    </script>
@endpush
   