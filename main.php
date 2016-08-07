<?php
if(isset($_SESSION['SES_LOGIN'])) {
	echo "<h2>Selamat pada PROGRAM KASIR TOKO !</h2>";
	echo "<b> Anda berhasil login";
	exit;
}
else {
	echo "<h2>Selamat datang ROGRAM KASIR TOKO !</h2>";
	echo "<b>Anda belum login, silahkan <a href='?open=Login' alt='Login'>login </a>untuk mengakses sitem ini ";	
}
?>