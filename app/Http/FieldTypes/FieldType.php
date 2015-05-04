<?php namespace App\Http\FieldTypes;

class FieldType {

    protected $output = "";
    protected $currentSettings = [];
    private $namespace = false;

    public function config()
    {
        return $this->_config();
    }

    protected function _config() {
        return "\nERROR: Config method not defined.\n";
    }

    public function render($field, array $options = []) {
        return $this->_render($field, $options);
    }

    public function renderConfig($field, array $options = []) {
        $this->namespace = 'settings';
        return $this->_render($field, $options);
    }

    protected function _render($field, array $options = []) {
        return "\nERROR: Render method not defined.\n";
    }

    public function process(array $settings = []) {
        return $this->_process($settings);
    }

    protected function _process(array $settings = []) {
        return false;
    }

    protected function fillOptions($field, $options) {

        $fieldHuman = ucwords(str_replace(['_', '-', '"'], ' ', $field));

        if (empty($options['id'])) {
            $namespace = '';
            if ($this->namespace) {
                $namespace = ucwords(str_replace(['_', '-', '"'], ' ', $this->namespace));
                $namespace = str_replace(' ', '', $namespace);
            }
            $fieldId = str_replace(' ', '', $namespace.$fieldHuman);
        }

        if (empty($options['label'])) {
            $labelText = $fieldHuman;
        }
        else {
            if (!is_array($options['label'])) {
                $labelText = $options['label'];
            }
            else {
                $labelText = !empty($options['label']['text']) ? $options['label']['text'] : ucwords(str_replace(['_', '-'], ' ', $field));
            }
        }

        $instructions = !empty($options['instructions']) ? $options['instructions'] : null;

        if ($this->namespace) {
            $field = "{$this->namespace}[$field]";
        }

        return compact('field', 'fieldId', 'labelText', 'instructions');
    }
}