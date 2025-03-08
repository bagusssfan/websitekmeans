<?php
include("koneksi.php");

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan variabel yang dikirimkan dari formulir tersedia
    if (isset($_POST['c1Data']) && isset($_POST['c2Data']) && isset($_POST['c3Data'])) {
        // Ambil nilai variabel yang dikirimkan dari formulir
        $c1Data = $_POST['c1Data'];
        $c2Data = $_POST['c2Data'];
        $c3Data = $_POST['c3Data'];

        // Pisahkan nilai variabel menjadi komponen-komponen yang sesuai
        list($c1x, $c1y, $c1hari, $c1stokdefault ) = explode("_", $c1Data);
        list($c2x, $c2y, $c2hari, $c2stokdefault) = explode("_", $c2Data);
        list($c3x, $c3y, $c3hari, $c3stokdefault) = explode("_", $c3Data);

        // Hitung nilai C1z, C2z, dan C3z
        $c1z = $c1x - $c1y;
        $c2z = $c2x - $c2y;
        $c3z = $c3x - $c3y;

        // Ambil tanggal saat ini
        $tanggal = date('Y-m-d');

        // Update data ke dalam database, termasuk tanggal
        $query = "UPDATE hasil 
                  SET c1='$c1x', c2='$c1y', c3='$c1z', 
                      c1y='$c2x', c2y='$c2y', c3y='$c2z', 
                      c1z='$c3x', c2z='$c3y', c3z='$c3z',
                      c1hari='$c1hari', c2hari='$c2hari', c3hari='$c3hari',
                      c1stokdefault='$c1stokdefault', c2stokdefault='$c2stokdefault', c3stokdefault='$c3stokdefault',
                      tanggal='$tanggal'
                  WHERE id_hasil='1'";

        if (mysql_query($query)) {
            echo "<script>alert('Data Berhasil Di Proses'); window.location.href='index.php?module=hasil';</script>";
        } else {
            echo "Error: " . mysql_error();
        }
    } else {
        echo "Variabel tidak tersedia!";
    }
} else {
    echo "Metode yang digunakan bukan POST!";
}
?>
