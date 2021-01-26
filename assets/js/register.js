let button = document.getElementById('button');
let input = document.querySelectorAll('.input');
let form = document.getElementById('form');
let fields = document.querySelectorAll('.field');
let pSuccess = document.getElementById('success');
let response = document.getElementById('response');
let spanResponse = document.getElementById('span_response');
let labelImg = document.getElementById('labelImg');
let imgInput = document.getElementById('imgInput');
let labelVal = labelImg.innerText;

let color = [];
let validation = [];
let success = [];
let password;
let confirmPassword;
let values = [];
let xhr = new XMLHttpRequest();

labelImg.addEventListener('mouseover', changeBackGroundBlack);
labelImg.addEventListener('mouseout', changeBackGroundWhite);

function changeBackGroundBlack() {
    labelImg.style.backgroundColor = '#262828';
    labelImg.style.color = '#F5F5F5';
}
function changeBackGroundWhite() {
    labelImg.style.backgroundColor = '#F5F5F5';
    labelImg.style.color = '#262828';
}

imgInput.addEventListener('change', changeLabel);

function changeLabel(event) {
    let fileName = event.target.value.split('\\').pop();
    if (fileName.length > 20) {
        fileName = `${fileName.substr(0,8)}...${fileName.substr((fileName.length - 8),8)}`;
    }
    if (fileName) {
        labelImg.innerText = fileName;
        labelImg.classList.add('changebg');
    } else {
        labelImg.innerText  = labelVal;
    }
}

function registration() {
    let formData = new FormData(form);
    formData.append("request_type", 'Register'); //передаем в запрос тип запроса (регистрация)
    formData.append("method", 'AddUser'); //метод (добавить пользователя)
    formData.append("name", values[0]);
    formData.append("surname", values[1]);
    formData.append("email", values[2]);
    formData.append("img", values[3]);
    formData.append("password", values[4]);
    xhr.open("POST", '/dataIndex.php'); //прописать адрес контроллера
    xhr.send(formData);
    xhr.addEventListener('load', onload);
}

function onload() {
    console.log(xhr.response);
    let serverResponse = JSON.parse(xhr.response);
    response.innerHTML = '';
    let pResponse = [];
    if (serverResponse[0] === 'success') {
        document.location.href = `/Page/successRegister/${serverResponse[1]}`;
        spanResponse.innerText = 'Already have an account?';
    } else if (serverResponse[0] === 'email') {
        spanResponse.innerText = 'The account with the specified email is already registered';
    } else {
        let responseJson = JSON.parse(xhr.response);
        for (let i = 0; i < responseJson.length; i++) {
            pResponse[i] = document.createElement('p');
            response.append(pResponse[i]);
            pResponse[i].innerText = `${responseJson[i]}`;
        }
    }
}

function err(event) {
    success.length = 0;
    values.length = 0;
    event.preventDefault();
    for (let i = 0; i < fields.length; i++) {
        input[i].error.validation();
    }
    if (success.length === 5) { //если валидация пройдена успешно запускаем функцию регистрации
        registration();
    }
}

button.addEventListener('click', err);

function clear(event) {
    event.target.parentElement.error.clear();
}

class error { //класс для валидации и вывода ошибок
    constructor(name) {
        this.input = name;
        this.color = [];
    }
    animate() { //функция анимации затухающего красного цвета в инпутах при попытке отправить пустую форму
        if (this.input.firstElementChild.getAttribute('name') === 'img') {
            labelImg.style.backgroundColor = `rgb(255,${this.color[0]},${this.color[1]})`;
        }
        if (this.color[0] >= 255) {
            return
        }
        this.input.firstElementChild.style.backgroundColor = `rgb(255,${this.color[0]},${this.color[1]})`;
        this.color[0] += 2;
        this.color[1] += 2;
        requestAnimationFrame(this.animate.bind(this));
    }
    notice() {//функция появления подсказок при ошибке заполнения инпута
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
        if (this.input.firstElementChild.getAttribute('name') === 'name') { //проверка имени
            if (this.input.firstElementChild.value !== '') {
                if (this.input.firstElementChild.value.length > 100) {
                    if (this.message === undefined) {
                        this.messageText = 'The name must be no more than 100 characters long!';
                        this.notice();
                    }
                } else {
                    success.push('ok');
                    values.push(this.input.firstElementChild.value); //при успешной валидации добавляем данные в массив values и записываем в массив success ok
                }
            }
        }
        if (this.input.firstElementChild.getAttribute('name') === 'surname') { //проверка фамилии
            if (this.input.firstElementChild.value !== '') {
                if (this.input.firstElementChild.value.length > 100) {
                    if (this.message === undefined) {
                        this.messageText = 'The length of the surname must not exceed 100 characters!';
                        this.notice();
                    }
                } else {
                    success.push('ok');
                    values.push(this.input.firstElementChild.value); //при успешной валидации добавляем данные в массив values и записываем в массив success ok
                }
            }
        }
        if (this.input.firstElementChild.getAttribute('name') === 'img') { //проверка картинки
            if (this.input.firstElementChild.value !== '') {
                if (this.input.firstElementChild.files[0].type !== 'image/png' && this.input.firstElementChild.files[0].type !== 'image/jpeg') {
                    if (this.message === undefined) {
                        this.messageText = 'The selected file type must be img!';
                        this.notice();
                    }
                } else {
                    success.push('ok');
                    values.push(this.input.firstElementChild.files); //при успешной валидации добавляем данные в массив values и записываем в массив success ok
                    //console.log(this.input.firstElementChild.files[0]);
                }
            }
        }
        if (this.input.firstElementChild.getAttribute('name') === 'email') { //проверка email
            if (this.input.firstElementChild.value !== '') {
                this.reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                this.addres = this.input.firstElementChild.value;
                if(this.reg.test(this.addres) === false) {
                    if (this.message === undefined) {
                        this.messageText = 'Please enter a valid e-mail';
                        this.notice();
                    }
                } else {
                    success.push('ok');
                    values.push(this.input.firstElementChild.value); //при успешной валидации добавляем данные в массив values и записываем в массив success ok
                }
            }
        }
        if (this.input.firstElementChild.getAttribute('name') === 'password') {
            if (this.input.firstElementChild.value !== '') {
                password = this.input.firstElementChild.value;
            }
        }

        if (this.input.firstElementChild.getAttribute('name') === 'confirm_password') {
            if (this.input.firstElementChild.value !== '') {
                confirmPassword = this.input.firstElementChild.value;
                if (password !== confirmPassword) {
                    if (this.message === undefined) {
                        this.messageText = 'Passwords do not match! Please check if the entered passwords are correct!';
                        this.notice();
                    }
                } else {
                    success.push('ok');
                    values.push(this.input.firstElementChild.value); //при успешной валидации добавляем данные в массив values и записываем в массив success ok
                }
            }
        }
    }
    clear() { //функция удаления подсказки при наведении курсора на инпут
        if (this.input.firstElementChild.getAttribute('name') === 'password') {
            if (this.input.nextElementSibling.error.message !== undefined) {
                this.input.nextElementSibling.error.triangle.remove();
                this.input.nextElementSibling.error.message.remove();
                delete this.input.nextElementSibling.error.triangle;
                delete this.input.nextElementSibling.error.message;
            }
        }

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




