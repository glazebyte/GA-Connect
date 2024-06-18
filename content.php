<?php
/* panggil file database.php untuk koneksi ke database */ 
require_once "db/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan message = 1
if (empty($_SESSION['id_user']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk pemanggilan file halaman konten
else {
	// jika halaman konten yang dipilih home, panggil file view home
	if ($_GET['module'] == 'home') {
		include "modules/home/view.php";
	}

	// jika halaman konten yang dipilih barang, panggil file view barang
	elseif ($_GET['module'] == 'send') {
		include "modules/send/view.php";
	}
	//halaman form kirim request
	elseif ($_GET['module'] == 'form_kirim') {
		include "modules/send/form.php";
	}

	// jika halaman konten yang dipilih barang, panggil file view barang
	elseif ($_GET['module'] == 'get') {
		include "modules/get/view.php";
	}
	elseif ($_GET['module'] == 'form_terima') {
		include "modules/get/form.php";
	}
	elseif ($_GET['module'] == 'manage') {
		include "modules/manage/view.php";
	}
	elseif ($_GET['module'] == 'form_kelola') {
		include "modules/manage/form.php";
	}
	elseif ($_GET['module'] == 'ticket_detail') {
		include "modules/ticket_detail/view.php";
	}

	// jika halaman konten yang dipilih barang, panggil file view barang
	elseif ($_GET['module'] == 'man_user') {
		include "modules/send/man_user.php";
	}
}
?>