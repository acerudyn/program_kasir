<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Data Form
	$txtNama		= $_POST['txtNama'];
	$txtHargaBeli	= $_POST['txtHargaBeli'];
	$txtHargaJual	= $_POST['txtHargaJual'];
	$txtStok		= $_POST['txtStok'];
	$cmbSatuan		= $_POST['cmbSatuan'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbKategori	= $_POST['cmbKategori'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
	}
	if (trim($txtHargaBeli)=="" or ! is_numeric(trim($txtHargaBeli))) {
		$pesanError[] = "Data <b>Harga Beli (Rp.)</b> harus diisi angka!";		
	}
	if (trim($txtHargaJual)=="" or ! is_numeric(trim($txtHargaJual))) {
		$pesanError[] = "Data <b>Harga Jual (Rp.)</b> harus diisi angka!";		
	}
	if (trim($txtStok)=="" or ! is_numeric(trim($txtStok))) {
		$pesanError[] = "Data <b>Stok barang</b> harus diisi angka !";		
	}
	if (trim($cmbSatuan)=="KOSONG") {
		$pesanError[] = "Data <b>Satuan</b> belum ada yang dipilih !";		
	}
	if (trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}
	if (trim($cmbKategori)=="KOSONG") {
		$pesanError[] = "Data <b>Kategori Barang</b> belum ada yang dipilih !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
$Kode	= $_POST['txtKode'];
$mySql	= "UPDATE barang SET nm_barang	= '$txtNama',
						harga_modal	= '$txtHargaBeli',
						harga_jual	= '$txtHargaJual',
						stok		= '$txtStok',
						satuan		= '$cmbSatuan',
						keterangan	= '$txtKeterangan',
						kd_kategori	= '$cmbKategori'
				WHERE kd_barang ='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
if($myQry){
	echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
}
exit;
	}
} // Penutup POST
	
	
# TAMPILKAN DATA UNTUK DIEDIT
$Kode	= $_GET['Kode']; 
$mySql 	= "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query data salah : ".mysql_error());
$myData	= mysql_fetch_array($myQry);
	// Membaca data, lalu disimpan dalam variabel data
	$dataKode		=  $myData['kd_barang'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
	$dataHargaBeli	= isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : $myData['harga_modal'];
	$dataHargaJual	= isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : $myData['harga_jual'];
	$dataStok		= isset($_POST['txtStok']) ? $_POST['txtStok'] :  $myData['stok'];
	$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : $myData['satuan'];
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table  class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">UBAH DATA BARANG</th>
    </tr>
    <tr>
      <td width="16%"><strong>Kode</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="83%"><input name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /> </td>
    </tr>
    <tr>
      <td><strong>Harga Beli (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtHargaBeli" value="<?php echo $dataHargaBeli; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
    <tr>
      <td><strong>Harga Jual (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtHargaJual" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></td>
    </tr>
    <tr>
      <td><strong>Stok</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtStok" value="<?php echo $dataStok; ?>" size="14" maxlength="10"/></td>
    </tr>
    <tr>
      <td><b>Satuan</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbSatuan">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Tabung", "Unit", "Botol", "Kotak", "Box", "Kotak");
          foreach ($pilihan as $nilai) {
            if ($dataSatuan ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>Kategori</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbKategori">
          <option value="KOSONG">....</option>
          <?php
	  $bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
  </table>
</form>
