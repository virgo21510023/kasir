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
		if (move_uploaded_file($tempname, $folder)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
    	}
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

?>