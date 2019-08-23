<?php
  include "koneksi.php";
    $user=$_POST['username'];
    $pass=md5($_POST['password']);
    $res="select * from admin where uname='$user' and pass='$pass'";
    $exe=mysqli_query($koneksi,$res);
    $data=mysqli_fetch_array($exe);
    $name=$data['uname'];
    $word=$data['pass'];
    $jabatan=$data['level'];
    $result = "";
    if($user==$name && $pass==$word)
    {
        if($jabatan=='Super Administrator' || $jabatan=='Kepala Toko')
        {
            $result = "OK";
        }
        else
        {
            $result = "Maaf Anda Tidak Berhak Untuk Merubah Harga Jual Silahkan Hubungi Super Admin Atau Kepala Toko";
        }
    }
    else
    {
        $result = "Username Dan Atau Password Salah";
    }
    echo json_encode($result);
?>