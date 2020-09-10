<?php
include_once('excel_reader2.php'); 
include_once('kondb.php');

$target = basename($_FILES['data_karyawan']['name']);
move_uploaded_file($_FILES['data_karyawan']['tmp_name'],$target);

define("MIN_DATES_DIFF", 25569);
 
// Numbers of second in a day:
define("SEC_IN_DAY", 86400);
 
function excel2timestamp($excelDate)
{
   if ($excelDate <= MIN_DATES_DIFF)
      return 0;
 
   return  ($excelDate - MIN_DATES_DIFF) * SEC_IN_DAY;
}

//permission agar file terbaca
chmod($_FILES['data_karyawan']['name'],0777);

//mengisi isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['data_karyawan']['name'],false);
$jumlah_baris = $data->rowcount($sheet_index=0);


$success =0;

for($i=2; $i<=$jumlah_baris; $i++){
    $date        = $data->val($i, 1); 
    $newformat  = excel2timestamp($date);
    $tanggal = date('Y-m-d',$newformat);
    $buku       = $data->val($i, 2);
    //date('Y-m-d',$akses);
    
    if($buku != ""){
        mysqli_query($connect, "INSERT INTO transaksi VALUES ('',
        '$tanggal','$buku')");
        //,'$tanggal'
        $success++;
    }
}
unlink($_FILES['data_karyawan']['name']);
if($success >0){
    //echo "berhasil";
    header("location: index.php?menu=data_transaksi&upload=succes");
}else{
    //echo "gagal";
    header("location: index.php?menu=data_transaksi&upload=gagal");
}
?>