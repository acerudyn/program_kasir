<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<h2> MANAJEMEN DATA SUPPLIER </h2>
<a href="?open=Supplier-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a>
<br /><br />

<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="29" align="center" bgcolor="#CCCCCC"><b>No</b></th>
    <th width="70" bgcolor="#CCCCCC"><b>Kode</b></th>
    <th width="208" bgcolor="#CCCCCC"><b>Nama Supplier </b></th>
    <th width="366" bgcolor="#CCCCCC"><b>Alamat</b></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_supplier'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_supplier']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td width="43" align="center"><a href="?open=Supplier-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
    <td width="47" align="center"><a href="?open=Supplier-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA SUPPLIER INI ... ?')">Delete</a></td>
  </tr>
  <?php } ?>
</table>
