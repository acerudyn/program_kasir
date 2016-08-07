<?php
//include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel penjualan
	$mySql = "SELECT * FROM penjualan WHERE no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Penjualan | Program Kasir Toko</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2> PENJUALAN </h2>
<table width="450" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="158"><b>No. Penjualan </b></td>
    <td width="10"><b>:</b></td>
    <td width="254" valign="top"><strong><?php echo $myData['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Penjualan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<p><strong>DAFTAR ITEM BARANG </strong></p>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="34" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="56" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="323" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="92" align="right" bgcolor="#F5F5F5"><b> Harga (Rp) </b></td>
    <td width="60" align="right" bgcolor="#F5F5F5"><b> Jumlah </b></td>
    <td width="104" align="right" bgcolor="#F5F5F5"><strong>Subtotal(Rp) </strong></td>
  </tr>
  <?php
  	// Buat variabel
	$subTotalJual	= 0;
	$grandTotalJual	= 0;
	
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
			  LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
			  WHERE penjualan_item.no_penjualan='$noNota'
			  ORDER BY penjualan_item.kd_barang";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotalJual 	= $myData['jumlah'] * $myData['harga'];
		$grandTotalJual	= $grandTotalJual + $subTotalJual;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga']); ?></td>
    <td align="right"><?php echo format_angka($myData['jumlah']); ?></td>
    <td align="right"><?php echo format_angka($subTotalJual); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><b> Grand Total (Rp)  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($grandTotalJual); ?></strong></td>
  </tr>
</table>
<br/>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>