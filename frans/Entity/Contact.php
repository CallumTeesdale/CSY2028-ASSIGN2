<?php
namespace frans\Entity;

class Contact
  {
    public $userTable;

    public $id;

    public $name;

    public $fname;
    public $lname;
    public $email;
    public $contact_no;
    public $enquiry;
    public $adminId;

    public function __construct(\classes\DatabaseTable $userTable)
      {
        $this->userTable = $userTable;
      }
    public function getAdmin()
      {
        return $this
            ->userTable
            ->find('id', $this->adminId) [0];
      }
  }
