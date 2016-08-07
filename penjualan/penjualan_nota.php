<?php
//include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# SKRIP MEMBACA DATA PENJUALAN
if(isset($_GET['noNota'])){
	// Membaca nomor penjualan dari URL
	$noNota = $_GET['noNota'];
	
	// Skrip untuk pembaca data dari database
	$mySql = "SELECT * FROM penjualan WHERE no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Nota (noNota) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Penjualan - Program Kasir Toko</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body onLoad="window.print()">
<table class="table-list" width="430" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="87" colspan="4" align="center">
		<strong>PROGRAM TOKO RITEL</strong><br />
        <strong>NPWP/ PKP : </strong>1.111111.11111<br />
        <strong>Tgl. Pengukuhan : </strong>01-10-2014 <br />
        Kota Metro, Lampung </td>
  </tr>
  <tr>
    <td><strong>No Nota :</strong> <?php echo $kolomData['no_penjualan']; ?></td>
    <td colspan="3" align="right"> <?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td width="193" bgcolor="#F5F5F5"><strong>Daftar Barang </strong></td>
    <td width="59" align="right" bgcolor="#F5F5F5"><strong>Harga@</strong></td>
    <td width="32" align="right" bgcolor="#F5F5F5"><strong>Qty</strong></td>
    <td width="103" align="right" bgcolor="#F5F5F5"><strong>Subtotal(Rp) </strong></td>
  </tr>
<?php
# Baca variabel
$totalBayar = 0; 
$jumlahBarang = 0;  
$uangKembali=0;

# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
$notaSql = "SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
			LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
			WHERE penjualan_item.no_penjualan='$noNota'
			ORDER BY barang.kd_barang ASC";
$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list salah : ".mysql_error());
$nomor  = 0;  
while($notaData = mysql_fetch_array($notaQry)) {
	$nomor++;
	$subSotal 	= $notaData['jumlah'] * $notaData['harga'];
	$totalBayar	= $totalBayar + $subSotal;
	$jumlahBarang = $jumlahBarang + $notaData['jumlah'];
	$uangKembali= $kolomData['uang_bayar'] - $totalBayar;
?>
  <tr>
    <td><?php echo $notaData['kd_barang']; ?>/ 
    <?php echo $notaData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($notaData['harga']); ?></td>
    <td align="right"><?php echo $notaData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="2" align="right"><strong>Total Belanja (Rp) : </strong></td>
    <td colspan="2" align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><strong> Uang Bayar (Rp) : </strong></td>
    <td colspan="2" align="right"><?php echo format_angka($kolomData['uang_bayar']); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><strong>Uang Kembali (Rp) : </strong></td>
    <td colspan="2" align="right"><?php echo format_angka($uangKembali); ?></td>
  </tr>
</table>
</body>
</html>
