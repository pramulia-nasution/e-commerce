<?php 

function active($path) {
    return request()->is($path) ? 'active' :  '';
}

function rupiah($angka){
    $hasil =  'Rp. '.number_format($angka,0, ',' , '.'); 
    return $hasil; 
}

function persen($angka){
    $hasil =  number_format($angka,0, ',' , '.').'%'; 
    return $hasil; 
}