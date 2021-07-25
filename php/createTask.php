<?php //Добавление задания в список заданий

//Подключение RedBeanPHP
require 'rb.php';
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' );
session_start();

//Кортеж с данными для записи в БД
$task = R::dispense('tasks');
    $task->login = $_SESSION['logged_user'];
    $task->task = $_POST['inputTask'];
    $task->done = false;
    $task->creationDate = time();
R::store($task);

echo $task->id;

?>