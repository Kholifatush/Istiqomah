<?php
function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function simpan_foto($nama, $foto){
  global $koneksi;
  global $item_foto;
  global $upload_dir;
  
  $sql="INSERT INTO tabel_foto(nama, foto) VALUES (?,?)";

  if($stmt=mysqli_prepare($koneksi, $sql)){
        mysqli_stmt_bind_param($stmt,"ss",$param_nama, $param_foto);
        $param_nama= $nama;
        $param_foto= $item_foto;

  if(mysqli_stmt_execute($stmt)&&(move_uploaded_file($foto, $upload_dir.$item_foto))){
        $simpan=true;
        }else{
        $simpan=false;
        }
        return $simpan;
  }
  mysqli_stmt_close($stmt);
}

function update_foto($nama,$foto, $id){
  global $koneksi;
  global $item_foto;
  global $upload_dir;
  $sql = "UPDATE tabel_foto SET nama=?, foto=? WHERE id=?";
        
if($stmt = mysqli_prepare($koneksi, $sql)){           
  mysqli_stmt_bind_param($stmt,"ssi",$param_nama, $param_foto, $param_id);
  $param_nama= $nama;
  $param_foto= $item_foto;
  $param_id= $id;
            
  $sql="SELECT * FROM tabel_foto where id=?";
  if($prepare=mysqli_prepare($koneksi,$sql)){
    mysqli_stmt_bind_param($prepare, "i", $param_id);
    mysqli_stmt_execute($prepare);
  $result = mysqli_stmt_get_result($prepare);
  if(mysqli_num_rows($result)==1){
  $jalankan=mysqli_fetch_array($result);
  $hapus_foto=unlink("folderfoto/$jalankan[foto]");
  }else{
  header("location: error");
  exit();                   
  }
  }

  if(mysqli_stmt_execute($stmt) && ($hapus_foto) && (move_uploaded_file($foto, $upload_dir.$item_foto))){
    $simpan=true;
    }else{
    $simpan=false;
    }
    return $simpan;
    }
    mysqli_stmt_close($stmt);
  }

function tampil_foto(){
  global $koneksi;
  $sql = "SELECT id, nama, foto FROM tabel_foto order by id desc";
  $result = mysqli_query($koneksi, $sql);
  return $result;
}

function detail_foto($var_id){
  global $koneksi;
  global $row;
  $sql = "SELECT * FROM tabel_foto WHERE id = ?";
  if($stmt = mysqli_prepare($koneksi, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    $param_id = $var_id;
    if(mysqli_stmt_execute($stmt)){     
    $result = mysqli_stmt_get_result($stmt);
  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if(mysqli_num_rows($result) == 1){
    return true;
    }else{                 
    return false;
    }
            
    }else{
    echo "Terjadi kesalahan. Coba lagi nanti";
    }     
    }
  mysqli_stmt_close($stmt);
  }

function delete_foto($id){
  global $koneksi;
  $sql = "DELETE FROM tabel_foto WHERE id = ?";
  if($stmt = mysqli_prepare($koneksi, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    $param_id = $id;

  $sql="SELECT * FROM tabel_foto where id=?";
  if($prepare=mysqli_prepare($koneksi, $sql)){
    mysqli_stmt_bind_param($prepare, "i", $param_id);
    mysqli_stmt_execute($prepare);
    $result = mysqli_stmt_get_result($prepare);
  if(mysqli_num_rows($result)==1){
    $jalankan=mysqli_fetch_array($result);
    $hapus_foto=unlink("folderfoto/$jalankan[foto]");
    }else{
    header("location: error");
    exit();                   
    }
    }
    if(mysqli_stmt_execute($stmt) && ($hapus_foto)){
      return true;
      }else{
      return false;
      }
    }
  
      mysqli_stmt_close($stmt);
      mysqli_stmt_close($prepare);   
}
?>