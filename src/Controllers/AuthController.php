<?php

namespace Controllers;

use Models\User;

/**
 * @property User $user
 */
class AuthController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User;
    }

    /**
     * @return void
     */
    public function checkPost(): void
    {
        if ((isset($_POST['email']) && isset($_POST['passwordForLogin'])) && ($_POST['email'] && $_POST['passwordForLogin'])) {
            $this->auth();
        }

        if (isset($_POST['logout']) && $_POST['logout']) {
            $this->logout();
        }
    }

    /**
     * @return void
     */
    private function auth(): void
    {
        $auth = $this->user->authUser($_POST['email'], $_POST['passwordForLogin']);
        if ($auth) {
            session_start();
            $_SESSION['email'] = htmlspecialchars($_POST['email']);
        }
    }

    /**
     * @return void
     */
    private function logout(): void
    {
        $this->user->logout();
    }
}
