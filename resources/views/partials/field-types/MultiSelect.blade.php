<div class="formplate">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p><small>{{ $instructions }}</small></p>
    @endif
    <div>
        <span class="fp-select">
            <select multiple id="{{ $fieldId }}" name="{{ $field }}">
                @foreach($options as $option)
                    <option value="{{ $option['value'] }}" {{ $option['selected'] }}>{{ $option['title']}}</option>
                @endforeach
            </select>
        </span>
    </div>
</div>