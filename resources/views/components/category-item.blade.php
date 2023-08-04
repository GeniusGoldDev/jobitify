@props(['category'])

<li class="level-{{ $category->depth }}">
    <input type="radio" value="{{ $category->id }}" wire:model.lazy="categoryId" id="category-item-{{ $category->id }}">
    <label for="category-item-{{ $category->id }}" class="tk-category-item-{{ $category->depth }}">{{ $category->name }}</label>
</li>

@foreach($category->children as $child)
    <x-category-item :category="$child" />
@endforeach
