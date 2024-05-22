<?php
;
use Models\PhoneNumber;
use Models\User;

$phoneNumber = new PhoneNumber();
$user = new User();
$usersIds = collect($user->all())->pluck('id')->toArray();

foreach($usersIds as $user_id) {
    $number = mt_rand(70000000000, 79999999999);
    $phoneNumber->save($number, $user_id);
}
