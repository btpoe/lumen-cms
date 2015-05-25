<?php namespace App\CMS\Services;

use \Schema;

class DynamicService {

    protected $modelClassName = 'App\CMS\Http\Model';

    protected $modelInstance;

    protected $tablePrefix = '';

    protected $constantFields = [];

    public function __construct() {

        $this->$modelInstance = app($this->modelClassName);
    }
    
    /**
     * Generate Table
     * @param mixed $modelData
     * @param mixed $oldSchema
     * @return bool
     */
    public function generateTable($modelData, $oldSchema = false) {

        if (is_string($modelData) || is_int($modelData)) {
            $modelData = $this->$modelInstance->find($modelData);
        }

        $modelTable = $this->tablePrefix.$modelData->handle;
        $oldTable = $this->tablePrefix.$oldSchema['handle'];

        if ($oldSchema) {
            if ($modelTable !== $oldTable && Schema::hasTable($oldTable)) {
                Schema::rename($oldTable, $modelTable);
            }
        }

        if (Schema::hasTable($modelTable)) {

            Schema::table($modelTable, function($table) use ($modelTable, $modelData)
            {
                foreach($modelData->fields()->get() as $field) {
                    if (!Schema::hasColumn($modelTable, $field->handle)) {
                        $table->{$field->type->db_type}($field->handle);
                    }
                }
            });
        }
        else {
            Schema::create($modelTable, function($table) use ($modelData)
            {
                $table->increments('id');
                $table->nullableTimestamps('created_at');
                $table->nullableTimestamps('updated_at');
                foreach($this->constantFields as $field => $type) {
                    $table->$type($field);
                }

                foreach($modelData->fields()->get() as $field) {
                    $table->{$field->type->db_type}($field->handle);
                }
            });
        }

        return true;
    }
}