<?php

namespace App\Support;

use DB;
use File;
use Config;
use Artisan;
use Illuminate\Filesystem\Filesystem;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Installer
{
    public static function updateEnv($data)
    {
        if (empty($data) || !is_array($data) || !is_file(base_path('.env'))) {
            return false;
        }
        $env = file_get_contents(base_path('.env'));
        $env = explode("\n", $env);
        foreach ($data as $data_key => $data_value) {
            $updated = false;
            foreach ($env as $env_key => $env_value) {
                $entry = explode('=', $env_value, 2);
                // Check if new or old key
                if ($entry[0] == $data_key) {
                    $env[$env_key] = $data_key . '=' . $data_value;
                    $updated = true;
                } else {
                    $env[$env_key] = $env_value;
                }
            }
            // Lets create if not available
            if (!$updated) {
                $env[] = $data_key . '=' . $data_value;
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path('.env'), $env);
        return true;
    }




//    public static function createDbTables($host, $port, $database, $username, $password)
//    {
//        if (!static::isDbValid($host, $port, $database, $username, $password)) {
//            return false;
//        }
//        // Set database details
//        static::saveDbVariables($host, $port, $database, $username, $password);
//
//        // check if database is empty
//        // $total_tables = count(DB::select('SHOW TABLES'));
//
//        // Try to increase the maximum execution time
//        set_time_limit(300); // 5 minutes
//        Artisan::call('migrate:fresh', ['--force' => true]);
//
//        // initially only seed the roles, permissions, countries, categories, periods, currencies
////        Artisan::call('db:seed', ['--class' => \CategoriesTableSeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \CountrySeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \PeriodsTableSeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \CurrenciesTableSeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \RolesTableSeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \PermissionsTableSeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \LanguagesTableSeeder::class, '--force' => true]);
////        Artisan::call('db:seed', ['--class' => \InitialSettingsSeeder::class, '--force' => true]);
//
//        //Artisan::call('db:seed', ['--class' => 'Database\Seeds\CategoriesTableSeeder', '--force' => true]);
//        return true;
//    }
//
//


//    public static function createUser(array $data)
//    {
//        return DB::transaction(function () use ($data) {
//
//            // Create the user
//            $user = User::create([
//                'first_name' => $data['first_name'],
//                'last_name' => $data['last_name'],
//                'username' => $data['username'],
//                'email' => $data['email'],
//                'password' => $data['password'],
//                'active' => true,
//                'confirmation_code' => md5(uniqid(mt_rand(), true)),
//                'confirmed' => true,
//            ]);
//
//            // Attach admin role
//            $user->assignRole(config('access.users.admin_role'));
//
//            return $user;
//        });
//    }

//    public static function finalTouches()
//    {
//        // Update .env file
//        static::updateEnv([
//            'APP_ENV' => 'production',
//            'APP_INSTALLED' => 'true',
//            'APP_DEBUG' => 'false',
//            'DEBUGBAR_ENABLED' => 'false'
//        ]);
//        // Rename the robots.txt file
//        try {
//            \File::put(storage_path() . '/INSTALL/site_installed.key', 'Installation completed on ' . \Carbon\Carbon::now());
//        } catch (\Exception $e) {
//            // nothing to do
//            return false;
//        }
//        return true;
//    }


}