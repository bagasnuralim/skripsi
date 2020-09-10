<?php
    $conv = md5('admin');
    $conv1 = md5('123');
    $conv2 = md5('@#$');
    $conv3 = md5('4dm1n');
    $conv4 = md5('@dmin');
    $conv5 = md5('123@#');
    $conv6 = md5('@dm1n');
    $conv7 = md5('1111111111111111111111111111111111111111111111111111');

    echo $conv ."&nbsp admin". "<br>" . 
    $conv1 ."&nbsp 123" . "<br>" . 
    $conv2 ." &nbsp@#$". "<br>" .
    $conv3 ."&nbsp 4dm1n" . "<br>" .
    $conv4 ."&nbsp @dmin" . "<br>" .
    $conv5 ."&nbsp 123@#" . "<br>" .
    $conv6 ."&nbsp @dm1n" . "<br>" .
    $conv7 ."&nbsp @dm1n" . "<br>" .
     "Tiga Jenis ";

    echo strlen($conv . "&nbsp" );
    echo strlen($conv1 . "&nbsp");
    echo strlen($conv2 . "&nbsp" );
    echo strlen($conv3 . "&nbsp" );
    echo strlen($conv4 . "&nbsp" );
    echo strlen($conv5 . "&nbsp" );
    echo strlen($conv6 . "&nbsp");
    echo strlen($conv7 . "&nbsp");
    
?>