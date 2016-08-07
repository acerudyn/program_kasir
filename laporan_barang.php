<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Baca variabel URL browser
$kodeKategori = isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : 'SEMUA'; 
// Baca variabel dari Form setelah di Post
$kodeKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

// Membuat filter SQL
if ($kodeKategori=="SEMUA") {
	//Query #1 (semua data)
	$filterSQL 	= "";
}
else {
	//Query #2 (filter)
	$filterSQL 	= " WHERE barang.kd_kategori ='$kodeKategori'";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die("Error paging:".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> LAPORAN DATA BARANG </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="84"><strong> Kategori </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="397">
	  <select name="cmbKategori">
        <option value="SEMUA">....</option>
        <?php
	  $bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_kategori'] == $kodeKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori]</option>";
	  }
	  ?>
      </select>
      <input name="btnTampilkan" type="submit" value=" Tampilkan  "/></td>
    </tr>
  </table>
</form>

<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="58" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="273" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
    <td width="76" bgcolor="#CCCCCC"><strong>Satuan</strong></td>
    <td width="31" align="right" bgcolor="#CCCCCC"><strong>Stok</strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Hrg. Beli  (Rp) </strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Hrg. Jual  (Rp) </strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT * FROM barang $filterSQL ORDER BY kd_barang ASC LIMIT $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['kd_barang']; ?> </td>
    <td> <?php echo $myData['nm_barang']; ?> </td>
    <td> <?php echo $myData['satuan']; ?> </td>
    <td align="right"> <?php echo $myData['stok']; ?> </td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
  </tr>
  <?php } ?>
  <tr class="selKecil">
    <td colspan="3"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="4" align="right">
	<strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Barang&hal=$list[$h]&kodeKategori=$kodeKategori'>$h</a> ";
	}
	?></td>
  </tr>
</table>
