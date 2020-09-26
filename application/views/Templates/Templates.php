<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="url" content="<?= base_url() ?>" />
    <title>Aplikasi Broadcast Email </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <?php
    if ($crud != null) {
        foreach ($crud->css_files as $file) : ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>

        <?php foreach ($crud->js_files as $file) : ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach;
    } else { ?>
        <script src="<?= base_url('assets/grocery_crud/js/jquery-1.11.1.min.js') ?>"></script>
    <?php } ?>
    <?php
    if (isset($css)) {
        foreach ($css as $list) : ?>
            <link rel="stylesheet" href="<?= $list ?>">
    <?php endforeach;
    } ?>
    <link href="<?= base_url('assets/template/css/styles.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/plugin/toastr/toastr.css') ?>">

</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= base_url() ?>">Broadcast Email</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <div class=" ml-auto ">
            <ul class="navbar-nav ml-md-0">
                <li class="nav-item ">
                    <a class="nav-link" id="userDropdown" href="<?= base_url('logout') ?>" role="button"><i class="fas fa-power-off"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Master</div>
                        <a class="nav-link" href="<?= base_url('anggota') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                            Anggota
                        </a>
                        <a class="nav-link" href="<?= base_url('jabatan') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-medal"></i></div>
                            Jabatan
                        </a>
                        <a class="nav-link" href="<?= base_url('pangkat') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div>
                            Pangkat
                        </a>

                        <div class="sb-sidenav-menu-heading">Transaksi</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                            Broadcast
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link text-size--1" href="<?= base_url('email') ?>">Buat Broadcast Email</a>
                                <a class="nav-link text-size--1" href="layout-sidenav-light.html">Riwayat Broadcast</a>
                            </nav>
                        </div>

                    </div>
                </div>

            </nav>
        </div>
        <?php $this->load->view($page); ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <?php
    if (isset($js)) {
        foreach ($js as $list) : ?>
            <script src="<?= $list ?>"></script>
    <?php endforeach;
    } ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?= base_url('assets/template/js/scripts.js') ?>"></script>
    <script src="<?= base_url('assets/template/js/script.js') ?>"></script>
    <?= $this->session->flashdata('pesan') ?>

</body>

</html>