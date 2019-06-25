<?php
namespace classes;

class Picture
{
    public function upload($path, $fileName)
    {
        for ($i = 1; $i < 5; $i++) {
            if (isset($_FILES['image' . $i]) && $_FILES['image' . $i]['error'] == 0) {
                $image = $fileName . '_' . $i . '.jpg';
                move_uploaded_file($_FILES['image' . $i]['tmp_name'], "images/$path/" . $image);
            }
        }
    }
}

