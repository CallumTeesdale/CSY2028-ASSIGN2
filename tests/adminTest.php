<?php
use frans\Controllers\Admin;
use classes\DatabaseTable;


class adminTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $userTable;
    

    public function setUp()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->userTable = new DatabaseTable($pdo, 'user', 'id');
        $this->controller = new Admin($this->userTable,[],[]);
    }

    public function testHome()
    {     
        $result = $this->controller->home();
        $this->assertEquals($result['template'], 'admin/adminHome.html.php');
    }
}
