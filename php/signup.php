<?php //Регистрация пользователя

//Подключение RedBeanPHP
require 'rb.php';
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' );
session_start();

// Проверка уникальности выбранного логина
if ( R::count('users', "login = ?", array($_POST['signupLogin'])) > 0) {
  echo 'Логин уже занят';

// Регистрация пользователя
} else {
  $user = R::dispense('users');
    $user->login = $_POST['signupLogin'];
    $user->password = password_hash($_POST['signupPassword'], PASSWORD_DEFAULT);
  R::store($user);
  $_SESSION['logged_user'] = $_POST['signupLogin'];
};

?>