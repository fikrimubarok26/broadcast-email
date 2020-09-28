<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h3 class="mt-4">Detail Broadcast</h3>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('email') ?>"> Broadcast</a></li>
                <li class="breadcrumb-item active "> Detail</li>
            </ol>
            <div class="card">
                <div class="card-body">
                    <div class='d-flex justify-content-between'>
                        <h4 class="card-title"><?= $collections->judul_broadcast ?></h4>
                        <span class='text-muted'><?= $collections->tanggal_kirim ?></span>
                    </div>
                    <div class="text-muted text-justify"><?= $collections->isi_broadcast ?></div>

                    <hr />

                    <!-- JUDUL TERKIRIM -->
                    <div class="row">
                        <div class="col">

                        </div>
                    </div>
                    <!-- /JUDUL TERKIRIM -->

                    <!-- DATA TERKIRIM -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="myTable" class="table table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>NRP</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                <?php $no = 1;foreach ($CollectionsDetail as $list) : ?>
                                    <tr>
                                        <td class="text-left"><?= $no++ ?></td>
                                        <td class="text-left"><?= $list['nrp'] ?></td>
                                        <td class="text-left"><?= $list['nama'] ?></td>
                                        <td class="text-left text-white <?= $list['status'] == 1 ? 'bg-success' : 'bg-danger' ?> font-weight-bold"><?= $list['status'] == 1 ? "Berhasil Terkirim" : "Tidak terkirim / Email Salah" ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- DATA TERKIRIM -->

                    <!-- /TERKIRIM -->
                </div>
            </div>
            <div style="height: 100vh;"></div>

        </div>
    </main>
</div>

<script>
    document.getElementsByClassName('groceryCrudTable')[0].classList.add('table-sm')
</script>