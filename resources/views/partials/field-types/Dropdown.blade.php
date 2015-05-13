<div class="formplate">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p><small>{{ $instructions }}</small></p>
    @endif
    <select id="{{ $fieldId }}" name="{{ $field }}">
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" {{ $option['selected'] }}>{{ $option['title'] }}</option>
        @endforeach
    </select>
</div>
