<?php
// Страница авторизации

// Подключаем RedBeanPHP
require 'php/rb.php';

// Соединямся с БД
R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' ); //Указываем адрес сервера, имя базы, логин и пароль пользователя (синтаксис RedBeanPHP)

session_start();

//Если на этой странице оказался незарегистрированный или разлогиненный пользователь, то переводим его на стартовую страницу
if(!$_SESSION) {
  header('Location: index.php');
}

// В переменную data кладем все что передается от формы
$data = $_POST;
if(isset($data['do_login'])) { //Если нажата кнопка Войти.
//Создаем массив ошибок
  $errors = array();
//Ищем пользователя по логину
  $user = R::findOne('users', 'login = ?', array($data['userLogin']));
//Если логин существует,
    if ( $user ) { 
//то проверяем пароль
        if ( password_verify($data['userPassword'], $user->password) )
        {
            //если пароль совпадает, то нужно авторизовать пользователя
            $userarray=$user->export();
            $_SESSION['logged_user'] = $userarray['login'];
            echo '<div style="color:dreen;">'  .$_SESSION['logged_user']. ', вы авторизованы!<hr>';
        }else
        {
            $errors[] = 'Неверно введен пароль!';
        }
 
    } else { //иначе (пользователь не найден)
      $errors[] = 'Пользователь с таким логином не найден!';
    }
//Вывод ошибок
    if ( ! empty($errors) ) { //Если массив с ошибками не пуст
      echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>'; // то выводим ошибки авторизации
    }
}

?>

<!DOCTYPE html> <!-- Документ HTML5 -->
<html lang='ru'>
  <head>
    <meta charset='utf-8'> <!-- Установка кодировки -->
    <meta name='viewport' content='width=device-width, initial-scale=1'> <!-- Для правильного масштабирования и установки ширины страницы на мобильных устройствах -->

    <!-- Блок загрузки фрэймворков для работы Bootstrap -->
      <!-- jQuery library -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <!-- Popper JS -->
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <!-- Последняя скомпилированная и оптимизированная версия CSS Bootstrap -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <!-- Последняя скомпилированная и оптимизированная версия JavaScript Bootstrap -->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Стили плавающих подсказок форм -->
    <link href="css/floating-labels.css" rel="stylesheet">

    <!-- Загрузка иконок Google -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
	
    <!-- Стили записей с делами -->
    <link rel="stylesheet" href="css/lifeplan_style.css">
	
	<title>Life Plan. Список дел</title> <!-- Название вкладки в браузере -->
  </head>
  

<body>

<div class="container col-md-6 p-0">
  <div class="header m-0">
    <a href="lifeplan_auth.php">
      <img  id="logo" src="images/lifeplan_logo.jpg">
	</a>
    <img id="avatar" src="images/logout_back.jpg">
    <a href="logout.php">
      <img  src="images/logout_btn.png">
    </a>
  </div>
</div>

<div class="container col-md-6 pt-2 pb-3">

<div id="list">

<?php
//Определяем Timestamp начала текущего дня
$timestampNow = time();
$startOfToday = floor ( ( $timestampNow + (7*60*60) ) / ( 24*60*60 ) ) * ( 24*60*60 ) - (7*60*60);

//Ищем и выдаем записи выполненные до сегодняшнего дня
$tasklist = R::find( 'tasks', 'done = :done AND completion_date < :startOfToday ORDER BY completion_date DESC', [':done' => true, ':startOfToday' => $startOfToday]);
  foreach( $tasklist as $task)
  {
    if($task->login == $_SESSION['logged_user'])
    {
        if($task->done == '1'){
          $checkedTask = ' checked';
        } else {
          $checkedTask = ' ';
        }
	$finishDate2 = getdate($task->completion_date + 60*60*4)['mday'] . ' ' . getdate($task->completion_date + 60*60*4)['month'] . ' ' . getdate($task->completion_date + 60*60*4)['year'];
	if ($finishDate2 != $finishDate1) {
    echo '
<div class="badge badge-secondary">' .$finishDate2. '</div>';
    }
    echo '
<form style="position: relative;" action="php/deleteTask.php" method="POST">
  <button class="btn btn-block" type="submit" style="padding: 0; border:0; background-color:transparent" name="editTask" value="' .$task->id. '">
    <div class="alert alert-secondary alert-dismissible fade show mb-0' .$checkedTask. '" role="alert">'
	.$task->task.
//  ' ' .sprintf("%02d", getdate($task->completion_date + 60*60*4)['hours']). ':' .sprintf("%02d", getdate($task->completion_date)['minutes']). ':' .sprintf("%02d", getdate($task->completion_date)['seconds']). 
  ' </div>
  </button>
  <button type="submit"  class="close" aria-label="Close" name="deleteTask" value="' .$task->id. '">
    <span style="padding: .75rem 1.25rem; position: absolute; top:0.0rem; right:0.0rem;" aria-hidden="true">&times;</span>
  </button>
</form>
  
    ';}
  $finishDate1 = getdate($task->completion_date + 60*60*4)['mday'] . ' ' . getdate($task->completion_date + 60*60*4)['month'] . ' ' . getdate($task->completion_date + 60*60*4)['year'];
  };

?>

</div>

</body>