<?php namespace App\CMS\Services;

use App\CMS\Models\Field;
use Doctrine\Common\Inflector\Inflector;

class ModuleService {

    const MODEL_NAMESPACE = 'App\Http\Models';

    protected $manifest = [];

    protected $adminManifest = [];

    private $handle;
    private $module;

    public function getManifest()
    {
        return $this->manifest;
    }

    public function getModelName($withNamespace = false)
    {
        $prefix = $withNamespace ? $this::MODEL_NAMESPACE . '\\' : '';
        return $prefix . $this->manifest[$this->handle];
    }

    public function getModelInstance()
    {
        if (!empty($this->module)) {
            return $this->module;
        }
        return app($this->getModelName(true));
    }

    public function getModelSchema()
    {
        return $this->module->fillable;
    }

    public function getModelFields()
    {
        $schema = $this->getModelSchema();

        return Field::whereIn('handle', $schema)->get()
            ->sort(function($a, $b) use ($schema) {
                return array_search($a->handle, $schema) > array_search($b->handle, $schema) ? 1 : -1;
            });
    }

    public function getModuleTitle()
    {
        return Inflector::pluralize($this->getModelName());
    }

    public function getFacade() {
        return (object) [
            'handle' => $this->handle,
            'title' => $this->getModuleTitle(),
            'classname' => $this->getModelName()
        ];
    }

    public function newEntry()
    {
        $class = $this->getModelName(true);
        return new $class();
    }

    public function setModuleByHandle($handle)
    {
        $this->handle = $handle;
        $this->module = $this->getModelInstance();

        return $this;
    }
}