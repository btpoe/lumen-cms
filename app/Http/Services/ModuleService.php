<?php namespace App\Http\Services;

use Illuminate\Support\Facades\Schema;
use App\Http\Models\Module;

/**
 * Class ModuleService
 * @package App\Http\Services
 * @param Module $module
 * @param mixed $oldSchema
 * @returns bool
 */
class ModuleService {

    public static function generateTable($module, $oldSchema = false) {

        if (is_string($module) || is_int($module)) {
            $module = Module::find($module)->first();
        }

        $appSchema = Schema::connection('app_mysql');

        if ($oldSchema) {
            if ($module->handle !== $oldSchema['handle'] && $appSchema->hasTable($oldSchema['handle'])) {
                $appSchema->rename($oldSchema['handle'], $module->handle);
            }
        }

        if ($appSchema->hasTable($module->handle)) {

            $appSchema->table($module->handle, function($table) use ($appSchema, $module)
            {
                foreach($module->fields()->get() as $field) {
                    if (!$appSchema->hasColumn($module->handle, $field->handle)) {
                        $table->string($field->handle);
                    }
                }
            });
        }
        else {
            $appSchema->create($module->handle, function($table) use ($module)
            {
                $table->increments('id');

                foreach($module->fields()->get() as $field) {
                    $table->string($field->handle);
                }
            });
        }

        return true;
    }

}