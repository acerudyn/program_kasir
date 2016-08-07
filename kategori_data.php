<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
?>
<h2> MANAJEMEN DATA KATEGORI </h2>
<a href="?open=Kategori-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a>
<br /><br />

<table class="table-list"  width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <th width="4%" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="10%" bgcolor="#CCCCCC"><strong>Kode</strong></th>
    <th width="72%" bgcolor="#CCCCCC"><strong>Nama Kategori </strong></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
		// Skrip menampilkan data dari database
		$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
		$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$nomor = 0; 
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_kategori'];
		?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kategori']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td width="7%" align="center"><a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
    <td width="7%" align="center"><a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA KATEGORI INI ... ?')">Delete</a></td>
  </tr>
  <?php } ?>
</table>
