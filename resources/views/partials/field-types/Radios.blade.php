<div class="form-group">
    @foreach($options as $key => $option)
        <span class="fp-radio {{ $option['checked'] }}">
            <input type="radio" id="{{ $fieldId.$key }}" name="{{ $field }}" value="{{ $option['value'] }}" {{ $option['checked'] }} />
        </span>
        <label for="{{ $fieldId.$key }}">{{ $option['title'] }}</label>
    @endforeach
</div>