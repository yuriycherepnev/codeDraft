let button = document.getElementById('button');
let input = document.querySelectorAll('.input');
let form = document.getElementById('form');
let fields = document.querySelectorAll('.field');
let response = document.getElementById('response');
let spanResponse = document.getElementById('span_response');

let color = [];
let validation = [];
let success = [];
let password;
let values = [];
let xhr = new XMLHttpRequest();

function err(event) {
    event.preventDefault();
    success.length = 0;
    values.length = 0;
    for (let i = 0; i < fields.length; i++) {
        input[i].error.validation();
    }
    if (values.length === 2) { //если валидация пройдена успешно запускаем функцию регистрации
        auth();
    }
}

button.addEventListener('click', err);

function auth() {
    let formData = new FormData(form);
    formData.append("request_type", 'Auth');
    formData.append("method", 'AuthUser');
    formData.append("email", values[0]);
    formData.append("password", values[1]);
    xhr.open("POST", '/dataIndex.php');
    xhr.send(formData);
    xhr.addEventListener('load', onload);
}

function onload() {
    let serverResponse = JSON.parse(xhr.response);
    response.innerHTML = '';
    spanResponse.innerText = 'Dont have an account?';
    let pResponse = [];
    if (serverResponse[0] === 'success') {
        document.location.href = `/Page/Account/${serverResponse[1]}`;
    } else if (serverResponse[0] === 'notfound') {
        spanResponse.innerText = 'The account with the specified email is not registered.';
    } else if (serverResponse[0] === 'wrong_password') {
        pResponse = document.createElement('p');
        response.append(pResponse);
        pResponse.innerText = 'Invalid user or password specified.';
    }
}

function clear(event) {
    event.target.parentElement.error.clear();
}

class error { //класс для валидации и вывода ошибок
    constructor(name) {
        this.input = name;
        this.color = [];
    }
    animate() { //функция анимации затухающего красного цвета в инпутах при попытке отправить пустую форму
        if (this.color[0] >= 255) {
            return
        }
        this.input.firstElementChild.style.backgroundColor = `rgb(255,${this.color[0]},${this.color[0]})`;
        this.color[0] += 2;
        requestAnimationFrame(this.animate.bind(this));
    }
    notice() {
        this.message = document.createElement('div');
        this.triangle = document.createElement('div');

        this.input.append(this.message);
        this.message.classList.add('message');

        this.message.innerText = `${this.messageText}`;
        this.message.append(this.triangle);
        this.triangle.classList.add('triangle');
    }
    validation() { //функция валидации
        if (this.input.firstElementChild.value === '') {
            this.color[0] = 100;
            this.color[1] = 100;
            requestAnimationFrame(this.animate.bind(this));
        }
        if (this.input.firstElementChild.getAttribute('name') === 'email') {
            if (this.input.firstElementChild.value !== '') {
                this.reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                this.addres = this.input.firstElementChild.value;
                if(this.reg.test(this.addres) === false) {
                    if (this.message === undefined) {
                        this.messageText = 'enter correct email';
                        this.notice();
                    }
                } else {
                    values.push(this.input.firstElementChild.value); //при успешной валидации добавляем данные в массив values и записываем в массив success ok
                }
            }
        }
        if (this.input.firstElementChild.getAttribute('name') === 'password') {
            if (this.input.firstElementChild.value !== '') {
                password = this.input.firstElementChild.value;
                values.push(this.input.firstElementChild.value);
            }
        }
    }
    clear() {
        if (this.message !== undefined) {
            this.triangle.remove();
            this.message.remove();
            delete this.message;
            delete this.triangle;

        }
    }
}

for (let j = 0; j < fields.length; j++) {
    input[j].error = new error(input[j]);
}

for (let l = 0; l < fields.length; l++) {
    input[l].firstElementChild.addEventListener('focus', clear);
}


