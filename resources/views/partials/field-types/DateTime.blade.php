<div class="form-group">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if (!empty($instructions))
        <p class="help-block">{{ $instructions }}</p>
    @endif
    <input class="form-control" type="text" id="{{ $fieldId }}" name="{{ $field }}" value="{{ $value }}" />
</div>
