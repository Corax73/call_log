<?php

use Models\Operator;

$operator = new Operator();
for ($i = 0; $i < 20; $i++) {
    $title = bin2hex(random_bytes(10));
    $internal_price = mt_rand(1, 10);
    $external_price = mt_rand(1, 10);
    if ($internal_price > $external_price) {
        $temp = $internal_price;
        $internal_price = $external_price;
        $external_price = $temp;
    } elseif ($internal_price == $external_price) {
        $external_price += mt_rand(1, 10);
    }
    $operator->save($title, $internal_price, $external_price);
}
