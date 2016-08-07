<?php
# KONTROL MENU PROGRAM
if($_GET) {
	// Jika mendapatkan variabel URL ?open
	switch($_GET['open']){				
		case '' :
			if(!file_exists ("main.php")) die ("File tidak ada!"); 
			include "main.php";	break;
			
		case 'Halaman-Utama' :
			if(!file_exists ("main.php")) die ("File tidak ada!"); 
			include "main.php";	break;
			
		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ada!"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ada!"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ada!"); 
			include "login_out.php"; break;		

		# DATA KASIR
		case 'Kasir-Data' :
			if(!file_exists ("kasir_data.php")) die ("File tidak ada!"); 
			include "kasir_data.php";	 break;		
		case 'Kasir-Add' :
			if(!file_exists ("kasir_add.php")) die ("File tidak ada!"); 
			include "kasir_add.php";	 break;		
		case 'Kasir-Delete' :
			if(!file_exists ("kasir_delete.php")) die ("File tidak ada!"); 
			include "kasir_delete.php"; break;		
		case 'Kasir-Edit' :
			if(!file_exists ("kasir_edit.php")) die ("File tidak ada!"); 
			include "kasir_edit.php"; break;	

		# KATEGORI BARANG
		case 'Kategori-Data' :
			if(!file_exists ("kategori_data.php")) die ("File tidak ada!"); 
			include "kategori_data.php"; break;		
		case 'Kategori-Add' :
			if(!file_exists ("kategori_add.php")) die ("File tidak ada!"); 
			include "kategori_add.php";	break;		
		case 'Kategori-Delete' :
			if(!file_exists ("kategori_delete.php")) die ("File tidak ada!"); 
			include "kategori_delete.php"; break;		
		case 'Kategori-Edit' :
			if(!file_exists ("kategori_edit.php")) die ("File tidak ada!"); 
			include "kategori_edit.php"; break;	
			
		# DATA BARANG
		case 'Barang-Data' :
			if(!file_exists ("barang_data.php")) die ("File tidak ada!"); 
			include "barang_data.php"; break;		
		case 'Barang-Add' :
			if(!file_exists ("barang_add.php")) die ("File tidak ada!"); 
			include "barang_add.php"; break;		
		case 'Barang-Delete' :
			if(!file_exists ("barang_delete.php")) die ("File tidak ada!"); 
			include "barang_delete.php"; break;		
		case 'Barang-Edit' :
			if(!file_exists ("barang_edit.php")) die ("File tidak ada!"); 
			include "barang_edit.php"; break;

		# SUPPLIER
		case 'Supplier-Data' :
			if(!file_exists ("supplier_data.php")) die ("File tidak ada!"); 
			include "supplier_data.php"; break;		
		case 'Supplier-Add' :
			if(!file_exists ("supplier_add.php")) die ("File tidak ada!"); 
			include "supplier_add.php"; break;
		case 'Supplier-Delete' :
			if(!file_exists ("supplier_delete.php")) die ("File tidak ada!"); 
			include "supplier_delete.php"; break;
		case 'Supplier-Edit' :
			if(!file_exists ("supplier_edit.php")) die ("File tidak ada!"); 
			include "supplier_edit.php"; break;

		case 'Pencarian-Barang' :
			if(!file_exists ("pencarian_barang.php")) die ("File tidak ada!"); 
			include "pencarian_barang.php"; break;		


		# REPORT INFORMASI / LAPORAN DATA
		case 'Laporan' :
				if(!file_exists ("menu_laporan.php")) die ("File tidak ada!"); 
				include "menu_laporan.php"; break;

			# LAPORAN MASTER DATA
			case 'Laporan-Kasir' :
				if(!file_exists ("laporan_kasir.php")) die ("File tidak ada!"); 
				include "laporan_kasir.php"; break;
	
			case 'Laporan-Supplier' :	
				if(!file_exists ("laporan_supplier.php")) die ("File tidak ada!"); 
				include "laporan_supplier.php"; break;
				
			case 'Laporan-Kategori' :	
				if(!file_exists ("laporan_kategori.php")) die ("File tidak ada!"); 
				include "laporan_kategori.php"; break;
				
			case 'Laporan-Barang' :	
				if(!file_exists ("laporan_barang.php")) die ("File tidak ada!"); 
				include "laporan_barang.php"; break;
				
			# LAPORAN PEMBELIAN
			case 'Laporan-Pembelian-Periode' :
				if(!file_exists ("laporan_pembelian_periode.php")) die ("File tidak ada!"); 
				include "laporan_pembelian_periode.php"; break;
				
			case 'Laporan-Pembelian-Supplier' :
				if(!file_exists ("laporan_pembelian_supplier.php")) die ("File tidak ada!"); 
				include "laporan_pembelian_supplier.php"; break;
															
			# LAPORAN PENJUALAN 
			case 'Laporan-Penjualan' :
				if(!file_exists ("laporan_penjualan.php")) die ("File tidak ada!"); 
				include "laporan_penjualan.php"; break;
				
			case 'Laporan-Penjualan-Periode' :
				if(!file_exists ("laporan_penjualan_periode.php")) die ("File tidak ada!"); 
				include "laporan_penjualan_periode.php"; break;
				
		default:
			if(!file_exists ("main.php")) die ("File tidak ada!"); 
			include "main.php";						
		break;
	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?page
	if(!file_exists ("main.php")) die ("File tidak ada!"); 
	include "main.php";	
}
?>