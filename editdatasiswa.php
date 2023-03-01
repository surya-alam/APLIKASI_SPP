<?php
include 'header.php';
include 'config.php';
?>
<!-- button triger -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahSiswa">Tambah Siswa</button>
<!-- button triger -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr class="text-center">
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Angkatan</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Alamat</th>
                    <th width="150">Aksi</th>
</tr>
</thead>
<tbody>
    <!-- Query untuk membaca data dari tabel database (webspp) --> 
    <?php
     $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* 
     FROM siswa, angkatan, jurusan, kelas
     WHERE siswa.id_angkatan = angkatan.id_angkatan AND siswa.id_jurusan = jurusan.id_jurusan
     AND siswa.id_kelas = kelas.id_kelas ORDER BY id_siswa";
     $exec = mysqli_query($db,$query);
     while($res = mysqli_fetch_assoc($exec)) :
        ?>
        <tr>
            <!-- Fungsi untuk mengambil data yang ada pada tiap kolom tabel siswa -->
        <td><?= $res['nisn'] ?></td>
        <td><?= $res['nama'] ?></td>
        <td><?= $res['nama_angkatan'] ?></td>
        <td><?= $res['nama_kelas'] ?></td>
        <td><?= $res['nama_jurusan'] ?></td>
        <td><?= $res['alamat'] ?></td>
        <td class="text-center">
            <div class="btn-group mr-2" role="group" aria-label="Action group button">
            <!-- Tombol edit data siswa -->
            <a href="#" class="view_data btn btn-sm btn-warning" data-toggle="modal" data-target="#editSiswa" id="<?php echo $res['id_siswa']; ?>">Update</a>
            <!-- Tombol hapus data siswa --> 
            <a href="editdatasiswa.php?id_siswa=<?= $res['id_siswa'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('apakah Yakin ingin menghapus data?')">Delete</a>
     </div>
     </td>
     </tr>
    <?php endwhile; ?>
     </tbody>
     </table>
     </div>
     </div>
     </div>
     <?php include 'footer.php'; ?>
     <!-- Modal --> 
     <div class="modal fade" id="tambahSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
     </button>
     </div>
     <div class="modal-body">
        <form action="editdatasiswa.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nama Siswa</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama Siswa">
                </div>
                <div class="form-group col-md-6">
                    <label>Nama Angkatan</label>
                    <select class="form-control mb-2" name="id_angkatan">
                        <option selected="">-Pilih Angkatan-</option> 
                        <?php
                        $exec = mysqli_query($db,"SELECT * FROM angkatan order by id_angkatan");
                        while($angkatan = mysqli_fetch_assoc($exec)) :
                            echo "<option value=".$angkatan['id_angkatan'].">".$angkatan['nama_angkatan']."</option>";
                        endwhile;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Nama Kelas</label>
                    <select class="form-control mb-2" name="id_kelas">
                        <option selected="">-Pilih Kelas-</option>
                        <?php
                        $exec =mysqli_query($db,"SELECT * FROM kelas order by id_kelas");
                        while ($angkatan = mysqli_fetch_assoc($exec)) :
                        echo "<option value=".$angkatan['id_kelas'].">".$angkatan['nama_kelas']."</option>";
                        endwhile;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Nama Jurusan</label>
                    <select class="form-control mb-2" name="id_jurusan">
                        <option selected="">-Pilih Jurusan-</option>
                        <?php
                        $exec =mysqli_query($db,"SELECT * FROM jurusan order by id_jurusan");
                        while ($angkatan = mysqli_fetch_assoc($exec)) :
                        echo "<option value=".$angkatan['id_jurusan'].">".$angkatan['nama_jurusan']."</option>";
                        endwhile;
                        ?>
                    </select>
                </div>
                <textarea class="form-control" mt-2 name="alamat" placeholder="Alamat Siswa"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="Submit" name="simpan" class="btn btn-primary">simpan</button>
            </div>
            
        </form>
     </div>
     </div>
     </div>
     </div>
    <!--Modal-->
    <div class="modal fade" id="editSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Data Siswa</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body" id="datasiswa">
    <!-- form edit data jurusan dipisah ke dalam file view.php -->
     </div>
     </div>
     </div>
     </div>

    <script type="text/javascript">
        $('.view_data').click(function(){
            var id_siswa = $(this).attr('id');
            $.ajax({
                url: 'view.php',
                method: 'POST',
                data: {id_siswa:id_siswa},
                success:function(data){
                    $('#datasiswa').html(data)
                    $('#editSiswa').modal('show');
                }
            })
        })
        </script>
     <?php
     //proses tambah data ke dalam tabel database
     if(isset($_POST['simpan'])) {
        $nama = htmlentities(strip_tags(strtoupper($_POST['nama'])));
        $id_kelas = htmlentities(strip_tags(strtoupper($_POST['id_kelas'])));
        $id_jurusan = htmlentities(strip_tags(strtoupper($_POST['id_jurusan'])));
        $id_angkatan = htmlentities(strip_tags(strtoupper($_POST['id_angkatan'])));
        $alamat = htmlentities(strip_tags(strtoupper($_POST['alamat'])));
        $nisn = date('dmYHis');
        $query = "INSERT INTO siswa (nisn, nama, id_angkatan, id_jurusan, id_kelas, alamat)
        VALUES ('$nisn','$nama','$id_angkatan','$id_jurusan','$id_kelas','$alamat')";
        $exec = mysqli_query($db, $query);
        if($exec) {
            //Variabel array untuk menggantikan default format bulan (English to Indonesian)
            $bulanindo =[
                '01' => 'Januari',
                '02' => 'Febuari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
            ];
            $query = "SELECT siswa.*, angkatan.* FROM siswa,angkatan
                WHERE siswa.id_angkatan = angkatan.id_angkatan
                ORDER BY siswa.id_siswa DESC LIMIT 1";
            $exec = mysqli_query($db,$query);
            $res = mysqli_fetch_assoc($exec);
            $biaya = $res['biaya'];
            $id_siswa = $res['id_siswa'];
            $awaltempo = date('Y-m-d');
            //bentuk perulangan yang akan membuat inputan 36 bulan pembayaran SPP dalam tabel pembayaran
            for ($i=0; $i<36; $i++){
                /*
                deklarasi variabel jatuhtempo untuk membuat auto increment bulan (+$i month)
                sebanyak 36 bulan pada variabel $awaltempo
                */
                $jatuhtempo = date("Y-m-d" , strtotime("+$i month" , strtotime($awaltempo)));
                /*
                variabel bulan di deklarasikan untuk proses perubahan format bulan
                berdasarkan data array variabel $bulanIndo
                */
                $bulan = $bulanindo [date('m', strtotime($jatuhtempo))]." ".date('Y', strtotime($jatuhtempo));
                //variabel add di deklarasikan untuk memproses input ke tabel pembayaran sesuai dengan kolom
                $add = mysqli_query($db, "INSERT INTO pembayaran(id_siswa, jatuhtempo, bulan, jumlah)
                VALUES ('$id_siswa','$jatuhtempo','$bulan','$biaya')");
            }
            echo "<script>alert('data siswa berhasil disimpan')
            document.location = 'editdatasiswa.php';</script>";
        }else {
            echo "<script>alert('data siswa gagal disimpan')
            document.location = 'editdatasiswa.php';</script>";
        }
     }
     

//proses hapus data pada tabel database
    if(isset($_GET['id_siswa'])) {
        $id_siswa = $_GET['id_siswa'];
        $exec = mysqli_query($db," DELETE FROM siswa WHERE id_siswa='$id_siswa' ");
        if($exec) {
            echo "<script>alert('data siswa berhasil dihapus')
            document.location = 'editdatasiswa.php';</script>";
        }else {
            echo "<script>alert('data siswa gagal dihapus')
            document.location = 'editdatasiswa.php';</script>";
        }
    }
    
    ?>
    <div class="modal fade" id="editSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Data Siswa</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body" id="datasiswa">
    <!-- form edit data siswa dipisah ke dalam file view2.php -->
     </div>
     </div>
     </div>
     <?php

    //Proses update data pada tabel database

    if(isset($_POST['edit'])) {
        $id_siswa = $_POST['id_siswa'];
        $nisn = $_POST['nisn'];
        $nama = (ucwords($_POST['nama']));
        $id_kelas = $_POST['id_kelas'];
        $id_jurusan = $_POST['id_jurusan'];
        $id_angkatan = $_POST['id_angkatan'];
        $alamat = (ucwords($_POST['alamat']));

        $query = "UPDATE siswa SET nisn = '$nisn', nama = '$nama', id_kelas = '$id_kelas', id_jurusan = '$id_jurusan', id_angkatan = '$id_angkatan', alamat = '$alamat' WHERE id_siswa= '$id_siswa'";
        $exec = mysqli_query($db,$query);
        if($exec) {
            echo " <script>alert('data siswa berhasil diedit')
            document.location = 'editdatasiswa.php'</script>; ";
        }else {
            echo " <script>alert('data siswa gagal diedit')
            document.location = 'editdatasiswa.php'</script>; ";
        }
    }

    ?>