<div class="span12">
    <div class="widget widget-nopad">
        <?php
        switch(@$_GET['act']){
        default:
        ?>
        <div class="widget-header"> <i class="icon-list-alt"></i>
        </div>
        <!-- /widget-header -->
        <div class="widget-content">
        <h2 style="text-align: center;">Hasil Clustering</h2>
            <?php
            // Mengambil data pusat cluster dari database
            $sql_edit = mysql_query("SELECT * FROM hasil WHERE id_hasil='1'");
            $row =  mysql_fetch_array($sql_edit);
            $px1=$row['c1'];
            $py1=$row['c2'];
            $pz1=$row['c3'];
            $c1hari=$row['c1hari'];
            $c1stokdefault=$row['c1stokdefault'];
            $px2=$row['c1y'];
            $py2=$row['c2y'];
            $pz2=$row['c3y'];
            $c2hari=$row['c2hari'];
            $c2stokdefault=$row['c2stokdefault'];
            $px3=$row['c1z'];
            $py3=$row['c2z'];
            $pz3=$row['c3z'];
            $c3hari=$row['c3hari'];
            $c3stokdefault=$row['c3stokdefault'];
            
            // Inisialisasi iterasi
            $it=1;
            
            // Perulangan clustering
            while(true) {
                // Menampilkan hasil clustering
                
                echo "<h2>&nbsp;Iterasi $it</h2>";
                echo '<div class="widget big-stats-container">
                <div class="shortcuts">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th rowspan=2>Pusat Cluster  </th>
                                <th colspan=5><center>titik cluster </center></th>
 
                            </tr>
                            <tr>
                                <th>Barang Masuk </th>
                                <th>Barang Keluar </th>
                                <th>Stok</th>
                                <th>Hari</th>
                                <th>Stok Default</th>
                            </tr>
                        </thead>
                        <tbody>';
            echo "<tr>
                    <td>Cluster 1</td>
                    <td>$px1</td>
                    <td>$py1</td>
                    <td>$pz1</td>
                    <td>$c1hari</td>
                    <td>$c1stokdefault</td>";
            echo "</tr>";
            echo "<tr>
                    <td>Cluster 2</td>
                    <td>$px2</td>
                    <td>$py2</td>
                    <td>$pz2</td>
                    <td>$c2hari</td>
                    <td>$c2stokdefault</td>";
           
            echo "</tr>";
            echo "<tr>
                    <td>Cluster 3</td>
                    <td>$px3</td>
                    <td>$py3</td>
                    <td>$pz3</td>
                    <td>$c3hari</td>
                    <td>$c3stokdefault</td>";
           
            echo "</tr>";
        echo '</tbody>
            </table>
        </div>
    </div>';
                echo '<div class="widget big-stats-container">
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
                                        <th>Barang Masuk </th>
                                        <th>Barang Keluar </th>
                                        <th>Stok</th>
                                        <th>Hari</th>
                                        <th>Stok Default</th>
                                    </tr>
                                </thead>
                                <tbody>';
                
                // Pengambilan data dari database
                $no=1;
                $q=mysql_query("select * from data1 order by id asc");
                
                // Inisialisasi variabel untuk mengecek perubahan pusat cluster
                $changed = false;
                
                // Inisialisasi variabel untuk menyimpan data baru yang dikelompokkan ke setiap cluster
                $agtc1x = [];
                $agtc1y = [];
                $agtc1z = [];
                $agtc1hari = [];
                $agtc1stokdefault = [];
                $agtc2x = [];
                $agtc2y = [];
                $agtc2z = [];
                $agtc2hari = [];
                $agtc2stokdefault = [];
                $agtc3x = [];
                $agtc3y = [];
                $agtc3z = [];
                $agtc3hari = [];
                $agtc3stokdefault = [];
                
                while($r=mysql_fetch_array($q)){
                    $min=0;
                    $sub=$r['dm']-$r['dk'];
                    echo "<tr>
                            <td>$no</td>
                            <td>$r[nmb]</td>
                            <td>$r[dm]</td>
                            <td>$r[dk]</td>
                            <td>$sub</td>
                            <td>$r[hari]</td>
                            <td>$r[stokdefault]</td>";
                    // Menghitung jarak ke masing-masing pusat cluster
                    $c1=sqrt((pow(($r['dm']-$px1),2))+(pow(($r['dk']-$py1),2))+(pow(($sub-$pz1),2))+(pow(($r['hari']-$c1hari),2))+(pow(($r['stokdefault']-$c1stokdefault),2)));
                    $c2=sqrt((pow(($r['dm']-$px2),2))+(pow(($r['dk']-$py2),2))+(pow(($sub-$pz2),2))+(pow(($r['hari']-$c2hari),2))+(pow(($r['stokdefault']-$c2stokdefault),2)));
                    $c3=sqrt((pow(($r['dm']-$px3),2))+(pow(($r['dk']-$py3),2))+(pow(($sub-$pz3),2))+(pow(($r['hari']-$c3hari),2))+(pow(($r['stokdefault']-$c3stokdefault),2)));
                    // Menentukan cluster untuk data
                    $min=min($c1,$c2,$c3);
                    if($min==$c1){
                        $ketmin="C1";
                        $agtc1x[] = $r['dm'];
                        $agtc1y[] = $r['dk'];
                        $agtc1z[] = $sub;
                        $agtc1hari[] = $r['hari'];
                        $agtc1stokdefault[] = $r['stokdefault'];
                    } elseif($min==$c2){
                        $ketmin="C2";                    
                        $agtc2x[] = $r['dm'];
                        $agtc2y[] = $r['dk'];
                        $agtc2z[] = $sub;
                        $agtc2hari[] = $r['hari'];
                        $agtc2stokdefault[] = $r['stokdefault'];
                    } elseif($min==$c3){
                        $ketmin="C3";                    
                        $agtc3x[] = $r['dm'];
                        $agtc3y[] = $r['dk'];
                        $agtc3z[] = $sub;
                        $agtc3hari[] = $r['hari'];
                        $agtc3stokdefault[] = $r['stokdefault'];
                    }
                    echo "<td>".number_format($c1,2)."</td>
                            <td>".number_format($c2,2)."</td>
                            <td>".number_format($c3,2)."</td>
                            <td>$ketmin</td>
                        </tr>";
                    $no++;
                }
                
                // Menghitung pusat cluster baru
                $pxx1 = array_sum($agtc1x) / count($agtc1x);
                $pyy1 = array_sum($agtc1y) / count($agtc1y);
                $pzz1 = array_sum($agtc1z) / count($agtc1z);
                $pzz1hari = array_sum($agtc1hari) / count($agtc1hari);
                $pzz1stokdefault = array_sum($agtc1stokdefault) / count($agtc1stokdefault);

                $pxx2 = array_sum($agtc2x) / count($agtc2x);
                $pyy2 = array_sum($agtc2y) / count($agtc2y);
                $pzz2 = array_sum($agtc2z) / count($agtc2z);
                $pzz2hari = array_sum($agtc2hari) / count($agtc2hari);
                $pzz2stokdefault = array_sum($agtc2stokdefault) / count($agtc2stokdefault);
                
                $pxx3 = array_sum($agtc3x) / count($agtc3x);
                $pyy3 = array_sum($agtc3y) / count($agtc3y);
                $pzz3 = array_sum($agtc3z) / count($agtc3z);
                $pzz3hari = array_sum($agtc3hari) / count($agtc3hari);
                $pzz3stokdefault = array_sum($agtc3stokdefault) / count($agtc3stokdefault);
                
                // Mengecek apakah pusat cluster berubah
                if ($px1 != $pxx1 || $py1 != $pyy1 || $pz1 != $pzz1 || $c1hari != $pzz1hari || $c1stokdefault != $pzz1stokdefault ||
                    $px2 != $pxx2 || $py2 != $pyy2 || $pz2 != $pzz2 || $c2hari != $pzz2hari || $c2stokdefault != $pzz2stokdefault ||
                    $px3 != $pxx3 || $py3 != $pyy3 || $pz3 != $pzz3 || $c3hari != $pzz3hari || $c3stokdefault != $pzz3stokdefault ) {
                    $changed = true;
                    // Memperbarui pusat cluster
                    $px1 = $pxx1;
                    $py1 = $pyy1;
                    $pz1 = $pzz1;
                    $c1hari = $pzz1hari;
                    $c1stokdefault = $pzz1stokdefault;
                    $px2 = $pxx2;
                    $py2 = $pyy2;
                    $pz2 = $pzz2;
                    $c2hari = $pzz2hari;
                    $c2stokdefault = $pzz2stokdefault;
                    $px3 = $pxx3;
                    $py3 = $pyy3;
                    $pz3 = $pzz3;
                    $c3hari = $pzz3hari;
                    $c3stokdefault = $pzz3stokdefault;
                }
                
                // Mengakhiri perulangan jika tidak ada perubahan pada pusat cluster
                if (!$changed) {
                    break;
                }
                
                echo '</tbody>
                    </table>
                </div>
            </div>';
                
                $it++;
            }
			
            ?>	
        </div>
		
        <?php
        break;
        }
		session_start (); 
		$_SESSION [ '$px1' ] = $px1 ;
		$_SESSION [ '$py1' ] = $py1 ;
		$_SESSION [ '$pz1' ] = $pz1 ;
        $_SESSION [ '$c1hari' ] = $c1hari ;
        $_SESSION [ '$c1stokdefault' ] = $c1stokdefault ;
		$_SESSION [ '$px2' ] = $px2 ;
		$_SESSION [ '$py2' ] = $py2 ;
		$_SESSION [ '$pz2' ] = $pz2 ;
        $_SESSION [ '$c2hari' ] = $c2hari ;
        $_SESSION [ '$c2stokdefault' ] = $c2stokdefault ;
		$_SESSION [ '$px3' ] = $px3 ;
		$_SESSION [ '$py3' ] = $py3 ;
		$_SESSION [ '$pz3' ] = $pz3 ;
        $_SESSION [ '$c3hari' ] = $c3hari ;
        $_SESSION [ '$c3stokdefault' ] = $c3stokdefault ;
        ?>
		
    </div>
</div>

