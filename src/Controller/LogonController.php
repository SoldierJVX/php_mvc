<?php

class LogonController extends Controller {

    private $userDao;

    public function __construct() {
        $this->view = new LogonView();

        $this->userDao = new UserDao();
    }

    public function loginAction() {

        $message = Message::singleton();

        if (array_key_exists('submit', $_POST)) {

            $email = array_key_exists('email', $_POST) ? $_POST['email'] : '';

            $password = array_key_exists('password', $_POST) ? $_POST['password'] : '';
            
            try {
                
                if (empty($email))
                    throw new Exception('Preencha o campo E-mail.');

                if (empty($password))
                    throw new Exception('Preencha o campo Senha.');
                
                if ($user = $this->userDao->login($email, $password)) {

                    $message->addMessage('Usuário autenticado com sucesso.');

                    $this->setRoute($this->view->getIndexRoute());

                    $_SESSION['USER'] = serialize($user);
                    
                } else {
                    $message->addWarning('Login ou Senha incorretos.');

                    $this->setRoute($this->view->getLogonRoute());
                }
            } catch (Exception $e) {

                $this->setRoute($this->view->getLogonRoute());

                $message->addWarning($e->getMessage());
            }
        } else {
            $this->setRoute($this->view->getLogonRoute());
        }

        $this->showView();

        return;
    }

    public function logoffAction() {
        unset($_SESSION['USER']);

        $this->setRoute($this->view->getLogonRoute());

        $message = Message::singleton();

        $message->addMessage('Você foi deslogado com sucesso.');

        $this->showView();
    }

}
