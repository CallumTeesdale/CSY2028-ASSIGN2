<?php
use frans\Controllers\News;
use classes\DatabaseTable;
use classes\Picture;

class newsTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $newsTable;
    

    public function setUp()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->userTable = new DatabaseTable($pdo, 'user', 'id');
        $this->picture = new Picture();
        $this->newsTable = new DatabaseTable($pdo, 'news', 'id');
        $this->controller = new News($this->newsTable, $this->userTable,$this->picture,$pdo,[],[]);
    }
    public function testAllValid(){
        $news = [
            'title' => 'Test',
            'description' => 'Test Description'
    ];
    $errors = $this->controller->validateNews($news);
    $this->assertEquals(count($errors),0);
    }
    public function testInvalidTitle(){
        $news = [
            'title' => '',
            'description' => 'Test Description'
    ];
    $errors = $this->controller->validateNews($news);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidDescription(){
        $news = [
            'title' => 'Test',
            'description' => ''
    ];
    $errors = $this->controller->validateNews($news);
    $this->assertEquals(count($errors),1);
    }

    public function testAdminNews()
    {
        $result = $this->controller->adminNews();
        $this->assertEquals($result['template'], 'admin/viewNews.html.php');
    }
    public function testNewsSubmitNoErrors()
    {
        $_SESSION['id']=1;
        $ses=$_SESSION['id'];
        $date = new \DateTime();
        $date1=$date->format('Y-m-d H:i:s');
        $testData = [
            'news'=>[
                'id'=>'1',
            'title'=>'test',
            'description' => 'Test',
            'date' => $date1,
            'adminId'=>$ses
            ]
    ];
    $newsTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $newsTable->expects($this->once())
        ->method('save')
        ->with($this->equalTo($testData['news']));
    $controller = new News($newsTable, $this->userTable,$this->picture,$this->pdo,[],$testData);
    $result = $controller->editSubmit();
    $this->assertEquals($result['template'], 'admin/adminHome.html.php');
    }
    public function testNewsSubmitErrors()
    {
        $_SESSION['id']=1;
        $ses=$_SESSION['id'];
        $date = new \DateTime();
        $date1=$date->format('Y-m-d H:i:s');
        $testData = [
            'news'=>[
                'id'=>'1',
            'title'=>'test',
            'description' => '',
            'date' => $date1,
            'adminId'=>$ses
            ]
    ];
    $controller = new News($this->newsTable, $this->userTable,$this->picture,$this->pdo,[],$testData);
    $result = $controller->editSubmit();
    $this->assertEquals(count($result['variables']['errors']),1);
    }
    public function testnewsFormNoID()
    {
        $result = $this->controller->editForm();
        $this->assertEquals($result['template'], 'admin/newsForm.html.php');   
    }
    public function testnewsFormID()
    {
        $id=[
            'id' => '1'
        ];
        $controller = new News($this->newsTable, $this->userTable,$this->picture,$this->pdo,$id,[]);
        $result = $controller->editForm();
        $this->assertEquals($result['template'], 'admin/newsForm.html.php');  
        $this->assertInstanceOf(stdClass::class,$result['variables']['news']);
    }
    public function testNewsDelete()
    {
        $testData=['id'=>'8'];
        $newsTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $newsTable->expects($this->once())
        ->method('delete')
        ->with($this->equalTo($testData['id']));
        $controller = new News($newsTable, $this->userTable,$this->picture,$this->pdo,[],$testData);
        $controller->delete(); 
    }

}
