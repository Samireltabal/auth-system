<?php 
    use SamirEltabal\AuthSystem\Controllers\AuthController;
    use SamirEltabal\AuthSystem\Controllers\AdminController;
    use SamirEltabal\AuthSystem\Controllers\RolesController;
    use SamirEltabal\AuthSystem\Controllers\SocialLoginController;

    Route::get('/', function() {
        // return SamirEltabal\AuthSystem\Models\PasswordReset::all();
        return AuthSystem::ping();
    });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('user', [AuthController::class, 'update']);
    Route::post('/avatar', [AuthController::class, 'set_avatar']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('verify', [AuthController::class, 'verify']);
    Route::get('reverify', [AuthController::class, 'reverify']);
    Route::prefix('notifications')->group( function () {
        Route::get('/markasread', [AuthController::class, 'mark_all_as_read']);
        Route::get('/markasread/{id}', [AuthController::class, 'mark_as_read']);
        Route::get('/delete', [AuthController::class, 'delete_notification']);
    });
    Route::prefix('roles')->group( function () {
        Route::post('/attach', [RolesController::class, 'attach_role']);
        Route::post('/permission/attach', [RolesController::class, 'add_permission_to_role']);
        Route::post('/create', [RolesController::class, 'create_role']);
        Route::get('/', [RolesController::class, 'list_roles']);
        Route::post('/permissions/create', [RolesController::class, 'create_permission']);
        Route::get('/permissions', [RolesController::class, 'list_permissions']);
        Route::post('/verify', [RolesController::class, 'verify_role']);
        Route::post('/verify/permission', [RolesController::class, 'verify_permission']);
    });
    Route::post('password/email', [AuthController::class, 'forgot']);
    Route::post('password/reset', [AuthController::class, 'reset']);
    Route::prefix('social')->group( function () {
        Route::get('/login/{service}', [SocialLoginController::class ,'redirect']);
        Route::get('/login/{service}/callback', [SocialLoginController::class ,'callback']);
    });

    Route::prefix('admin')->group( function () {
        Route::get('/accounts', [AdminController::class, 'list_accounts']);
    });