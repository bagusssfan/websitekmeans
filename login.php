<link rel="stylesheet" type="text/css" href="styleadmin.css">

<div id="login">
<fieldset>
<form name="form1" method="post" action="" enctype="multipart/form-data">
 <h3>ADMINISTRATOR</h3>
 <input name="username" type="text" id="username" placeholder="Username">
 <input name="password" type="password" id="password" placeholder="Password">
 <input name="login" type="submit" value="LOGIN ">
</form>

<?php
error_reporting(0);
session_start();
include_once("koneksi.php");

if($_POST["login"]!=""){ //jika tombol Login diklik

	$user=$_POST["username"];
	$pass=$_POST["password"];
	
	if($user!="" && $pass!=""){
		include_once("koneksi.php");
		$em = mysql_query("select * from admin where password = '$pass' AND username = '$user'");
		$data = mysql_fetch_assoc($em);
		
		if ($data["username"] == $user && $data["password"] == $pass) {
			echo "<div class='alert alert-success alert-dismissable'>\n
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\n
			Data Telah Ditemukan!!.\n</div>";
			$_SESSION["useradmin"] = $data["username"];
			$_SESSION["passadmin"] = $data["password"];
			$_SESSION["nmadmin"] = $data["nm_lengkap"];
			
			echo "<script>window.location.href='index.php'</script>";
		} else {
			echo "<center><div class='alert alert-warning alert-dismissable'>\n
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>\n
			<b>Data Tidak Ditemukan!!</b>\n</div><center>";
		}
	}
}
?>

</fieldset>
</div>
