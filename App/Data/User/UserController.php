<?php

namespace App\Data\User;

use App\Controller\AbstractController;
use App\Data\User\Exception\EmptyFieldException;
use App\Data\User\Exception\PasswordMismatchException;
use App\Http\Request;

class UserController extends AbstractController
{
    /**
     * @route("/user/register")
     */
    public function register(Request $request, UserRepository $userRepository, UserService $userService)
    {
        $data = [];

        if ($request->isPost()) {

            try {
               $user = $this->registerAction($userRepository);

                $user->setPassword(
                    $userService->passwordEncoder(
                        $user->getPassword()
                    )
                );

                $userRepository->save($user);

                return $this->redirect("/user/register");
            } catch (EmptyFieldException $e) {
                    $data['error'] = [
                        'massage' => 'Заполните необходимые поля',
                        'requiredFields' => $e->getEmptyFields(),
                    ];
            } catch (PasswordMismatchException $e) {
                $data['error'] = [
                    'massage' => 'Паоли не совпадают',
                    'requiredFields' => [
                        'password' => true,
                        'passwordRepeat' => true,
                    ],
                ];
            }
        }

       return $this->render('user/register.form.tpl', $data);
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     *
     * @route("/user/auth")
     */
    public function auth(Request $request, UserRepository $userRepository, UserService $userService)
    {
        $data = [];

        if ($request->isPost()) {

            try {
                $user = $this->authAction($userService);

                $_SESSION['userId'] = $user->getId();

                return $this->redirect("/user/auth");
            } catch (EmptyFieldException $e) {
                $data['error'] = [
                    'massage' => 'Заполните необходимые поля',
                    'requiredFields' => $e->getEmptyFields(),
                ];
            } catch (PasswordMismatchException $e) {
                $data['error'] = [
                    'massage' => 'Пользователь с таким Емэйлом или паролем не найден',
                    'requiredFields' => [
                        'password' => true,
                        'passwordRepeat' => true,
                    ],
                ];
            }
        }

        return $this->render('user/auth.form.tpl', $data);

    }

    private function registerAction(): UserModel
    {

        $email              = $this->request->getStrFromPost('email' );
        $password           = $this->request->getStrFromPost('password');
        $passwordRepeat     = $this->request->getStrFromPost('password-repeat');
        $name               = $this->request->getStrFromPost('name');


        $hasEmptyFields = false;
        $emptyFieldsException = new EmptyFieldException();
        if (empty($name)) {
            $emptyFieldsException->addEmptyField('name');
            $hasEmptyFields = true;
        }
        if (empty($email)) {
            $emptyFieldsException->addEmptyField('email');
            $hasEmptyFields = true;
        }
        if (empty($password)) {
            $emptyFieldsException->addEmptyField('password');
            $hasEmptyFields = true;
        }
        if (empty($passwordRepeat)) {
            $emptyFieldsException->addEmptyField('passwordRepeat');
            $hasEmptyFields = true;
        }

        if ($hasEmptyFields) {
            throw  $emptyFieldsException;
        }

        if ($password !== $passwordRepeat) {
            throw  new PasswordMismatchException();
        }

        $user = new UserModel($name, $email, $password);

        return $user;
    }

    /**
     * @param UserRepository $userRepository
     * @return UserModel|null
     * @throws EmptyFieldException
     * @throws PasswordMismatchException
     */
    private function authAction(UserRepository $userRepository): ?UserModel
    {

        $email              = $this->getRequest()->getStrFromPost( 'email' );
        $password           = $this->getRequest()->getStrFromPost('password');

        $hasEmptyFields = false;
        $emptyFieldsException = new EmptyFieldException();

        if (empty($email)) {
            $emptyFieldsException->addEmptyField('email');
            $hasEmptyFields = true;
        }
        if (empty($password)) {
            $emptyFieldsException->addEmptyField('password');
            $hasEmptyFields = true;
        }


        if ($hasEmptyFields) {
            throw  $emptyFieldsException;
        }


        $user = $userRepository->getByEmailAndPassword($email, $password);

        if (is_null($user)) {
            throw new PasswordMismatchException();
        }

        return $user;
    }
}