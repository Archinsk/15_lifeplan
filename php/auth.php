<?php //Авторизация пользователя

//Подключение RedBeanPHP
require 'rb.php';
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' );
session_start();
$data = $_POST;
// Проверка наличия пользователя в базе и соответствия пароля
$user = R::findOne('users', 'login = ?', array($data['userLogin']) );
if ( $user ) {
  if ( password_verify($_POST['userPassword'], $user->password) ) {
    $_SESSION['logged_user'] = $_POST['userLogin'];
  } else {
    echo 'Неверно введен пароль!';
  };
} else {
  echo 'Пользователь не зарегистрирован!';
};

?>