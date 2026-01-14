<?php
require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Hash;

// Create a service container
$container = new Container();
$events = new Dispatcher($container);

// Create a database capsule
$capsule = new Capsule($container);
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'project',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setEventDispatcher($events);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Reset password for resident
$email = 'serafinJoelito21@gmail.com';
$newPassword = 'password123'; // Simple password for testing

$resident = Capsule::table('residents')->where('email', $email)->first();

if ($resident) {
    Capsule::table('residents')
        ->where('email', $email)
        ->update(['password' => Hash::make($newPassword)]);
    
    echo "Password reset successfully for " . $email . "\n";
    echo "New password: " . $newPassword . "\n";
    echo "Please change this after logging in.\n";
} else {
    echo "No resident found with email: " . $email . "\n";
}
?>