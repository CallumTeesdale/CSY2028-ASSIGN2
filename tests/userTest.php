<?php
use frans\Controllers\User;
use classes\DatabaseTable;


class userTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $userTable;
    

    public function setUp()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->userTable = new DatabaseTable($pdo, 'user', 'id');
        $this->controller = new User($this->userTable,[],[]);
    }

    public function testAllValid(){
        $user = [
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => 'Test fname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => 'Test address'
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),0);
    }
    public function testAllInvalid(){
        $user = [
            'username' => '',
            'password' => '',
            'fname' => '',
            'email' => '',
            'contact_no' => '',
            'address' => ''
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),6);
    }
    public function testInvalidUsername(){
        $user = [
            'username' => '',
            'password' => 'Test password',
            'fname' => 'Test fname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => 'Test address'
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidPassword(){
        $user = [
            'username' => 'Test username',
            'password' => '',
            'fname' => 'Test fname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => 'Test address'
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidFname(){
        $user = [
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => '',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => 'Test address'
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidEmail(){
        $user = [
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => 'Test fname',
            'email' => '',
            'contact_no' => 'Test number',
            'address' => 'Test address'
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidNumber(){
        $user = [
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => 'Test fname',
            'email' => 'Test email',
            'contact_no' => '',
            'address' => 'Test address'
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidAddress(){
        $user = [
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => 'Test fname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => ''
    ];
    $errors = $this->controller->validateRegistration($user);
    $this->assertEquals(count($errors),1);
    }


    public function testUserSubmitNoErrors()
    {

        $user = [
            'user'=>[
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => 'Test fname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => 'Test address'
            ]
            ];
    $userTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $userTable->expects($this->once())
        ->method('save');
    $controller = new User($userTable,[],$user);
    $result = $controller->Register();
    $this->assertEquals($result['template'], 'admin/adminHome.html.php');
    }
    public function testUserSubmitErrors()
    {

        $user = [
            'user'=>[
            'username' => 'Test username',
            'password' => 'Test password',
            'fname' => '',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'address' => 'Test address'
            ]
            ];
    
    $controller = new User($this->userTable,[],$user);
    $result = $controller->Register();
    $this->assertEquals(count($result['variables']['errors']),1);
    }

    public function testUserEdit()
    {
        $id= [
            'id'=>'0'
        ];
    $controller = new User($this->userTable,$id,[]);
    $result = $controller->registerForm();
    $this->assertInstanceOf(stdClass::class,$result['variables']['user']);
    }

    public function testLoginNoErrors()
    {
        $testPostData=[
            'user'=>[
                'username'=>'admin',
                'password'=>'admin'
            ]
            ];
            $controller = new User($this->userTable,[],$testPostData);
    $result = $controller->Login();
    $this->assertEquals($result['template'], 'admin/adminHome.html.php');

    }
    public function testLoginErrors()
    {
        $testPostData=[
            'user'=>[
                'username'=>'admin',
                'password'=>'wrong'
            ]
            ];
            $controller = new User($this->userTable,[],$testPostData);
    $result = $controller->Login();
    $this->assertEquals($result['template'], 'admin/userLoginForm.html.php');
    }
 
    public function testLoginFormLoggedIn()
    {
        session_start();
        $_SESSION['loggedin']=true;
        $result = $this->controller->loginForm();
        $this->assertEquals($result['template'], 'admin/adminHome.html.php'); 
        session_destroy(); 
    }
    
    public function testLogout()
    {
        session_start();
        $result = $this->controller->Logout();
        $this->assertEquals($result['template'], 'admin/userLoginForm.html.php');   
    }
    public function testLoginFormLoggedInFalse()
    {
        $result = $this->controller->loginForm();
        $this->assertEquals($result['template'], 'admin/userLoginForm.html.php'); 
    }


}