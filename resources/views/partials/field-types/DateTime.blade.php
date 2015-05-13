<div class="formplate">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if (!empty($instructions))
        <p><small>{{ $instructions }}</small></p>
    @endif
    <input type="text" id="{{ $fieldId }}" name="{{ $field }}" value="{{ $value }}" />
</div>