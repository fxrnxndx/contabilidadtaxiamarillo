<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Taxi</title>
  <!-- loader-->
  <link href=<?php echo (base_url("assets/css/pace.min.css")); ?> rel="stylesheet" />
  <script src=<?php echo (base_url("assets/js/pace.min.js")); ?>></script>
  <!--favicon-->
  <link rel="icon" href=<?php echo (base_url("assets/images/favicon.png")); ?> type="image/x-icon">
  <!-- Vector CSS -->
  <link href=<?php echo (base_url("assets/plugins/vectormap/jquery-jvectormap-2.0.2.css")); ?> rel="stylesheet" />
  <!-- simplebar CSS-->
  <link href=<?php echo (base_url("assets/plugins/simplebar/css/simplebar.css")); ?> rel="stylesheet" />
  <!-- Bootstrap core CSS-->
  <link href=<?php echo (base_url("assets/css/bootstrap.min.css")); ?> rel="stylesheet" />
  <!-- animate CSS-->
  <link href=<?php echo (base_url("assets/css/animate.css")); ?> rel="stylesheet" type="text/css" />
  <!-- Icons CSS-->
  <link href=<?php echo (base_url("assets/css/icons.css")); ?> rel="stylesheet" type="text/css" />
  <!-- Sidebar CSS-->
  <link href=<?php echo (base_url("assets/css/sidebar-menu.css")); ?> rel="stylesheet" />
  <!-- Custom Style-->
  <link href=<?php echo (base_url("assets/css/app-style.css")); ?> rel="stylesheet" />
  <!-- notificaciones-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">

  <link href="<?php echo (base_url("assets/css/adminsitrador.css")); ?>" rel="stylesheet" />

  <link href="<?php echo (base_url("assets/css/datatables.css")); ?>" rel="stylesheet" />

  <link href="<?php echo (base_url("assets/css/select2.min.css")); ?>" rel="stylesheet" />
  <script src="<?php echo (base_url("assets/js/select2.min.js")); ?>" defer></script>
  <style>
    .select2-results__option[aria-selected] {
      color: black !important;
    }
  </style>
</head>

<body class="bg-theme bg-theme3">

  <!-- Start wrapper-->
  <div id="wrapper">

    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
      <div class="brand-logo">
        <a href=<?php echo (base_url("Home/index")); ?>>
          <img src=<?php echo (base_url("assets/images/icon.png")); ?> class="logo-icon" alt="logo icon">
          <h5 class="logo-text">Administracion</h5>
        </a>
      </div>
      <ul class="sidebar-menu do-nicescrol">
        <li class="sidebar-header">MENU DE NAVEGACION</li>
        <li>
          <a href=<?php echo (base_url("Home/index")); ?>>
            <i class="zmdi zmdi-view-dashboard"></i> <span>Inicio</span>
          </a>
        </li>
        <li>
          <a href=<?php echo (base_url("Home/unidad")); ?>>
            <i class="zmdi zmdi-format-list-bulleted"></i> <span>Unidades</span>
          </a>
        </li>

        <li>
          <a href=<?php echo (base_url("Home/chofer")); ?>>
            <i class="zmdi zmdi-format-list-bulleted"></i> <span>Choferes</span>
          </a>
        </li>

        <li>
          <a href=<?php echo (base_url("Home/vendedores")); ?>>
            <i class="zmdi zmdi-format-list-bulleted"></i> <span>Vendedores</span>
          </a>
        </li>

        <li>
          <a href=<?php echo (base_url("Home/supervisores")); ?>>
            <i class="zmdi zmdi-format-list-bulleted"></i> <span>Supervisores</span>
          </a>
        </li>

        <li>
          <a href=<?php echo (base_url("Home/venta")); ?>>
            <i class="zmdi zmdi-grid"></i> <span>Ventas

            </span>
          </a>
        </li>
        <li>
          <a href=<?php echo (base_url("Home/Clientes")); ?>>
            <i class="zmdi zmdi-format-list-bulleted"></i> <span>Clientes</span>
          </a>
        </li>
        <li>
          <a href=<?php echo (base_url("Home/Reservaciones")); ?>>
            <i class="zmdi zmdi-format-list-bulleted"></i> <span>Reservaciones</span>
          </a>
        </li>
        <li>
          <a href=<?php echo (base_url("Home/reporte")); ?>>
            <i class="zmdi zmdi-grid"></i> <span>Reportes

            </span>
          </a>
        </li>


      </ul>

    </div>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <header class="topbar-nav">
      <nav class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link toggle-menu" href="javascript:void();">
              <i class="icon-menu menu-icon"></i>
            </a>
          </li>

        </ul>

        <ul class="navbar-nav align-items-center right-nav-link">

          <li class="nav-item">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
              <span class="user-profile"><img src=<?php echo (base_url("assets/images/icon.png")); ?> class="img-circle"
                  alt="user avatar"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li class="dropdown-item user-details">
                <a href="javaScript:void();">
                  <div class="media">
                    <div class="avatar"><img class="align-self-start mr-3" src=<?php echo (base_url("assets/images/icon.png")); ?> alt="user avatar"></div>
                    <div class="media-body">
                      <h6 class="mt-2 user-title"><?php echo ($_SESSION['nombre']); ?></h6>
                      <p class="user-subtitle"><?php echo ($_SESSION['correo']); ?></p>
                    </div>
                  </div>
                </a>
              </li>

              <li class="dropdown-divider"></li>
              <a href=<?php echo (base_url("Home/logout")); ?>>
                <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
              </a>
            </ul>
          </li>
        </ul>
      </nav>
    </header>
    <!--End topbar header-->