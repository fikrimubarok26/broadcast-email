<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h3 class="mt-4">Broadcast Email</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"> Broadcast</li>
                <li class="breadcrumb-item active"> Buat</li>
            </ol>

            <div style="height: 100vh;">

                <form action="<?= base_url('email/kirim') ?>" method="POST">
                    
                    <div class="form-group">
                        <label for="">Tujuan Kirim</label>
                        <input type="text" class="form-control" name="tujuan" placeholder="Anggota">
                    </div>
                    <div class="form-group">
                        <label for="">Subjek / Judul</label>
                        <input type="text" class="form-control" name="subjek" placeholder="Subjek">
                    </div>
                    <div class="form-group">
                        <label for="">Pesan Email</label>
                        <textarea cols="30" name="isi_surat" class="summernote" placeholder="Pesan Email" rows="10"></textarea>
                    </div>

                    <button class="btn btn-success" type="submit">Kirim Pesan</button>
                </form>

            </div>

        </div>
    </main>
</div>