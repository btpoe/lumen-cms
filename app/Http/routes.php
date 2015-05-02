<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() {
    return view('home.index');
});

$app->get('/channels', ['as' => 'channels', 'uses' => '\App\Http\Controllers\ChannelsController@index']);
$app->get('/channels/add', ['as' => 'channel-add', 'uses' => '\App\Http\Controllers\ChannelsController@detail']);
$app->get('/channels/{id}', ['as' => 'channel-detail', 'uses' => '\App\Http\Controllers\ChannelsController@detail']);

$app->get('/templates', ['as' => 'templates', 'uses' => '\App\Http\Controllers\TemplatesController@index']);
$app->get('/templates/add', ['as' => 'template-add', 'uses' => '\App\Http\Controllers\TemplatesController@detail']);
$app->get('/templates/{id}', ['as' => 'template-detail', 'uses' => '\App\Http\Controllers\TemplatesController@detail']);

$app->get('/modules', ['as' => 'modules', 'uses' => '\App\Http\Controllers\ModulesController@index']);
$app->get('/modules/add', ['as' => 'module-add', 'uses' => '\App\Http\Controllers\ModulesController@add']);
$app->post('/modules/add', ['as' => 'module-add-do', 'uses' => '\App\Http\Controllers\ModulesController@addDo']);
$app->get('/modules/{id}', ['as' => 'module-detail', 'uses' => '\App\Http\Controllers\ModulesController@detail']);
$app->post('/modules/{id}', ['as' => 'module-detail-do', 'uses' => '\App\Http\Controllers\ModulesController@detailDo']);

$app->get('/fields', ['as' => 'fields', 'uses' => '\App\Http\Controllers\FieldsController@index']);
$app->get('/fields/add', ['as' => 'field-add', 'uses' => '\App\Http\Controllers\FieldsController@add']);
$app->post('/fields/add', ['as' => 'field-add-do', 'uses' => '\App\Http\Controllers\FieldsController@addDo']);
$app->get('/fields/{id}', ['as' => 'field-detail', 'uses' => '\App\Http\Controllers\FieldsController@detail']);
$app->post('/fields/{id}', ['as' => 'field-detail-do', 'uses' => '\App\Http\Controllers\FieldsController@detailDo']);
