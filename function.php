<?php

session_start();
$connection = mysqli_connect("localhost","root","","kasir");

if(isset($_POST["login"])){
	$username = $_POST['username'];
	$password = $_POST['password'];

	$check = mysqli_query($connection, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
	$count = mysqli_num_rows($check);

	if($count>0){
		$_SESSION['login']=true;
		header('location:index.php');
	} else {
		echo"
			<script>
				alert('Username atau Password salah')
				window.location.href='login.php'
			</script>
		";
	}
}

if(isset($_POST['tambahbuku'])){
	$msg = "";

	$gambar = $_FILES["gambar"]["name"];
    $tempname = $_FILES["gambar"]["tmp_name"];  
    $folder = "image/".$gambar; 

	$judul_buku = $_POST['judul_buku'];
	$penulis = $_POST['penulis'];
	$harga = $_POST['harga'];
	$stok = $_POST['stok'];

	$tambah_buku = (mysqli_query($connection,"INSERT INTO buku (judul_buku, penulis, gambar, harga, stok) VALUES ('$judul_buku', '$penulis', '$gambar', '$harga', '$stok')"));

	if ($tambah_buku) {
		move_uploaded_file($tempname, $folder);
     //        $msg = "Image uploaded successfully";
     //    }else{
     //        $msg = "Failed to upload image";
    	// }
		header('location:stok.php');
	} else {
		echo"
			<script>
				alert('Gagal menambahkan data')
				window.location.href='stok.php'
			</script>
		";
	}

	
}

if(isset($_POST['tambahpelanggan'])){
	$nama_pelanggan = $_POST['nama_pelanggan'];
	$notelp = $_POST['notelp'];
	$alamat = $_POST['alamat'];

	$tambah_pelanggan = (mysqli_query($connection,"INSERT INTO pelanggan (nama_pelanggan, notelp, alamat) VALUES ('$nama_pelanggan', '$notelp', '$alamat')"));

	if ($nama_pelanggan) {
		header('location:pelanggan.php');
	} else {
		echo"
			<script>
				alert('Gagal menambahkan data')
			</script>
		";
	}
}

if(isset($_POST['tambahpesanan'])){
	$id_pelanggan = $_POST['id_pelanggan'];

	$tambah_pesanan = (mysqli_query($connection,"INSERT INTO pesanan (id_pelanggan) VALUES ('$id_pelanggan')"));

	if ($tambah_pesanan) {
		header('location:index.php');
	} else {
		echo"
			<script>
				alert('Gagal menambahkan data')
			</script>
		";
	}
}

if(isset($_POST['tambahbuku2'])){
	$id_buku = $_POST['id_buku'];
	$idp = $_POST['idp'];
	$qty = $_POST['qty'];

	$hitung1 = mysqli_query($connection, "SELECT * FROM buku WHERE id_buku='$id_buku'");
	$hitung2 = mysqli_fetch_array($hitung1);
	$stoksekarang = $hitung2["stok"];

	if ($stoksekarang>=$qty) {
		$selisih = $stoksekarang-$qty;

		$insert = (mysqli_query($connection,"INSERT INTO detail_pesanan (id_pesanan, id_buku, qty) VALUES ('$idp', '$id_buku', '$qty')"));
		$update = mysqli_query($connection,"UPDATE buku SET stok='$selisih' WHERE id_buku='$id_buku'");

		if ($insert && $update) {
			header("location:view.php?idp=".$idp);
		} else {
			echo"
				<script>
					alert('Gagal menambahkan data')
				</script>
			";
		}
	} else {
		
	}

	
}


?>