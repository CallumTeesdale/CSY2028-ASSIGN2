<?php
use frans\Controllers\Category;
use classes\DatabaseTable;

class categoryTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $categoriesTable;
    

    public function setUp()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->categoriesTable = new DatabaseTable($pdo, 'category', 'id');
        $this->controller = new Category($this->categoriesTable,[],[]);
    }
    public function testAllValid(){
        $category = [
            'name' => 'Test'
    ];
    $errors = $this->controller->validateCategory($category);
    $this->assertEquals(count($errors),0);
    }
    public function testInvalid(){
        $category = [
            'name' => ''
    ];
    $errors = $this->controller->validateCategory($category);
    $this->assertEquals(count($errors),1);
    }
    public function testList()
    {     
        $result = $this->controller->list();
        $this->assertEquals($result['template'], 'adminCategories.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['categories'][0]);
    }

    public function testCategoryDelete()
    {
        $testData=['id'=>'8'];
        $categoriesTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $categoriesTable->expects($this->once())
        ->method('delete')
        ->with($this->equalTo($testData['id']));
        $controller = new Category($categoriesTable,[],$testData);
        $controller->delete(); 
    }

    public function testCategorySubmitNoErrors()
    {
        $testData=[
            'category'=>[
            'name'=>'test'
            ]
        ];
        $categoriesTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $categoriesTable->expects($this->once())
        ->method('save')
        ->with($this->equalTo($testData['category']));
        $controller = new Category($categoriesTable,[],$testData);
        $result = $controller->editSubmit();
        $this->assertEquals($result['template'], 'admin/adminHome.html.php');
    }


    public function testCategorySubmitErrors()
    {
        $testData=[
            'category'=>[
            'name'=>''
            ]
        ];
        $controller = new Category($this->categoriesTable,[],$testData);
        $result = $controller->editSubmit();
        $this->assertEquals(count($result['variables']['errors']),1);
    }
    public function testCategoryFormNoID()
    {
        $result = $this->controller->editForm();
        $this->assertEquals($result['template'], 'admin/adminEditCategory.html.php');   
    }
    
    public function testFurnitureFormID()
    {
        $id=[
            'id' => '1'
        ];
        $controller = new Category($this->categoriesTable,$id,[]);
        $result = $controller->editForm();
        $this->assertEquals($result['template'], 'admin/adminEditCategory.html.php');  
        $this->assertInstanceOf(stdClass::class,$result['variables']['category']);
    }

    public function testAdminCategories()
    {
        $result = $this->controller->adminCategories();
        $this->assertEquals($result['template'], 'admin/adminCategories.html.php');
    }

    public function testFind()
    {
        $id=[
            'categoryId' => '1'
        ];
        $controller = new Category($this->categoriesTable,$id,[]);
        $result = $controller->find();
        $this->assertEquals($result['template'], 'public/furnitureList.html.php');
    }
    

}