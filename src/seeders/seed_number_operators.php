<?php

use Models\NumberOperators;
use Models\Operator;
use Models\PhoneNumber;

$numberOperators = new NumberOperators();
$number = new PhoneNumber();
$numberIds = collect($number->all())->pluck('id')->toArray();
$operator = new Operator();
$operatorIds = collect($operator->all())->pluck('id')->toArray();
shuffle($numberIds);
shuffle($operatorIds);
for($i = 0; $i < count($numberIds); $i++) {
    $numberOperators->save($numberIds[$i], $operatorIds[$i]);
}
