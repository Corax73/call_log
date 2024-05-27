<?php

use Controllers\FormController;
use Models\User;

require '../../vendor/autoload.php';
require '../../src/layouts/header.php';
require '../../src/layouts/navbar.php';
include '../../config/const.php';
if (!isset($_SESSION['email']) && $_SESSION['email'] !== 'admin@admin.com') {
    header('Location: /');
}

$user = new User();
$users = collect($user->all($user->getTotal()))->pluck('id', 'email')->toArray();

$formController = new FormController();
$result = $formController->checkPost();
if(isset($result['errors'])) {
    $errors['errors'] = $result['errors'];
} elseif(isset($result['result']) && $result['result']) {
    $saved = true;
}
