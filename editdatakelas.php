<?php
include 'header.php';
include 'config.php';
?>
<!-- button triger -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKelas">Tambah Kelas</button>
<!-- button triger -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr class="text-center">
                    <th width="50">No</th>
                    <th>Nama Kelas</th>
                    <th width="150">Aksi</th>
</tr>
</thead>
<tbody>
    <!-- Query untuk membaca data dari tabel database (webspp) --> 
    <?php
     $no=1;
     $query = "SELECT * FROM kelas";
     $exec = mysqli_query($db,$query);
     while($res = mysqli_fetch_assoc($exec)) :
        ?>
        <tr>
            <!-- Fungsi untuk mengambil data yang ada pada tiap kolom tabel urusan -->
        <td class="text-center"><?= $no++ ?></td>
        <td><?= $res['nama_kelas'] ?></td>
        <td class="text-center">
            <div class="btn-group mr-2" role="group" aria-label="Action group button">
            <!-- Tombol edit data kelas -->
            <a href="#" class="view_data btn btn-sm btn-warning" data-toggle="modal" data-target="#editKelas" id="<?php echo $res['id_kelas']; ?>">Update</a>
            <!-- Tombol hapus data kelas --> 
            <a href="editdatakelas.php?id_kelas=<?= $res['id_kelas'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('apakah Yakin ingin menghapus data?')">Delete</a>
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
     <div class="modal fade" id="tambahKelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
     </button>
     </div>
     <div class="modal-body">
        <form action="editdatakelas.php" method="POST">
            <input type="text" name="nama_kelas" placeholder="Nama Kelas" class="form-control mb-2">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
     </div>
     </form>
     </div>
     </div>
     </div>
     </div>

    <div class="modal fade" id="editKelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Data Kelas</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body" id="datakelas">
    <!-- form edit data kelas dipisah ke dalam file view3.php -->
     </div>
     </div>
     </div>
     </div>
     <script type="text/javascript">
        $('.view_data').click(function(){
            var id_kelas = $(this).attr('id');
            $.ajax({
                url: 'view.php',
                method: 'POST',
                data: {id_kelas:id_kelas},
                success:function(data){
                    $('#datakelas').html(data)
                    $('#editKelas').modal('show');
                }
            })
        })
        </script>

     <?php

     //proses tambah data ke dalam tabel database
     if(isset($_POST['simpan'])) {
        $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));
        $query = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
        $exec = mysqli_query($db, $query);
        if($exec) {
            echo "<script>alert('data kelas berhasil disimpan')
            document.location = 'editdatakelas.php';</script>";
        }else {
            echo "<script>alert('data kelas gagal disimpan')
            document.location = 'editdatakelas.php';</script>";
        }
     }

     //proses hapus data pada tabel database
    if(isset($_GET['id_kelas'])) {
        $id_kelas = $_GET['id_kelas'];
        $exec = mysqli_query($db," DELETE FROM kelas WHERE id_kelas='$id_kelas' ");
        if($exec) {
            echo "<script>alert('data kelas berhasil dihapus')
            document.location = 'editdatakelas.php';</script>";
        }else {
            echo "<script>alert('data kelas gagal dihapus')
            document.location = 'editdatakelas.php';</script>";
        }
    }

    //proses hapus data pada tabel database
    //Proses update data pada tabel database

    if(isset($_POST['update'])) {
        $id_kelas = $_POST['id_kelas'];
        $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));
        $query = "UPDATE kelas SET nama_kelas = '$nama_kelas' WHERE id_kelas = '$id_kelas'";
        $exec = mysqli_query($db,$query);
        if($exec) {
            echo " <script>alert('data kelas berhasil diedit')
            document.location = 'editdatakelas.php'</script>; ";
        }else {
            echo " <script>alert('data kelas gagal diedit')
            document.location = 'editdatakelas.php'</script>; ";
        }
    }

    ?>