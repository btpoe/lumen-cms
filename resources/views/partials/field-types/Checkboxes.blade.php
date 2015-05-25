@foreach($options as $key => $option)
    <div class="checkbox">
        <label>
            <input id="{{ $fieldId.$key }}" type="checkbox" name="{{ $field }}[]" value="{{ $option['value'] }}" {{ $option['checked'] }} />
            {{ $option['title'] }}
        </label>
    </div>
@endforeach
