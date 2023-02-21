<?php

$db = mysqli_connect('localhost','root','','webspp');
if(!$db){
    throw new Exception("Daabase gagal terdeteksi",1);
}

?>