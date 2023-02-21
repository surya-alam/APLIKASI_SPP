<?php
include 'header.php';
include 'config.php';
?>
<!-- button triger -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahJurusan">Tambah Jurusan</button>
<!-- button triger -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Jurusan</h6>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr class="text-center">
                    <th width="50">No</th>
                    <th>Nama Jurusan</th>
                    <th width="150">Aksi</th>
</tr>
</thead>
<tbody>
    <!-- Query untuk membaca data dari tabel database (webspp) --> 
    <?php
     $no=1;
     $query = "SELECT * FROM jurusan";
     $exec = mysqli_query($db,$query);
     while($res = mysqli_fetch_assoc($exec)) :
        ?>
        <tr>
            <!-- Fungsi untuk mengambil data yang ada pada tiap kolom tabel urusan -->
        <td class="text-center"><?= $no++ ?></td>
        <td><?= $res['nama_jurusan'] ?></td>
        <td class="text-center">
            <div class="btn-group mr-2" role="group" aria-label="Action group button">
            <!-- Tombol edit data jurusan -->
            <a href="#" class="view_data btn btn-sm btn-warning" data-toggle="modal" data-target="#editJurusan" id="<?php echo $res['id_jurusan']; ?>">Update</a>
            <!-- Tombol hapus data jurusan --> 
            <a href="editdatajurusan.php?id_jurusan=<?= $res['id_jurusan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('apakah Yakin ingin menghapus data?')">Delete</a>
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
     <div class="modal fade" id="tambahJurusan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
     </button>
     </div>
     <div class="modal-body">
        <form action="editdatajurusan.php" method="POST">
            <input type="text" name="nama_jurusan" placeholder="Nama Jurusan" class="form-control mb-2">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
     </div>
     </form>
     </div>
     </div>
     </div>
     </div>

    <div class="modal fade" id="editJurusan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Data Jurusan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body" id="datajurusan">
    <!-- form edit data jurusan dipisah ke dalam file view1.php -->
     </div>
     </div>
     </div>
     </div>
     <script type="text/javascript">
        $('.view_data').click(function(){
            var id_jurusan = $(this).attr('id');
            $.ajax({
                url: 'view.php',
                method: 'POST',
                data: {id_jurusan:id_jurusan},
                success:function(data){
                    $('#datajurusan').html(data)
                    $('#editJurusan').modal('show');
                }
            })
        })
        </script>

     <?php

     //proses tambah data ke dalam tabel database
     if(isset($_POST['simpan'])) {
        $nama_jurusan = htmlentities(strip_tags(strtoupper($_POST['nama_jurusan'])));
        $query = "INSERT INTO jurusan (nama_jurusan) VALUES ('$nama_jurusan')";
        $exec = mysqli_query($db, $query);
        if($exec) {
            echo "<script>alert('data jurusan berhasil disimpan')
            document.location = 'editdatajurusan.php';</script>";
        }else {
            echo "<script>alert('data jurusan gagal disimpan')
            document.location = 'editdatajurusan.php';</script>";
        }
     }

     //proses hapus data pada tabel database
    if(isset($_GET['id_jurusan'])) {
        $id_jurusan = $_GET['id_jurusan'];
        $exec = mysqli_query($db," DELETE FROM jurusan WHERE id_jurusan='$id_jurusan' ");
        if($exec) {
            echo "<script>alert('data jurusan berhasil dihapus')
            document.location = 'editdatajurusan.php';</script>";
        }else {
            echo "<script>alert('data jurusan gagal dihapus')
            document.location = 'editdatajurusan.php';</script>";
        }
    }

    //proses hapus data pada tabel database
    //Proses update data pada tabel database

    if(isset($_POST['update'])) {
        $id_jurusan = $_POST['id_jurusan'];
        $nama_jurusan = htmlentities(strip_tags(strtoupper($_POST['nama_jurusan'])));
        $query = "UPDATE jurusan SET nama_jurusan = '$nama_jurusan' WHERE id_jurusan = '$id_jurusan'";
        $exec = mysqli_query($db,$query);
        if($exec) {
            echo " <script>alert('data jurusan berhasil diedit')
            document.location = 'editdatajurusan.php'</script>; ";
        }else {
            echo " <script>alert('data jurusan gagal diedit')
            document.location = 'editdatajurusan.php'</script>; ";
        }
    }

    ?>