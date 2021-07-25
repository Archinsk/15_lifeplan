<?php // Страница авторизованного пользователя
  // Подключаем RedBeanPHP
  require 'php/rb.php';
  // Соединямся с БД
  R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' ); //Указываем адрес сервера, имя базы, логин и пароль пользователя (синтаксис RedBeanPHP)
  session_start();

  //Если на этой странице оказался незарегистрированный или разлогиненный пользователь, то переводим его на стартовую страницу
  if(!$_SESSION) {
    header('Location: index.php');
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
    <div class="listsContainer container col-md-6 p-0">

      <div class="header m-0">
        <img id="logo" src="images/lifeplan_logo.jpg" >
        <div class="buttonsContainer">
          <button type="button" class="btn" data-toggle="modal" data-target="#categoriesModal">
            <span class="material-icons">menu</span>
          </button>
          <a class="btn mx-3" href="php/logout.php">
            <span class="material-icons">logout</span>
          </a>
        </div>
      </div>

      <!--При нажатии на Enter отправка формы осуществляется-->
      <form id="taskForm" action="" method="POST" class="col py-2 sticky-top" >
        <div class="input-group mb-0">
          <input type="text" id="myInput" class="form-control py-4" placeholder="Выполнить..." name="inputTask" aria-describedby="button-addon2"> <!--Уточнить запись имени (name)-->
          <div class="input-group-append">
            <button type="button" class="btn btn-primary addBtn px-3" id="addTaskButton" name="addTask" onclick="ajaxPostRequest('php/createTask.php', createFormElementDataById('myInput'), newElement)"><b>+</b></button> <!--На JS onclick=newElement()-->
          </div>
        </div>
      </form>

      <div id="list">
        <div class="container col">
        <?php
          //Определяем Timestamp начала текущего дня
          $timestampNow = time();
          $startOfToday = floor ( ( $timestampNow + (7*60*60) ) / ( 24*60*60 ) ) * ( 24*60*60 ) - (7*60*60);
          //Ищем и выдаем записи текущего пользователя (невыполненные или выполненные сегодня)
          $tasklist = R::find( 'tasks', "done = :done OR completion_date > :startOfToday ORDER BY creation_date DESC", [':done' => false, ':startOfToday' => $startOfToday]);
          foreach( $tasklist as $task) {
            if($task->login == $_SESSION['logged_user']) {
              if($task->done == '1') {
                $checkedTask = ' checked';
              } else {
                $checkedTask = ' ';
              };
              echo '<div class="taskItem alert alert-secondary alert-dismissible fade show mb-1' .$checkedTask. '" role="alert" id="' .$task->id. '">
                      <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
                        <span class="deleteTask material-icons" aria-hidden="true">close</span>
                      </button>
                      <p>' .$task->task. '
                      </p>
                    </div>';
            };
          };
        ?>
        </div>
      </div>

      <div id="listCompleted">
        <div class="container col">
        <?php
          //Определяем Timestamp начала текущего дня
          $timestampNow = time();
          $startOfToday = floor ( ( $timestampNow + (7*60*60) ) / ( 24*60*60 ) ) * ( 24*60*60 ) - (7*60*60);
          //Ищем и выдаем записи выполненные до сегодняшнего дня
          $tasklist = R::find( 'tasks', 'done = :done AND completion_date < :startOfToday ORDER BY completion_date DESC', [':done' => true, ':startOfToday' => $startOfToday]);
          foreach( $tasklist as $task) {
            if($task->login == $_SESSION['logged_user']) {
              if($task->done == '1'){
                $checkedTask = ' checked';
              } else {
                $checkedTask = ' ';
              }
      	      $finishDate2 = getdate($task->completion_date + 60*60*4)['mday'] . ' ' . getdate($task->completion_date + 60*60*4)['month'] . ' ' . getdate($task->completion_date + 60*60*4)['year'];
      	      if ($finishDate2 != $finishDate1) {
                echo '<div class="badge badge-secondary">' .$finishDate2. '</div>';
              }
              echo '<div class="taskItem alert alert-secondary alert-dismissible fade show mb-1' .$checkedTask. '" role="alert" id="' .$task->id. '">
      	              <p>' .$task->task. '
                      </p>
                    </div>';}
              $finishDate1 = getdate($task->completion_date + 60*60*4)['mday'] . ' ' . getdate($task->completion_date + 60*60*4)['month'] . ' ' . getdate($task->completion_date + 60*60*4)['year'];
            };
        ?>
        </div>
      </div>
    </div>

<!-- Модальное окно настроек-->
<div class="modal fade bd-example-modal-sm" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="categoriesModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<form action="index.php" class="p-0" method="POST"> <!--Ссылка на себя-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="categoriesModalLabel">Категории</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="material-icons" aria-hidden="true">close</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="categoriesTable">
            <tr>
              <th>Категория</th>
              <th>Иконка</th>
              <th>Цвет</th>
            </tr>
              <?php
                $categories = R::find( 'categories', 'login = :login', [':login' => $_SESSION["logged_user"] ] );
                foreach( $categories as $category) {
                  echo '
                    <tr>
                      <td>' .$category->keyword. '</td>
                      <td>' .$category->icon. '</td>
                      <td>' .$category->color. '</td>
                    </tr>';
                }
              ?>
          </table>
          <div class="form-row">
            <div class="col-4">
              <div class="form-label-group">
                <input type="text" id="categName" class="form-control" placeholder="Категория" name="categName">
                <label for="categName">Категория</label>
              </div>
            </div>
            <div class="col-4">
              <div class="form-label-group">
                <input type="text" id="categIcon" class="form-control" placeholder="Иконка" name="categIcon">
                <label for="categIcon">Иконка</label>
              </div>
            </div>
            <div class="col-4">
              <div class="form-label-group">
                <input type="text" id="categColor" class="form-control" placeholder="Цвет" name="categColor">
                <label for="categColor">Цвет</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Отмена</button>
          <button id="add_category" class="btn btn-primary" type="button" name="add_category">Добавить</button>
        </div>
      </div>
    </form>
  </div>
</div>

    <template id="taskItem">
      <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert" id="">
        <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
          <span class="deleteTask material-icons" aria-hidden="true">close</span>
        </button>
        <p></p>
      </div>
    </template>

    <template id="taskCategory">
      <button type="button" class="filterTaskByCategory">
        <span class="material-icons filterTaskByCategory"></span>
      </button>
    </template>

    <script src="js/list.js"></script>
    <script src="js/ajaxRequests.js"></script>
    <script src="js/swipe.js"></script>

  </body>

</html>