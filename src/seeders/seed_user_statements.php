<?php

use Models\Operator;
use Models\User;
use Models\UserStatements;

$userStatements = new UserStatements();
$user = new User();
$usersIds = collect($user->all())->pluck('id')->toArray();
$operator = new Operator();
$operatorIds = collect($operator->all())->pluck('id')->toArray();
shuffle($usersIds);
shuffle($operatorIds);
for($i = 0; $i < count($usersIds); $i++) {
    $userStatements->save($usersIds[$i], $operatorIds[$i]);
}
