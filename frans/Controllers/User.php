<?php
namespace frans\Controllers;

class User
  {
    private $userTable;
    private $get;
    private $post;
    public function __construct($userTable, array $get, array $post)
      {
        $this->userTable = $userTable;
        $this->get=$get;
        $this->post=$post;

      }
    
      public function validateRegistration($user){
        $errors = [];
        if ($user['username'] == '') {
          $errors[]= 'Enter a valid username';
        }
        if ($user['password'] == '') {
          $errors[]= 'Enter a valid password';
        }
        if ($user['fname'] == '') {
          $errors[]= 'Enter a valid first name';
        }
        if ($user['email'] == '') {
          $errors[]= 'Enter a valid last name';
        }
        if ($user['contact_no'] == '') {
          $errors[]= 'Enter a valid contact number';
        }
        if ($user['address'] == '') {
          $errors[]= 'Enter a valid address';
        }
  
        return $errors;
      }  
    
    public function Register()
      {
        $errors = $this->validateRegistration($this->post['user']);

        if (count($errors) == 0) {
        $password = $this->post['user']['password'];
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->post['user']['password'] = $hashed;
        $user = $this->post['user'];
        $this
            ->userTable
            ->save($user);
            return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
      }else {
        return $this->registerForm($errors);
      }
    }
    public function Login()
      {
        $user = $this
            ->userTable
            ->find('username', $this->post['user']['username']);
        if (password_verify($this->post['user']['password'], $user[0]->password))
          {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user[0]->username;
            $_SESSION['id'] = $user[0]->id;
            session_write_close();
            return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
          }
        else
          {
            $error = 'Incorrect Username or Password';
            return ['template' => 'admin/userLoginForm.html.php', 'variables' => ['errors' => [$error]], 'title' => 'Login'];
          }
      }
    
    
    public function registerForm($errors = [])
      {
        if (isset($this->get['id']))
          {
            $user = $this
                ->userTable
                ->find('id', $this->get['id']);
            $user = $user[0];
          }
        else
          {
            $user = false;
          }
        return ['template' => 'admin/createUser.html.php', 'variables' => ['user' => $user, 'errors'=>$errors], 'title' => 'Register User'];
      }

    public function loginForm()
      {
        if (!isset($_SESSION['loggedin']))
          {
            return ['template' => 'admin/userLoginForm.html.php', 'variables' => ['' => []], 'title' => 'Login'];
          }
        elseif (isset($_SESSION['loggedin']))
          {
            return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
          }
      }
    public function Logout()
      {
        session_destroy();
        return ['template' => 'admin/userLoginForm.html.php', 'variables' => ['' => []], 'title' => 'Login'];
      }

  }
?>
