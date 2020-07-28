<?php
include_once('excel_reader2.php');
include_once('kondb.php');

$target = basename($_FILES['data_peminjaman']['name']);
move_uploaded_file($_FILES['data_peminjaman']['tmp_name'],$target);

//permission agar file terbaca
chmod($_FILES['data_peminjaman']['name'],0777);

//mengisi isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['data_peminjaman']['name'],false);
$jumlah_baris = $data->rowcount($sheet_index=0);

function format_date($date){
    $date_ex = explode("/", $date);
    return $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];
}

$success =0;
for($i=2; $i<=$jumlah_baris; $i++){
    $tanggal    = format_date($data->val($i, 1)); 
    $buku       = $data->val($i, 2);
    //$date = str_replace("/", "-", $tanggal);
    //$dates = date("Y-m-j", strtotime($date));

    if($buku != ""){
        mysqli_querry($connect, "INSERT INTO transaksi VALUES ('',
        '$tanggal','$buku')");
        $success++;
    }
}
unlink($_FILES['data_peminjaman']['name']);
if($success >0){
    header("location:index.php?menu=data_transaksi&pesan_success=Data berhasil disimpan");
}else{
    header("location:index.php?menu=data_transaksi&pesan_success=Data gagal disimpan");
}
?>