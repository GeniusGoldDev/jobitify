@props(['errors'])

@if ($errors->any())
    <div class="tk-loginalert">
        <div class="tk-loginalert_error">
            <ul class="tk-loginalert_option">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
