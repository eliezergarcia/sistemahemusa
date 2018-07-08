<?php
	require_once('../conexion.php');
	require_once('../sesion.php');
	error_reporting(0);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Usuarios</title>
	<?php include('../enlacescss.php'); ?>
</head>
<body>
	<?php include('../header.php'); ?>
  <div class="be-content be-no-padding">
    <aside class="page-aside">
      <div class="be-scroller">
        <div class="aside-content">
          <div class="content">
            <div class="aside-header">
              <button data-target=".aside-nav" data-toggle="collapse" type="button" class="navbar-toggle"><span class="icon mdi mdi-caret-down"></span></button><span class="title">Servicio de Email</span>
              <p class="description">Descripción de servicio</p>
            </div>
          </div>
          <div class="aside-nav collapse">
            <ul class="nav">
              <li><a href="#"><i class="icon fas fa-inbox"></i> Recibidos<span class="badge badge-primary float-right">8</span></a></li>
              <li class="active"><a href="#"><i class="icon fas fa-paper-plane"></i> Enviados</a></li>
              <li><a href="#"><i class="icon fas fa-file"></i> <span class="badge badge-secondary float-right">4</span>Borradores</a></li>
              <li><a href="#"><i class="icon fas fa-tags"></i> Categorías</a></li>
              <li><a href="#"><i class="icon fas fa-trash"></i> Papelera</a></li>
            </ul>
            <div class="aside-compose"><a href="#" class="btn btn-lg btn-primary btn-block"><i class="fas fa-envelope"></i> Redactar Email</a></div>
          </div>
        </div>
      </div>
    </aside>
    <!-- <div class="main-content container-fluid"> -->
      <!-- <div class="email-inbox-header"> -->
        <!-- <div class="row">
          <div class="col-lg-6">
            <div class="email-title"><span class="icon mdi mdi-inbox"></span> Inbox <span class="new-messages">(2 new messages)</span>  </div>
          </div>
          <div class="col-lg-6">
            <div class="email-search">
              <div class="input-group input-search input-group-sm">
                <input type="text" placeholder="Search mail..." class="form-control"><span class="input-group-btn">
                <button type="button" class="btn btn-secondary"><i class="icon mdi mdi-search"></i></button></span>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- <div class="email-filters"> -->
        <!-- <div class="email-filters-left">
          <label class="custom-control custom-checkbox be-select-all">
            <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
          </label>
          <div class="btn-group">
            <button data-toggle="dropdown" type="button" class="btn btn-secondary dropdown-toggle"> With selected <span class="caret"></span></button>
            <div role="menu" class="dropdown-menu"><a href="#" class="dropdown-item">Mark as rea</a><a href="#" class="dropdown-item">Mark as unread</a><a href="#" class="dropdown-item">Spam</a>
              <div class="dropdown-divider"></div><a href="#" class="dropdown-item">Delete</a>
            </div>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-secondary">Archive</button>
            <button type="button" class="btn btn-secondary">Span</button>
            <button type="button" class="btn btn-secondary">Delete</button>
          </div>
          <div class="btn-group">
            <button data-toggle="dropdown" type="button" class="btn btn-secondary dropdown-toggle">Order by <span class="caret"></span></button>
            <div role="menu" class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item">Date</a><a href="#" class="dropdown-item">From</a><a href="#" class="dropdown-item">Subject</a>
              <div class="dropdown-divider"></div><a href="#" class="dropdown-item">Size</a>
            </div>
          </div>
        </div>
        <div class="email-filters-right"><span class="email-pagination-indicator">1-50 of 253</span>
          <div class="btn-group email-pagination-nav">
            <button type="button" class="btn btn-secondary"><i class="mdi mdi-chevron-left"></i></button>
            <button type="button" class="btn btn-secondary"><i class="mdi mdi-chevron-right"></i></button>
          </div>
        </div>
      </div> -->
      <!-- <div class="email-list"> -->
        <!-- <div class="email-list-item email-list-item--unread">
          <div class="email-list-actions">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
            </label><a href="#" class="favorite active"><span class="mdi mdi-star"></span></a>
          </div>
          <div class="email-list-detail"><span class="date float-right"><i class="icon mdi mdi-attachment-alt"></i> 28 Jul</span><span class="from">Penelope Thornton</span>
            <p class="msg">Urgent - You forgot your keys in the class room, please come imediatly!</p>
          </div>
        </div>
        <div class="email-list-item email-list-item--unread">
          <div class="email-list-actions">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
            </label><a href="#" class="favorite"><span class="mdi mdi-star"></span></a>
          </div>
          <div class="email-list-detail"><span class="date float-right"></span><span class="date float-right"><i class="icon mdi mdi-attachment-alt"></i> 13 Jul</span><span class="from">Benji Harper</span>
            <p class="msg">Urgent - You forgot your keys in the class room, please come imediatly!</p>
          </div>
        </div>
        <div class="email-list-item">
          <div class="email-list-actions">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
            </label><a href="#" class="favorite"><span class="mdi mdi-star"></span></a>
          </div>
          <div class="email-list-detail"><span class="date float-right">23 Jun</span><span class="from">Justine Myranda</span>
            <p class="msg">Urgent - You forgot your keys in the class room, please come imediatly!</p>
          </div>
        </div>
        <div class="email-list-item">
          <div class="email-list-actions">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
            </label><a href="#" class="favorite"><span class="mdi mdi-star"></span></a>
          </div>
          <div class="email-list-detail"><span class="date float-right">17 May</span><span class="from">John Doe</span>
            <p class="msg">Urgent - You forgot your keys in the class room, please come imediatly!</p>
          </div>
        </div>
        <div class="email-list-item">
          <div class="email-list-actions">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
            </label><a href="#" class="favorite"><span class="mdi mdi-star"></span></a>
          </div>
          <div class="email-list-detail"><span class="date float-right">16 May</span><span class="from">Sherwood Clifford</span>
            <p class="msg">Urgent - You forgot your keys in the class room, please come imediatly!</p>
          </div>
        </div>
        <div class="email-list-item">
          <div class="email-list-actions">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
            </label><a href="#" class="favorite"><span class="mdi mdi-star"></span></a>
          </div>
          <div class="email-list-detail"><span class="date float-right">12 May</span><span class="from">Kristopher Donny</span>
            <p class="msg">Urgent - You forgot your keys in the class room, please come imediatly!</p>
          </div>
        </div>
      </div> -->
    <!-- </div> -->
  </div>
  <header>
  <?php include('../enlacesjs.php'); ?>
	<script>
		$(document).ready(function(){
			App.init();
    	App.mailInbox();
		});
	</script>
</body>
</html>
