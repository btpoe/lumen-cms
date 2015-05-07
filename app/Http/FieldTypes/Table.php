<?php namespace App\Http\FieldTypes;

class Table extends FieldType {

    protected function _config() {

        $output  = "";
        $output .= $this->renderConfig('table_columns', [
            'title' => 'Table Options',
            'instructions' => 'Define the columns your table should have.',
            'add_row' => 'Add a column',
            'cols' => [
                [
                    'heading' => 'Column Heading',
                    'handle' => 'heading',
                    'type' => 'single-line'
                ],[
                    'heading' => 'Handle',
                    'handle' => 'handle',
                    'type' => 'single-line'
                ],[
                    'heading' => 'Width',
                    'handle' => 'width',
                    'type' => 'number',
                    'width' => 50
                ],[
                    'heading' => 'Type',
                    'handle' => 'type',
                    'type' => 'select'
                ]
            ]
        ]);
        $output .= $this->renderConfig('default_values', [
            'instructions' => 'Define the default values for the field.',
            'cols' => [
                [
                    'heading' => null,
                    'handle' => null,
                    'type' => 'single-line'
                ]
            ]
        ]);
        return $output;
    }

    protected function _render($field, array $params = []) {

        extract($this->fillOptions($field, $params));

        $output = '<div class="formplate" data-field-type="table">';
        $output .= "<label for=\"$fieldId\">$title</label>";
        if ($instructions) {
            $output .= "<p><small>$instructions</small></p>";
        }
        $output .= '<table><thead><tr>';

        foreach($cols as $col) {

            $col_width = $col['width'];
            $col_heading = $col['heading'];

            $output .= "<th>$col_heading</th>";
        }

        $output .= '</tr></thead><tbody><tr>';

        foreach($cols as $col) {

            extract($col, EXTR_PREFIX_ALL, 'col');

            $name =  "name=\"{$field}[0][$col_handle]\" data-namespace=\"$field\" data-field=\"$col_handle\"";

            $output .= "<td data-table-type=\"$col_type\" $col_width>";

            if ($col_type === 'checkbox') {
                $output .= "<input $name type=\"checkbox\" />";
            }
            else {
                $output .= "<textarea $name></textarea>";
            }

            $output .= '</td>';
        }

        $output .='</tr></tbody></table>';
        $output .= "<button class=\"add-row\"><i class=\"fa fa-plus\"></i> $addRow</button></div>";

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

    protected function fillOptions($field, $params) {

        $parentOptions = parent::fillOptions($field, $params);
        $cols = $params['cols'];
        foreach($cols as &$col) {
            $col['heading'] = !empty($col['heading']) ?
                $col['heading'] : ucwords(str_replace('_', ' ', $col['handle']));

            $col['width'] = !empty($col['width']) ?
                "width=\"{$col['width']}\"" : '';

            $col['type'] = !empty($col['type']) && in_array($col['type'], ['single-line', 'multi-line', 'number', 'checkbox']) ?
                $col['type'] : 'single-line';
        }
        $addRow = !empty($params['add_row']) ? $params['add_row'] : 'Add a row';
        return $parentOptions + compact('cols', 'addRow');
    }

}