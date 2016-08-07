<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "WHERE ( tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "WHERE ( tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembelian $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);

// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");
?>
<html>
<head>
<title> :: Laporan Pembelian Per Periode</title>
<link href="styles/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css"/>
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 
</head>
<body>
<h2>LAPORAN PEMBELIAN PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE PEMBELIAN </strong></td>
    </tr>
    <tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><input name="cmbTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d
        <input name="cmbTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="32" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="90" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="124" bgcolor="#CCCCCC"><strong>No. Pembelian </strong></td>
    <td width="172" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="286" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
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
    <td width="65" align="center"><a href="pembelian/pembelian_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="3" align="right"><strong>Halaman ke :
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Pembelian-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
</body>
</html>
