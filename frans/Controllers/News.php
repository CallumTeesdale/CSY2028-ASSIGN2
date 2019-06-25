<?php
namespace frans\Controllers;

class News

  {
    private $newsTable;
    private $get;
    private $post;

    public function __construct($newsTable ,$userTable, $picture, $pdo, array $get, array $post)
      {
        $this->newsTable = $newsTable;
        $this->userTable = $userTable;
        $this->picture = $picture;
        $this->pdo= $pdo;
        $this->get=$get;
        $this->post=$post;

      }

      public function validateNews($news){
        $errors = [];
        if ($news['title'] == '') {
          $errors[]= 'Enter a valid title';
        }
        if ($news['description'] == '') {
          $errors[]= 'Enter a valid description';
        }
        return $errors;
      }
      public function delete()
    {
        $this
            ->newsTable
            ->delete($this->post['id']);

        header('location: /admin/newsList');
    }
      public function editSubmit()
        {
          $errors = $this->validateNews($this->post['news']);

        if (count($errors) == 0) {
           $date = new \DateTime();
           $this->post['news']['date'] = $date->format('Y-m-d H:i:s');
           $this->post['news']['adminId'] = $_SESSION['id'];
            $this
                ->newsTable
                ->save($this->post['news']);
          // @codeCoverageIgnoreStart
          if (isset($_FILES)) { 
            if ($this->pdo->lastInsertId() != 0) {
              $this
                  ->picture
                  ->upload('news', $this->pdo->lastInsertId());
            } else {
              $this
                  ->picture
                  ->upload('news', $this->post['news']['id']);
            }
          }
                // @codeCoverageIgnoreEnd
                return ['template' => 'admin/adminHome.html.php', 'variables' => ['' => []], 'title' => 'Admin Area'];
        }else {
          return $this->editForm($errors);
        }
      }

      public function editForm($errors =[])
        {
            if (isset($this->get['id']))
            {
                $result = $this
                    ->newsTable
                    ->find('id', $this->get['id']);
                $news = $result[0];
            }
            else
            {
                $news = false;
            }
            return ['template' => 'admin/newsForm.html.php', 'variables' => ['news' => $news, 'errors' =>$errors], 'title' => 'Edit News'];
        }
      public function adminnews()
          {

            $news = $this
                ->newsTable
                ->findAll();

            return ['template' => 'admin/viewNews.html.php', 'title' => 'News List', 'variables' => ['news' => $news]];
          }







  }
