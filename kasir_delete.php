<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Membaca data dari URL
$Kode	= $_GET['Kode'];
if(isset($Kode)){
	// Skrip menghapus data dari tabel database
	$mySql = "DELETE FROM kasir WHERE kd_kasir='$Kode' AND username !='admin'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Error query".mysql_error());
	
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=?open=Kasir-Data'>";
}
else {
	echo "Data yang dihapus tidak ada";
}
?>