<?php
include 'header.php';
include 'config.php';
?>
<!-- button triger -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahAngkatan">Tambah Data</button>
<!-- button triger -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Angkatan</h6>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr class="text-center">
                    <th width="50">No</th>
                    <th>Nama Angkatan</th>  
                    <th>Biaya</th>
                    <th width="150">Aksi</th>
</tr>
</thead>
<tbody>
    <!-- Query untuk membaca data dari tabel database (webspp) --> 
    <?php
     $no=1;
     $query = "SELECT * FROM angkatan";
     $exec = mysqli_query($db,$query);
     while($res = mysqli_fetch_assoc($exec)) :
        ?>
        <tr>
            <!-- Fungsi untuk mengambil data yang ada pada tiap kolom tabel angkatan -->
        <td class="text-center"><?= $no++ ?></td>
        <td><?= $res['nama_angkatan'] ?></td>
        <td><?= $res['biaya'] ?></td>
        <td class="text-center">
            <div class="btn-group mr-2" role="group" aria-label="Action group button">
            <!-- Tombol edit data angkatan -->
            <a href="#" class="view_data btn btn-sm btn-warning" data-toggle="modal" data-target="#editAngkatan" id="<?php echo $res['id_angkatan'] ?>">Update</a>
            <!-- Tombol hapus data angkatan --> 
            <a href="editdataangkatan.php?id_angkatan=<?= $res['id_angkatan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('apakah Yakin ingin menghapus data?')">Delete</a>
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
     <div class="modal fade" id="tambahAngkatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
     </button>
     </div>
     <div class="modal-body">
        <form action="editdataangkatan.php" method="POST">
            <input type="text" name="nama_angkatan" placeholder="Nama Angkatan" class="form-control mb-2">
            <input type="text" name="biaya" placeholder="Biaya SPP" class="form-control mb-2">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
     </div>
     </form>
     </div>
     </div>
     </div>
     </div>

    <div class="modal fade" id="editAngkatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Data Angkatan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body" id="dataangkatan">
    <!-- form edit data angkatan dipisah ke dalam file view.php -->
     </div>
     </div>
     </div>
     </div>
     <script type="text/javascript">
        $('.view_data').click(function(){
            var id_angkatan = $(this).attr('id');
            $.ajax({
                url: 'view.php',
                method: 'POST',
                data: {id_angkatan:id_angkatan},
                success:function(data){
                    $('#dataangkatan').html(data)
                    $('#editAngkatan').modal('show');
                }
            })
        })
        </script>

     <?php

     //proses tambah data ke dalam tabel database
     if(isset($_POST['simpan'])) {
        $nama_angkatan = htmlentities(strip_tags(strtoupper($_POST['nama_angkatan'])));
        $biaya = htmlentities(strip_tags(strtoupper($_POST['biaya'])));
        $query = "INSERT INTO angkatan (nama_angkatan,biaya) VALUES ('$nama_angkatan', '$biaya')";
        $exec = mysqli_query($db, $query);
        if($exec) {
            echo "<script>alert('data angkatan berhasil disimpan')
            document.location = 'editdataangkatan.php';</script>";
        }else {
            echo "<script>alert('data angkatan gagal disimpan')
            document.location = 'editdataangkatan.php';</script>";
        }
     }

     //proses hapus data pada tabel database
    if(isset($_GET['id_angkatan'])) {
        $id_angkatan = $_GET['id_angkatan'];
        $exec = mysqli_query($db," DELETE FROM angkatan WHERE id_angkatan='$id_angkatan' ");
        if($exec) {
            echo "<script>alert('data angkatan berhasil dihapus')
            document.location = 'editdataangkatan.php';</script>";
        }else {
            echo "<script>alert('data angkatan gagal dihapus')
            document.location = 'editdataangkatan.php';</script>";
        }
    }

    //proses hapus data pada tabel database
    //Proses update data pada tabel database

    if(isset($_POST['update'])) {
        $id_angkatan = $_POST['id_angkatan'];
        $nama_angkatan = htmlentities(strip_tags(strtoupper($_POST['nama_angkatan'])));
        $biaya = htmlentities(strip_tags(strtoupper($_POST['biaya'])));
        $query = "UPDATE angkatan SET nama_angkatan = '$nama_angkatan', biaya = '$biaya' WHERE id_angkatan= '$id_angkatan'";
        $exec = mysqli_query($db,$query);
        if($exec) {
            echo " <script>alert('data angkatan berhasil diedit')
            document.location = 'editdataangkatan.php'</script>; ";
        }else {
            echo " <script>alert('data angkatan gagal diedit')
            document.location = 'editdataangkatan.php'</script>; ";
        }
    }

    ?>