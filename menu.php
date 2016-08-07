<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
?>
<ul>
	<li><a href='?open' title='Halaman Utama'>Home</a></li>
	<li><a href='?open=Kasir-Data' title='Kasir Login'>Data Kasir</a></li>
	<li><a href='?open=Kategori-Data' title='Kategori'>Data Kategori</a></li>
	<li><a href='?open=Supplier-Data' title='Supplier'>Data Supplier</a></li>
	<li><a href='?open=Barang-Data' title='Obat'>Data Barang</a></li>
	<li><a href='pembelian/' title='Pembelian Barang' target='_blank'>Transaksi Pembelian</a></li>
	<li><a href='penjualan/' title='Penjualan Barang' target='_blank'>Transaksi Penjualan</a></li>
	<li><a href='?open=Laporan' title='Laporan'>Laporan</a></li>
	<li><a href='?open=Logout' title='Logout (Exit)'>Logout</a></li>
</ul>
<?php
}
else {
# JIKA BELUM LOGIN (BELUM ADA SESION LEVEL YG DIBACA)
?>
<ul>
	<li><a href='?open=Login' title='Login System'>Login</a></li>	
</ul>
<?php
}
?>