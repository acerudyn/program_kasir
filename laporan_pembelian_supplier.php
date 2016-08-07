<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Baca variabel URL browser
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'SEMUA'; 
// Baca variabel dari Form setelah di Post
$kodeSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;

// Membuat filter SQL
if ($kodeSupplier=="SEMUA") {
	//Query #1 (semua data)
	$filterSQL 	= "";
}
else {
	//Query #2 (filter)
	$filterSQL 	= " WHERE pembelian.kd_supplier ='$kodeSupplier'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembelian $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<h2>LAPORAN PEMBELIAN PER SUPPLIER</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="450" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="84"><strong> Supplier </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="397"><select name="cmbSupplier">
          <option value="SEMUA">....</option>
          <?php
	  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_supplier'] == $kodeSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[kd_supplier] - $bacaData[nm_supplier]</option>";
	  }
	  ?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampilkan" type="submit" value=" Tampilkan  "/></td>
    </tr>
  </table>
</form>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="32" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="90" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="115" bgcolor="#CCCCCC"><strong>No. Pembelian </strong></td>
    <td width="200" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="295" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan pembelian dengan Filter Periode
	$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			$filterSQL ORDER BY no_pembelian DESC LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $halaman;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		// Baca kode
		$noNota = $myData['no_pembelian'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td width="37" align="center"><a href="pembelian/pembelian_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="3" align="right"><strong>Halaman ke :
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Pembelian-Supplier&hal=$list[$h]&kodeSupplier=$kodeSupplier'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
