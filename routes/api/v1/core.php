<?php

use App\Modules\CoreModule\Http\Controllers\AuthController;
use App\Modules\CoreModule\Http\Controllers\OptionDataController;
use App\Modules\CoreModule\Http\Controllers\RoleController;
use App\Modules\CoreModule\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => '/v1/core'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);

        Route::group(['middleware' => ['auth:api', 'user.check']], function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('profile', [UserController::class, 'getProfile']);

            /* user information includes file/image upload,
             * frontend side needs to use [post] method by adding _method:PUT in payload
             * e.g formData.append('_method', 'PUT');
             * Laravel will correctly interpret the POST request as PUT because of the _method parameter
             */
            Route::put('profile', [UserController::class, 'updateProfile']);
        });
    });

    Route::group(['middleware' => ['auth:api', 'user.check']], function () {
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->middleware(['can:index,Role']);
            Route::get('/{id}', [RoleController::class, 'read'])->middleware(['can:read,Role']);
            Route::post('/', [RoleController::class, 'create'])->middleware(['can:create,Role']);
            Route::put('/{id}', [RoleController::class, 'update'])->middleware(['can:update,Role']);
            Route::delete('/{id}', [RoleController::class, 'delete'])->middleware(['can:delete,Role']);
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->middleware(['can:index,User']);
            Route::get('/{id}', [UserController::class, 'read'])->middleware(['can:read,User']);
            Route::post('/', [UserController::class, 'create'])->middleware(['can:create,User']);

            /* user information includes file/image upload,
             * frontend side needs to use [post] method by adding _method:PUT in payload
             * e.g formData.append('_method', 'PUT');
             * Laravel will correctly interpret the POST request as PUT because of the _method parameter
             */
            Route::put('/{id}', [UserController::class, 'update'])->middleware(['can:update,User']);

            Route::delete('/{id}', [UserController::class, 'delete'])->middleware(['can:delete,User']);
        });

        Route::get('/options/{key}', [OptionDataController::class, 'get']); //should perform authorization in case inside job
    });

});
