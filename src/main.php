<?php

use Models\User;
use Repositories\CallsRepository;

$callsRepository = new CallsRepository();
$calls = $callsRepository->getCallWithCalculatedData();

if ((isset($_POST['email']) && isset($_POST['passwordForLogin'])) && ($_POST['email'] && $_POST['passwordForLogin'])) {
    $user = new User();
    $auth = $user->authUser($_POST['email'], $_POST['passwordForLogin']);
    if ($auth) {
        $_SESSION['email'] = htmlspecialchars($_POST['email']);
    }
}

if (isset($_POST['logout']) && $_POST['logout']) {
    $user = new User();
    $user->logout();
}
