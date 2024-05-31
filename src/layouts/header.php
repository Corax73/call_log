<?php

use Controllers\AuthController;

session_start();
$authController = new AuthController();
$authController->checkPost();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title>Call log</title>
</head>

