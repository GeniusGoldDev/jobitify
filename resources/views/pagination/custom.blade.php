@if ($paginator->hasPages())
    <div class="tk-pagiantion-holder">
        <div class="tk-pagination">
            <ul>
                @if ($paginator->onFirstPage())    
                    <li class="d-none">
                        <span class="icon-chevron-left"></span>
                    </li>
                @else
                    <li class="tk-prevpage">
                        <a href="javascript:;" wire:click="previousPage('page')">
                            <i class="icon-chevron-left"></i>
                        </a>
                    </li>
                @endif

                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        @if ($paginator->currentPage() == $i)
                            <span wire:key="paginator-page{{ $i }}" wire:click="gotoPage({{ $i }})">{{ $i }}</span>
                        @else
                            <a href="javascript:;" wire:key="paginator-page{{ $i }}" wire:click="gotoPage({{ $i }})">{{ $i }}</a>
                        @endif
                    </li>
                @endfor
            
                @if ($paginator->hasMorePages())    
                    <li class="tk-nextpage">
                        <a href="javascript:;" wire:click="nextPage('page')">
                            <i class="icon-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="d-none" >
                        <span class="icon-chevron-right"></span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif