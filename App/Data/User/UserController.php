<?php

namespace App\Data\User;

use App\Controller\AbstractController;
use App\Data\User\Exception\EmptyFieldException;
use App\Data\User\Exception\PasswordMismatchException;
use App\Http\Request;

class UserController extends AbstractController
{
    /**
     * @route("/user/login")
     */
    public function login()
    {
        return $this->redirect("/products");
    }

    /**
     * @route("/user/register")
     */
    public function register(Request $request, UserRepositoryOld $userRepository, UserService $userService)
    {
        $data = [];

        if ($request->isPost()) {

            try {
               $user = $this->registerAction();

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
     * @param UserRepositoryOld $userRepository
     *
     * @route("/user/auth")
     */
    public function auth(Request $request, UserRepositoryOld $userRepository, UserService $userService)
    {
        $data = [];

        if ($request->isPost()) {

            try {
                $user = $this->authAction($userRepository);

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
     * @param UserRepositoryOld $userRepository
     * @return UserModel|null
     * @throws EmptyFieldException
     * @throws PasswordMismatchException
     */
    private function authAction(UserRepositoryOld $userRepository): ?UserModel
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

echo "<pre>";
var_dump($email, $password);
echo "</pre>";

        if ($hasEmptyFields) {
            throw  $emptyFieldsException;
        }


        $user = $userRepository->getByEmail($email, $password);

        if (is_null($user)) {
            throw new PasswordMismatchException();
        }

        return $user;
    }
}