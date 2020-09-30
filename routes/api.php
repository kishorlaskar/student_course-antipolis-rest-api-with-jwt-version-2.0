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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {

    // Routes for logout starts here..

    Route::get('logout', 'ApiController@logout');

    // Routes for logout ends here..

    // Routes for User starts here..
    Route::get('user', 'ApiController@getAuthUser');
    // Routes for User ends here..

    // Routes for  students starts  here..
    Route::get('students', 'StudentController@index');
    Route::post('students', 'StudentController@store');
    Route::get('students/{id}', 'StudentController@show');
    Route::put('students/{id}', 'StudentController@update');
    // Routes for students ends here..

    // Routes for courses starts here..
    Route::get('courses', 'CourseController@index');
    Route::post('courses', 'CourseController@store');
    Route::get('courses/{id}', 'CourseController@show');
    Route::put('courses/{id}', 'CourseController@update');
    Route::delete('courses/{id}', 'CourseController@destroy');
    //Routes for courses ends here...

    //Routes for course-registration starts here......
    Route::get('course-reg','CourseRegistationController@index');
    Route::post('course-reg','CourseRegistationController@store');
    Route::delete('course-reg/{id}','CourseRegistationController@drop');
    Route::get('/specific_course','CourseRegistationController@student_course');
    //Routes for course-registration ends here......
});


