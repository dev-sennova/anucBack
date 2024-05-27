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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('/verify-email','AuthController@verifyEmail')->name('verify_email');
    Route::post('/resend-email','AuthController@resendEmail')->name('resend_email');
    Route::post('register', 'AuthController@register');

    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido

    Route::group(['middleware' => 'auth:api'], function() {
     Route::get('logout', 'AuthController@logout');
     Route::get('user', 'AuthController@user');
     Route::post('verifypassword','AuthController@verifyPassword');
     Route::post('changepassword','AuthController@changePassword');

     Route::get("usuario", "Tb_usuarioController@index");
     Route::post("usuario/store", "Tb_usuarioController@store");
     Route::put("usuario/update", "Tb_usuarioController@update");
     Route::put("usuario/deactivate", "Tb_usuarioController@deactivate");
     Route::put("usuario/activate", "Tb_usuarioController@activate");
     Route::get("usuario/selectusuario/{id}", "Tb_usuarioController@indexOne");
     Route::get("usuario/selectemail/{id}", "Tb_usuarioController@indexUser");
     Route::get("usuario/selectemaillogin/{id}", "Tb_usuarioController@indexIdUser");
     Route::get("usuarioGestor/{idGestor}", "Tb_usuarioController@indexGestor");
     Route::get("usuarioPendientes/{idUsuario}", "Tb_usuarioController@indexPendientes");
     Route::get("countUsuario/{idUsuario}", "Tb_usuarioController@countUsuario");

     Route::get("rol", "Tb_rolController@index");
     Route::post("rol/store", "Tb_rolController@store");
     Route::put("rol/update", "Tb_rolController@update");
     Route::put("rol/deactivate", "Tb_rolController@deactivate");
     Route::put("rol/activate", "Tb_rolController@activate");
     Route::get("rol/selectrol/{id}", "Tb_rolController@indexOne");

     Route::get("ciudad", "Tb_ciudadController@index");
     Route::post("ciudad/store", "Tb_ciudadController@store");
     Route::put("ciudad/update", "Tb_ciudadController@update");
     Route::put("ciudad/deactivate", "Tb_ciudadController@deactivate");
     Route::put("ciudad/activate", "Tb_ciudadController@activate");
     Route::get("ciudad/selectciudad/{id}", "Tb_ciudadController@indexOne");

     Route::post('/upload-image', 'ImageController@uploadImage');
    });

});
