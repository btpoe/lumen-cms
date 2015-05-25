<div class="form-group">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p class="help-block">{{ $instructions }}</p>
    @endif
    <input class="form-control" type="number" id="{{ $fieldId }}" name="{{ $field }}" {{ $min }} {{ $max }} {{ $decimal }} {{ $value }} />
</div>
