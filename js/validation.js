//Скрипты валидации формы регистрации

signupLogin.onblur = function () {
    emptyFieldError(this, "Введите логин");
};

signupLogin.oninput = function () {
    removeError(this, "Логин");
};

signupPassword.onblur = function () {
    emptyFieldError(this, "Введите пароль");
};

signupPassword.oninput = function () {
    signupPassword.classList.remove("error");
    signupPasswordLabel.firstChild.textContent = "Пароль";
    if ((signupPassword.value == verifySignupPassword.value) && (passVerify.children.length > 2)) {
        verifySignupPassword.classList.remove("error");
        passVerify.lastElementChild.remove();
    } else if ( (signupPassword.value != verifySignupPassword.value) && verifySignupPassword.value.trim()) {
        verifySignupPassword.classList.add("error");
        if (passVerify.children.length == 2) {
            passVerify.appendChild(createErrorComment("Повтор не совпадает с паролем"));
        }
    }
};

verifySignupPassword.onblur = function () {
    if (!emptyFieldError(this, "Повторите логин") && (signupPassword.value != verifySignupPassword.value) ) {
        verifySignupPassword.classList.add("error");
        if (passVerify.children.length == 2) {
            passVerify.appendChild(createErrorComment("Повтор не совпадает с паролем"));
        }
    }
};

verifySignupPassword.oninput = function () {
    verifySignupPassword.classList.remove("error");
    verifySignupPasswordLabel.firstChild.textContent = "Пароль ещё раз";
    if ((signupPassword.value == verifySignupPassword.value) && (passVerify.children.length > 2)) {
        verifySignupPassword.classList.remove("error");
        passVerify.lastElementChild.remove();
    }
};

//Скрипты валидации формы авторизации

inputLogin.onblur = function () {
    emptyFieldError(this, "Введите логин");
};

inputLogin.oninput = function () {
    removeError(this, "Логин");
};

inputPassword.onblur = function () {
    emptyFieldError(this, "Введите пароль");
};

inputPassword.oninput = function () {
    removeError(this, "Пароль");
};

function createErrorComment(errorComment) {
    let comment = document.createElement("div");
    comment.className = "form-text";
    let textValue = document.createTextNode(errorComment);
    comment.appendChild(textValue);
    return comment;
}

function emptyFieldError(field, label){
    if (!field.value.trim()) { // если поле не заполнено или заполнено пробелами
        field.classList.add("error");
        field.value = "";
        field.nextElementSibling.firstChild.textContent = label;
        return true;
    }
    return false;
}

function removeError(field, label){
    field.classList.remove("error");
    if (field.parentElement.children.length > 2) {
        field.parentElement.lastElementChild.remove();
    }
    field.nextElementSibling.firstChild.textContent = label;
}


do_login.addEventListener('click', function(event) {
    let requestText = inputLogin.name + '=' + inputLogin.value + '&' + inputPassword.name + '=' + inputPassword.value;
    if (isValidAuthForm()) {
        ajaxPostRequest('php/auth.php', requestText, errorOutput);
    }
});


do_signup.addEventListener('click', function(event) {
    let requestText = signupLogin.name + '=' + signupLogin.value + '&' + signupPassword.name + '=' + signupPassword.value  + '&' + verifySignupPassword.name + '=' + verifySignupPassword.value;
    if (isValidSignupForm()) {
        ajaxPostRequest('php/signup.php', requestText, errorOutput);
    }
});

function errorOutput(xhr){
  if (xhr.responseText) {
      if (xhr.responseText == 'Пользователь не зарегистрирован!') {
          inputLogin.classList.add("error");
          logAuth.appendChild(createErrorComment("Пользователь не зарегистрирован!"));
      } else if (xhr.responseText == 'Неверно введен пароль!') {
          inputPassword.classList.add("error");
          pasAuth.appendChild(createErrorComment("Неверно введен пароль!"));
      } else if (xhr.responseText == 'Логин уже занят') {
          signupLogin.classList.add("error");
          logSign.appendChild(createErrorComment("Данный логин уже занят!"));
      };
  } else {
      location.assign('lifeplan_auth.php');
  }
};

function isValidAuthForm() {
    if (emptyFieldError(inputLogin, "Введите логин") || emptyFieldError(inputPassword, "Введите пароль")) {
        return false;
    }
    if (inputLogin.classList.contains("error") || inputPassword.classList.contains("error")) {
        return false;
    } else {
        return true;
    }
};

function isValidSignupForm() {
    if  (emptyFieldError(signupLogin, "Введите логин") || emptyFieldError(signupPassword, "Введите пароль") || emptyFieldError(verifySignupPassword, "Повторите пароль")) {
        return false;
    }
    if (signupLogin.classList.contains("error") || signupPassword.classList.contains("error") || verifySignupPassword.classList.contains("error")) {
        return false;
    } else {
        return true;
    }
}

function isValidCategForm() {
    if  (emptyFieldError(categName, "Введите категорию") || emptyFieldError(categIcon, "Введите Имя иконки") || emptyFieldError(categColor, "Введите номер цвета")) {
        return false;
    }
    if (categName.classList.contains("error") || categIcon.classList.contains("error") || categColor.classList.contains("error")) {
        return false;
    } else {
        return true;
    }
};