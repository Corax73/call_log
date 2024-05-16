<?php

namespace Controllers;

use Pecee\Http\Response;

class UserController extends AbstractController
{
    /**
     * Creates a user.
     * @return \Pecee\Http\Response
     */
    public function create(): Response
    {
        $resp = ['create' => false];
        return $this->response->json(['response' => $resp]);
    }

    /**
     * Deletes a user.
     * @param int $user_id
     * @return \Pecee\Http\Response
     */
    public function destroy(int $user_id): Response
    {
        $resp = ['destroy' => false];
        return $this->response->json(['response' => $resp]);
    }
}
