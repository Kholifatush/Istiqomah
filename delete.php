<?php
  include ('koneksi.php');
  include ('function.php');
?>
<?php
if(!empty($_GET['id']) && intval($_GET['id']) ){
 if(detail_foto(trim($_GET['id']))){
  $id=$row["id"];
 }else{
  die ("Data tidak ditemukan");
 }
 
 }else{
  die("Data kosong atau tidak ditemukan");
}
?>
<?php
$berhasil_simpan = $berhasil_simpan_err = $id_err ="";   
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty(trim($_POST['id']))){
           $id_err = "id Mahasiswa tidak boleh kosong";     
           }elseif(strlen($_POST['id'])>25){
           $id_err = "id Mahasiswa tidak boleh lebih dari 25 karakter ";
           }else{
           $id=test_input($_POST['id']);
           $id=mysqli_real_escape_string($koneksi,$id);
  }

if(empty($id_err)){       
if(delete_foto($id)){
  $berhasil_simpan = "Data berhasil dihapus";
  echo "<meta http-equiv=\"refresh\"content=\"1;URL=lihat.php\"/>";
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
<link rel="stylesheet" type="text/css" href="style.css">
<style type="text/css">
.error-form {color: red;}
.sukses-form{color: #0081ff;}
</style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-4">    
<p class="sukses-form"><?php echo $berhasil_simpan; ?></p>
<p class="error-form"><?php echo $berhasil_simpan_err; ?></p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI']));?>" method="post">
<div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">    
      <input type="hidden" name="id" class="form-control" id="id" placeholder="Masukan id Mahasiswa" value="<?php echo $id; ?>">
      <p style="font-size: 20px;color: white;">Yakin ingin mengahpus data ?</p>
      <span><p class="error-form"><?php echo $id_err; ?></p></span>    
</div>  
<button type="submit" class="btn btn-danger">Delete</button>
</form>
</div>
</div>
</div>
</body>
</html>