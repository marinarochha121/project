<?php
class userController extends Controller
{
    public function index()
    {
        $model = $this->load_model('user');
        $users =  $model->index();
        $message = $model->getMessage();
        require_once ABSPATH . '/views/index.php';
    }

    public function add()
    {
        $model = $this->load_model('user');
        $message = $model->getMessage();
        require_once ABSPATH . '/views/user.php';
    }

    public function insert()
    {
        $model = $this->load_model('user');
        $userId = $model->insert();
        if ($userId) {
            header('Location: edit/' . $userId);
        }
        $message = $model->getMessage();
        require_once ABSPATH . '/views/user.php';
    }

    public function edit()
    {
        $model = $this->load_model('user');
        $message = $model->getMessage();
        $user = $model->getUser($this->parameters[0]);
        require_once ABSPATH . '/views/user.php';
    }

    public function update()
    {
        $model = $this->load_model('user');
        $user = $model->update($this->parameters[0]);
        $message = $model->getMessage();
        header('Location: ' . HOME_URI .  '/edit/' . $this->parameters[0]);
    }

    public function delete()
    {
        $model = $this->load_model('user');
        $delete = $model->delete($this->parameters[0]);
        $message = $model->getMessage();
        header('Location: ' . HOME_URI . '/index');
    }
}
