<?php
namespace frans\Controllers;

class Furniture
{
    private $furnitureTable;
    private $get;
    private $post;

    public function __construct($furnitureTable,$categoriesTable, $newsTable, $picture, $pdo, array $get, array $post)
    {
        $this->furnitureTable = $furnitureTable;
        $this->categoriesTable = $categoriesTable;
        $this->newsTable = $newsTable;
        $this->picture = $picture;
        $this->pdo= $pdo;
        $this->get=$get;
        $this->post=$post;

    }

    public function list()
    {
      $categories = $this
          ->categoriesTable
          ->findAll();

      if (isset($this->get['id'])) {
        $furniture = $this
            ->furnitureTable
            ->find('categoryId', $this->get['id']);
        $subtitle = $this
            ->categoriesTable
            ->find('id', $this->get['id'])[0];
      }
      else
      {
        $furniture = $this
            ->furnitureTable
            ->findAll();
        $subtitle = 'Furniture';
      }

        return ['template' => 'public/furnitureList.html.php', 'title' => 'Our furniture', 'variables' => ['furniture' => $furniture, 'categories'=>$categories, 'subtitle'=>$subtitle]];
    }
    public function order()
    {
      $categories = $this
          ->categoriesTable
          ->findAll();

      if (isset($this->post['order']) && !isset($this->get['id'])) {
        $furniture = $this
            ->furnitureTable
            ->find('cond', $this->post['order']);
        $subtitle = 'Furniture';
      }
      elseif (isset($this->post['order']) && isset($this->get['id'])) {
        $result = $this
        ->furnitureTable
        ->find('categoryId', $this->get['id']);
        $furniture = [];
        foreach ($result as $res) {    
            if ($res->cond == $this->post['order']) {
                $furniture[]=$res;
            }
        }
        $subtitle = $this
        ->categoriesTable
        ->find('id', $this->get['id'])[0];      
      }
      else
      {
        $furniture = $this
            ->furnitureTable
            ->findAll();
        $subtitle = 'Furniture';
      }

        return ['template' => 'public/furnitureList.html.php', 'title' => 'Our furniture', 'variables' => ['furniture' => $furniture, 'categories'=>$categories, 'subtitle'=>$subtitle]];
    }
    public function delete()
    {
        $this
            ->furnitureTable
            ->delete($this->post['id']);

        header('location: /admin/furniture');
    }

    public function home()
    {
        $news = $this
            ->newsTable
            ->findAll();
        

        return ['template' => 'public/home.html.php', 'variables' => ['news' => $news], 'title' => 'Frans Furniture'];

    }

    public function about()
    {

        return ['template' => 'public/about.html.php', 'variables' => ['' => []], 'title' => 'About'];

    }
    public function faqs()
    {

        return ['template' => 'public/faqs.html.php', 'variables' => ['' => []], 'title' => 'FAQ\'s'];

    }
    public function validateFurniture($furniture){
        $errors = [];
        if ($furniture['name'] == '') {
            $errors[]= 'Enter a valid name';
        }
        if ($furniture['description'] == '') {
            $errors[]= 'Enter a valid description';
        }
        if ($furniture['price'] == '') {
            $errors[]= 'Enter a valid price';
        }
        if ($furniture['categoryId'] == '') {
            $errors[]= 'Enter a valid category';
        }
        if ($furniture['archived'] == '') {
            $errors[]= 'Enter a archive state';
        }
        if ($furniture['cond'] == '') {
            $errors[]= 'Enter a valid condition';
        }
        return $errors;
    }

    public function editSubmit()
    {
        $errors = $this->validateFurniture($this->post['furniture']);

        if (count($errors) == 0) {
        $furniture = $this->post['furniture'];
          $this
            ->furnitureTable
            ->save($this->post['furniture']);
            // @codeCoverageIgnoreStart
            if (isset($_FILES)) { 
            if ($this->pdo->lastInsertId() != 0) {
              $this
                  ->picture
                  ->upload('furniture', $this->pdo->lastInsertId());
            } else {
              $this
                  ->picture
                  ->upload('furniture', $this->post['furniture']['id']);
            }
        }
        // @codeCoverageIgnoreEnd
            return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
        }else {
            return $this->editForm($errors);
          }
    }
    public function editForm($errors = [])
    {
      $categories = $this
          ->categoriesTable
          ->findAll();
        if (isset($this->get['id']))
        {
            $result = $this
                ->furnitureTable
                ->find('id', $this->get['id']);
            $furniture = $result[0];
        }
        else
        {
            $furniture = false;
        }
        return ['template' => 'admin/adminEditFurniture.html.php', 'variables' => ['furniture' => $furniture,'categories' => $categories, 'errors'=>$errors], 'title' => 'Edit Furniture'];
    }
    public function adminFurniture()
    {
      $categories = $this
          ->categoriesTable
          ->findAll();

      if (isset($this->get['id'])) {
        $furniture = $this
            ->furnitureTable
            ->find('categoryId', $this->get['id']);
        $subtitle = $this
            ->categoriesTable
            ->find('id', $this->get['id'])[0];
      }
      else
      {
        $furniture = $this
            ->furnitureTable
            ->findAll();
        $subtitle = 'Furniture';
      }

        return ['template' => 'admin/adminFurniture.html.php', 'title' => 'Our furniture', 'variables' => ['furniture' => $furniture, 'categories'=>$categories, 'subtitle'=>$subtitle]];
    }
}
