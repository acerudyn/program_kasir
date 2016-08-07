<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> MANAJEMEN DATA BARANG </h2>
<a href="?open=Barang-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a>
<br /><br />

<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="27" align="center" bgcolor="#CCCCCC">No</th>
    <th width="55" bgcolor="#CCCCCC">Kode</th>
    <th width="247" bgcolor="#CCCCCC">Nama Barang</th>
    <th width="48" align="center" bgcolor="#CCCCCC">Stok</th>
    <th width="102" bgcolor="#CCCCCC">Satuan</th>
    <th width="95" align="right" bgcolor="#CCCCCC">H Beli(Rp)</th>
    <th width="85" align="right" bgcolor="#CCCCCC">H Jual(Rp)</th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="center"><?php echo $myData['stok']; ?></td>
    <td><?php echo $myData['satuan']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_modal']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td width="40" align="center"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Edit</a></td>
    <td width="49" align="center"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG INI ... ?')">Delete</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="6" align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
