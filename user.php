<?php

require_once 'koneksi.php';

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// Menampilakn Data

function tampilData(){
    global $koneksi;

    $sql = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($sql)){
        $user[] = $data;
}

$respon = array(
    'status' => 200,
    'pesan' => 'Berhasil menampilkan data',
    'users' => $user
);

header('Content-type: application/json');
print json_encode($respon);

}


// Menamahkan Data

function tambahData(){
    global $koneksi;

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek =count(array_intersect_key($_POST, $isi));

    if($cek == count($isi)){
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $hasil = mysqli_query($koneksi, "INSERT INTO users values('', '$nama', '$alamat', '$no_telp')");

        if($hasil){
            return pesan(1, "Berhasil menamahkan data $nama");
        }else{
            return pesan(0,"Gagal menambahkan data $nama");
        }
    }else{
        return pesan(0,"Gagal menambahkan data, parameter salah");
    }
}


function pesan($status, $pesan){
    $respon = array(
        'status' => $status,
        'pesan' => $pesan
    );

    header('Content-type:application/json');
    print json_encode($respon);
}


// Edit Data

function editData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek = count(array_intersect_key($_POST, $isi));

    if($cek == count($isi)){
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $sql = mysqli_query($koneksi, "UPDATE users set id='$id', nama='$nama', alamat='$alamat', no_telp='$no_telp' where id='$id'");

        if($sql){
            return pesan(1,"Berhasil mengedit data $nama");
        }else{
            return pesan(0,"Gagal mengedit data $nama");
        }
    }else{
        return pesan(0,"Gagal mengedit data, parameter salah");
    }
}


// Menghapus Data

function hapusData(){
    global $koneksi;

    if(!empty($_GET["id"])){
        $id = $_GET["id"]; 
    }

    $sql = mysqli_query($koneksi,"DELETE from users where id='$id'");

    if($sql){
        return pesan(1,"Berhasil hapus data");
    }else{
        return pesan(0,"Gagal hapus data");
    }
}

// Menampilkan Detail Data

function detailData(){
    global $koneksi;

    if(!empty($_GET["id"])){
        $id = $_GET["id"];
    }
    
    $sql = mysqli_query($koneksi,"SELECT * FROM users where id='$id'");
    $data = mysqli_fetch_object($sql);
    
    $respon = array(
        'status' => 200,
        'pesan' => 'Berhasil menampilkan data',
        'user'=> $data
    );
    
    header('Content-type: application/json');
    print json_encode($respon);
}


?>