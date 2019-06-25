<?php
namespace frans\Entity;

class Furniture
  {
    public $categoriesTable;

    public $id;
    public $name;
    public $description;
    public $price;
    public $categoryId;
    public $archived;
    public $cond;
    public function __construct(\classes\DatabaseTable $categoriesTable)
      {
        $this->categoriesTable = $categoriesTable;
      }
    public function getCategory()
      {
        return $this
            ->categoriesTable
            ->find('id', $this->categoryId) [0];
      }
  }
