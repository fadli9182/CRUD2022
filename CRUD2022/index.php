<?php
    //Koneksi Database
    $server="localhost";
    $user="root";
    $pass="";
    $database="dblatihan";

    $koneksi=mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    
    if(isset($_POST['bsimpan']))
    {
        //Pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit"){
            //maka data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE tmhs set 
                                            nim ='$_POST[tnim]',
                                            nama ='$_POST[tnama]',
                                            alamat ='$_POST[talamat]',
                                            prodi ='$_POST[tprodi]'
                                            WHERE id_mhs ='$_GET[id]'
            ");
            if($edit) {
                echo "<script>
                        alert('Edit Data Berhasil!');
                        document.location='index.php';
                        </script>";
            }
            else {
                echo "<script>
                        alert('Edit Data GAGAL!');
                        document.location='index.php';
                        </script>";
            }
        } else {
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi) 
            VALUES ('$_POST[tnim]', 
                    '$_POST[tnama]',
                    '$_POST[talamat]',
                    '$_POST[tprodi]')
            ");
            if($simpan) {
                echo "<script>
                        alert('Simpan Data Berhasil!');
                        document.location='index.php';
                        </script>";
            }
            else {
                echo "<script>
                        alert('Simpan Data GAGAL!');
                        document.location='index.php';
                        </script>";
            }
        } 


        

    }

    //Pengujian jika tombol edit atau hapus diklik
    if(isset ($_GET['hal'])) {
        //pengujian jika edit data
        if($_GET['hal'] =="edit"){
            //tampilkan data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs where id_mhs ='$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data) {
                //JIka data ditemukan, maka data ditampung ke dalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];

            }
        } else if ($_GET['hal'] =="hapus") {
            //Persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]'");
            if($hapus){
                echo "<script>
                        alert('Hapus Data Berhasil!');
                        document.location='index.php';
                        </script>";
            } 
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 2022 PHP & MySQL + Bootstrap 4</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
    <h1 class="text-center">CRUD 2022 PHP & MySQL + Bootstrap 4</h1>
    <h2 class="text-center">@Ngodingbusuk</h2>

    <!-- Awal Card Form -->
    <div class="card mt-3">
    <div class="card-header bg-primary text-white">
        Form input Data Mahasiswa
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class=form-group>
                <label for="">NIM</label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input Nim anda disini!" required>
            </div>
            <div class=form-group>
                <label for="">Nama</label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini!" required>
            </div>
            <div class=form-group>
                <label for="">Alamat</label>
                <textarea class="form-control" name="talamat" 
                    placeholder="Input Alamat anda disini!"><?=@$valamat?></textarea>
            </div>
            <div class=form-group>
                <label for="">Program Studi</label>
                <select class="form-control" name="tprodi" id="">
                    <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                    <option value="D3-MI">D3-MI</option>
                    <option value="S1-SI">S1-SI</option>
                    <option value="S2-MT">S2-TI</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
        </form>
    </div>
    </div>
    <!--Akhir Card Form -->
    <!-- Awal Card Form -->
    <div class="card mt-3">
    <div class="card-header bg-success text-white">
        Daftar Mahasiswa
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No</th>
                <th>Nim</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['alamat']?></td>
                <td><?=$data['prodi']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning">Edit</a>
                    <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" 
                    onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
        <?php endwhile; //Penutup perulangan while ?>
        </table>
    </div>
    </div>
    <!--Akhir Card Form -->
    </div>
<script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>