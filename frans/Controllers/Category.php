<?php
namespace frans\Controllers;
class Category
  {
    private $categoriesTable;
    private $get;
    private $post;

    public function __construct($categoriesTable, array $get, array $post)
      {
        $this->categoriesTable = $categoriesTable;
        $this->get=$get;
        $this->post=$post;

      }

    public function list()
      {

        $categories = $this
            ->categoriesTable
            ->findAll();

        return ['template' => 'adminCategories.html.php', 'title' => 'Category List', 'variables' => ['categories' => $categories]];
      }

    public function find()
      {

        $category = $this
            ->categoriesTable
            ->find('id', $this->get['categoryId']);

        return ['template' => 'public/furnitureList.html.php', 'title' => 'Category List', 'category' => $category];
      }

    public function delete()
      {
        $this
            ->categoriesTable
            ->delete($this->post['id']);

        header('location: /admin/category');
      }
    public function validateCategory($category)
    {
      $errors = [];
      if ($category['name'] == '') {
        $errors[]= 'Enter a valid name';
      }
      return $errors;
    }

    public function editSubmit()
      {
        $errors = $this->validatecategory($this->post['category']);

        if (count($errors) == 0) {
          $category = $this->post['category'];
          $this
              ->categoriesTable
              ->save($category);
              return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
        }else {
          return $this->editForm($errors);
        }
      }
    public function editForm($errors = [])
      {
          if (isset($this->get['id']))
          {
              $result = $this
                  ->categoriesTable
                  ->find('id', $this->get['id']);
              $category = $result[0];
          }
          else
          {
              $category = false;
          }
          return ['template' => 'admin/adminEditCategory.html.php', 'variables' => ['category' => $category, 'errors' => $errors], 'title' => 'Edit Category'];
      }
      
    public function adminCategories()
        {

          $categories = $this
              ->categoriesTable
              ->findAll();

          return ['template' => 'admin/adminCategories.html.php', 'title' => 'Category List', 'variables' => ['categories' => $categories]];
        }
  }
