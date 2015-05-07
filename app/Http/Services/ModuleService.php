<?php namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
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
        $appPrefix = DB::table('config')
            ->select('value')
            ->where('handle', 'db_prefix')
            ->first()
            ->value;

        $moduleTable = $appPrefix.$module->handle;

        if ($oldSchema) {
            $oldModuleTable = $appPrefix.$oldSchema['handle'];

            if ($moduleTable !== $oldModuleTable && $appSchema->hasTable($oldModuleTable)) {
                $appSchema->rename($oldModuleTable, $moduleTable);
            }
        }

        if ($appSchema->hasTable($moduleTable)) {

            $appSchema->table($moduleTable, function($table) use ($appSchema, $module, $moduleTable)
            {
                foreach($module->fields()->get() as $field) {
                    if (!$appSchema->hasColumn($moduleTable, $field->handle)) {
                        $table->string($field->handle);
                    }
                }
            });
        }
        else {
            $appSchema->create($moduleTable, function($table) use ($module)
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