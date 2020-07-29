<?php
  include ('koneksi.php');
  include ('function.php');
?>
<?php
if(!empty($_GET['id']) && intval($_GET['id']) ){

if(detail_foto(trim($_GET['id']))){
  $foto=$row["foto"];
  $nama=$row["nama"];
  $id=$row["id"];
}else{
die ("Data tidak ditemukan");
}

}else{
die("Data kosong atau tidak ditemukan");  
}
?>
<?php
$berhasil_simpan = $berhasil_simpan_err = $nama_err = $foto_err = $id_err ="";   
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty(trim($_POST['nama']))){
    $nama_err = "Nama Mahasiswa tidak boleh kosong";     
    }elseif(strlen($_POST['nama'])>25){
    $nama_err = "Nama Mahasiswa tidak boleh lebih dari 25 karakter ";
    }else{
    $nama=test_input($_POST['nama']);
    $nama=mysqli_real_escape_string($koneksi,$nama);
  }

    $imgFile = $_FILES['foto']['name'];
    $tmp_dir = $_FILES['foto']['tmp_name'];
    $imgSize = $_FILES['foto']['size'];
      
    $upload_dir = 'folderfoto/';
      
    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
      
    $item_foto = rand(1000,1000000).".".$imgExt; 
    if (!empty($_FILES["foto"]["tmp_name"])){
    if(in_array($imgExt, $valid_extensions)){  
    if(!$imgSize< 2000000){
    $foto=$tmp_dir;
    }else{
    $foto_err="Maaf file foto Mahasiswa terlalu besar. Max 2MB"; 
    } 
    }else{
    $foto_err="Maaf ektensi foto Mahasiswa tidak sesuai ketentuan";
    }
    }else{
    $foto_err = "Maaf Foto Mahasiswa masih kosong";
    }
    if(empty($_POST['id'])){
    die("Terjadi keslahan, id data masing kosong");
    }else{
    $id=test_input($_POST['id']);
    $id=mysqli_real_escape_string($koneksi, $id);
    }

  if(empty($nama_err) && empty($foto_err)){     
    if(update_foto($nama, $foto, $id)){
      $berhasil_simpan = "Data berhasil disimpan <a href='lihat.php'>Lihat Data</a>";
      echo "<meta http-equiv=\"refresh\"content=\"2\"/>";
      }else{
      $berhasil_simpan_err = "Data gagal disimpan";
      }
  }
}
?>

<html>
<head>
<title>DATA MAHASISWA</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
.error-form {color: red;}
.sukses-form{color: #0081ff;}
</style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-4">
<div class="page-header">
<h1>Data Mahasiswa</h1>
</div>
<p class="sukses-form"><?php echo $berhasil_simpan; ?></p>
<p class="error-form"><?php echo $berhasil_simpan_err; ?></p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI']));?>" method="post" enctype="multipart/form-data">
<div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
<label>Nama Mahasiswa :</label>
<input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama Mahasiswa" value="<?php echo $nama; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
<span><p class="error-form"><?php echo $nama_err; ?></p></span>    
</div>
<div class="form-group <?php echo (!empty($foto_err)) ? 'has-error' : ''; ?>">
<label>Foto Mahasiswa</label>   
<input type="file" class="form-control-file" id="foto" name="foto">
<span><p class="error-form"><?php echo $foto_err; ?></p></span>
<p>
Foto saat ini :<br>
<img src="folderfoto/<?php echo $foto; ?>" class="img-fluid" height="100" width="100">
</p>      
</div>
<button type="submit" class="btn btn-primary">Submit</button>
<a href="http://localhost/halo/">Kembali</a>
</form>
</div>
</div>
</div>
</body>
</html>