<?php //Добавление задания в список заданий

//Подключение RedBeanPHP
require 'rb.php';
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' );
session_start();

//Кортеж с данными для записи в БД
$category = R::dispense('categories');
    $category->login = $_SESSION['logged_user'];
    $category->keyword = $_POST['categName'];
    $category->icon = $_POST['categIcon'];
    $category->color = $_POST['categColor'];
R::store($category);

echo $category->id;

?>