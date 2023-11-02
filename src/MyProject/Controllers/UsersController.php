<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Users\User;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\Models\Users\UsersAuthService;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try{
                $user = User::signUp($_POST);
	    } catch (InvalidArgumentException $e) {
		$this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
		return;
	    }
	

	    if ($user instanceof User) {
                /* @var string $code */
		$code = UserActivationService::createActivationCode($user);
                var_dump($code);
		EmailSender::send($user, 'Активация', 'userActivation.php', ['userId' => $user->getId(), 'code' => $code]);

	        $this->view->renderHtml('users/signUpSuccessful.php');
	        return;
	    }
        }
    
	$this->view->renderHtml('users/signUp.php');
    }

    public function login()
    {
	if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
		header('Location: /');
		exit();
	    } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
		return;
	    }
	}
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
	setcookie('token', '', -1, '/', '', false, true);
	header('Location: /');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
	$isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
	if ($isCodeValid) {
            $user->activate();
	    echo 'OK!';
	}

    }
}
