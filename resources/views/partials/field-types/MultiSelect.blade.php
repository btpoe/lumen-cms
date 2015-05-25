<div class="form-group">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p class="help-block">{{ $instructions }}</p>
    @endif
    <select class="form-control" multiple id="{{ $fieldId }}" name="{{ $field }}">
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" {{ $option['selected'] }}>{{ $option['title']}}</option>
        @endforeach
    </select>
</div>
