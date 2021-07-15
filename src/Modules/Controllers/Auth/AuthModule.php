<?php

namespace App\Modules\Controllers\Auth;

use App\Core\View;
use App\Modules\Module;
use App\Modules\BinksBeatHelper;
use App\Modules\BinksBeatMailer;
use App\Modules\Middlewares\Authorize;
use App\Modules\Controllers\Auth\Models\User;
use App\Modules\Controllers\Auth\Models\Credential;
use App\Modules\Controllers\Auth\Utils\AuthHelpers;
use App\Modules\Controllers\Auth\Models\Verification;
use App\Modules\Controllers\Auth\UseCases\AuthUseCases;
use App\Modules\Controllers\Auth\Middlewares\IsAlreadyConnected;


class AuthModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [

            $this->router->get('/test', middlewares: [], callback: function (): void {
                $view = new View('test');
                $view->show();
            }),

            $this->router->match(["get", "post"], '/login', middlewares: [new IsAlreadyConnected()], callback: function (): void {
                $form = User::createLoginForm();
                $view = new View('login');
                $view->assign('form', $form);

                if ($_POST) {
                    $errors = $form->getErrors($_POST);
                    if (empty($errors)) {
                        $errors = AuthUseCases::connect($_POST['email'], $_POST['password']);
                        if (empty($errors)) {
                            $this->router->redirect('/projects');
                        }
                    }
                    $view->assign('errors', $errors);
                }
                $view->show();
            }),

            $this->router->get('/register', callback: function (): void {
                $form = User::createRegisterForm();
                $view = new View('register');
                $view->assign('form', $form);
                $view->show();
            }),

            $this->router->post('/register', callback: function (): void {
                $form = User::createRegisterForm();
                if ($_POST) {
                    $errors = $form->getErrors($_POST);
                    if (empty($errors)) {
                        $user = new User(array_merge(
                            $_POST,
                            ["picture" => BinksBeatHelper::getRandomColor()]
                        ));
                        try {
                            $userId = $user->save();
                        } catch (\Exception $e) {
                            if ($e->getCode() === 409) {
                                $this->router->redirect(params: [
                                    "errors" => ['Adresse email déjà utilisé']
                                ]);
                            } else {
                                throw $e;
                            }
                        }
                        $token = AuthHelpers::createToken();
                        $csrf = AuthHelpers::createToken();
                        $verificationToken = bin2hex(random_bytes(6));

                        (new Verification(['userId' => $userId, 'verificationToken' => $verificationToken]))->save();

                        $verificationLink = $_SERVER['HTTP_HOST'] . '/verify?token=' . $verificationToken;
                        $html = '<h1>Verifiez votre compte<h1/> <p>pour verifier votre compte cliquez sur ce <a href=' . $verificationLink . '>lien</a></p>';
                        BinksBeatMailer::getInstance()->sendEmail('maziarzoliwier93@gmail.com', ['maziarzoliwier93@gmail.com'], 'Veuillez vérifier votre compte', $html);

                        $credential = new Credential([
                            "userId" => $userId,
                            "token" => $token
                        ]);
                        $credential->save();

                        AuthHelpers::setTokenSession($token);
                        AuthHelpers::setCsrfSession($csrf);

                        $this->router->redirect('/projects');
                    }
                    $this->router->redirect(params: [
                        "errors" => $errors
                    ]);
                }
            }),

            $this->router->get('verify', callback: function (): void {
                $view = new View('verification');

                if (isset($_GET['token'])) {
                    $verification = new Verification();
                    $result = $verification->findOne([
                        ['verificationToken', '=', $_GET['token']]
                    ]);
                    if ($result) {
                        $credential = new Credential(['verified' => 1]);
                        //Logger::dd($credential);
                        $credential->update([['userId', '=', $result['userId']]]);
                        echo 'woohoo';
                    } else $view->assign('display', 'OOGA');
                } else $view->assign('display', 'Il y\'a eu un problème: Aucun token fourni');

                $view->show();
            }),

            $this->router->get('/profile', middlewares: [new Authorize()], callback: function (): void {
                $view = new View('profile', ['main_nav'], false);
                $currentUser = $_SESSION['user'];
                $form =  User::editInfoForm($currentUser);
                $view->assign('form', $form);
                $view->assign("user", $currentUser);
                $view->show();
            }),

            $this->router->post('/profile', middlewares: [new Authorize()], callback: function (): void {
                ["id" => $currentUserId] = $_SESSION['user'];
                $form = User::editInfoForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    $user = new User(array_merge(
                        ["id" => $currentUserId],
                        $form->filterPost($_POST)
                    ));
                    $user->save();
                    $this->router->redirect(params: [ 
                        "success" => ["Informations mises à jour"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->get('/logout', callback: function (): void {
                session_destroy();
                $this->router->redirect('/login');
            }),
        ];
    }
}
