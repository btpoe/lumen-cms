<div class="formplate" data-field-type="table">
    <label for="{{ $fieldId }}">{{ $title }}</label>
    @if ($instructions)
        <p><small>{{ $instructions }}</small></p>
    @endif
    <table>
        <thead>
            <tr>
                @foreach($cols as $col)
                    <th>{{ $col['heading'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($cols as $col)
                    <td data-table-type="{{ $col['type'] }}" {{ $col['width'] }}>
                        @if ($col['type'] === 'checkbox')
                            <input type="checkbox" name="{{ $field }}[0][{{ $col['handle'] }}]" data-namespace="{{ $field }}" data-field="{{ $col['handle'] }}" />
                        @else
                            <textarea name="{{ $field }}[0][{{ $col['handle'] }}]" data-namespace="{{ $field }}" data-field="{{ $col['handle'] }}"></textarea>
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <button class="add-row"><i class="fa fa-plus"></i> {{ $addRow }}</button>
</div>
