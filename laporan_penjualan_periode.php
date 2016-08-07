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
	$filterSQL = "WHERE ( tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "WHERE ( tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM penjualan $filterSQL"; 
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
<h2>LAPORAN PENJUALAN PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0" class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE PENJUALAN </strong></td>
    </tr>
    <tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"><input name="cmbTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" />
        s/d <input name="cmbTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
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
    <td width="27" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>No. Penjualan </strong></td>
    <td width="170" bgcolor="#CCCCCC"><strong>Pelanggan </strong></td>
    <td width="279" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan Penjualan dengan Filter Periode
	$mySql = "SELECT * FROM penjualan $filterSQL ORDER BY no_penjualan DESC LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $halaman;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$noNota = $myData['no_penjualan'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['pelanggan']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td width="44" align="center"><a href="penjualan/penjualan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
    <td width="44" align="center"><a href="penjualan/penjualan_nota.php?noNota=<?php echo $noNota; ?>" target="_blank">Nota</a></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="4" align="right"><strong>Halaman ke :
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Penjualan-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
</body>
</html>