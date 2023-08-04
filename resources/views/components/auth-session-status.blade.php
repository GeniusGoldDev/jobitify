@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'tk-verifyemail_alert']) }}>
        {{ $status }}
    </div>
@endif
