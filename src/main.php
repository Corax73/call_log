<?php

use Models\User;
use Repositories\CallsRepository;

$callsRepository = new CallsRepository();

$pag = $callsRepository->getPagination();
$countPages = $pag['count_pages'];
$offset = 0;
$perPage = 12;
if (isset($_GET['page']) && $_GET['page'] <= $countPages) {
    $page = $_GET['page'];
    $offset = ($page - 1) * $perPage;
}
$calls = $callsRepository->getCallWithCalculatedData($perPage, $offset);

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
