<?php
namespace frans\Controllers;

class Contact
  {
    private $contactTable;
    private $get;
    private $post;

    public function __construct($contactTable, $userTable, array $get, array $post)
      {
        $this->contactTable = $contactTable;
        $this->userTable = $userTable;
        $this->get=$get;
        $this->post=$post;

      }

    public function list()
      {
        
        $contacts = $this
            ->contactTable
            ->findAll();
        return ['template' => 'admin/adminContacts.html.php', 'title' => 'All messages', 'variables' => ['contacts' => $contacts]];
      }

    public function delete()
      {
        $this
            ->contactTable
            ->delete($this->post['id']);
              
        header('location: /admin/contact');
      }
    
      public function validateContact($contact)
      {
        $errors = [];
        if ($contact['fname'] == '') {
          $errors[]= 'Enter a valid first name';
        }
        if ($contact['lname'] == '') {
          $errors[]= 'Enter a valid last name';
        }
        if ($contact['email'] == '') {
          $errors[]= 'Enter a valid email';
        }
        if ($contact['contact_no'] == '') {
          $errors[]= 'Enter a valid phone number';
        }
        if ($contact['enquiry'] == '') {
          $errors[]= 'Enter a valid enquiry';
        }
        return $errors;
      }  
    
    public function contactSubmit()
      {
        $errors = $this->validateContact($this->post['contact']);

        if (count($errors) == 0) {
        $contact = $this->post['contact'];
        $this
            ->contactTable
            ->save($contact);
            // @codeCoverageIgnoreStart
            if(isset($_SESSION['loggedin'])){
              header('Location: /admin/contact');
            }
            // @codeCoverageIgnoreEnd
            return ['template' => 'public/contactForm.html.php', 'variables' => ['contact' => $contact, 'errors' => $errors], 'title' => 'Contact'];
      }else {
        return $this->contactForm($errors);
      }

    }
    public function contactForm($errors = [])
      {
        if (isset($this->get['id']))
          {
            $result = $this
                ->contactTable
                ->find('id', $this->get['id']);
            $contact = $result[0];
          }
        else
          {
            $contact = false;
          }
        return ['template' => 'public/contactForm.html.php', 'variables' => ['contact' => $contact, 'errors' => $errors], 'title' => 'Contact'];
      }
  }

?>
