function reloadOn() {
	location.reload();
	return false;
}

function masukOn() {
	var masuk = document.getElementById("masuk");
	var background = document.getElementById("navbar-bg-gelap");

	masuk.classList.toggle("masukStyle");
	background.classList.toggle("navbar-bg-gelapStyle");
}

function daftarOn() {
	var daftar = document.getElementById("daftar");
	var background = document.getElementById("navbar-bg-gelap2");

	daftar.classList.toggle("daftarStyle");
	background.classList.toggle("navbar-bg-gelap2Style");
}

function keluarOn() {
	var keluar = document.getElementById("pembeli-penjual");
	var background = document.getElementById("bg-gelap");
	
	keluar.classList.toggle("pembeli-penjualStyle");
	background.classList.toggle("bg-gelapStyle");
}

function passwordpembeliOn() {
	var profil = document.getElementById("password-profil-pembeli");
	var background = document.getElementById("navbar-bg-gelap3");

	profil.classList.toggle("password-profil-pembeliStyle");
	background.classList.toggle("navbar-bg-gelap3Style");
}

function passwordpenjualOn() {
	var profil = document.getElementById("password-profil-penjual");
	var background = document.getElementById("navbar-bg-gelap4");

	profil.classList.toggle("password-profil-penjualStyle");
	background.classList.toggle("navbar-bg-gelap4Style");
}