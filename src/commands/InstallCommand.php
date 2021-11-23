<?php

namespace SamirEltabal\Authsystem\commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class InstallCommand extends Command
{
    public $signature = 'AuthSystem:install';

    public $description = 'install System Package';

    public function handle(): int
    {
      $this->info('Starting..');
      \Artisan::call('migrate');
      $this->info('Publishing Spatie Roles Migrations');
      \Artisan::call('vendor:publish', ['--provider' => "Spatie\Permission\PermissionServiceProvider"]);
      $this->info('Done..');
      $this->info('Publishing Spatie Media Migrations');
      \Artisan::call('vendor:publish', ['--provider' => "Spatie\MediaLibrary\MediaLibraryServiceProvider"]);
      $this->info('Done..');
      $this->info('Installing Passport');
      \Artisan::call('passport:install');
      $this->info('Done..');
      $this->info('migrating..');
      \Artisan::call('migrate');
      $this->info('Done..');
      $user = User::create([
        'email' => 'admin@example.com',
        'phone' => '01000000000',
        'name'  => 'admin user', 
        'password' => 'password',
        'email_verified_at' => \Carbon\Carbon::now()
      ]);
      $this->info('created user :');
      $this->info('email: admin@example.com');
      $this->info('password: password');
      $admin_role = Role::create(['guard_name' => 'api', 'name' => 'admin']);
      $this->info('Created Role : admin');
      $user->syncRoles($admin_role);
      $this->info('Attached Role : Admin To User: admin@example.com');
      $admin_role = Role::create(['guard_name' => 'api', 'name' => 'user']);
      $this->info('Created Role : user');
      $this->info('And All Done');

        return self::SUCCESS;
    }
}