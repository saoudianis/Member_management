<?php
    require 'vendor/autoload.php';

    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/firstfirebase-6f0bb-firebase-adminsdk-n141c-180d9e5c6d.json');
    $firebase=(new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://firstfirebase-6f0bb-default-rtdb.firebaseio.com/')
        ->Create();
    
    $database = $firebase->getDatabase();
?>
<!-- The core Firebase JS SDK is always required and must be listed first -->
