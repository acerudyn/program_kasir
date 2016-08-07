<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<h2> DAFTAR KATEGORI </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="29" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="72" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="483" bgcolor="#CCCCCC"><strong>Nama Kategori </strong></td>
  </tr>
<?php
// Skrip menampilkan data dari database
$mySql 	= "SELECT  * FROM kategori ORDER BY kd_kategori";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$nomor  = 0; 
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kategori']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
  </tr>
<?php } ?>
</table>
