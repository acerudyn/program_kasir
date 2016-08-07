<?php
//include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# SKRIP UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembelian";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> DATA TRANSAKSI PEMBELIAN </h2>
<br />

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="30" align="center"><strong>No</strong></th>
    <th width="94"><strong>Tgl. Nota </strong></th>
    <th width="115"><strong>No. Nota </strong></th>
    <th width="175"><strong>Supplier </strong></th>
    <th width="244"><strong>Keterangan</strong></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	  // Skrip menampilkan data dari database
	$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			 LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			 ORDER BY no_pembelian DESC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_pembelian'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td width="45" align="center"><a href="pembelian_cetak.php?noNota=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
    <td width="45" align="center"><a href="?open=Pembelian-Hapus&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMBELIAN INI ... ?')">Delete</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><b>Jumlah Data :<?php echo $jmlData; ?></b></td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Pembelian-Tampil&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
