<?php
class User extends Model
{
    /** $db */
    public $db;

    /** $data */
    public $data;

    /** $message */
    public $message;

    /** $parameters */
    public $parameters;

    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parameters;
    }

    public function index()
    {
        $query = $this->db->query('SELECT * FROM user ORDER BY id DESC');
        return $query->fetchAll();
    }

    public function insert()
    {
        try {
            if (!$this->validate()) {
                return;
            }

            $userId = $this->db->insert('user', $_POST);
            if ($userId) {
                $this->setMessage('<div class="alert alert-success">Usuário cadastrado com sucesso!</div>');
                return $userId;
            }
            $this->setMessage('<div class="alert alert-danger">Erro ao cadastrar usuário!</div>');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getUser($id)
    {
        $query = $this->db->query('SELECT * FROM user where id = ' . $id);
        return $query->fetch();
    }

    public function update($id)
    {
        try {
            if (!$this->validate()) {
                return;
            }

            $user = $this->db->update('user', 'id', $id, $_POST);
            if ($user) {
                $this->setMessage('<div class="alert alert-success">Usuário alterado com sucesso!</div>');
                return $this->getUser($id);
            }

            $this->setMessage('<div class="alert alert-danger">Erro ao cadastrar usuário!</div>');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $delete = $this->db->delete('user', 'id', $id);
            if ($delete) {
                $this->setMessage('<div class="alert alert-success">Usuário deletado com sucesso!</div>');
                return;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function validate()
    {
        $this->data = [];
        if ('POST' != $_SERVER['REQUEST_METHOD'] && empty($_POST)) {
            return false;
        }

        foreach ($_POST as $field => $value) {
            $this->data[$field] = $value;
            if (empty($value)) {
                $this->setMessage('<div class="alert alert-success"> Campo .' . $field . ' está vazio. </div>');
                return false;
            }
        }

        if (empty($this->data)) {
            $this->setMessage('<div class="alert alert-success"> Formulário está vazio. </div>');
            return false;
        }

        return true;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
       return $this->message;
    }
}
