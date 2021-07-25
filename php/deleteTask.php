<?php //Удаление задания

//Подключение RedBeanPHP
require 'rb.php';
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' );
session_start();

//Удаление сроки задания из БД с определенным id
$task = R::load('tasks', $_POST['id']);
R::trash( $task );

?>