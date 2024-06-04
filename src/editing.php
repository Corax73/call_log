<?php

use Controllers\FormController;
use Models\Operator;
use Models\PhoneNumber;
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

$phoneNumber = new PhoneNumber();
$allPhoneNumbers = collect($phoneNumber->all($phoneNumber->getTotal()));
$phoneNumbers = $allPhoneNumbers->pluck('id', 'number')->toArray();

$operator = new Operator();
$operators = collect($operator->all($operator->getTotal()))->pluck('id', 'title')->toArray();

$usersWithPhoneNumbers = $allUsers->whereIn('id', collect($allPhoneNumbers)->pluck('user_id')->toArray());

$formController = new FormController();
$result = $formController->checkPost();
if(isset($result['errors'])) {
    $errors = $result;
} elseif(isset($result['result']) && $result['result'][$_POST['form']]) {
    $saved = $result['result'];
}
