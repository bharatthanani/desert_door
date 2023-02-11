<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InverntoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\VerificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

        // Route::any('/', function () {
        //     return view('welcome');
        // });

        Route::get('forgot-password',[FrontController::class,'forgotPasswords'])->name('forgot-password');
        Route::post('forgotPassword',[FrontController::class,'forgotPassword'])->name('forgotPassword');
        Route::post('updatePassword',[FrontController::class,'updatePassword'])->name('updatePassword');
        Route::get('resetpassword/{id}',[FrontController::class,'resetpassword'])->name('resetpassword');


        Auth::routes(['verify' => true]);
        route::get('/',[AdminController::class,'user_login'])->name('user-login');

        route::post('loginAdminProcess',[AdminController::class,'loginAdminProcess'])->name('loginAdminProcess');
        
        route::post('AdminRegisterPrcess',[AdminController::class,'AdminRegisterPrcess'])->name('AdminRegisterPrcess');

        route::get('user-register',[AdminController::class,'register'])->name('user-register');
        Route::get('CheckEmailVerify/{token}/{email}', [AdminController::class,'CheckEmailVerify'])->name('CheckEmailVerify');
        Route::get('verrify-email/{token}', [AdminController::class,'verrifyEmail'])->name('verrify-email');
        

    // Route::middleware([AdminMiddleware::class])->group(function(){
            
    
    Route::group(['middleware' => ['auth']], function() {

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::get('role-change-status', [RoleController::class, 'roleChangeStatus'])->name('role-change-status');
        Route::controller(UserController::class)->group(function () {
            Route::get('view-manager', 'viewManager')->name('view-manager');
            Route::get('view-employee', 'viewEmployee')->name('view-employee');
            Route::get('employee-detail/{id}','EmployeeDetail')->name('employee-detail');
            Route::get('manager-detail/{id}','managerDetail')->name('manager-detail');
            
            
        });
        Route::controller(AdminController::class)->group(function () {
            Route::get('getUsers', 'getUsers')->name('getUsers');
            Route::post('addUpdateUser', 'addUpdateUser')->name('addUpdateUser');
            Route::get('delete-user', 'delete_user')->name('delete-user');
            Route::get('get-users', 'get_users')->name('get-users');
            Route::get('change-status', 'change_status')->name('change-status');
            Route::get('view-user', 'view_user')->name('view-user');
            Route::get('logouts', 'logouts')->name('logouts');
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('profile', 'profile')->name('profile');
            Route::get('contact-us-page', 'contactUsPage')->name('contact-us-page');
            Route::post('addContactUsImage', 'addContactUsImage')->name('addContactUsImage');
            
       });
    
      Route::controller(StoreController::class)->group(function () {
        Route::get('view-store', 'viewStore')->name('view-store');
        Route::post('addStore', 'addStore')->name('addStore');
        Route::get('deleteStore', 'deleteStore')->name('deleteStore');
        Route::get('updateStore', 'updateStore')->name('updateStore');
        Route::get('changeStoreStatus/{id}/{status}','changeStoreStatus')->name('changeStoreStatus');
        Route::get('assign-store', 'assignStore')->name('assign-store');
        Route::post('AssignToManager', 'AssignToManager')->name('AssignToManager');
        Route::get('getUserForAssingStore','getUserForAssingStore')->name('getUserForAssingStore');
        Route::get('store-detail/{id}','storeDetail')->name('store-detail');
        Route::any('create-event','createEvent')->name('create-event');
        Route::get('updateEvent','updateEvent')->name('updateEvent');
        Route::get('view-event','viewEvent')->name('view-event');
        Route::get('deleteEvent','deleteEvent')->name('deleteEvent');
    });

    Route::controller(InverntoryController::class)->group(function () {
        Route::get('view-inventory', 'viewInventory')->name('view-inventory');
        Route::get('get-store-and-employee','getStoreAndEmployee')->name('get-store-and-employee');
        Route::get('change-inventory-status','changeInventoryStatus')->name('change-inventory-status');
        Route::get('deleteInventory','deleteInventory')->name('deleteInventory');
        Route::post('updateInventory','updateInventory')->name('updateInventory');
        Route::any('send-email-to-manager','sendEmailToManager')->name('send-email-to-manager');
        Route::any('total-sell-bottels/{id}','totalSellBottels')->name('total-sell-bottels');
        
    });

});
    // });  


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
