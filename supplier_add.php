<?php
//include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtSupplier= $_POST['txtSupplier'];
	$txtAlamat	= $_POST['txtAlamat'];
	$txtTelepon	= $_POST['txtTelepon'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtSupplier)=="") {
		$pesanError[] = "Data <b>Nama Supplier</b> tidak boleh kosong !";		
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
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
		$kodeBaru	= buatKode("supplier", "S");
		$mySql	= "INSERT INTO supplier (kd_supplier, nm_supplier, alamat, no_telepon) 
					VALUES ('$kodeBaru',
							'$txtSupplier',
							'$txtAlamat',
							'$txtTelepon')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Add'>";
		}
		exit;
	}	
} // Penutup POST
	
# MASUKKAN DATA KE VARIABEL
$dataKode	= buatKode("supplier", "S");
$dataNama	= isset($_POST['txtSupplier']) ? $_POST['txtSupplier'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
<table width="100%" cellpadding="2" cellspacing="1" class="table-list" style="margin-top:0px;">
	<tr>
	  <th colspan="3">TAMBAH DATA SUPPLIER </th>
	</tr>
	<tr>
	  <td width="19%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="80%"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly"/></td></tr>
	<tr>
	  <td><b>Nama Supplier </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtSupplier" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
	</tr>
	<tr>
      <td><b>Alamat Lengkap </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></td>
    </tr>
	<tr>
      <td><b>No Telepon </b></td>
	  <td><b>:</b></td>
	  <td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
</table>
</form>
