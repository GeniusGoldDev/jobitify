@props(['skill'])

<li class="level-{{ $skill->depth }}">
    <input type="radio" value="{{ $skill->id }}" wire:model="parentId" id="skill-item-{{ $skill->id }}">
    <label for="skill-item-{{ $skill->id }}">{{ $skill->name }}</label>
</li>
@foreach($skill->children as $child)
    <x-admin.skill-item :skill="$child" />
@endforeach
