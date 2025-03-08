<?php
// Mengambil tanggal dari database
$tanggal_query = mysql_query("SELECT tanggal FROM hasil WHERE id_hasil='1'");
$tanggal_data = mysql_fetch_assoc($tanggal_query);
$tanggal = $tanggal_data['tanggal'];
$tanggal_format = date("d-m-Y", strtotime($tanggal)); // Format tanggal dengan "hari bulan tahun"

// Inisialisasi array untuk menyimpan titik-titik data
$data_points = array();

// Inisialisasi array untuk menyimpan warna setiap data
$data_colors = array();

// Mengambil data dari database untuk ditampilkan pada grafik
$q = mysql_query("SELECT * FROM data1 ORDER BY id ASC");
while ($r = mysql_fetch_array($q)) {
    $data_point = array(
        'x' => $r['dm'],
        'y' => $r['dk'],
        'z' => $sub=$r['dm']-$r['dk']
    );

    $sub=$r['dm']-$r['dk'];
    session_start (); 
    $px1 = $_SESSION [ '$px1' ] ;
    $py1 = $_SESSION [ '$py1' ] ;
    $pz1 = $_SESSION [ '$pz1' ] ;
    $px2 = $_SESSION [ '$px2' ] ;
    $py2 = $_SESSION [ '$py2' ] ;
    $pz2 = $_SESSION [ '$pz2' ] ;
    $px3 = $_SESSION [ '$px3' ] ;
    $py3 = $_SESSION [ '$py3' ] ;
    $pz3 = $_SESSION [ '$pz3' ] ;
    $c1 = sqrt(pow(($r['dm'] - $px1), 2) + pow(($r['dk'] - $py1), 2) + pow(($sub - $pz1), 2));
    $c2 = sqrt(pow(($r['dm'] - $px2), 2) + pow(($r['dk'] - $py2), 2) + pow(($sub - $pz2), 2));
    $c3 = sqrt(pow(($r['dm'] - $px3), 2) + pow(($r['dk'] - $py3), 2) + pow(($sub - $pz3), 2));

    // Menentukan cluster untuk data
    $min = min($c1, $c2, $c3);
    
   // Menentukan cluster untuk data
if ($min == $c1) {
    $color = 'red';
    $cluster_labels[] = 'C1'; // Label untuk Cluster 1
} elseif ($min == $c2) {
    $color = 'blue'; // Ubah warna ke biru untuk Cluster 2
    $cluster_labels[] = 'C2'; // Label untuk Cluster 2
} elseif ($min == $c3) {
    $color = 'green'; // Ubah warna ke hijau untuk Cluster 3
    $cluster_labels[] = 'C3'; // Label untuk Cluster 3
} else {
    $color = 'gray'; // Warna default untuk data yang tidak termasuk dalam cluster
    $cluster_labels[] = 'None'; // Label untuk data yang tidak termasuk dalam cluster
}


    // Menyimpan titik data ke dalam array
    $data_points[] = $data_point;

    // Menyimpan warna data ke dalam array
    $data_colors[] = $color;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clustering Chart</title>
    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2 style="text-align: center;">Grafik Hasil Clustering Data Persediaan Barang</h2>
    <p style="text-align: center;">Tanggal: <?php echo $tanggal_format; ?></p>
    <canvas id="clusteringChart" width="200" height="80"></canvas>
    <div id="legend">
        <h2>Keterangan :</h2>
        <h2><span style="color: red;">&#9632;</span> Cluster 1</h2>
        <h2><span style="color: blue;">&#9632;</span> Cluster 2</h2>
        <h2><span style="color: green;">&#9632;</span> Cluster 3</h2>
    </div>
    <script>
        // Mengambil data titik-titik dan warna dari PHP
        var data_points = <?php echo json_encode($data_points); ?>;
        var data_colors = <?php echo json_encode($data_colors); ?>;
        var cluster_labels = <?php echo json_encode($cluster_labels); ?>;
        console.log(cluster_labels);

        // Menggambar grafik clustering menggunakan Chart.js
        var ctx = document.getElementById('clusteringChart').getContext('2d');
        var clusteringChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Clustered Data',
                    data: data_points,
                    backgroundColor: data_colors, // Menggunakan warna sesuai dengan cluster
                    pointRadius: 5
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Dimensi x (Barang Masuk (pcs) )'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Dimensi y (Barang Keluar (pcs) )'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = 'Cluster: ' + cluster_labels[context.dataIndex];
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
