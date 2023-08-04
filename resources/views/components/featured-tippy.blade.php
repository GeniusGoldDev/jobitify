<div class="tk-hastippy" x-data="{ open: false}">
    <span class="tk-featureditem" x-on:mouseover="open = true" x-on:mouseleave="open = false">
        <i class="icon icon-zap"></i>
    </span>
    <span class="tk-tippycontent" x-show="open" style="display: none;">
        {{__('settings.featured_project')}}
    </span>
</div>

