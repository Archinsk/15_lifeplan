<?php //Редактирование задания

//Подключение RedBeanPHP
require 'rb.php';
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' );
session_start();

//Редактирование кортежа с записи задания с определенным id
$task = R::load('tasks', $_POST['id']);
if ($task->done == false) {
    $task->done = true;
    $task->completionDate = time();
} else {
    $task->done = false;
    $task->completionDate = NULL;
}
R::store($task);

?>