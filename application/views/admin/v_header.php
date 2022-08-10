<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/html2pdf.bundle.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
            <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

      <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>

      <!-- Divider -->
        <hr class="sidebar-divider">

      <!-- Heading -->
        <div class="sidebar-heading">
            MASTER DATA
        </div>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('karyawan') ?>">
            <i class="fas fa-users fa-chart-area"></i>
            <span>Karyawan</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesQrcode" aria-expanded="false" aria-controls="collapsePagesQrcode">
            <i class="fas fa-fw fa-qrcode"></i>
            <span>Qrcode</span>
            </a>
            <div id="collapsePagesQrcode" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">setting:</h6>
                <a class="collapse-item" href="<?= base_url('gen_qrcode') ?>">Generate Qrcode</a>
                <a class="collapse-item" href="<?= base_url('absensi') ?>">Scan Qrcode</a>
            </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Presensi</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">setting:</h6>
                <a class="collapse-item" href="<?= base_url('presensi') ?>">Presensi</a>
                <a class="collapse-item" href="<?= base_url('absensi/setAbsensi') ?>">Set presensi</a>
            </div>
            </div>
        </li>
      <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('login/logout') ?>">
            <i class="fa fa-arrow-left "></i>
            <span>Logout</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>


    </nav>
<!-- End of Topbar -->