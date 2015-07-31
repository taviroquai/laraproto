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

// Model bindings
Route::model('user', 'App\User');
Route::model('role', 'App\Role');
Route::model('permission', 'App\Permission');
Route::model('content', 'App\Content');
Route::model('brand', 'App\Brand');
Route::model('page', 'App\Page');

// Load user pages
Route::group(['middleware' => ['visit']], function () {
    
    // Run all pages
    foreach(App\Page::where('active', 1)->get() as $page) {
        
        // Create page route
        Route::get($page->route, function () use ($page) {
            
            // Get page data file
            $data = (array) include($page->getDataPath());
            
            // Display page view file
            return view($page->getView(), $data);
        });
    }
});

// Auth routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Backoffice routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'permission']], function () {
    
    Route::get('dashboard', 'DashboardController@index');
    
    // Content
    Route::get('/contents', 'ContentController@json');
    Route::get('/contents/list', 'ContentController@index');
    Route::get('/contents/form/{content?}', 'ContentController@form');
    Route::post('/contents', 'ContentController@save');
    Route::get('/contents/delete/{content}', 'ContentController@delete');
    Route::post('/contents/upload/{content}', 'ContentController@upload');
    Route::get('/contents/{content}/delete/{filename}', 'ContentController@deleteGalleryImage');
    
    // Views
    Route::get('/pages', 'PageController@json');
    Route::get('/pages/list', 'PageController@index');
    Route::get('/pages/form/{page?}', 'PageController@form');
    Route::post('/pages', 'PageController@save');
    Route::get('/pages/delete/{page}', 'PageController@delete');
    
    // User
    Route::get('/users', 'UserController@json');
    Route::get('/users/list', 'UserController@index');
    Route::get('/users/form/{user?}', 'UserController@form');
    Route::post('/users', 'UserController@save');
    Route::get('/users/delete/{user}', 'UserController@delete');
    Route::get('/profile', 'UserController@profile');
    Route::post('/profile', 'UserController@profileSave');
    
    // Role
    Route::get('/roles', 'RoleController@json');
    Route::get('/roles/list', 'RoleController@index');
    Route::get('/roles/form/{role?}', 'RoleController@form');
    Route::post('/roles', 'RoleController@save');
    Route::get('/roles/delete/{role}', 'RoleController@delete');
    
    // Permission
    Route::get('/permissions', 'PermissionController@json');
    Route::get('/permissions/list', 'PermissionController@index');
    Route::get('/permissions/form/{permission?}', 'PermissionController@form');
    Route::post('/permissions', 'PermissionController@save');
    Route::get('/permissions/delete/{permission}', 'PermissionController@delete');
    
    // Branding
    Route::get('/brands', 'BrandController@json');
    Route::get('/brands/list', 'BrandController@index');
    Route::get('/brands/form/{brand?}', 'BrandController@form');
    Route::post('/brands', 'BrandController@save');
    Route::get('/brands/delete/{brand}', 'BrandController@delete');
    
    // Visits
    Route::get('visits', 'VisitController@json');
    Route::get('visits/list', 'VisitController@index');
    Route::get('visits/totals', 'VisitController@visitsTotalsJson');
    
});

