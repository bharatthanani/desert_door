<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\StoreController;

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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('forget-password-email', [UserController::class, 'ForgetPasswordEmail']);
Route::post('check-forget-password-code', [UserController::class, 'checkForgetPasswordCodeVerification']);
Route::post('update-forget-password', [UserController::class, 'updateForgetPassword']);
route::get('invalid',[UserController::class,'invalid'])->name('invalid');


Route::middleware(['auth:api'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('update-profile','UpdateProfile')->name('update-profile');
            Route::post('change-password','changePassword')->name('change-password');
        });

        Route::controller(InventoryController::class)->group(function () {
            Route::post('create-update-inventory','createUpdateInventory')->name('create-update-inventory');
            Route::any('inventory-list','inventoryLlist')->name('inventory-list');
            Route::any('my-inventory','myInventory')->name('my-inventory');
            Route::post('register-employee-in-event','registerEmployeeInEvent')->name('register-employee-in-event');
            Route::post('sell-item-by-user','sellItemByUser')->name('sell-item-by-user');
            // Route::get('checknotification_for_user/{titke}/{body}/{device}','checknotification_for_user')->name('checknotification_for_user');
            Route::get('checknotification_for_user','checknotification_for_user')->name('checknotification_for_user');
            
        });
        Route::controller(StoreController::class)->group(function () {
            Route::any('store-list','storeLlist')->name('store-list');
            Route::any('my-store','myStore')->name('my-store');
        });
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
