<div class="form-group">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p class="help-block">{{ $instructions }}</p>
    @endif
    <input class="form-control" type="color" id="{{ $fieldId }}" name="{{ $field }}" value="{{ $value }}" />
</div>
