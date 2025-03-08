<?php 
	session_start();
	include "koneksi.php";
	error_reporting(0);
	
	if(!empty($_SESSION["useradmin"]) && !empty($_SESSION["passadmin"])){
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Mining</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>
/* CSS untuk Dropdown Menu */
.dropdown {
	position: relative;
	display: inline-block;
}

.dropdown-content {
	display: none;
	position: absolute;
	top: 100%; /* Menempatkan dropdown di bawah tombol */
	left: 0; /* Menjaga dropdown di bawah tombol */
	background-color: #f9f9f9;
	box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	z-index: 1;
	flex-direction: row; /* Menyusun item secara horizontal */
	padding: 0;
	margin: 0;
	border-radius: 4px; /* Sudut dropdown sedikit membulat */
}

.dropdown-content a {
	color: black;
	padding: 12px 16px;
	text-decoration: none;
	display: inline-block; /* Menyusun item secara horizontal */
	width: auto; /* Menyusun item secara horizontal */
	margin-right: 2px; /* Jarak antar item */
	background-color: #f9f9f9; /* Latar belakang item */
	border-right: 1px solid #9D0000; /* Border merah di sebelah kanan item */
	bottom: 1px;
}

.dropdown-content a:last-child {
	border-right: none; /* Menghilangkan border kanan pada item terakhir */
}

.dropdown-content a:hover {
	background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
	display: flex; /* Menampilkan dropdown sebagai flex container */
}

.dropdown:hover .dropbtn {
	background-color: #333333;
}

</style>
</head>

<body>

<div class="container2">
  <ul id="menu">
	<li><a href="?module=data">Data</a></li>
	<li><a href="?module=data_proses">Proses Clustering</a></li>
	<li><a href="?module=hasil">Hasil Clustering</a></li>
	<li><a href="?module=grafiklingkaran">Grafik Hasil Clustering</a></li>
	<li><a href="?module=laporan">Laporan</a></li>
	<li><a href="?module=logout">Logout</a></li>
  </ul>
</div>

<div class="container5" style="padding:0px 20px;">
  <div class="grid">
	<?php include "content.php"; ?>
  </div>
</div>

<br><br><br><br><br>

<?php include "footer.php"; ?>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>

</body>
</html>

<?php
	} else {
		include "login.php";
	}
?>
