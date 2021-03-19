<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('organizer/register', 'OrganizerAuthController@register');
Route::post('organizer/login', 'OrganizerAuthController@login');
Route::post('organizer/logout', 'OrganizerAuthController@logout');

Route::post('participant/register', 'ParticipantAuthController@register');
Route::post('participant/login', 'ParticipantAuthController@login');
Route::post('participant/logout', 'ParticipantAuthController@logout');

Route::post('admin/register', 'AdminAuthController@register');
Route::post('admin/login', 'AdminAuthController@login');
Route::post('admin/logout', 'AdminAuthController@logout');



Route::group(['prefix' => 'admin', 'middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
    Route::get('/demo','AdminController@demo');
});

Route::group(['prefix' => 'organizer', 'middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
    Route::get('/demo','OrganizerController@demo');
});

Route::group(['prefix' => 'participant', 'middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
    Route::get('/demo','ParticipantController@demo');
});

Route::get('test', function (){
    return hasPermission('run_test');
});


Route::get('gender', 'GenderController@retrieve');
Route::get('gender/{id}', 'GenderController@getGender');
