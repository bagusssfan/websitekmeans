<div class="span12">
          <div class="widget widget-nopad">
<?php
switch($_GET['act']){
default:
?>
<div class="widget-header"> <i class="icon-list-alt"></i>

            </div>
            <!-- /widget-header -->
			<div class="widget big-stats-container">
				<br/>
				<p>
				&nbsp;<a href="cetak.php" class="btn btn-more" target="_blank">Cetak</a>
				</p>
				<div class="shortcuts">
				<table class="table table-striped table-bordered table-hover">
				<thead>
                    <tr>
						<th rowspan=2>No</th>
                        <th rowspan=2>Nama Barang</th>
                        <th colspan=5><center>Data Persediaan Barang </center></th>
                        <th rowspan=2>C1</th>
                        <th rowspan=2>C2</th>
						<th rowspan=2>C3</th>
                        <th rowspan=2>Hasil</th>

                    </tr>
					<tr>
						<th>Barang Masuk (pcs) </th>
						<th>Barang Keluar (pcs)</th>
						<th>Stok (pcs)</th>
						<th>Hari</th>
						<th>Stok Default(pcs)</th>
					</tr>
                </thead>
				<tbody>
				<?php 
    $no=1;
    $q = mysql_query("select * from data1 order by id asc");
    
    // Array untuk menyimpan data berdasarkan cluster
    $dataCluster1 = [];
    $dataCluster2 = [];
    $dataCluster3 = [];
    
    // Menyimpan data per cluster dalam array sesuai cluster
    while($r = mysql_fetch_array($q)) {
        $sub = $r['dm'] - $r['dk'];
        session_start(); 
        
        // Mengambil nilai dari session
        $px1 = $_SESSION['$px1'];
        $py1 = $_SESSION['$py1'];
        $pz1 = $_SESSION['$pz1'];
        $c1hari = $_SESSION['$c1hari'];
        $c1stokdefault = $_SESSION['$c1stokdefault'];
        $px2 = $_SESSION['$px2'];
        $py2 = $_SESSION['$py2'];
        $pz2 = $_SESSION['$pz2'];
        $c2hari = $_SESSION['$c2hari'];
        $c2stokdefault = $_SESSION['$c2stokdefault'];
        $px3 = $_SESSION['$px3'];
        $py3 = $_SESSION['$py3'];
        $pz3 = $_SESSION['$pz3'];
        $c3hari = $_SESSION['$c3hari'];
        $c3stokdefault = $_SESSION['$c3stokdefault'];
        
        // Hitung jarak untuk masing-masing cluster
        $c1 = sqrt((pow(($r['dm'] - $px1), 2)) + (pow(($r['dk'] - $py1), 2)) + (pow(($sub - $pz1), 2)) + (pow(($r['hari'] - $c1hari), 2)) + (pow(($r['stokdefault'] - $c1stokdefault), 2)));
        $c2 = sqrt((pow(($r['dm'] - $px2), 2)) + (pow(($r['dk'] - $py2), 2)) + (pow(($sub - $pz2), 2)) + (pow(($r['hari'] - $c2hari), 2)) + (pow(($r['stokdefault'] - $c2stokdefault), 2)));
        $c3 = sqrt((pow(($r['dm'] - $px3), 2)) + (pow(($r['dk'] - $py3), 2)) + (pow(($sub - $pz3), 2)) + (pow(($r['hari'] - $c3hari), 2)) + (pow(($r['stokdefault'] - $c3stokdefault), 2)));
        
        $min = min($c1, $c2, $c3);
        
        if($min == $c1) {
            $ketmin = "C1";    
            $dataCluster1[] = [
            
                'nmb' => $r['nmb'],
                'dm' => $r['dm'],
                'dk' => $r['dk'],
                'sub' => $sub,
                'hari' => $r['hari'],
                'stokdefault' => $r['stokdefault'],
                'c1' => number_format($c1, 2),
                'c2' => number_format($c2, 2),
                'c3' => number_format($c3, 2),
                'ketmin' => $ketmin

            ];
			$x[]=$r['dm'];	
			$x1[]=$r['dk'];
			$x2[]=$r['dm']-$r['dk'];
			$x3[]=$r['hari'];
			$x4[]=$r['stokdefault'];
			$nomor_cluster_1[] = $no; 	
			$namabarangc1[] = $r['nmb']; 	
			$jumlah_masuk_c1 += $r['dm']; 
			$dmc1 = $r['dm'];
			$dkc1 = $r['dk'];
			$haric1 =  $r['hari'];
			$stokdefaultc1 =  $r['stokdefault'];// Tambahkan nilai barang masuk ke dalam variabel total
			$totaldmc1=count($x);
			$ratadmc1=$jumlah_masuk_c1/$totaldmc1; 
			$jumlah_keluar_c1 += $r['dk']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totaldkc1=count($x1);
			$ratadkc1=$jumlah_keluar_c1/$totaldkc1; 
			$stok_c1 += ($r['dm']-$r['dk']); // Tambahkan nilai stok ke dalam variabel total
			$totalsubc1=count($x2);
			$ratasubc1=$stok_c1/$totalsubc1;
			$sub=$r['dm']-$r['dk'];
			$jumlahharic1 += $r['hari']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totalharic1=count($x3);
			$rataharic1=$jumlahharic1/$totalharic1;
			$jumlahstokdefaultc1 += $r['stokdefault']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totalstokdefaultc1=count($x4);
			$ratastokdefaultc1=$jumlahstokdefaultc1/$totalstokdefaultc1; 
			$sswc1 = sqrt((pow(($dmc1 - $px1), 2)) + (pow(($dkc1 - $py1), 2)) + (pow(($sub - $pz1), 2))+ (pow(($haric1 - $c1hari), 2))+ (pow(($stokdefaultc1 - $c1stokdefault), 2)));
			$totalsswc1+=$sswc1;
			$averagesswc1=$totalsswc1/$totalsubc1;
        } elseif($min == $c2) {
            $ketmin = "C2";    
            $dataCluster2[] = [
               
                'nmb' => $r['nmb'],
                'dm' => $r['dm'],
                'dk' => $r['dk'],
                'sub' => $sub,
                'hari' => $r['hari'],
                'stokdefault' => $r['stokdefault'],
                'c1' => number_format($c1, 2),
                'c2' => number_format($c2, 2),
                'c3' => number_format($c3, 2),
                'ketmin' => $ketmin
            ];
			$y[]=$r['dm'];	
			$y1[]=$r['dk'];
			$y2[]=$r['dm']-$r['dk'];
			$y3[]=$r['hari'];
			$y4[]=$r['stokdefault'];
			$nomor_cluster_2[] = $no; 	
			$namabarangc2[] = $r['nmb']; 
			$dmc2 = $r['dm'];
			$dkc2 = $r['dk']; 
			$haric2 =  $r['hari'];
			$stokdefaultc2 =  $r['stokdefault'];
			$jumlah_masuk_c2 += $r['dm']; // Tambahkan nilai barang masuk ke dalam variabel total
			$totaldmc2=count($y);
			$ratadmc2=$jumlah_masuk_c2/$totaldmc2; 
			$jumlah_keluar_c2 += $r['dk']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totaldkc2=count($y1);
			$ratadkc2=$jumlah_keluar_c2/$totaldkc2; 
			$stok_c2 += ($r['dm']-$r['dk']); // Tambahkan nilai stok ke dalam variabel total
			$totalsubc2=count($y2);
			$ratasubc2=$stok_c2/$totalsubc2; 
			$sub=$r['dm']-$r['dk'];
			$jumlahharic2 += $r['hari']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totalharic2=count($y3);
			$rataharic2=$jumlahharic2/$totalharic2;
			$jumlahstokdefaultc2 += $r['stokdefault']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totalstokdefaultc2=count($y4);
			$ratastokdefaultc2=$jumlahstokdefaultc2/$totalstokdefaultc2;
			$sswc2 = sqrt((pow(($dmc2 - $px2), 2)) + (pow(($dkc2 - $py2), 2)) + (pow(($sub - $pz2), 2))+ (pow(($haric2 - $c2hari), 2))+ (pow(($stokdefaultc2 - $c2stokdefault), 2)));
			$totalsswc2+=$sswc2;
			$averagesswc2=$totalsswc2/$totalsubc2;
        } elseif($min == $c3) {
            $ketmin = "C3";    
            $dataCluster3[] = [
              
                'nmb' => $r['nmb'],
                'dm' => $r['dm'],
                'dk' => $r['dk'],
                'sub' => $sub,
                'hari' => $r['hari'],
                'stokdefault' => $r['stokdefault'],
                'c1' => number_format($c1, 2),
                'c2' => number_format($c2, 2),
                'c3' => number_format($c3, 2),
                'ketmin' => $ketmin
            ];
			
			$z[]=$r['dm'];
			$z1[]=$r['dk'];
			$z2[]=$r['dm']-$r['dk'];
			$z3[]=$r['hari'];
			$z4[]=$r['stokdefault'];
			$nomor_cluster_3[] = $no; 
			$namabarangc3[] = $r['nmb']; 
			$dmc3 = $r['dm'];
			$dkc3 = $r['dk']; 
			$haric3 =  $r['hari'];
			$stokdefaultc3 =  $r['stokdefault'];
			$jumlah_masuk_c3 += $r['dm']; // Tambahkan nilai barang masuk ke dalam variabel total
			$totaldmc3=count($z);
			$ratadmc3=$jumlah_masuk_c3/$totaldmc3; 
			$jumlah_keluar_c3 += $r['dk']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totaldkc3=count($z1);
			$ratadkc3=$jumlah_keluar_c3/$totaldkc3; 
			$stok_c3 += ($r['dm']-$r['dk']); // Tambahkan nilai stok ke dalam variabel total
			$totalsubc3=count($z2);
			$ratasubc3=$stok_c3/$totalsubc3; 	
			$sub=$r['dm']-$r['dk'];
			$jumlahharic3 += $r['hari']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totalharic3=count($z3);
			$rataharic3=$jumlahharic3/$totalharic3;
			$jumlahstokdefaultc3 += $r['stokdefault']; // Tambahkan nilai barang keluar ke dalam variabel total
			$totalstokdefaultc3=count($z4);
			$ratastokdefaultc3=$jumlahstokdefaultc3/$totalstokdefaultc3;
			$sswc3 = sqrt((pow(($dmc3 - $px3), 2)) + (pow(($dkc3 - $py3), 2)) + (pow(($sub - $pz3), 2))+ (pow(($haric3 - $c3hari), 2))+ (pow(($stokdefaultc3 - $c3stokdefault), 2)));

			$totalsswc3+=$sswc3;
			$averagesswc3=$totalsswc3/$totalsubc3;	
        }
        
        $no++;
    }
    
    // Tampilkan data sesuai urutan cluster: C1, C2, C3
	$number = 1;
    foreach ($dataCluster1 as $data) {
        echo "<tr>
            <td>{$number}</td>
            <td>{$data['nmb']}</td>
            <td>{$data['dm']}</td>
            <td>{$data['dk']}</td>
            <td>{$data['sub']}</td>
            <td>{$data['hari']}</td>
            <td>{$data['stokdefault']}</td>
            <td>{$data['c1']}</td>
            <td>{$data['c2']}</td>
            <td>{$data['c3']}</td>
            <td>{$data['ketmin']}</td>
        </tr>";
		$number++;
    }
   
    foreach ($dataCluster2 as $data) {
        echo "<tr>
            <td>{$number}</td>
            <td>{$data['nmb']}</td>
            <td>{$data['dm']}</td>
            <td>{$data['dk']}</td>
            <td>{$data['sub']}</td>
            <td>{$data['hari']}</td>
            <td>{$data['stokdefault']}</td>
            <td>{$data['c1']}</td>
            <td>{$data['c2']}</td>
            <td>{$data['c3']}</td>
            <td>{$data['ketmin']}</td>
        </tr>";
		$number++;
    }
    
    foreach ($dataCluster3 as $data) {
        echo "<tr>
            <td>{$number}</td>
            <td>{$data['nmb']}</td>
            <td>{$data['dm']}</td>
            <td>{$data['dk']}</td>
            <td>{$data['sub']}</td>
            <td>{$data['hari']}</td>
            <td>{$data['stokdefault']}</td>
            <td>{$data['c1']}</td>
            <td>{$data['c2']}</td>
            <td>{$data['c3']}</td>
            <td>{$data['ketmin']}</td>
        </tr>";
		$number++;
    }
?>

				</tbody>
			</table>
				</div>
              </div>
            </div>
<?php
break;
}
session_start (); 
$_SESSION [ '$nomor_cluster_1' ] = $nomor_cluster_1 ;
$_SESSION [ '$nomor_cluster_2' ] = $nomor_cluster_2 ;
$_SESSION [ '$nomor_cluster_3' ] = $nomor_cluster_3 ;
$_SESSION [ '$ratadmc1' ] = $ratadmc1 ;
$_SESSION [ '$ratadkc1' ] = $ratadkc1 ;
$_SESSION [ '$ratasubc1' ] = $ratasubc1 ;
$_SESSION [ '$rataharic1' ] = $rataharic1 ;
$_SESSION [ '$ratastokdefaultc1' ] = $ratastokdefaultc1 ;
$_SESSION [ '$ratadmc2' ] = $ratadmc2 ;
$_SESSION [ '$ratadkc2' ] = $ratadkc2 ;
$_SESSION [ '$ratasubc2' ] = $ratasubc2 ;
$_SESSION [ '$rataharic2' ] = $rataharic2 ;
$_SESSION [ '$ratastokdefaultc2' ] = $ratastokdefaultc2 ;
$_SESSION [ '$ratadmc3' ] = $ratadmc3 ;
$_SESSION [ '$ratadkc3' ] = $ratadkc3 ;
$_SESSION [ '$ratasubc3' ] = $ratasubc3 ;
$_SESSION [ '$rataharic3' ] = $rataharic3 ;
$_SESSION [ '$ratastokdefaultc3' ] = $ratastokdefaultc3 ;
$_SESSION [ '$totaldmc1' ] = $totaldmc1 ;
$_SESSION [ '$totaldmc2' ] = $totaldmc2 ;
$_SESSION [ '$totaldmc3' ] = $totaldmc3 ;
$_SESSION [ '$totalhari1' ] = $totalhari1 ;
$_SESSION [ '$totalhari2' ] = $totalhari2 ;
$_SESSION [ '$totalhari3' ] = $totalhari3 ;
$_SESSION [ '$totalstokdefault1' ] = $totalstokdefault1 ;
$_SESSION [ '$totalstokdefault2' ] = $totalstokdefault2 ;
$_SESSION [ '$totalstokdefault3' ] = $totalstokdefault3 ;
$_SESSION [ '$averagesswc1' ] = $averagesswc1 ;
$_SESSION [ '$averagesswc2' ] = $averagesswc2 ;
$_SESSION [ '$averagesswc3' ] = $averagesswc3 ;
?>
          </div>
          <!-- /widget -->
          
          <!-- /widget -->
          <!-- /widget --> 
        </div>
		<div class="span12" >
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-home"></i>
              <h3> Keterangan :<b></b></h3>
            </div>
          </div>
          <!-- /widget -->
          
          <!-- /widget -->
          <!-- /widget --> 
        </div>
		<?php
// Menampilkan total nilai barang masuk, keluar, dan stok di setiap cluster
echo"<p> Dari tabel hasil proses clustering di atas, mendapatkan hasil yaitu ";
?>

<!-- /widget-header -->

	<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th rowspan=2>Cluster 1</th>
			<th rowspan=2>Nama Barang</th>
			<th rowspan=2>Jumlah Barang Masuk</th>
			<th rowspan=2>Jumlah Barang Keluar</th>
			<th rowspan=2>Jumlah Stok</th>
			<th rowspan=2>Hari Menuju Kadaluwarsa</th>
			<th rowspan=2>Stok Default</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no=1;
	$q=mysql_query("select * from data1 order by id asc");
	session_start (); 
	$nomor_cluster_1 = $_SESSION['$nomor_cluster_1'];
	$ratadmc1 = $_SESSION['$ratadmc1'];
	$ratadkc1 = $_SESSION['$ratadkc1'];
	$ratasubc1 = $_SESSION['$ratasubc1'];
	$rataharic1 = $_SESSION['$rataharic1'];
	$ratastokdefaultc1 = $_SESSION['$ratastokdefaultc1'];
	// Memeriksa apakah data masuk ke dalam Cluster 1
	while($r=mysql_fetch_array($q)){
		if(in_array($no, $nomor_cluster_1)){
			// Jika data masuk ke dalam Cluster 1, tampilkan data tersebut
			echo "<tr>";
			echo "<td></td>";
			echo "<td>{$r['nmb']}</td>";
			echo "<td>{$r['dm']}</td>";
			echo "<td>{$r['dk']}</td>";
			echo "<td>".($r['dm'] - $r['dk'])."</td>";
			echo "<td>{$r['hari']}</td>";
			echo "<td>{$r['stokdefault']}</td>";
			echo "</tr>";
		}
		$no++;
	}
	echo "<tr>";
	echo "<td>Rata-rata</td>";
	echo "<td></td>";
	echo "<td>$ratadmc1</td>";
	echo "<td>$ratadkc1</td>";
	echo "<td>$ratasubc1</td>";
	echo "<td>$rataharic1</td>";
	echo "<td>$ratastokdefaultc1</td>";
	?>
	</tbody>
	<thead>
		<tr>
			<th rowspan=2>Cluster 2</th>
			<th rowspan=2>Nama Barang</th>
			<th rowspan=2>Jumlah Barang Masuk</th>
			<th rowspan=2>Jumlah Barang Keluar</th>
			<th rowspan=2>Jumlah Stok</th>
			<th rowspan=2>Hari Menuju Kadaluwarsa</th>
			<th rowspan=2>Stok Default</th>

		</tr>
	</thead>
	<tbody>
	<?php 
	$no=1;
	$q=mysql_query("select * from data1 order by id asc");
	session_start (); 
	$nomor_cluster_2 = $_SESSION['$nomor_cluster_2'];
	$ratadmc2 = $_SESSION['$ratadmc2'];
	$ratadkc2 = $_SESSION['$ratadkc2'];
	$ratasubc2 = $_SESSION['$ratasubc2'];
	// Memeriksa apakah data masuk ke dalam Cluster 1
	while($r=mysql_fetch_array($q)){
		if(in_array($no, $nomor_cluster_2)){
			// Jika data masuk ke dalam Cluster 1, tampilkan data tersebut
			echo "<tr>";
			echo "<td></td>";
			echo "<td>${$r['nmb']}</td>";
			echo "<td>{$r['dm']}</td>";
			echo "<td>{$r['dk']}</td>";
			echo "<td>".($r['dm'] - $r['dk'])."</td>";
			echo "<td>{$r['hari']}</td>";
			echo "<td>{$r['stokdefault']}</td>";
			echo "</tr>";
		}
		$no++;
	}
	echo "<tr>";
	echo "<td>Rata-rata</td>";
	echo "<td></td>";
	echo "<td>$ratadmc2</td>";
	echo "<td>$ratadkc2</td>";
	echo "<td>$ratasubc2</td>";
	echo "<td>$rataharic2</td>";
	echo "<td>$ratastokdefaultc2</td>";
	?>
	</tbody>
	<thead>
		<tr>
			<th rowspan=2>Cluster 3</th>
			<th rowspan=2>Nama Barang</th>
			<th rowspan=2>Jumlah Barang Masuk</th>
			<th rowspan=2>Jumlah Barang Keluar</th>
			<th rowspan=2>Jumlah Stok</th>
			<th rowspan=2>Hari Menuju Kadaluwarsa</th>
			<th rowspan=2>Stok Default</th>

		</tr>
	</thead>
	<tbody>
	<?php 
	$no=1;
	$q=mysql_query("select * from data1 order by id asc");
	session_start (); 
	$nomor_cluster_3 = $_SESSION['$nomor_cluster_3'];
	$ratadmc3 = $_SESSION['$ratadmc3'];
	$ratadkc3 = $_SESSION['$ratadkc3'];
	$ratasubc3 = $_SESSION['$ratasubc3'];
	// Memeriksa apakah data masuk ke dalam Cluster 1
	while($r=mysql_fetch_array($q)){
		if(in_array($no, $nomor_cluster_3)){
			// Jika data masuk ke dalam Cluster 1, tampilkan data tersebut
			echo "<tr>";
			echo "<td></td>";
			echo "<td>{$r['nmb']}</td>";
			echo "<td>{$r['dm']}</td>";
			echo "<td>{$r['dk']}</td>";
			echo "<td>".($r['dm'] - $r['dk'])."</td>";
			echo "<td>{$r['hari']}</td>";
			echo "<td>{$r['stokdefault']}</td>";
			echo "</tr>";
		}
		$no++;
	}
	echo "<tr>";
	echo "<td>Rata-rata</td>" ;
	echo "<td></td>";
	echo "<td>$ratadmc3</td>";
	echo "<td>$ratadkc3</td>";
	echo "<td>$ratasubc3</td>";
	echo "<td>$rataharic3</td>";
	echo "<td>$ratastokdefaultc3</td>";
	?>
	</tbody>
	<thead>
		<tr>
			
<th rowspan=2>Tingkat akurasi </th>
<th rowspan=2><?php  session_start (); 
$totaldmc1 = $_SESSION['$totaldmc1'];
$totaldmc2 = $_SESSION['$totaldmc2'];
$ratadmc1 = $_SESSION['$ratadmc1'];
	$ratadkc1 = $_SESSION['$ratadkc1'];
	$ratasubc1 = $_SESSION['$ratasubc1'];
	$rataharic1 = $_SESSION['$rataharic1'];
	$ratastokdefaultc1 = $_SESSION['$ratastokdefaultc1'];
	$ratadmc2 = $_SESSION['$ratadmc2'];
	$ratadkc2 = $_SESSION['$ratadkc2'];
	$ratasubc2 = $_SESSION['$ratasubc2'];
	$rataharic2 = $_SESSION['$rataharic2'];
	$ratastokdefaultc2 = $_SESSION['$ratastokdefaultc2'];
	$ratadmc3 = $_SESSION['$ratadmc3'];
	$ratadkc3 = $_SESSION['$ratadkc3'];
	$ratasubc3 = $_SESSION['$ratasubc3'];
	$rataharic3 = $_SESSION['$rataharic3'];
	$ratastokdefaultc3 = $_SESSION['$ratastokdefaultc3'];
$averagesswc1 = $_SESSION['$averagesswc1'];
$averagesswc2 = $_SESSION['$averagesswc2'];
$averagesswc3 = $_SESSION['$averagesswc3'];
$ssbc12 = sqrt((pow(($ratadmc1 - $ratadmc2), 2)) + (pow(($ratadkc1 - $ratadkc2), 2)) + (pow(($ratasubc1 - $ratasubc2), 2))+ (pow(($rataharic1 - $rataharic2), 2))+ (pow(($ratastokdefaultc1 - $ratastokdefaultc2), 2)));
$ssbc13 = sqrt((pow(($ratadmc1 - $ratadmc3), 2)) + (pow(($ratadkc1 - $ratadkc3), 2)) + (pow(($ratasubc1 - $ratasubc3), 2))+ (pow(($rataharic1 - $rataharic3), 2))+ (pow(($ratastokdefaultc1 - $ratastokdefaultc3), 2)));
$ssbc23 = sqrt((pow(($ratadmc2 - $ratadmc3), 2)) + (pow(($ratadkc2 - $ratadkc3), 2)) + (pow(($ratasubc2 - $ratasubc3), 2))+ (pow(($rataharic2 - $rataharic3), 2))+ (pow(($ratastokdefaultc2 - $ratastokdefaultc3), 2)));
$r12=($averagesswc1+$averagesswc2)/$ssbc12;
$r13=($averagesswc1+$averagesswc3)/$ssbc13;
$r23=($averagesswc2+$averagesswc3)/$ssbc23;
$dbi=($r12+$r13+$r23)/3;
echo $dbi; ?> </th>
			<th rowspan=2></th>
			<th rowspan=2></th>
			<th rowspan=2></th>
			<th rowspan=2></th>
			<th rowspan=2></th>

		</tr>
	</thead>
</table>


<?php
session_start (); 
$ratac1=($ratasubc1 + $rataharic1)/2;
$ratac2=($ratasubc2 + $rataharic2)/2;
$ratac3=($ratasubc3 + $rataharic3)/2;
session_start (); 
$totaldmc1 = $_SESSION['$totaldmc1'];
echo "<p>Cluster 1 ";
if ($ratac1 < $ratac2 && $ratac1 < $ratac3) {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang rendah dan waktu kadaluwarsa yang lebih pendek dibanding Cluster 2 dan 3. Artinya, barang-barang ini tidak terlalu cepat terjual, sehingga bisa dikategorikan sebagai Kurang Laku.</p> ";

} elseif ($ratac1 > $ratac2 && $ratac1 > $ratac3) {
	echo "Kesimpulan:</p>";
    echo "Barang-barang dalam cluster ini memiliki stok yang rendah dan waktu kadaluwarsa yang sangat panjang. Ini menunjukkan bahwa barang-barang dalam cluster ini laku keras dan cepat terjual, sehingga bisa dikategorikan sebagai Laku.</p>";
} else {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang menengah dan waktu yang cukup panjang sebelum kadaluwarsa. Barang-barang ini terjual dengan baik, namun tidak secepat barang di Cluster 3. Maka, cluster ini bisa dikategorikan sebagai Cukup Laku.</p>";

}

echo "<p>Cluster 2 ";
if ($ratac2 < $ratac1 && $ratac2 < $ratac3) {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang rendah dan waktu kadaluwarsa yang lebih pendek dibanding Cluster 2 dan 3. Artinya, barang-barang ini tidak terlalu cepat terjual, sehingga bisa dikategorikan sebagai Kurang Laku.</p>";

} elseif ($ratac2 > $ratac1 && $ratac2 > $ratac3) {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang rendah dan waktu kadaluwarsa yang sangat panjang. Ini menunjukkan bahwa barang-barang dalam cluster ini laku keras dan cepat terjual, sehingga bisa dikategorikan sebagai Laku.</p>";

} else {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang menengah dan waktu yang cukup panjang sebelum kadaluwarsa. Barang-barang ini terjual dengan baik, namun tidak secepat barang di Cluster 3. Maka, cluster ini bisa dikategorikan sebagai Cukup Laku.</p>";

}

echo "<p>Cluster 3 ";
if ($ratac3 < $ratac1 && $ratac3 < $ratac2) {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang rendah dan waktu kadaluwarsa yang lebih pendek dibanding Cluster 2 dan 3. Artinya, barang-barang ini tidak terlalu cepat terjual, sehingga bisa dikategorikan sebagai Kurang Laku.</p>";

} elseif ($ratac3 > $ratac1 && $ratac3 > $ratac2) {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang rendah dan waktu kadaluwarsa yang sangat panjang. Ini menunjukkan bahwa barang-barang dalam cluster ini laku keras dan cepat terjual, sehingga bisa dikategorikan sebagai Laku.</p>";


} else {
	echo "Kesimpulan:</p>";
	echo "Barang-barang dalam cluster ini memiliki stok yang menengah dan waktu yang cukup panjang sebelum kadaluwarsa. Barang-barang ini terjual dengan baik, namun tidak secepat barang di Cluster 3. Maka, cluster ini bisa dikategorikan sebagai Cukup Laku.</p>";

}

?>


		