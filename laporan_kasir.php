<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<h2> DAFTAR KASIR </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="349" bgcolor="#CCCCCC"><strong>Nama Kasir </strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Username</strong></td>
  </tr>
	<?php
		// Skrip menampilkan data dari database
		$mySql 	= "SELECT * FROM kasir ORDER BY kd_kasir";
		$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$nomor  = 0; 
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kasir']; ?></td>
    <td><?php echo $myData['nm_kasir']; ?></td>
    <td><?php echo $myData['username']; ?></td>
  </tr>
  <?php } ?>
</table>
