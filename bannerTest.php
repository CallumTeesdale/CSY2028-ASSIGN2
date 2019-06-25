<?php
use frans\Controllers\Banner;


class bannerTest extends \PHPUnit\Framework\TestCase {
    private $controller;
    

    public function setUp()
    {
        $this->controller = new Banner();
    }

    public function testGetBanner()
    {     
        $this->controller->getBanner();
        //$result =file_get_contents('images/banner');
        //$this->assertNotEmpty($result);
    }
}
