<?php namespace App\CMS\Services;

use \Illuminate\Support\Facades\Schema;
use App\CMS\Models\Module;

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

        if ($oldSchema) {
            if ($module->handle !== $oldSchema['handle'] && Schema::hasTable($oldSchema['handle'])) {
                Schema::rename($oldSchema['handle'], $module->handle);
            }
        }

        if (Schema::hasTable($module->handle)) {

            Schema::table($module->handle, function($table) use ($module)
            {
                foreach($module->fields()->get() as $field) {
                    if (!Schema::hasColumn($module->handle, $field->handle)) {
                        $table->string($field->handle);
                    }
                }
            });
        }
        else {
            Schema::create($module->handle, function($table) use ($module)
            {
                $table->increments('id');
                $table->string('title');

                foreach($module->fields()->get() as $field) {
                    $table->string($field->handle);
                }
            });
        }

        return true;
    }

}