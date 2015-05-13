<div class="formplate">
    @foreach($options as $key => $option)
        <span class="fp-checkbox {{ $option['checked'] }}">
            <input id="{{ $fieldId.$key }}" type="checkbox" name="{{ $field }}[]" value="{{ $option['value'] }}" {{ $option['checked'] }} />
        </span>
        <label for="{{ $fieldId.$key }}">{{ $option['title'] }}</label>
    @endforeach
</div>
