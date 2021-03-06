include_once "database.php";
include_once "fungsi.php";
include_once "import/excel_reader2.php";
?>

<?php
//object database class
$db_object = new database();

$pesan_error = $pesan_success = "";
if(isset($_GET['pesan_error'])){
    $pesan_error = $_GET['pesan_error'];
}
if(isset($_GET['pesan_success'])){
    $pesan_success = $_GET['pesan_success'];
}

if(isset($_POST['submit'])){
    // if(!$input_error){
    $data = new Spreadsheet_Excel_Reader($_FILES['laporan_peminjaman']['tmp_name']);

        $baris = $data->rowcount($sheet_index=0);
        $column = $data->colcount($sheet_index=0);
        //import data excel dari baris kedua, karena baris pertama adalah nama kolom
        // $temp_date = $temp_produk = "";
        for ($i=2; $i<=$baris; $i++) {
            for($c=1; $c<=$column; $c++){
                $value[$c] = $data->val($i, $c);
            }
                    $table = "transaksi";
                    // $produkIn = get_produk_to_in($temp_produk);
                    $temp_date = format_date($value[1]);
                    $produkIn = $value[2];
                    
                    //mencegah ada jarak spasi
                    $produkIn = str_replace(" ,", ",", $produkIn);
                    $produkIn = str_replace("  ,", ",", $produkIn);
                    $produkIn = str_replace("   ,", ",", $produkIn);
                    $produkIn = str_replace("    ,", ",", $produkIn);
                    $produkIn = str_replace(", ", ",", $produkIn);
                    $produkIn = str_replace(",  ", ",", $produkIn);
                    $produkIn = str_replace(",   ", ",", $produkIn);
                    $produkIn = str_replace(",    ", ",", $produkIn);
                    $sql = "INSERT INTO transaksi (transaction_date, produk) VALUES ";
                    $value_in = array();
                    $sql .= " ('$temp_date', '$produkIn')";
                    $db_object->db_query($sql);

            //         $temp_produk = $value[3];
            //     }
            // }
            
            // $temp_date = $value[1];
        }
        ?>
        <script> location.replace("?menu=data_transaksi&pesan_success=Data berhasil disimpan"); </script>
        <?php
}
/*
if(isset($_POST['delete'])){
    $sql = "TRUNCATE transaksi";
    $db_object->db_query($sql);
    ?>
        <script> location.replace("?menu=data_transaksi&pesan_success=Data transaksi berhasil dihapus"); </script>
        <?php
}
*/
$sql = "SELECT
        *
        FROM
         transaksi";
$query=$db_object->db_query($sql);
$jumlah=$db_object->db_num_rows($query);

?>

<div class="super_sub_content">
    <div class="container">
        <div class="row">
            <!--<form method="post" enctype="multipart/form-data" action="uploader.php">
                <div class="form-group">
                    <div class="input-group">
                        <label>Import data from excel</label>
                        <input name="file_data_transaksi" type="file" class="form-control" require="required">
                    </div>
                </div>
                <div class="form-group">
                    <input name="upload" type="submit" value="Upload" class="btn btn-success">
                </div>
            
            -->
            <!--UPLOAD EXCEL FORM OLD-->
            <form method="post" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <div class="input-group">
                        <label>Import data from excel</label>
                        <input name="file_data_transaksi" type="file" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <input name="submit" type="submit" value="Upload Data" class="btn btn-success">
                </div>
                <div class="form-group">
                    <button name="delete" type="submit"  class="btn btn-danger" >
                        <i class="fa fa-trash-o"></i> Delete All Data Transaction
                    </button>
                </div> 
            </form>
            <?php
            
            if (!empty($pesan_error)) {
                display_error($pesan_error);
            }
            if (!empty($pesan_success)) {
                display_success($pesan_success);
            }

            
            echo "Jumlah data: ".$jumlah."<br>";
            if($jumlah==0){
                    echo "Data kosong...";
            }
            else{ 
                           
            if(isset($_GET['upload']))
            {
                if($_GET['upload']=="success")
                {
                    echo "<h4>data berhasil di upload</h4>";
                }
                else
                {
                    echo "<h4>data gagal diupload!</h4>";
                }
            }
            ?>
            <table class='table table-bordered table-striped  table-hover'>
                <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Golongan</th>
                </tr>
                <?php
                    $no=1;
                    while($row=$db_object->db_fetch_array($query)){
                        echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$row['transaction_date']."</td>";
                            echo "<td>".$row['produk']."</td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
            </table>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
function get_produk_to_in($produk){
    $ex = explode(",", $produk);
    //$temp = "";
    for ($i=0; $i < count($ex); $i++) { 

        $jml_key = array_keys($ex, $ex[$i]);
        if(count($jml_key)>1){
            unset($ex[$i]);
        }

        //$temp = $ex[$i];
    }
    return implode(",", $ex);
}
