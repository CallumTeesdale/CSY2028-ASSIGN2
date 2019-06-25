<?php
use classes\DatabaseTable;
class databasetableTest extends \PHPUnit\Framework\TestCase {

    public function testSaveNonExisting()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $DatabaseTable= new DatabaseTable($pdo, 'category', 'id');
        $pdo->query('DELETE FROM category WHERE id = 10');
        $stmt = $pdo->query('SELECT * FROM category WHERE id = 10');
        //fetch the record
        $record = $stmt->fetch();
        //Check there is no record for john
        $this->assertFalse($record);
        $testPostData = [
            'category' => [
            'id'=>'10',
            'name' => 'test'
            ]
            ];
            $DatabaseTable->save($testPostData['category']);
            $stmt = $pdo->query('SELECT * FROM category WHERE id = 10');
            $record = $stmt->fetch();
            $this->assertEquals($record['id'],$testPostData['category']['id']);
            $this->assertEquals($record['name'],$testPostData['category']['name']);
    }
    public function testSaveExisting()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $DatabaseTable= new DatabaseTable($pdo, 'category', 'id');
        $stmt = $pdo->query('SELECT * FROM category WHERE id = 10');
        $record = $stmt->fetch();
        $this->assertNotEmpty($record);
        $testPostData = [
            'category' => [
            'id'=>'10',
            'name' => 'TestChange'
            ]
            ];
            $DatabaseTable->save($testPostData['category']);
            $stmt = $pdo->query('SELECT * FROM category WHERE id = 10');
            $record = $stmt->fetch();
            $this->assertEquals($record['id'],$testPostData['category']['id']);
            $this->assertEquals($record['name'],$testPostData['category']['name']);
    }
    public function testDelete()
    {
        $pdo=new \PDO('mysql:host=localhost;dbname=furniture;charset=utf8', 'student', 'student',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $DatabaseTable= new DatabaseTable($pdo, 'category', 'id');
            $id=10;
            $DatabaseTable->delete($id);
            $stmt = $pdo->query('SELECT * FROM category WHERE id = 10');
            $record = $stmt->fetch();
            $this->assertEmpty($record);
        }

}