@foreach($options as $key => $option)
    <div class="radio">
        <label>
            <input type="radio" id="{{ $fieldId.$key }}" name="{{ $field }}" value="{{ $option['value'] }}" {{ $option['checked'] }} />
            {{ $option['title'] }}
        </label>
    </div>
@endforeach
