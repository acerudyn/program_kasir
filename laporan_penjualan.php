<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM penjualan";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>LAPORAN PENJUALAN</h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="31" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="88" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="126" bgcolor="#CCCCCC"><strong>No. Penjualan </strong></td>
    <td width="180" bgcolor="#CCCCCC"><strong>Pelanggan </strong></td>
    <td width="304" bgcolor="#CCCCCC"><strong>Keterangan </strong></td>
    <td width="40" colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
	$mySql = "SELECT * FROM penjualan ORDER BY no_penjualan DESC LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $halaman;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		# Membaca Kode Penjualan/ Nomor transaksi
		$noNota = $myData['no_penjualan'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['pelanggan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="center"><a href="penjualan/penjualan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
    <td align="center"><a href="penjualan/penjualan_nota.php?noNota=<?php echo $noNota; ?>" target="_blank">Nota</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="4" align="right"><strong>Halaman ke :
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Penjualan&hal=$list[$h]'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
