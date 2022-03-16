<?php

include_once './Models/User.model.php';
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $created_at;
    private $model;

    public function __construct($username, $email, $password, $created_at = null, $id = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->model = new UserModel();
    }

    public static function is_logged()
    {
        if (!empty($_SESSION['user_id'])) {
            echo json_encode(['isLogged'=>true, 'username'=>$_SESSION['username'], 'email'=>$_SESSION['email']]);
        } else {
            echo json_encode(['isLogged'=>false]);
        }
    }

    public function login($data)
    {
        if (!isset($data['username'], $data['password'])) {
            var_dump($data);
            die(json_encode((['error' => 'no enough data provided'])));
        }
        $params = array($this->username);
        $res = $this->model->login($params);
        if (isset($res['password']) && password_verify($this->password, $res['password'])) {
            $_SESSION['user_id'] = $res['id'];
            $_SESSION['username'] = $this->username;
            $_SESSION['email'] = $this->email;
            echo json_encode(['logged'=>true]);
        } else {
            echo json_encode(['logged'=>false]);
        }
    }

    public function singup()
    {
        $params = array($this->username, $this->email, password_hash($this->password, PASSWORD_BCRYPT));
        // TODO: check for duplication
        try {
            $this->model->singup($params);
            echo json_encode(['logged'=>true]);
        } catch (Exception) {
            echo json_encode(['logged'=>false]);
        }
    }

    public function add()
    {
        $params = array($this->username, $this->email, $this->password);
        $this->id = $this->model->add($params);
    }

    public function update($params)
    {
        $this->username = isset($params['username']) ? $params['username'] : $this->username;
        $this->email = isset($params['email']) ? $params['email'] : $this->email;
        $this->password = isset($params['password']) ? $params['password'] : $this->password;
        $params = [$this->username, $this->email, $this->password, $this->id];
        $this->model->update($params);
    }

    public function delete()
    {
        $params = array($this->id);
        $this->model->delete($params);
    }

    public static function fetch_all()
    {
        $userModel = new UserModel();
        $result = $userModel->fetch_all();
        return $result;
    }

    public static function fetch_by_id($id)
    {
        $userModel = new UserModel();
        $user = $userModel->fetch_by_id($id);
        return new User($user['username'], $user['email'], $user['password'], $user['created_at'], $id);
    }

    public static function fetch_by_username($username)
    {
        $userModel = new UserModel();
        $user = $userModel->fetch_by_username($username);
        return $user;
    }
}
