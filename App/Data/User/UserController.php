<?php

namespace App\Data\User;

use App\Controller\AbstractController;
use App\Data\User\Exception\EmptyFieldException;
use App\Data\User\Exception\PasswordMismatchException;
use App\Http\Request;

class UserController extends AbstractController
{
    /**
     * @route("/user/register/")
     */
    public function register(Request  $request)
    {
        $data = [];


        if ($request->isPost()) {

            try {
                $this->registerAction($request);

            } catch (EmptyFieldException $e) {
                    $data['error'] = [
                        'massage' => 'Заполните необходимые поля',
                        'requiredFields' => $e->getEmptyFields(),
                    ];

            }
        }

        $this->render('user/register.form.tpl', $data);
    }

    private function registerAction(Request $request)
    {

        $email              = $request->getStrFromPost('email' );
        $password           = $request->getStrFromPost('password');
        $passwordRepeat     = $request->getStrFromPost('password-repeat');
        $name               = $request->getStrFromPost('name');


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

    }
}