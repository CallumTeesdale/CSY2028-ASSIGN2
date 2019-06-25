<?php
use frans\Controllers\Furniture;
use classes\DatabaseTable;
use classes\Picture;

class furnitureTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $furnitureTable;
    private $categoriesTable;
    private $newsTable;
    private $picture;
    

    public function setUp()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->furnitureTable = new DatabaseTable($pdo, 'furniture', 'id');
        $this->categoriesTable = new DatabaseTable($pdo, 'category', 'id');
        $this->picture = new Picture();
        $this->newsTable = new DatabaseTable($pdo, 'news', 'id');
        $this->controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$pdo,[],[]);
    }

    public function testAllValid(){
        $furniture = [
            'name' => 'Test',
            'description' => 'Test Description',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => 'NEW'
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),0);
    }



    public function testInvalidCondition(){
        $furniture = [
            'name' => 'Test',
            'description' => 'Test Description',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => ''
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),1);
    }

    public function testInvalidArchive(){
        $furniture = [
            'name' => 'Test',
            'description' => 'Test Description',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '',
            'cond' => 'NEW'
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),1);
    }


    public function testInvalidCategoryId(){
        $furniture = [
            'name' => 'Test',
            'description' => 'Test Description',
            'price' => '15.00',
            'categoryId' => '',
            'archived' => '0',
            'cond' => 'NEW'
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),1);
    }

    public function testInvalidPrice(){
        $furniture = [
            'name' => 'Test',
            'description' => 'Test Description',
            'price' => '',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => 'NEW'
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidDescription(){
        $furniture = [
            'name' => 'Test',
            'description' => '',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => 'NEW'
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidName(){
        $furniture = [
            'name' => '',
            'description' => 'Test',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => 'NEW'
    ];
    $errors = $this->controller->validateFurniture($furniture);
    $this->assertEquals(count($errors),1);
    }


    public function testAllInvalid(){
            $furniture = [
                'name' => '',
                'description' => '',
                'price' => '',
                'categoryId' => '',
                'archived' => '',
                'cond' => ''
        ];
        $errors = $this->controller->validateFurniture($furniture);
        $this->assertEquals(count($errors),6);

    }
    public function testList()
    {     
        $result = $this->controller->list();
        $this->assertEquals($result['template'], 'public/furnitureList.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['furniture'][0]);
        $this->assertInstanceOf(stdClass::class,$result['variables']['categories'][0]);
    }
    public function testListIdSet()
    {     
        $id=[
            'id' => '1'
        ];
        $controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,$id,[]);
        $result = $controller->list();
        $this->assertEquals($result['template'], 'public/furnitureList.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['furniture'][0]);
        $this->assertInstanceOf(stdClass::class,$result['variables']['categories'][0]);
    }
    public function testFurnitureFormNoID()
    {
        $result = $this->controller->editForm();
        $this->assertEquals($result['template'], 'admin/adminEditFurniture.html.php');   
    }
    public function testFurnitureFormID()
    {
        $id=[
            'id' => '1'
        ];
        $controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,$id,[]);
        $result = $controller->editForm();
        $this->assertEquals($result['template'], 'admin/adminEditFurniture.html.php');  
        $this->assertInstanceOf(stdClass::class,$result['variables']['furniture']);
        $this->assertInstanceOf(stdClass::class,$result['variables']['categories'][0]);
    }

    public function testHome()
    {
        $result = $this->controller->home();
        $this->assertEquals($result['template'], 'public/home.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['news'][0]);
    }

    public function testAbout() {
        $result = $this->controller->about();
        $this->assertEquals($result['template'], 'public/about.html.php');
    }

    public function testFAQS()
    {
        $result = $this->controller->faqs();
        $this->assertEquals($result['template'], 'public/faqs.html.php');
    }

    public function testAdminFurnitureNoID()
    {
        $result = $this->controller->adminFurniture();
        $this->assertEquals($result['template'], 'admin/adminFurniture.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['furniture'][0]);
        $this->assertInstanceOf(stdClass::class,$result['variables']['categories'][0]);
    }
    public function testAdminFurnitureID()
    {
        $id=[
            'id' => '1'
        ];
        $controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,$id,[]);
        $result = $controller->adminFurniture();
        $this->assertEquals($result['template'], 'admin/adminFurniture.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['furniture'][0]);
        $this->assertInstanceOf(stdClass::class,$result['variables']['categories'][0]);
    }
    public function testFurnitureSubmitNoErrors()
    {
        $testData = [
            'furniture'=>[
            'id'=>'1',
            'name' => 'Test',
            'description' => 'Test Description',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => 'NEW'
            ]
    ];
    $furnitureTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $furnitureTable->expects($this->once())
        ->method('save')
        ->with($this->equalTo($testData['furniture']));
    $controller = new Furniture($furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,[],$testData);
    $result = $controller->editSubmit();
    $this->assertEquals($result['template'], 'admin/adminHome.html.php');
    }
    public function testFurnitureSubmitErrors()
    {
        $testData = [
            'furniture'=>[
            'id'=>'1',
            'name' => '',
            'description' => 'Test Description',
            'price' => '15.00',
            'categoryId' => '1',
            'archived' => '0',
            'cond' => 'NEW'
            ]
    ];

    $controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,[],$testData);
    $result = $controller->editSubmit();
    $this->assertEquals(count($result['variables']['errors']),1);
    }
    
    public function testFurnituretDelete()
    {
        $testData=['id'=>'8'];
        $furnitureTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $furnitureTable->expects($this->once())
        ->method('delete')
        ->with($this->equalTo($testData['id']));
        $controller = new Furniture($furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,[],$testData);
        $controller->delete(); 
    }


    public function testOrderNoGet()
    {
        $testPostData=[
            'order'=>'NEW'
        ];
        $controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,[],$testPostData);
        $results = $controller->order();
        foreach ($results['variables']['furniture'] as $r) {
           $this->assertEquals($r->cond, 'NEW');  
        } 
    }

    public function testOdrderGet()
    {
        $testPostData=[
            'order'=>'NEW'
        ];
        $testGetData=[
            'id'=>'1'
        ];
        $controller = new Furniture($this->furnitureTable, $this->categoriesTable,$this->newsTable,$this->picture,$this->pdo,$testGetData,$testPostData);
        $results = $controller->order();
        foreach ($results['variables']['furniture'] as $r) {
           $this->assertEquals($r->cond, 'NEW');  
        } 
    }

    public function testOrder()
    {
        $result = $this->controller->order();
        $this->assertEquals($result['template'], 'public/furnitureList.html.php'); 
    }
}