<?php
//include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM penjualan";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> DATA TRANSAKSI PENJUALAN </h2>
<br />

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="30" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
    <th width="90" bgcolor="#CCCCCC"><strong>Tgl. Nota </strong></th>
    <th width="90" bgcolor="#CCCCCC"><strong>No. Nota </strong></th>
    <th width="204" bgcolor="#CCCCCC"><strong>Pelanggan </strong></th>
    <th width="244" bgcolor="#CCCCCC"><strong>Keterangan</strong></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM penjualan ORDER BY no_penjualan DESC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_penjualan'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['pelanggan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td width="45" align="center"><a href="penjualan_nota.php?noNota=<?php echo $Kode; ?>" target="_blank">Nota</a></td>
    <td width="45" align="center"><a href="?open=Penjualan-Hapus&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENJUALAN INI ... ?')">Delete</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :<?php echo $jmlData; ?></b></td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Penjualan-Tampil&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
