<?php
  include ('koneksi.php');
  include ('function.php');
?>
<?php
$tampil=tampil_foto();
?>
<html>
<head>
<title>DATA MAHASISWA</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<link rel="stylesheet" type="text/css" href="style.css">
<style type="text/css">
.error-form {color: red;}
.sukses-form{color: #0081ff;}
</style>
</head>
<body>
<div class="container">
  <div class="row">
    <section class="col-sm-12">
      <div class="page-header">
      <h3 style="font-size: 20px;color: white;">Lihat Data Mahasiswa</h3>
    </div>
  <div class="table-responsive">
  <?php 
  $result=tampil_foto(); 
  if($result){
  if(mysqli_num_rows($result) > 0){
  echo "<table class='table table-striped table-bordered table-hover'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>No</th>";
  echo "<th>Nama</th>";
  echo "<th>Foto</th>";                  
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
$awal=0;
$no=$awal+1;
while($data=mysqli_fetch_array($result)) {                     
  echo "<tr>";
  echo "<td>".$no."</td>";
  echo "<td>".$data['nama']."</td>";
  echo "<td>".'<img class="img-responsive" width="80" height="100" src="folderfoto/'.$data['foto'].'"'."</td>";   
  echo "<td>";
  echo "<a href='tb_data.php' title='Tambah Data' alt='Tambah Data'><i  class='fa fa-edit fa-fw small'></i></a>";
  echo "<a href='edit_data.php?id=".$data['id']."' title='Edit Mahasiswa' alt='Edit Mahasiswa'><i class='fa fa-edit fa-fw small'></i></a>";
  echo "<a href='delete.php?id=". $data['id'] ."' title='Delete Mahasiswa' alt='Delete Mahasiswa'><i  class='fa fa-trash fa-fw small'></i></a>";

  echo "</td>";
  echo "</tr>";
  $no+=1;  
  }
  echo "</tbody>";
  echo"</table>";
  echo "<a href='http://localhost/1900018190/'>Kembali</a>";
  mysqli_free_result($result);
  } else{
  echo "<p class='lead'><em>Data Mahasiswa belum ada. <a href='tb_data.php'>Tambah Data</a></em></p>";
  }
  } else{
  echo "ERROR: Tidak bisa mengeksekusi perintah. " . mysqli_error($koneksi);
  }
  mysqli_close($koneksi);
?>
</div>
</section>
</div>
</div>
</body>
</html>