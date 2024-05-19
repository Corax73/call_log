<?php

use Models\Call;
use Models\User;

$call = new Call();
$user = new User();
$usersIds = collect($user->all())->pluck('id')->toArray();
$midIndex = count($usersIds) / 2;
for($i = 0; $i < $midIndex; $i++) {
    $call_start_time = date('Y-m-d H:i:s');
    $call_end_time = date('Y-m-d H:i:s', strtotime('+' . mt_rand(20, 360) . ' seconds', strtotime($call_start_time)));
    $call->save($usersIds[$i], $usersIds[$i + $midIndex], $call_start_time, $call_end_time);
}
