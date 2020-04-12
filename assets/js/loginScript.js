function login() {
	var user = document.getElementById("input-usuario").value;
	var psw = document.getElementById("input-contrasenia").value;

	if(user==="" && psw===""){
		window.alert("Para iniciar sesión, ingrese usuario y contraseña");
	}else if(user===""){
		window.alert("Ingrese un usuario en el campo \"usuario\"");
	}else if(psw===""){
		window.alert("Ingrese un usuario en el campo \"contraseña\"");
	}
}

const IMGS = ['../images/slider-image1.png', '../images/slider-image2.png'];
const CHANGE_TIME = 2000;
var current_img = 0;
function slide() {
	if(current_img===IMGS.length-1){
		current_img=0;
	}else {
		current_img++;
	}
	document.getElementById('slider-img').src = IMGS[current_img];
}

let intervalo = setInterval(slide, CHANGE_TIME);

function register(){
	document.getElementById("pop-up").style.display = 'flex';
}

function closeRegister(){
	document.getElementById("pop-up").style.display = "none";
}