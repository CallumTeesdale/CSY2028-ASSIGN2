<?php
namespace frans\Entity;

class News
  {
    public $userTable;

    public $id;
    public $title;
    public $description;
    public $date;
    public $adminId;

    public function __construct(\classes\DatabaseTable $userTable)
      {
        $this->userTable = $userTable;
      }
    public function getAuthor()
      {
        return $this
            ->userTable
            ->find('id', $this->adminId) [0];
      }
  }
