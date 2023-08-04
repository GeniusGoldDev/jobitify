<div class="tb-themeselect-wrapper">
    @if(!empty($categories_tree) && $categories_tree->count() > 0)
        <div class="tb-themeselect">
            <label class="tb-titleinput {{ $is_required ? 'tk-required':''}}">{{ $label_text }}</label>
            <div class="tb-select border-0 tk-selectv-two @error('project_location') tk-invalid @enderror">
                <span class="form-control tb-themeselect_value @if($has_error) tk-invalid @endif {{ $categoryId ? 'tk-selected' : '' }}">{{ $category_name }}</span>
            </div>
            <ul class="tb-categorytree-dropdown tb-themeselect_options">
                @foreach($categories_tree as $category)
                    <x-category-item :category="$category" />
                @endforeach
            </ul>
        </div>
    @endif
</div>

