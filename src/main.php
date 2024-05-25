<?php

use Controllers\AuthController;
use Models\User;
use Repositories\CallsRepository;

$callsRepository = new CallsRepository();

$pag = $callsRepository->getPagination();
$countPages = $pag['count_pages'];
$offset = 0;
$perPage = 12;

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
if (isset($_GET['page']) && $_GET['page'] <= $countPages) {
    $page = $_GET['page'];
    $offset = ($page - 1) * $perPage;
}
$calls = $callsRepository->getCallWithCalculatedData($perPage, $offset);
