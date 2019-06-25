<?php
use classes\Picture;

class pictureTest extends \PHPUnit\Framework\TestCase {

    private $picture;
    

    public function setUp()
    {     
        $this->picture = new Picture();
    
        $_FILES = array(
        'image1'    =>  array( 
            'name'      =>  'test.jpg',
            'type'      =>  'image/jpeg',
            'tmp_name'  =>  __DIR__ . '/test.jpg',
            'error'     =>  0,
            'size'      =>  117786
        ),
        'image2'    =>  array( 
            'name'      =>  '',
            'type'      =>  '',
            'tmp_name'  =>  '',
            'error'     =>  4,
            'size'      =>  0
        ),
        'image3'    =>  array( 
            'name'      =>  '',
            'type'      =>  '',
            'tmp_name'  =>  '',
            'error'     =>  4,
            'size'      =>  0
        ),
        'image4'    =>  array( 
            'name'      =>  '',
            'type'      =>  '',
            'tmp_name'  =>  '',
            'error'     =>  4,
            'size'      =>  0
        ),
        'image5'    =>  array( 
            'name'      =>  '',
            'type'      =>  '',
            'tmp_name'  =>  '',
            'error'     =>  4,
            'size'      =>  0
        )
    );
    $_FILES['image1']['jpeg']=base64_encode(file_get_contents(__DIR__ . '/test.jpg', FILE_USE_INCLUDE_PATH));
    parent::setUp();
    
    }
    public function testUpload()
    {
        if(isset($_FILES)){
            print_r($_FILES['image1']);
        }
    $this->picture->upload('test','1');
    }
    }