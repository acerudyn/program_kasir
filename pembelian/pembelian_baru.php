<?php
//include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# SKRIP HAPUS DATA TMP
if(isset($_GET['Aksi'])){
	if(trim($_GET['Aksi'])=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_pembelian WHERE kd_barang='".$_GET['Kode']."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal menghapus  tmp".mysql_error());
	}
}
// =========================================================================


# TOMBOL TAMBAH (SETELAH MEMILIH BARANG DARI COMBO) DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca Data dari Form
	$cmbBarang	= $_POST['cmbBarang'];
	$txtHarga	= $_POST['txtHarga'];
	$txtJumlah	= $_POST['txtJumlah'];
			
	# Validasi Kotak isi Form
	$pesanError = array();
	if (trim($cmbBarang)=="KOSONG") {
		$pesanError[] = "Data <b>Data Barang belum dipilih</b>, silahkan pilih dari comboBox !";			
	}
	if (trim($txtHarga)=="" or ! is_numeric(trim($txtHarga))) {
		$pesanError[] = "Data <b>Harga Pembelian (Rp) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN KE DATABASE (tmp_pembelian)	
		$tmpSql 	= "INSERT INTO tmp_pembelian (kd_barang, harga, jumlah) 
					VALUES ('$cmbBarang', '$txtHarga', '$txtJumlah')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
	}
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca variabel data from
	$txtTanggal 	= $_POST['txtTanggal'];
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	
	# Validasi Kotak isi Form
	$pesanError = array();
	if (trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if (trim($cmbSupplier)=="") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_pembelian";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, belum ada barang yang dimasukan, <b>minimal 1 barang</b>.";
	}
	
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE
		// Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. 
		// Data dari tmp dipindah ke tabel pembelian dan pembelian_item 
		$noTransaksi = buatKode("pembelian", "BL");
		$mySql	= "INSERT INTO pembelian SET 
						no_pembelian='$noTransaksi', 
						tgl_pembelian='".InggrisTgl($txtTanggal)."', 
						kd_supplier='$cmbSupplier', 
						keterangan='$txtKeterangan'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang ada di TMP (keranjang)
		$tmpSql ="SELECT * FROM  tmp_pembelian ORDER BY kd_barang";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_barang'];
			$dataHarga	= $tmpData['harga'];
			$dataJumlah	= $tmpData['jumlah'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO pembelian_item SET 
									no_pembelian='$noTransaksi', 
									kd_barang='$dataKode', 
									harga='$dataHarga', 
									jumlah='$dataJumlah'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok + $dataJumlah WHERE kd_barang ='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			
			// Skrip Update Harga Beli (Modal)
			$stokSql = "UPDATE barang SET harga_beli = $dataHarga WHERE kd_barang ='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Harga Modal".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_pembelian";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?open=Pembelian-Baru'>";
	}	
}

# VARIABEL DATA UNTUK FORM
$noTransaksi 	= buatKode("pembelian", "BL");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" cellpadding="3" cellspacing="1"  class="table-list">
    <tr>
      <td colspan="3"><h1>PEMBELIAN BARANG</h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA TRANSAKSI </strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="26%"><strong>No. Pembelian </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td width="72%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl. Pembelian </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="20" /></td>
    </tr>
    <tr>
      <td><strong>Supplier</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbSupplier">
        <option value="KOSONG">....</option>
        <?php
	  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_supplier'] == $dataSupplier) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[nm_supplier]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INPUT  BARANG </strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Kategori</strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbKategori">
          <option value="Kosong"> - </option>
          <?php
	  	// Menampilkan data kategori ke List/Menu
	  	$bacaSql	= "SELECT * FROM kategori ORDER BY kd_kategori";
		$bacaQry	= mysql_query($bacaSql, $koneksidb) or die ("Error Query".mysql_error()); 
		while($bacaData = mysql_fetch_array($bacaQry)) {
		  	// Status terpilih
			if ($bacaData['kd_kategori'] == $dataKategori) {
				$pilih = " selected";
			} else { $pilih=""; }

			echo "<option value='$bacaData[kd_kategori]' $pilih> $bacaData[nm_kategori] </option>";
		}
	  ?>
        </select>
          <input name="btnPilih" type="submit" value="Pilih" /></td>
    </tr>
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBarang">
          <option value="KOSONG">....</option>
          <?php
	  $bacaSql = "SELECT * FROM barang WHERE kd_kategori='$dataKategori' AND stok >=1 ORDER BY kd_barang";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
	  	// Status terpilih
		if ($bacaData['kd_barang'] == $dataBarang) {
			$pilih = " selected";
		} else { $pilih=""; }
		
		$hargaBeli	= format_angka($bacaData['harga_beli']);
		echo "<option value='$bacaData[kd_barang]' $pilih>[ $bacaData[kd_barang] ] $bacaData[nm_barang] | Rp. $hargaBeli</option>";
	  }
	 ?>
      </select></td>
    </tr>
    <tr>
      <td><b>Harga Beli (Rp) </b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="txtHarga" size="20" maxlength="12"/>
        Jumlah : 
        <input class="angkaC" name="txtJumlah" size="4" maxlength="4" value="10" 
				 onblur="if (value == '') {value = '10'}" 
				 onfocus="if (value == '10') {value =''}"/>
        <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
  <table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="7">DAFTAR BARANG </th>
    </tr>
    <tr>
      <td width="29" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="85" bgcolor="#CCCCCC"><strong>Kode</strong></td>
      <td width="432" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
      <td width="85" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
      <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
      <td width="100" align="right" bgcolor="#CCCCCC"><strong>Subtotal(Rp) </strong></td>
      <td width="22" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
    </tr>
	<?php
	// deklarasi variabel
	$hargaDiskon= 0; 
	$totalBayar	= 0; 
	$jumlahbarang	= 0;
	
	// Qury menampilkan data dalam Grid TMP_Pembelian 
	$tmpSql ="SELECT barang.nm_barang, tmp.* FROM tmp_pembelian As tmp
			LEFT JOIN barang ON tmp.kd_barang = barang.kd_barang 
			ORDER BY tmp.kd_barang ";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor=0;  
	while($tmpData = mysql_fetch_array($tmpQry)) {
		$nomor++;
		$subSotal 	= $tmpData['harga'] * $tmpData['jumlah'];
		$totalBayar	= $totalBayar + $subSotal;
		$jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];
	?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
      <td align="right"><?php echo format_angka($tmpData['jumlah']); ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?Aksi=Delete&Kode=<?php echo $tmpData['kd_barang']; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL   (Rp.) : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($jumlahbarang); ?></b></td>
      <td align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($totalBayar); ?></b></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
  </table>
</form>
