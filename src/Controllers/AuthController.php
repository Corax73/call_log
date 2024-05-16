<?php

namespace Controllers;

use Models\User;
use Pecee\Http\Response;

class AuthController extends AbstractController
{
    /**
     * Checks the email and password from the request. If successful, returns the user token.
     * @return \Pecee\Http\Response
     */
    public function login(): Response
    {
        $resp = ['auth' => false];
        $user = new User();
        $data = $this->request->getInputHandler()->getOriginalPost();
        $auth = $user->authUser($data['email'], $data['password']);
        if ($auth) {
            $resp = ['auth' => true];
        }
        return $this->response->json($resp);
    }

    /**
     * Requests data checks from the request, tries to create a user, returns json in the response.
     * @return \Pecee\Http\Response
     */
    public function registration(): Response
    {
        $resp = ['reg' => false];
        $data = $this->request->getInputHandler()->getOriginalPost();
        if (
            isset($data['email']) && isset($data['password']) && isset($data['password_confirm'])
            && $data['email'] != NULL && $data['password'] != NULL && $data['password_confirm'] != NULL
        ) {
            if ($data['password'] == $data['password_confirm']) {
                $user = new User();
                $result = $user->save($data['email'], $data['password']);
                if ($result) {
                    $resp = ['reg' => true];
                }
            }
        }
        return $this->response->json($resp);
    }
}
