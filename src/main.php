<?php

use Models\Call;
use Models\User;

$call = new Call();
$calls = collect($call->all());
$userIds = $calls->pluck('user_id')->toArray();
$dialedUserIds = $calls->pluck('dialed_user_id')->toArray();
$user = new User();
$users = collect($user->find($userIds));
$dialedUsers = collect($user->find($dialedUserIds));
$calls = $calls->map(function ($item) use ($users, $dialedUsers) {
    $user = $users->where('id', $item['user_id']);
    if ($user) {
        $item['user'] = $user->first()['email'];
    }

    $dialedUser = $dialedUsers->where('id', $item['dialed_user_id']);
    if ($dialedUser) {
        $item['dialed_user'] = $dialedUser->first()['email'];
    }
    return $item;
});

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
