## Authentication System For Laravel 

# depends on 
- laravel/framework: "^8.65",
- laravel/Passport : "^10.1"
- laravel/Socialite : "^5.2.0"
- spatie/laravel-medialibrary : "^9.0.0"
- spatie/laravel-permission: "^5.3"

# Installation 
- composer require samireltabal/auth-system
- php artisan authsystem:install
- php artisan passport:install
- php artisan storage:link
- php artisan migrate

# Setup 
- add : use SamirEltabal\AuthSystem\Traits\AuthenticableTrait; to User Model
- add : use Spatie\MediaLibrary\HasMedia; to User Model
- change Class User Extends Authenticable to class User extends Authenticatable implements MustVerifyEmail , HasMedia
- change use HasFactory; to use HasFactory, AuthenticableTrait; 
- add 
 -- 'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
to protected $routeMiddleware in App\Http\Kernel.php

# and you are Ready To Go. 