<?php namespace App\CMS\Services;

use \Schema;
use App\CMS\Models\Template;

/**
 * Class ModuleService
 */
class TemplateService {

    /**
     * Generate Table
     * @param Template $template
     * @param mixed $oldSchema
     * @return bool
     */
    public static function generateTable($template, $oldSchema = false) {

        if (is_string($template) || is_int($template)) {
            $template = Template::find($template)->first();
        }

        $templateTable = 'template_'.$template->handle;
        $oldTable = 'template_'.$oldSchema['handle'];

        if ($oldSchema) {
            if ($templateTable !== $oldTable && Schema::hasTable($oldTable)) {
                Schema::rename($oldTable, $templateTable);
            }
        }

        if (Schema::hasTable($templateTable)) {

            Schema::table($templateTable, function($table) use ($templateTable, $template)
            {
                foreach($template->fields()->get() as $field) {
                    if (!Schema::hasColumn($templateTable, $field->handle)) {
                        $table->string($field->handle);
                    }
                }
            });
        }
        else {
            Schema::create($templateTable, function($table) use ($template)
            {
                $table->increments('id');
                $table->nullableTimestamps('created_at');
                $table->nullableTimestamps('updated_at');
                $table->int('single_id');

                foreach($template->fields()->get() as $field) {
                    $table->{$field->type->db_type}($field->handle);
                }
            });
        }

        return true;
    }

}