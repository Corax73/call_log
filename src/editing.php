<?php

use Controllers\FormController;

require '../../vendor/autoload.php';
require '../../src/layouts/header.php';
require '../../src/layouts/navbar.php';
if (!isset($_SESSION['email']) && $_SESSION['email'] !== 'admin@admin.com') {
    header('Location: /');
}

$formController = new FormController();
$formController->checkPost();
