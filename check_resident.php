<?php
require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

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

// Check resident data
$email = 'serafinJoelito21@gmail.com';
$resident = Capsule::table('residents')->where('email', $email)->first();

if ($resident) {
    echo "Resident found:\n";
    echo "ID: " . $resident->id . "\n";
    echo "Name: " . $resident->first_name . " " . $resident->last_name . "\n";
    echo "Email: " . $resident->email . "\n";
    echo "Email Verified: " . ($resident->email_verified_at ? $resident->email_verified_at : 'No') . "\n";
    echo "Approval Status: " . $resident->approval_status . "\n";
} else {
    echo "No resident found with email: " . $email . "\n";
}
?>