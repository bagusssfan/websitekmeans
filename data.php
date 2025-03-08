<?php
switch(@$_GET['act']){
    default:
?>
<div class="widget-header"> <i class="icon-list-alt"></i></div>
<div class="widget-content">
    <div class="widget big-stats-container">
        <br/><p><a href='?module=data&act=import' class='btn btn-more'><span class='icon-upload'>Import Excel</span></a></p>
        <div class="shortcuts">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan=2>No</th>
                        <th rowspan=2>Nama Barang</th>
                        <th colspan=7><center>Data persediaan barang</center></th>
                    </tr>
                    <tr>
                        <th>Barang Masuk (pcs)</th>
                        <th>Barang Keluar (pcs)</th>
                        <th>STOK (pcs)</th>
                        <th>Tanggal Rekapan Data</th>
                        <th>Tanggal Kadaluwarsa</th>
                        <th>Stok Default (pcs)</th>
                        <th>Hari Menuju Kadaluwarsa</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no=1;
                $q=mysql_query("SELECT * FROM data1 ORDER BY id ASC");
                while($r=mysql_fetch_array($q)){
                    $sub=$r['dm']-$r['dk'];
                    echo "
                    <tr>
                        <td>$no</td>
                        <td>$r[nmb]</td>
                        <td>$r[dm]</td>
                        <td>$r[dk]</td>
                        <td>$sub</td>
                        <td>$r[tgl]</td>
                        <td>$r[tglkadaluwarsa]</td>
                        <td>$r[stokdefault]</td>
                         <td>$r[hari]</td>
                    </tr>
                    ";
                    $no++; 
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
break;

case "import":
if(isset($_POST["import"])){
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);
    $isFirstRow = true;
    $rows = [];
    $errors = [];

    // Membaca data dari file excel
    foreach($reader as $key => $row){
        if ($isFirstRow) {
            $isFirstRow = false;
            continue; // Lewati baris pertama (header)
        }
        $rows[] = $row;
    }

    // Mengisi data kosong dengan data dari baris berikutnya
    $rowCount = count($rows);
    for ($i = 0; $i < $rowCount; $i++) {
        if (empty($rows[$i][0]) || empty($rows[$i][1]) || empty($rows[$i][2]) || empty($rows[$i][4]) || empty($rows[$i][5]) || empty($rows[$i][6])) {
            // Temukan baris berikutnya yang tidak kosong
            for ($j = $i + 1; $j < $rowCount; $j++) {
                if (!empty($rows[$j][0]) && !empty($rows[$j][1]) && !empty($rows[$j][2]) && !empty($rows[$j][4]) && !empty($rows[$j][5]) && !empty($rows[$j][6])) {
                    // Isi data kosong dengan data dari baris berikutnya
                    $rows[$i] = $rows[$j];
                    // Hapus baris yang diganti
                    array_splice($rows, $j, 1);
                    break;
                }
            }
        }
        
       // Fungsi untuk memeriksa format tanggal
function isValidDate($date) {
    $dateObject = DateTime::createFromFormat('Y-m-d', $date);
    return $dateObject !== false && $dateObject->format('Y-m-d') === $date;
}
$checkedDuplicates = []; // Array untuk menyimpan kombinasi duplikat yang telah dicek

for ($i = 0; $i < $rowCount; $i++) {
    for ($j = $i + 1; $j < $rowCount; $j++) {
        if ($rows[$i] === $rows[$j]) {
            $key = implode('-', $rows[$i]); // Menggabungkan semua elemen baris menjadi satu string sebagai kunci
            if (!isset($checkedDuplicates[$key])) {
                $errors[] = "Duplikat ditemukan pada baris ke-" . ($i + 1) . " dan ke-" . ($j + 1) . " dengan data: '" . implode(', ', $rows[$i]) . "'.";
                $checkedDuplicates[$key] = true;
            }
        }
    }
}


// Cek apakah data yang diimpor sesuai dengan kriteria
for ($i = 0; $i < $rowCount; $i++) {
    if ($rows[$i][1] > 1000) { // Misalnya jumlah barang masuk tidak boleh lebih dari 1000
        $errors[] = "Baris ke-" . ($i+1) . ": Jumlah barang masuk terlalu besar.";
    }
    if ($rows[$i][2] > 1000) { // Misalnya jumlah barang keluar tidak boleh lebih dari 1000
        $errors[] = "Baris ke-" . ($i+1) . ": Jumlah barang keluar terlalu besar.";
    }
    if ($rows[$i][6] > 1000) { // Misalnya stokdefault tidak boleh lebih dari 1000
        $errors[] = "Baris ke-" . ($i+1) . ": stokdefault terlalu besar.";
    }

    // Pengecekan format tanggal
    if (!isValidDate($rows[$i][4])) { // Pengecekan format tanggal pada kolom 'Tanggal Rekapan Data'
        $errors[] = "Baris ke-" . ($i+1) . ": Format tanggal pada kolom 'Tanggal Rekapan Data' tidak valid. Harus menggunakan format 'YYYY-MM-DD'.";
    }
    if (!isValidDate($rows[$i][5])) { // Pengecekan format tanggal pada kolom 'Tanggal Kadaluwarsa'
        $errors[] = "Baris ke-" . ($i+1) . ": Format tanggal pada kolom 'Tanggal Kadaluwarsa' tidak valid. Harus menggunakan format 'YYYY-MM-DD'.";
    }
}

    }

    if (!empty($errors)) {
        // Menyimpan error sebagai session untuk ditampilkan
        session_start();
        $_SESSION['import_errors'] = $errors;
        echo "<script>
                window.onload = function() {
                    var errors = " . json_encode($errors) . ";
                    var errorList = errors.map(function(error) { return '<li>' + error + '</li>'; }).join('');
                    var popup = '<div id=\"errorPopup\" style=\"position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); width: 80%; max-width: 600px; padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.2);\">' +
                                 '<h4>Peringatan!</h4>' +
                                 '<ul>' + errorList + '</ul>' +
                                 '<a href=\"?module=data&act=import\" class=\"btn btn-more\" >Ok</a>' +
                                 '</div>';
                    document.body.insertAdjacentHTML('beforeend', popup);
                }
              </script>";
    } else {
        // Kosongkan tabel data1
        mysql_query("TRUNCATE TABLE data1");

        // Masukkan data yang sudah diproses ke database
        foreach ($rows as $row) {
            $nm = mysql_real_escape_string($row[0]);
            $dm = mysql_real_escape_string($row[1]);
            $dk = mysql_real_escape_string($row[2]);
            $tgl = mysql_real_escape_string($row[4]);
            $tglkadaluwarsa = mysql_real_escape_string($row[5]);
            $stokdefault = mysql_real_escape_string($row[6]);

            mysql_query("INSERT INTO data1 (nmb, dm, dk, tgl, tglkadaluwarsa, stokdefault) VALUES ('$nm', '$dm', '$dk', '$tgl', '$tglkadaluwarsa', '$stokdefault')");
        }

        echo "
        <script>
            alert('Data Tersimpan');
            window.location.href='?module=data';
        </script>
        ";
    }
}
?>

<div class="widget-header"> <i class="icon-list-alt"></i></div>
<div class="widget-content">
    <div class="widget big-stats-container">
        <h2 style="text-align: center;">Import File Excel</h2>
        <br/>
        <b> Contoh Format File Excel</b>
        <br>
        <img src="contoh1.png" alt="Your Image" style="max-width: 500px; max-height: 500px; margin-bottom: 10px;">
        <br/>
        <a href="Book1.xlsx" download class="btn btn-more">Download Format Excel</a>
        <br>
        <br/>
        <form action="?module=data&act=import" method="post" enctype="multipart/form-data">
            <div class="control-group">                                          
                <label class="control-label" for="csv_file">Unggah File Excel</label>
                <div class="controls">
                    <input type="file" name="excel" id="excel" accept=".xlsx, .xls" required>
                </div>
            </div>
            <br>
            <div class="form-actions">
                <button type="submit" name="import" class="btn btn-more">Import</button>
                <a href="?module=data" class="btn btn-more">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php
break;
}
?>
</div>
