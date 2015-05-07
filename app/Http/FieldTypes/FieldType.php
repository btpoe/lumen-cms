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

    public function render($field, array $params = []) {
        return $this->_render($field, $params);
    }

    public function renderConfig($field, array $params = []) {
//        $this->namespace = 'settings';
        return $this->_render($field, $params);
    }

    protected function _render($field, array $params = []) {
        return "\nERROR: Render method not defined.\n";
    }

    public function process(array $settings = []) {
        return $this->_process($settings);
    }

    protected function _process(array $settings = []) {
        return false;
    }

    protected function fillOptions($field, $params) {

        $fieldHuman = ucwords(str_replace(['_', '-', '"'], ' ', $field));

        if (empty($params['id'])) {
            $namespace = '';
            if ($this->namespace) {
                $namespace = ucwords(str_replace(['_', '-', '"'], ' ', $this->namespace));
                $namespace = str_replace(' ', '', $namespace);
            }
            $fieldId = str_replace(' ', '', $namespace.$fieldHuman);
        } else {
            $fieldId = $params['id'];
        }

        $title = !empty($params['title']) ? $params['title'] : $fieldHuman;

        $instructions = !empty($params['instructions']) ? $params['instructions'] : null;

        if ($this->namespace) {
            $field = "{$this->namespace}[$field]";
        }

        return compact('field', 'fieldId', 'title', 'instructions');
    }
}