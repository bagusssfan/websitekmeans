<div class="span12">
    <div class="widget widget-nopad">
        <?php
        switch(@$_GET['act']){
        default:
        ?>
        <div class="widget-header"> <i class="icon-list-alt"></i></div>
        <!-- /widget-header -->
        <div class="widget-content">
            <div class="widget big-stats-container">
                <div class="shortcuts">
                    <?php
                    include("koneksi.php");
                    $sql_edit = mysql_query("SELECT * FROM hasil WHERE id_hasil='1'");
                    $row =  mysql_fetch_array($sql_edit);

                    // Mengambil data barang
                    $sql_data = mysql_query("SELECT * FROM data1 ORDER BY id ASC");
                    ?>
                    <form name="f1" method="post" action="proses.php" target="_blank">
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <td colspan="10">
                                    <label>Pilih Data untuk C1:</label>
                                    <select id="c1Data" class="form-control" onchange="setC1Values(this)" name="c1Data">
                                        <option value="" disabled selected hidden>Pilih Data</option>
                                        <?php mysql_data_seek($sql_data, 0); // Reset pointer untuk pengambilan ulang data ?>
                                        <?php while($row_data = mysql_fetch_array($sql_data)) { ?>
                                            <option value="<?php echo $row_data['dm'] . '_' . $row_data['dk'] . '_' . $row_data['hari'] . '_' . $row_data['stokdefault']; ?>"><?php echo $row_data['nmb']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Barang masuk</td>
                                <td><input type="text" id="c1x" class="form-control" readonly></td>
                                <td>Barang keluar</td>
                                <td><input type="text" id="c1y" class="form-control" readonly></td>
                                <td>Stok</td>
                                <td><input type="text" id="c1z" class="form-control" readonly></td>
                                <td>Hari</td>
                                <td><input type="text" id="c1hari" class="form-control" readonly></td>
                                <td>Stok Default</td>
                                <td><input type="text" id="c1stokdefault" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <label>Pilih Data untuk C2:</label>
                                    <select id="c2Data" class="form-control" onchange="setC2Values(this)" name="c2Data">
                                        <option value="" disabled selected hidden>Pilih Data</option>
                                        <?php mysql_data_seek($sql_data, 0); ?>
                                        <?php while($row_data = mysql_fetch_array($sql_data)) { ?>
                                            <option value="<?php echo $row_data['dm'] . '_' . $row_data['dk'] . '_' . $row_data['hari'] . '_' . $row_data['stokdefault']; ?>"><?php echo $row_data['nmb']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Barang masuk</td>
                                <td><input type="text" id="c2x" class="form-control" readonly></td>
                                <td>Barang keluar</td>
                                <td><input type="text" id="c2y" class="form-control" readonly></td>
                                <td>Stok</td>
                                <td><input type="text" id="c2z" class="form-control" readonly></td>
                                <td>Hari</td>
                                <td><input type="text" id="c2hari" class="form-control" readonly></td>
                                <td>Stok Default</td>
                                <td><input type="text" id="c2stokdefault" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <label>Pilih Data untuk C3:</label>
                                    <select id="c3Data" class="form-control" onchange="setC3Values(this)" name="c3Data">
                                        <option value="" disabled selected hidden>Pilih Data</option>
                                        <?php mysql_data_seek($sql_data, 0); ?>
                                        <?php while($row_data = mysql_fetch_array($sql_data)) { ?>
                                            <option value="<?php echo $row_data['dm'] . '_' . $row_data['dk'] . '_' . $row_data['hari'] . '_' . $row_data['stokdefault']; ?>"><?php echo $row_data['nmb']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Barang masuk</td>
                                <td><input type="text" id="c3x" class="form-control" readonly></td>
                                <td>Barang keluar</td>
                                <td><input type="text" id="c3y" class="form-control" readonly></td>
                                <td>Stok</td>
                                <td><input type="text" id="c3z" class="form-control" readonly></td>
                                <td>Hari</td>
                                <td><input type="text" id="c3hari" class="form-control" readonly></td>
                                <td>Stok Default</td>
                                <td><input type="text" id="c3stokdefault" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td colspan="2"><input type="submit" name="simpan" value="Proses" class="btn btn-more"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <?php
        break;
        }
        ?>
    </div>
    <!-- /widget -->
</div>
<script>
function setC1Values(select) {
    var selectedData = select.value.split("_");
    document.getElementById("c1x").value = selectedData[0];
    document.getElementById("c1y").value = selectedData[1];
    document.getElementById("c1z").value = selectedData[0] - selectedData[1];
    document.getElementById("c1hari").value = selectedData[2];
    document.getElementById("c1stokdefault").value = selectedData[3];
}

function setC2Values(select) {
    var selectedData = select.value.split("_");
    document.getElementById("c2x").value = selectedData[0];
    document.getElementById("c2y").value = selectedData[1];
    document.getElementById("c2z").value = selectedData[0] - selectedData[1];
    document.getElementById("c2hari").value = selectedData[2];
    document.getElementById("c2stokdefault").value = selectedData[3];
}

function setC3Values(select) {
    var selectedData = select.value.split("_");
    document.getElementById("c3x").value = selectedData[0];
    document.getElementById("c3y").value = selectedData[1];
    document.getElementById("c3z").value = selectedData[0] - selectedData[1];
    document.getElementById("c3hari").value = selectedData[2];
    document.getElementById("c3stokdefault").value = selectedData[3];
}
</script>
