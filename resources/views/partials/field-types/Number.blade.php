<div class="formplate">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p><small>{{ $instructions }}</small></p>
    @endif
    <input type="number" id="{{ $fieldId }}" name="{{ $field }}" {{ $min }} {{ $max }} {{ $decimal }} {{ $value }} />
</div>