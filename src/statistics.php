<?php

use Models\User;

require '../../vendor/autoload.php';
require '../../src/layouts/header.php';
require '../../src/layouts/navbar.php';
include '../../config/const.php';
if (!isset($_SESSION['email']) && $_SESSION['email'] !== 'admin@admin.com') {
    header('Location: /');
}

$user = new User();
$allUsers = collect($user->all($user->getTotal()));
$users = $allUsers->pluck('id', 'email')->toArray();
