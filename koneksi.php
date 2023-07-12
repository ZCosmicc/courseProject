<?php
//Connect database local
$koneksi = mysqli_connect('localhost', 'root', '', 'simpcourse', 3306);

//Check connection
if(!$koneksi){
    echo 'Connection error: '. mysqli_connect_error();
}
?>