<?php
//session_start();
if (!isset($_SESSION['apriori_toko_id'])) {
    header("location:index.php?menu=forbidden");
}

?>
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
                <b>import data</b>
                <input type="file" name="data_karyawan" require="required">
                <input type="submit" name="upload" value="Upload">
            </form>
            <?php 
                if(isset($_GET['upload'])){
                    if($_GET['upload']=="succes"){
                        echo "<h3>berhasil</h3>";
                    }else{
                        echo "<h3>gagal</h3>";
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
                $peminjaman = mysqli_query($connect, "SELECT * FROM transaksi");
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