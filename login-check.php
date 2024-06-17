<?php
// panggil file untuk koneksi ke database 
require_once "db/database.php";

// ambil data hasil submit dari form
$email = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['email'])))));
$password = md5(mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password']))))));

// pastikan email dan password adalah berupa huruf atau angka.
if (!ctype_alnum($password)) {
	header("Location: index.php?alert=1");
}
else {
	// ambil data dari tabel user untuk pengecekan berdasarkan inputan email dan passrword
	$sql="SELECT * FROM tb_pegawai WHERE email='$email' AND password='$password' ";
    try {
        $query = $mysqli->query($sql);
        $rows = $query->num_rows;
    } catch (mysqli_sql_exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

	// jika data ada, jalankan perintah untuk membuat session
	if ($rows > 0) {
		$data  = mysqli_fetch_assoc($query);

		session_start();
		$_SESSION['id_user']   		= $data['id'];
		$_SESSION['email']  		= $data['email'];
		$_SESSION['password']  		= $data['password'];
		$_SESSION['nama_user'] 		= $data['nama'];
		$_SESSION['bidang']			= $data['bidang'];
		$_SESSION['avatar'] 		= $data['avatar'];
		
		$response = array(
            'status'=> 'success',
            'message'=> 'Berhasil login'
        );
	}

	// jika data tidak ada, alihkan ke halaman login dan tampilkan pesan = 1
	else {
		$response = array(
            'message'=> $error
        );
	}
    echo json_encode($response);
}
?>