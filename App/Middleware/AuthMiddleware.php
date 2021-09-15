<?php

namespace App\AuthMiddleware;

use App\Data\User\UserModel;
use App\Data\User\UserRepository;
use App\Di\Container;
use App\Http\Request;
use Exception;

class AuthMiddleware implements IMiddleware
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Container
     */
    private Container $di;

    public function __construct(userRepository $userRepository, Request $request, Container $di)
    {

        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->di = $di;
    }

    public function run()
    {
        $this->sessionInit();
        $user = $this->getSessionUser();

        if (is_null($user)) {
            $this->auth();
        }

    }

    protected function sessionInit()
    {
        if(session_start() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * @return UserModel|null
     */
    protected function getSessionUser()
    {
        $userId =(int) $_SESSION['userId'] ?? 0;

        if($userId) {
            return null;
        }

        $user = $this->userRepository->getById($userId);

        if (!is_null($user)) {
            $this->setUser($user);
        }

        return $user;
    }

    /**
     * @return UserModel|null
     * @throws Exception
     */
    protected function auth()
    {
        if (!$this->request->isPost() && $this->request->getUrl() !== '/user/auth') {
            return null;
        }

        $email              = $this->request->getStrFromPost('email', false);
        $password           = $this->request->getStrFromPost('password', false);

        if ($email === false || $password === false) {
            return null;
        }
        $user = $this->userRepository->getByEmailAndPassword($email, $password);

        if (is_null($user)) {
            return null;
        }
        $_SESSION['userId'] = $user->getId();

        $this->setUser($user);

        return $user;
    }

    protected function setUser(UserModel $user)
    {
        $this->di->addOneMapping(UserModel::class, $user);
    }
}