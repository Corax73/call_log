<?php

use Models\Call;
use Models\NumberOperators;

$call = new Call();
$numberOperators = new NumberOperators();
$numbersIds = collect($numberOperators->all())->pluck('number_id')->toArray();
$midIndex = count($numbersIds) / 2;
for($i = 0; $i < $midIndex; $i++) {
    $call_start_time = date('Y-m-d H:i:s');
    $call_end_time = date('Y-m-d H:i:s', strtotime('+' . mt_rand(20, 360) . ' seconds', strtotime($call_start_time)));
    $call->save($numbersIds[$i], $numbersIds[$i + $midIndex], $call_start_time, $call_end_time);
}
