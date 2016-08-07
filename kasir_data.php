<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<h2> MANAJEMEN DATA KASIR </h2>
<a href="?open=Kasir-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a>
<br /><br />

<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="30"><b>No</b></th>
    <th width="74"><b>Kode</b></th>
    <th width="394"><b>Nama Kasir </b></th>
    <th width="175"><b>Username</b></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT * FROM kasir ORDER BY kd_kasir ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_kasir'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kasir']; ?></td>
    <td><?php echo $myData['nm_kasir']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td width="45" align="center"><a href="?open=Kasir-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
    <td width="45" align="center"><a href="?open=Kasir-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self">Delete</a></td>
  </tr>
  <?php } ?>
</table>
