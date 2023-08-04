<button {{ $attributes->merge(['type' => 'submit', 'class' => 'tk-btn-solid-lg']) }}>
    {{ $slot }}
</button>
