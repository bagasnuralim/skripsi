<?php
//session_start();
if (!isset($_SESSION['apriori_toko_id'])) {
    header("location:index.php?menu=forbidden");
}

?>
<script>
    
    function validasiFile(){
    var inputFile = document.getElementById('file');
    var pathFile = inputFile.value;
    var ekstensiOk = /(\.xls)$/i;
    if(!ekstensiOk.exec(pathFile)){
        alert('Silakan upload file yang memiliki ekstensi .xls');
        inputFile.value = '';
        return false;
    }else{
        document.getElementById('pesan').innerHTML = '<br><div class="alert alert-success" role="alert">Extensi file telah sesuai !</div>';
        //Pratinjau gambar
        // if (inputFile.files && inputFile.files[0]) {
        //     var reader = new FileReader();
        //     reader.onload = function(e) {
        //         document.getElementById('pratinjauGambar').innerHTML = '<img src="'+e.target.result+'"/>';
        //     };
        //     reader.readAsDataURL(inputFile.files[0]);
        // }
        //reset tabel gas ALTER TABLE nama_tabel AUTO_INCREMENT = 1;
    }
}
</script>
<section class="page_head">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="page_title">
                    <h2>Input Nilai</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="super_sub_content">
    <div class="container">
        <div class="row">
            <form method="post" enctype="multipart/form-data" action="uploader.php">
                <label for="">Import data disini.</label> <div class="alert alert-warning" role="alert">Format nama file harus sesuai dengan : <b>data_peminjaman.xls</b></div>
                <input type="file" name="data_karyawan" id="file" onchange="return validasiFile()" require="required">
                <div id="pesan">
                </div>
                <input type="submit" name="upload" value="Upload">
            </form>
            <br>
            <?php 
                if(isset($_GET['upload'])){
                    if($_GET['upload']=="succes"){
                        echo "
                        <div class='alert alert-success' role='alert'>
                            Yeay ! <b>Data berhasil</b> disimpan ... 
                        </div>
                        ";
                    }else{
                        echo "
                        <div class='alert alert-danger' role='alert'>
                            Format nama file anda <b>tidak sesuai</b> dengan : <b>data_peminjaman.xls</b>
                        </div>
                        ";
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
                include_once('kondb.php');
                $no =1;
                $peminjaman = mysqli_query($connect, "SELECT * FROM transaksi ");
                while($data = mysqli_fetch_assoc($peminjaman)){
            ?>
            <tr>
                <td><?= $no++;?></td>
                <td><?= $data['transaction_date'];?></td>
                <td><?= $data['produk'];?></td>
            </tr>
                <?php } ?>
            </table>       
        </div>
    </div>
</div>