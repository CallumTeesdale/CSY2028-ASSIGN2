<?php
namespace frans\Controllers;

class Admin

  {
    private $userTable;
    private $get;
    private $post;

    public function __construct($userTable, array $get, array $post)
      {
        $this->userTable = $userTable;
        $this->get=$get;
        $this->post=$post;

      }

    public function home()
      {
        return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
      }


  }
