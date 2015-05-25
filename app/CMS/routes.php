<?php

$app->get('/singles', ['as' => 'singles', 'uses' => '\App\CMS\Controllers\SinglesController@index']);
$app->get('/singles/add', ['as' => 'single-add', 'uses' => '\App\CMS\Controllers\SinglesController@add']);
$app->get('/singles/{id}', ['as' => 'single-detail', 'uses' => '\App\CMS\Controllers\SinglesController@detail']);
$app->post('/singles/add', ['as' => 'single-add-do', 'uses' => '\App\CMS\Controllers\SinglesController@addDo']);
$app->post('/singles/{id}', ['as' => 'single-detail-do', 'uses' => '\App\CMS\Controllers\SinglesController@detailDo']);

$app->get('/modules', ['as' => 'modules', 'uses' => '\App\CMS\Controllers\ModulesController@index']);
$app->get('/modules/{handle}', ['as' => 'module-list', 'uses' => '\App\CMS\Controllers\ModulesController@listing']);
$app->get('/modules/{handle}/add', ['as' => 'module-add', 'uses' => '\App\CMS\Controllers\ModulesController@detail']);
$app->get('/modules/{handle}/{id}', ['as' => 'module-detail', 'uses' => '\App\CMS\Controllers\ModulesController@detail']);
$app->post('/modules/{handle}/add', ['as' => 'module-add-do', 'uses' => '\App\CMS\Controllers\ModulesController@detailDo']);
$app->post('/modules/{handle}/{id}', ['as' => 'module-detail-do', 'uses' => '\App\CMS\Controllers\ModulesController@detailDo']);


// settings

$app->get('/settings/templates', ['as' => 'settings-templates', 'uses' => '\App\CMS\Controllers\TemplatesController@settings_index']);
$app->get('/settings/templates/add', ['as' => 'settings-template-add', 'uses' => '\App\CMS\Controllers\TemplatesController@settings_add']);
$app->post('/settings/templates/add', ['as' => 'settings-template-add-do', 'uses' => '\App\CMS\Controllers\TemplatesController@settings_addDo']);
$app->get('/settings/templates/{id}', ['as' => 'settings-template-detail', 'uses' => '\App\CMS\Controllers\TemplatesController@settings_detail']);
$app->post('/settings/templates/{id}', ['as' => 'settings-template-detail-do', 'uses' => '\App\CMS\Controllers\TemplatesController@settings_detailDo']);
$app->get('/settings/templates/{id}/config', ['as' => 'settings-template-config', 'uses' => '\App\CMS\Controllers\TemplatesController@config']);

$app->get('/settings/fields', ['as' => 'settings-fields', 'uses' => '\App\CMS\Controllers\FieldsController@index']);
$app->get('/settings/fields/add', ['as' => 'settings-field-add', 'uses' => '\App\CMS\Controllers\FieldsController@add']);
$app->post('/settings/fields/add', ['as' => 'settings-field-add-do', 'uses' => '\App\CMS\Controllers\FieldsController@addDo']);
$app->get('/settings/fields/{id}', ['as' => 'settings-field-detail', 'uses' => '\App\CMS\Controllers\FieldsController@detail']);
$app->post('/settings/fields/{id}', ['as' => 'settings-field-detail-do', 'uses' => '\App\CMS\Controllers\FieldsController@detailDo']);

$app->get('/settings/field-types', ['as' => 'settings-field-types', 'uses' => '\App\CMS\Controllers\FieldTypesController@index']);
$app->get('/settings/field-types/add', ['as' => 'settings-field-type-add', 'uses' => '\App\CMS\Controllers\FieldTypesController@add']);
$app->post('/settings/field-types/add', ['as' => 'settings-field-type-add-do', 'uses' => '\App\CMS\Controllers\FieldTypesController@addDo']);
$app->get('/settings/field-types/{id}', ['as' => 'settings-field-type-detail', 'uses' => '\App\CMS\Controllers\FieldTypesController@detail']);
$app->post('/settings/field-types/{id}', ['as' => 'settings-field-type-detail-do', 'uses' => '\App\CMS\Controllers\FieldTypesController@detailDo']);
$app->get('/settings/field-types/{id}/config', ['as' => 'settings-field-type-config', 'uses' => '\App\CMS\Controllers\FieldTypesController@config']);
