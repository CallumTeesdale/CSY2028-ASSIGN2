<?php
namespace frans\Controllers;

use \DirectoryIterator;

class Banner
{
    public function getBanner()
    {
        $files = [];
        foreach (new DirectoryIterator('./images/banners') as $file) {
            if ($file->isDot()) {
                continue;
            }
            if (!strpos($file->getFileName(), '.jpg')) {
                continue;
            }
            $files[] = $file->getFileName();
        }
        $contents = $this->loadFile('./images/banners/' . $files[rand(0, count($files) - 1)]);
    }
    public function loadFile($name)
    {
        ob_start();
        include($name);
        $contents = ob_get_clean();
        return $contents;
    }
}
