<div class="formplate">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p><small>{{ $instructions }}</small></p>
    @endif
    <input type="text" id="{{ $fieldId }}" name="{{ $field }}" value="{{ $value }}" {{ $placeholder }} {{ $maxlength }} />
</div>