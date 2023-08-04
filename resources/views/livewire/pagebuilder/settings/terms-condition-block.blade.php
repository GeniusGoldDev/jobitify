<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.page_content') }}</label>
                <textarea id="tk_editor_{{time()}}" class="form-control" name="page_content" placeholder="{{ __('pages.page_content') }}"></textarea>
            </div>
        </div>
    </fieldset>
</form>