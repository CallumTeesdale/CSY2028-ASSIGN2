<?php
namespace frans;

class Routes implements \classes\Routes
{
    public function getRoutes()
    {
        require '../database.php';
        $picture= new \classes\Picture();
        $categoriesTable = new \classes\DatabaseTable($pdo, 'category', 'id');
        $userTable = new \classes\DatabaseTable($pdo, 'user', 'id');
        $newsTable = new \classes\DatabaseTable($pdo, 'news', 'id','\frans\Entity\News', [$userTable]);
        $contactTable = new \classes\DatabaseTable($pdo, 'contact', 'id','\frans\Entity\Contact', [$userTable]);
        $furnitureTable = new \classes\DatabaseTable($pdo, 'furniture', 'id', '\frans\Entity\Furniture', [$categoriesTable]);

        $categoryController = new \frans\Controllers\Category($categoriesTable, $_GET, $_POST);
        $userController = new \frans\Controllers\User($userTable,$_GET, $_POST);
        $newsController = new \frans\Controllers\News($newsTable, $userTable, $picture, $pdo,$_GET, $_POST);
        $furnitureController = new \frans\Controllers\Furniture($furnitureTable, $categoriesTable, $newsTable, $picture, $pdo,$_GET, $_POST);
        $adminController = new \frans\Controllers\Admin($userTable,$_GET, $_POST);
        $contactController = new \frans\Controllers\Contact($contactTable, $userTable,$_GET, $_POST);
        $bannerController = new \frans\Controllers\Banner();



        $furnitureObject = new \frans\Entity\Furniture($categoriesTable);
        $newsObject = new \frans\Entity\News($userTable);
        $contactObject = new \frans\Entity\Contact($userTable);

        $routes = [
        '' => ['GET' => ['controller' => $furnitureController, 'function' => 'home']],

        'about' => ['GET' => ['controller' => $furnitureController, 'function' => 'about']],

        'faqs' => ['GET' => ['controller' => $furnitureController, 'function' => 'faqs']],

        'contact/delete' => [
          'POST' => ['controller' => $contactController, 'function' => 'delete'],
          'login' => true],

        'contact' => [
          'GET' => ['controller' => $contactController, 'function' => 'contactForm'],

          'POST' => ['controller' => $contactController, 'function' => 'contactSubmit']],

        'images/banner' => ['GET' => ['controller' => $bannerController, 'function' => 'getBanner']],

        'furniture/order' => ['GET' => ['controller' => $furnitureController, 'function' => 'order']],

          
        'furniture/list' => [
          'GET' => ['controller' => $furnitureController, 'function' => 'list'],

          'POST' => ['controller' => $furnitureController, 'function' => 'order']],

          'furniture/edit' => [
            'GET' => ['controller' => $furnitureController, 'function' => 'editForm'],
  
            'POST' => ['controller' => $furnitureController, 'function' => 'editSubmit']],

        'furniture/delete' => ['POST' => ['controller' => $furnitureController, 'function' => 'delete'],
         'login' => true],

        'category/edit' => [
          'GET' => ['controller' => $categoryController, 'function' => 'editForm'],

          'POST' => ['controller' => $categoryController, 'function' => 'editSubmit'],
        'login' => true],

        'category/delete' => ['POST' => ['controller' => $categoryController, 'function' => 'delete'],
        'login' => true],

        'admin/register' => [
          'GET' => ['controller' => $userController, 'function' => 'registerForm'],

          'POST' => ['controller' => $userController, 'function' => 'Register'],
        'login' => true],


        'admin/login' => [
          'GET' => ['controller' => $userController, 'function' => 'loginForm'],

          'POST' => ['controller' => $userController, 'function' => 'Login'],
        ],

        'admin/logout' => [
          'GET' => ['controller' => $userController, 'function' => 'Logout'],
        'login' => true],

        'admin/home' => [
          'GET' => ['controller' => $adminController, 'function' => 'home'],
        'login' => true],

        'admin/furniture' => ['GET' => ['controller' => $furnitureController, 'function' => 'adminFurniture'],
        'login' => true],

        'admin/category' => ['GET' => ['controller' => $categoryController, 'function' => 'adminCategories'],
        'login' => true],

        'admin/contact' => ['GET' => ['controller' => $contactController, 'function' => 'list'],
        'login' => true],

        'admin/newsList' => ['GET' => ['controller' => $newsController, 'function' => 'adminnews'],
        'login' => true],
        'news/delete' => ['POST' => ['controller' => $newsController, 'function' => 'delete'],
        'login' => true],

        'admin/news' => [
          'GET' => ['controller' => $newsController, 'function' => 'editForm'],

          'POST' => ['controller' => $newsController, 'function' => 'editSubmit'],
        'login' => true],
        ];

        return $routes;
    }
    public function checkLogin()
    {
        if (!isset($_SESSION['loggedin']))
        {
            header('location: /');
        }
    }

}
?>