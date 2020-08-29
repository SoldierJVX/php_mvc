<?php

class UserController extends Controller {

    private $userDao;

    public function __construct() {
        $this->view = new UserView();

        $this->userDao = new UserDao();
    }

    public function indexAction() {
        return;
    }

    public function activateAction() {

        $id = array_key_exists('id', $_GET) ? $_GET['id'] : '';

        $active = $this->userDao->activate($id);

        ob_start();
        ?>

        <a href="#" onClick="activate(<?= $id ?>)" class="btn btn-<?= ($active) ? 'danger' : 'success' ?> btn-sm" role="button"><?= ($active) ? 'Desativar' : 'Ativar' ?></a>

        <?php
        echo ob_get_clean();
    }

    public function createAction() {
        $message = Message::singleton();

        $viewModel = array();

        if (array_key_exists('save', $_POST)) {
            $name = array_key_exists('name', $_POST) ? $_POST['name'] : '';

            $email = array_key_exists('email', $_POST) ? $_POST['email'] : '';

            $password = array_key_exists('password', $_POST) ? $_POST['password'] : '';

            $active = array_key_exists('active', $_POST) ? 1 : 0;

            try {
                if (empty($name))
                    throw new Exception('Preencha o campo Nome!');

                if (empty($email))
                    throw new Exception('Preencha o campo Email!');

                if (empty($password))
                    throw new Exception('Preencha o campo Senha!');

                $user = new User();
                $user->setName($name);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setActive($active);

                $userDao = new UserDao();

                if ($userDao->insert($user))
                    $message->addMessage('Usuário adicionado com sucesso!');
                else
                    throw new Exception('Problema ao adicionar um novo usuário.');

                $viewModel = array(
                    'users' => $userDao->getAll(),
                );

                $this->setRoute($this->view->getListRoute());
            } catch (Exception $e) {
                $this->setRoute($this->view->getCreateRoute());

                $message->addWarning($e->getMessage());
            }
        } else
            $this->setRoute($this->view->getCreateRoute());

        $this->showView($viewModel);

        return;
    }

    public function updateAction() {

        $message = Message::singleton();

        $id = array_key_exists('id', $_GET) ? $_GET['id'] : '';

        if (array_key_exists('save', $_POST)) {
            $name = array_key_exists('name', $_POST) ? $_POST['name'] : '';

            $email = array_key_exists('email', $_POST) ? $_POST['email'] : '';

            try {
                if (empty($name))
                    throw new Exception('Preencha o campo Nome!');

                if (empty($email))
                    throw new Exception('Preencha o campo Email!');

                $user = new User();
                $user->setId($id);
                $user->setName($name);
                $user->setEmail($email);

                if ($this->userDao->update($user))
                    $message->addMessage('Usuário alterado com sucesso!');
                else
                    throw new Exception('Problema ao alterar um o usuário.');

                $viewModel = array(
                    'users' => $this->userDao->getAll(),
                );

                $this->setRoute($this->view->getListRoute());
            } catch (Exception $e) {
                $this->setRoute($this->view->getUpdateRoute());

                $message->addWarning($e->getMessage());
            }
        } else {
            $viewModel = array(
                'user' => $this->userDao->getUser($id)
            );

            $this->setRoute($this->view->getUpdateRoute());
        }

        $this->showView($viewModel);

        return;
    }

    public function listAction() {
        $userDao = new UserDao();

        $viewModel = array(
            'users' => $userDao->getAll(),
        );

        $this->setRoute($this->view->getListRoute());

        $this->showView($viewModel);

        return;
    }

    public function deleteAction() {

        $message = Message::singleton();

        $id = array_key_exists('id', $_GET) ? $_GET['id'] : '';

        if ($this->userDao->delete($id))
            $message->addMessage('Usuário excluído com sucesso');

        $viewModel = array(
            'users' => $this->userDao->getAll(),
        );

        $this->setRoute($this->view->getListRoute());

        $this->showView($viewModel);

        return;
    }

    public function updatePasswordAction() {

        $message = Message::singleton();

        $viewModel = array();

        $id = array_key_exists('id', $_GET) ? $_GET['id'] : '';

        if (array_key_exists('save', $_POST)) {
            $currentPassword = array_key_exists('currentPassword', $_POST) ? $_POST['currentPassword'] : '';

            $newPassword = array_key_exists('newPassword', $_POST) ? $_POST['newPassword'] : '';

            $confirmPassword = array_key_exists('confirmPassword', $_POST) ? $_POST['confirmPassword'] : '';

            $viewModel = array(
                'users' => $this->userDao->getAll(),
                'user' => $this->userDao->getUser($id),
            );

            try {
                if (empty($currentPassword))
                    throw new Exception('Preencha o campo Senha Atual.');

                if (empty($newPassword))
                    throw new Exception('Preencha o campo Nova Senha.');

                if (empty($confirmPassword))
                    throw new Exception('Preencha o campo Confirme a Senha.');

                if (!$this->userDao->checkPassword($id, $currentPassword))
                    throw new Exception('Senha atual incorreta.');

                if ($newPassword != $confirmPassword)
                    throw new Exception('Senhas não conferem.');

                if (!$this->userDao->updatePassword($id, $newPassword))
                    throw new Exception('Problema ao alterar senha');

                $message->addMessage('Senha alterada com sucesso');

                $this->setRoute($this->view->getListRoute());
            } catch (PDOException $e) {
                $message->addWarning($e->getMessage());
            } catch (Exception $e) {
                $this->setRoute($this->view->getUpdatePasswordRoute());

                $message->addWarning($e->getMessage());
            }
        } else {
            $viewModel = array(
                'user' => $this->userDao->getUser($id),
            );

            $this->setRoute($this->view->getUpdatePasswordRoute());
        }



        $this->showView($viewModel);

        return;
    }

}
