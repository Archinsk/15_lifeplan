<?php //Страница неавторизованного пользователя
  // Подключаем RedBeanPHP
  require 'php/rb.php';
  // Соединямся с БД
  R::setup( 'mysql:host=localhost; dbname=lifeplan', 'mikhail', '9039033661!' ); //Указываем адрес сервера, имя базы, логин и пароль пользователя (синтаксис RedBeanPHP)
  session_start();

  //Перевод авторизованного пользователя на страницу авторизованного пользователя
  if ( isset($_SESSION['logged_user']) ) {
    header('Location: lifeplan_auth.php');
  };
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
        <img id="logo" src="images/lifeplan_logo.jpg">
        <div class="buttonsContainer">
          <button type="button" class="btn mx-3" data-toggle="modal" data-target="#authorizationModal">
            <span class="material-icons">login</span>
          </button>
        </div>
      </div>

    <form id="taskForm" action="" class="col py-2 sticky-top">
      <div class="input-group mb-0">
        <input type="text" id="myInput" class="form-control py-4" placeholder="Выполнить..." name="inputTask" aria-describedby="button-addon2"> <!--Уточнить запись имени (name)-->
        <div class="input-group-append">
          <button type="button" class="btn btn-primary addBtn px-3" id="button-addon2" onclick=newElement()><b>+</b></button> <!--На JS onclick=newElement()-->
        </div>
      </div>
    </form>

    <div id="list">
      <div class="container col">

        <div class="alert alert-warning mb-1" role="alert">
          <p>
            Внимание! Это демонстрационная страница. Записанные дела не сохранятся! Для того, чтобы список дел сохранялся необходимо зарегистрироваться или войти
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Построить дом
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Сделать проект дома
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Подсчитать количество необходимых материалов
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Купить материалы
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Провести строительные работы
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Посадить дерево
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Найти жёлудь
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Прорастить росток из жёлудя
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Высадить росток в грунт
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Вырастить сына
          </p>
        </div>
        <div class="taskItem alert alert-secondary alert-dismissible fade show mb-1" role="alert">
          <button type="button" class="deleteTask close" data-dismiss="alert" aria-label="Close">
            <span class="deleteTask material-icons" aria-hidden="true">close</span>
          </button>
          <p>
            Купить квартиру
          </p>
        </div>

      </div>
    </div>

    <!-- Модальное окно авторизации-->
    <div class="modal fade" id="authorizationModal" tabindex="-1" aria-labelledby="authorizationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
	    <form action="index.php" class="p-0" method="POST" id="authorizationForm" novalidate> <!--Ссылка на себя-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="authorizationModalLabel">Вход</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="material-icons" aria-hidden="true">close</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="logAuth" class="form-label-group mb-3" id="logAuth">
                <input type="text" id="inputLogin" class="form-control" placeholder="Login" name="userLogin" value="<?php echo @$data['userLogin']; ?>" required>
                <label for="inputLogin" id="inputLoginLabel">Логин</label>
              </div>
              <div class="form-label-group mb-0" id="pasAuth">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="userPassword" value="<?php echo @$data['userPassword']; ?>" required>
                <label for="inputPassword" id="inputPasswordLabel">Пароль</label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" data-toggle="modal" data-target="#registrationModal">Регистрация</button>
              <button id="do_login" class="btn btn-primary" type="button" name="do_login">Войти</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Модальное окно регистрации-->
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
	    <form action="index.php" class="p-0" method="POST"> <!--Ссылка на себя-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="registrationModalLabel">Регистрация</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="material-icons" aria-hidden="true">close</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="logSign" class="form-label-group mb-3" id="logSign">
                <input type="text" id="signupLogin" class="form-control" placeholder="Login" name="signupLogin" value="<?php echo @$data['signupLogin']; ?>">
                <label for="signupLogin" id="signupLoginLabel">Логин</label>
              </div>
              <div class="form-label-group mb-3">
                <input type="password" id="signupPassword" class="form-control" placeholder="Password" name="signupPassword" value="<?php echo @$data['signupPassword']; ?>">
                <label for="signupPassword" id="signupPasswordLabel">Пароль</label>
              </div>
              <div class="form-label-group mb-0" id="passVerify">
                <input type="password" id="verifySignupPassword" class="form-control" placeholder="Password" name="verifySignupPassword" value="<?php echo @$data['verifySignupPassword']; ?>">
                <label for="verifySignupPassword" id="verifySignupPasswordLabel">Пароль ещё раз</label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Отмена</button>
              <button id="do_signup" class="btn btn-primary" type="button" name="do_signup">Зарегистрироваться</button>
            </div>
          </div>
        </form>
      </div>
    </div>

<script src="js/list.js"></script>
<script src="js/ajaxRequests.js"></script>
<script src="js/validation.js"></script>

</body>