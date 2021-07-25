// События по клику на элементе
list.addEventListener('click', function(event) {
  console.log(event.target);
  if (event.target.classList.contains('filterTaskByCategory')) {
    let category = event.target.closest('div').className;
    filterByCategory(category);
  } else if (event.target.classList.contains('deleteTask')) {
    let requestText = 'id=' + event.target.closest('.taskItem').id;
    ajaxPostRequest('php/deleteTask.php', requestText);
  } else if ( event.target.classList.contains('taskItem') ) {
    event.target.classList.toggle('checked');
    let requestText = 'id=' + event.target.id;
    ajaxPostRequest('php/updateTask.php', requestText);
  } else if ( event.target.closest('div').classList.contains('taskItem') ) {
    event.target.closest('div').classList.toggle('checked');
    let requestText = 'id=' + event.target.closest('div').id;
    ajaxPostRequest('php/updateTask.php', requestText);
  }
});

function  filterByCategory(categoryName) {
  let taskItems = list.querySelectorAll('.taskItem');
  taskItems.forEach(function(item) {
    if (item.className != categoryName) {
      item.classList.toggle('unvisible');
    }
  });
}

// Создание нового элемента списка по клику "Добавить"
function newElement(xhr) {
  let taskTemplate = document.getElementById('taskItem').content;
  let taskItem = taskTemplate.querySelector('div');
  let newTask = taskItem.cloneNode(true);
  let newTaskText = newTask.querySelector('p');
  newTask.id = xhr.responseText
  newTaskText.prepend(myInput.value);
  list.firstElementChild.prepend(newTask);
  myInput.value = '';
  myInput.focus();
  //Расфокусировка через 3 секунды
  function unfocus() {
    if(!myInput.value) {
      myInput.blur();
    }
  }
  setTimeout(unfocus, 3000);
}

function emptyTask() {
  alert ("Сначала нужно записать задание!")
}

function formVaidate() {
  let valid = true;
  if (myInputField.value == '') {
	emptyTask();
    valid = false;
  }
  return valid
}

function createFormElementDataById(inputId) {
  return getInputName(inputId) + "=" + getInputValue(inputId);
}

function getInputName(inputId) {
  let inputField = document.getElementById(inputId);
  return inputField.name;
}

function getInputValue(inputId) {
  let inputField = document.getElementById(inputId);
  return inputField.value;
}

document.addEventListener("DOMContentLoaded", () => {
  addCategoriesButtons ();
});

// Добавление кнопок категорий заданиям по ключевой фразе
function addCategoriesButtons () {
  let elements = document.querySelectorAll('.taskItem');
  let tableRows = categoriesTable.firstElementChild.children;
  for (let i = 1; i < tableRows.length; i++) {
    let categoryName = tableRows[i].querySelector("td:nth-child(1)").textContent;
    let iconName = tableRows[i].querySelector("td:nth-child(2)").textContent;
    let colorName = tableRows[i].querySelector("td:nth-child(3)").textContent;
    elements.forEach(function(item) {
      let task = item.querySelector("p");
      if (task.textContent.startsWith(categoryName)) {
        let categoryButton = createCategoryButton (iconName, colorName)
        item.prepend(categoryButton);
        item.classList.add('category_' + i);
      }
    });
  }
}

// Создание кнопки категории
function createCategoryButton (iconName, colorName) {
  let buttonTemplate = document.getElementById('taskCategory').content;
  let buttonItem = buttonTemplate.querySelector('button');
  let categoryButton = buttonItem.cloneNode(true);
  categoryButton.style = "background-color: " + colorName;
  let spanNode = categoryButton.firstElementChild;
  spanNode.textContent = iconName;
  return categoryButton;
}

add_category.addEventListener('click', function(event) {
  let requestText = categName.name + '=' + categName.value + '&' + categIcon.name + '=' + categIcon.value + '&' + categColor.name + '=' + categColor.value;
  //if (isValidCategForm()) {
    ajaxPostRequest('php/createCategory.php', requestText);
  //}
});

logo.addEventListener('click', slide);

function slide(event) {
    listCompleted.classList.toggle('norm');
    if (listCompleted.classList.contains('norm')) {
      list.removeEventListener('touchmove', moveIt);
      listCompleted.addEventListener('touchmove', moveItBack);
    } else {
      listCompleted.removeEventListener('touchmove', moveItBack);
      list.addEventListener('touchmove', moveIt);
    }
}