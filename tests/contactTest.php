<?php
use frans\Controllers\Contact;
use classes\DatabaseTable;

class contactTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    private $contactTable;
    

    public function setUp()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student');
        $this->userTable = new DatabaseTable($pdo, 'user', 'id');
        $this->contactTable = new DatabaseTable($pdo, 'contact', 'id');
        $this->controller = new Contact($this->contactTable, $this->userTable,[],[]);
    }
    public function testAllValid(){
        $contact = [
            'fname' => 'Test fname',
            'lname' => 'Test lname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'enquiry' => 'Test enquiry'
    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),0);
    }
    public function testAllInvalid(){
        $contact = [
            'fname' => '',
            'lname' => '',
            'email' => '',
            'contact_no' => '',
            'enquiry' => ''
    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),5);
    }
    public function testInvalidFName(){
        $contact = [
            'fname' => '',
            'lname' => 'Test lname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'enquiry' => 'Test enquiry'
    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidLName(){
        $contact = [
            'fname' => 'Test fname',
            'lname' => '',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'enquiry' => 'Test enquiry'
    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidEmail(){
        $contact = [
            'fname' => 'Test fname',
            'lname' => 'Test Lname',
            'email' => '',
            'contact_no' => 'Test number',
            'enquiry' => 'Test enquiry'
    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidContactNo(){
        $contact = [
            'fname' => 'Test fname',
            'lname' => 'Test lname',
            'email' => 'Test email',
            'contact_no' => '',
            'enquiry' => 'Test enquiry'
    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),1);
    }
    public function testInvalidEnquiry(){
        $contact = [
            'fname' => 'Test fname',
            'lname' => 'Test lname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'enquiry' => ''

    ];
    $errors = $this->controller->validateContact($contact);
    $this->assertEquals(count($errors),1);
    }

    public function testList()
    {     
        $result = $this->controller->list();
        $this->assertEquals($result['template'], 'admin/adminContacts.html.php');
        $this->assertInstanceOf(stdClass::class,$result['variables']['contacts'][0]);
    }
    public function testContactFormNoID()
    {
        $result = $this->controller->contactForm();
        $this->assertEquals($result['template'], 'public/contactForm.html.php');   
    }
    public function testContactFormID()
    {
        $id=[
            'id' => '1'
        ];
        $controller = new Contact($this->contactTable, $this->userTable,$id,[]);
        $result = $controller->contactForm();
        $this->assertEquals($result['template'], 'public/contactForm.html.php');  
        $this->assertInstanceOf(stdClass::class,$result['variables']['contact']); 
    }

    public function testContactSubmitErrors()
    {
        $contact = [
            'contact' =>[
            'fname' => 'Test fname',
            'lname' => 'Test lname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'enquiry' => '',
            'dealt' => '0'
        ]   
    ];
    $controller = new Contact($this->contactTable, $this->userTable,[],$contact);
    $result = $controller->contactSubmit();
    $this->assertEquals($result['template'], 'public/contactForm.html.php');
    $this->assertEquals(count($result['variables']['errors']),1);
    }
    public function testContactSubmitNoErrors()
    {
        $testData = [
            'contact' =>[
            'fname' => 'Test fname',
            'lname' => 'Test lname',
            'email' => 'Test email',
            'contact_no' => 'Test number',
            'enquiry' => 'Test Enquiry',
            'dealt' => '0'
        ]   
    ];
    $contactTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $contactTable->expects($this->once())
        ->method('save')
        ->with($this->equalTo($testData['contact']));
    $controller = new Contact($contactTable, $this->userTable,[],$testData);
    $result = $controller->contactSubmit();
    $this->assertEquals($result['template'], 'public/contactForm.html.php');
    $this->assertEquals(count($result['variables']['errors']),0);
    }

    public function testContactDelete()
    {
        $testData=['id'=>'8'];
        $contactTable = $this->getMockBuilder('\classes\DatabaseTable')->disableOriginalConstructor()->getMock();
         $contactTable->expects($this->once())
        ->method('delete')
        ->with($this->equalTo($testData['id']));
        $controller = new Contact($contactTable, $this->userTable,[],$testData);
        $controller->delete(); 
    }
}