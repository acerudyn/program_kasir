<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel pembelian
	$mySql = "SELECT pembelian.*,  supplier.nm_supplier FROM pembelian 
			  LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			  WHERE pembelian.no_pembelian='$noNota'";
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
<title>:: Cetak Pembelian | Program Kasir Toko</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> CETAK PEMBELIAN </h2>
<table width="450" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="154"><b>No. Pembelian </b></td>
    <td width="10"><b>:</b></td>
    <td width="258"><strong><?php echo $myData['no_pembelian']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembelian </b></td>
    <td><b>:</b></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
  	// Variabel data
	$jumlahHarga	= 0;
	$totalHarga		= 0;
	$totalBarang	= 0;
	
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT pembelian_item.*,  barang.nm_barang FROM pembelian_item
			  LEFT JOIN barang ON pembelian_item.kd_barang=barang.kd_barang 
			  WHERE pembelian_item.no_pembelian='$noNota'
			  ORDER BY pembelian_item.kd_barang";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		// Penjumlahan data
		$jumlahHarga 	= $myData['jumlah'] * $myData['harga'];
		$totalHarga		= $totalHarga + $jumlahHarga;
		$totalBarang	= $totalBarang	+ $myData['jumlah'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga']); ?></td>
    <td align="right"><?php echo format_angka($myData['jumlah']); ?></td>
    <td align="right"><?php echo format_angka($jumlahHarga); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right" bgcolor="#F5F5F5"><b> GRAND TOTAL   : </b></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
</table>
<br/>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>