<?php namespace App\CMS\FieldTypes;

class Table extends FieldType {

    protected function _config()
    {
        $output  = "";
        $output .= $this->render('cols', [
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
        $output .= $this->render('default_values', [
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

    protected function _process(array $settings = [])
    {
        return $settings;
    }

    public function validate($data, $settings)
    {
        return json_encode($data);
    }

    protected function fillOptions($field, $params)
    {
        $parentOptions = parent::fillOptions($field, $params);
        $cols = $params['cols'];
        foreach($cols as &$col) {
            $col['heading'] = !empty($col['heading']) ?
                $col['heading'] : ucwords(str_replace('_', ' ', $col['handle']));

            $col['width'] = !empty($col['width']) ?
                'width="' . $col['width'] . '"' : '';

            $col['type'] = !empty($col['type']) && in_array($col['type'], ['single-line', 'multi-line', 'number', 'checkbox']) ?
                $col['type'] : 'single-line';
        }
        $addRow = !empty($params['add_row']) ? $params['add_row'] : 'Add a row';
        return $parentOptions + compact('cols', 'addRow');
    }

}