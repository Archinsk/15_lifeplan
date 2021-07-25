
let startX;

//Для первого объекта
list.addEventListener('touchstart', function(event) {
    startX = event.touches[0].clientX;
});

list.addEventListener('touchmove', moveIt);

function moveIt(event) {
    if (event.touches[0].clientX - startX >= 100) {
        listCompleted.classList.toggle('norm');
        list.removeEventListener('touchmove', moveIt);
        listCompleted.addEventListener('touchmove', moveItBack);
    }
}

//Для второго объекта
listCompleted.addEventListener('touchstart', function(event) {
    startX = event.touches[0].clientX;
});

listCompleted.addEventListener('touchmove', moveItBack);

function moveItBack(event) {
    if (event.touches[0].clientX - startX <= -100) {
        listCompleted.classList.toggle('norm');
        listCompleted.removeEventListener('touchmove', moveItBack);
        list.addEventListener('touchmove', moveIt);
    }
}