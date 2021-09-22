<?php

namespace App\Middleware;

use App\Data\User\UserModel;
use App\Data\User\UserRepositoryOld;
use App\Data\User\UserService;
use App\Di\Container;
use App\Http\Request;
use Exception;

class AuthMiddleware implements IMiddleware
{

    /**
     * @var UserRepositoryOld
     */
    private UserRepositoryOld $userRepository;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Container
     */
    private Container $di;

    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(UserRepositoryOld $userRepository,
                                Request           $request,
                                Container         $di,
                                UserService       $userService)
    {
        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->di = $di;
        $this->userService = $userService;
    }

    /**
     * @throws Exception
     */
    public function beforeDispatch()
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


        if(!$userId) {

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


        if (!$this->request->isPost() || $this->request->getUrl() !== '/user/login') {
            return null;
        }

        $email              = $this->request->getStrFromPost('email', false);
        $password           = $this->request->getStrFromPost('password', false);

        if ($email === false || $password === false) {
            return null;
        }
        $user = $this->userRepository->getByEmail($email);

        if (is_null($user) || $this->userService->passwordVerify($password, $user->getPassword())) {
            return null;
        };

        $_SESSION['userId'] = $user->getId();

        $this->setUser($user);

        return $user;
    }

    protected function setUser(UserModel $user)
    {
        $this->di->addOneMapping(UserModel::class, $user);
    }

    public function afterDispatch()
    {
        // TODO: Implement afterDispatch() method.
    }
}