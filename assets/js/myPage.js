let selectImgInput = document.getElementById('selectImgInput');
let selectImgLabel = document.getElementById('selectImgLabel');
let labelVal;
if (selectImgLabel !== null) {
	labelVal = selectImgLabel.innerText;
}
let id;
let section = document.getElementById('user');
if (section !== null) {
	id = section.getAttribute('data-id');
}
let upload = document.getElementById('upload');
let message = document.getElementById('message');
let exit = document.getElementById('exit');
let formAddImg = document.getElementById('addImg');
let deleteButton = document.querySelectorAll('.deleteButton');

for (let i = 0; i < deleteButton.length; i++) {
	deleteButton[i].addEventListener('click', deleteImg);
}
let xhr = new XMLHttpRequest();

function deleteImg(event) {
	event.preventDefault();
	let deleteForm = new FormData(event.target.parentElement);
	deleteForm.append("request_type", 'Img');
	deleteForm.append("method", 'deleteImg');
	deleteForm.append("imageid", event.target.value);
	xhr.open("POST", '/dataIndex.php');
	xhr.send(deleteForm);
	xhr.addEventListener('load', onloadDelete);
}

function onloadDelete() {
	if (xhr.response === 'success') {
		document.location.href = `/Page/Account/${id}`;
	}
}

if (selectImgLabel !== null) {
	selectImgInput.addEventListener('change', changeLabel);
}

function changeLabel(event) {
	let fileName = event.target.value.split('\\').pop();
	if (fileName.length > 20) {
		fileName = `${fileName.substr(0,8)}...${fileName.substr((fileName.length - 8),8)}`;
	}
	if (fileName) {
		selectImgLabel.innerText = fileName;
	} else {
		selectImgLabel.innerText  = labelVal;
	}
}

if (selectImgLabel !== null) {
	upload.addEventListener('click', uploadImg);
}

function uploadImg(event) {
	event.preventDefault();
	if (selectImgLabel.innerText === labelVal) {
		message.innerHTML = 'you have not chosen a picture!';
	} else {
		message.innerHTML = '';
		let imgForm = new FormData(formAddImg);
		imgForm.append("request_type", 'Img');
		imgForm.append("method", 'upLoadImg');
		imgForm.append("image", selectImgInput.files);
		xhr.open("POST", '/dataIndex.php'); //прописать адрес контроллера
		xhr.send(imgForm);
		xhr.addEventListener('load', onloadImg);
	}
}

function onloadImg() {
	if (xhr.response === 'success') {
		document.location.href = `/Page/Account/${id}`;
	}
}

exit.addEventListener('click', exitPage);

function exitPage(event) {
	event.preventDefault();
	document.location.href = '/Main/exit';
}


