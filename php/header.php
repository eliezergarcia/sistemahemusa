	
<header class="be-wrapper be-fixed-sidebar be-color-header">
	<nav class="navbar navbar-expand fixed-top be-top-header">
	    <div class="container-fluid">
	      <div class="be-navbar-header"><a href="<?php echo $ruta;?>php/inicio/inicio.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $ruta; ?>media/images/logo_hemusa.png" alt="logo" width="150" height="60" class="logo-img"></a>
	      </div>
	      <div class="be-right-navbar">
	        <ul class="nav navbar-nav float-right be-user-nav">
	          <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><img src="<?php echo $ruta; ?>assets/img/eliezerhernandez.jpg" alt="Avatar"><span class="user-name"><?php echo $usuario." ".$usuarioApellido; ?></span></a>
	            <div role="menu" class="dropdown-menu">     
	              <div class="user-info">
	                <div class="user-name"><?php echo $usuario." ".$usuarioApellido; ?></div>
	                <div class="user-position online">Disponible</div>
	              </div>
	              	<a href="pages-profile.html" class="dropdown-item"><span class="icon mdi mdi-face"></span> Cuenta</a>
	              	<a href="#" class="dropdown-item"><span class="icon mdi mdi-settings"></span> Configuración</a>
	              	<a href="<?php echo $logoutGoTo; ?>" class="dropdown-item"><span class="icon mdi mdi-power"></span> Cerrar sesión</a>
	            </div>
	          </li>
	        </ul>
	        <!-- <div class="page-title"><span>Dashboard</span></div> -->
	        <ul class="nav navbar-nav float-right be-icons-nav">
	          <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="icon mdi mdi-notifications"></span><span class="indicator"></span></a>
	            <ul class="dropdown-menu be-notifications">
	              <li>
	                <div class="title">Notificaciones<span class="badge badge-pill">3</span></div>
	                <div class="list">
	                  <div class="be-scroller">
	                    <div class="content">
	                      <ul>
	                        <li class="notification notification-unread"><a href="#">
	                            <div class="image"><img src="<?php echo $ruta; ?>assets/img/avatar2.png" alt="Avatar"></div>
	                            <div class="notification-info">
	                              <div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation to join the team.</div><span class="date">2 min ago</span>
	                            </div></a></li>
	                        <li class="notification"><a href="#">
	                            <div class="image"><img src="<?php echo $ruta; ?>assets/img/avatar3.png" alt="Avatar"></div>
	                            <div class="notification-info">
	                              <div class="text"><span class="user-name">Joel King</span> is now following you</div><span class="date">2 days ago</span>
	                            </div></a></li>
	                        <li class="notification"><a href="#">
	                            <div class="image"><img src="<?php echo $ruta; ?>assets/img/avatar4.png" alt="Avatar"></div>
	                            <div class="notification-info">
	                              <div class="text"><span class="user-name">John Doe</span> is watching your main repository</div><span class="date">2 days ago</span>
	                            </div></a></li>
	                        <li class="notification"><a href="#">
	                            <div class="image"><img src="<?php echo $ruta; ?>assets/img/avatar5.png" alt="Avatar"></div>
	                            <div class="notification-info"><span class="text"><span class="user-name">Emily Carter</span> is now following you</span><span class="date">5 days ago</span></div></a></li>
	                      </ul>
	                    </div>
	                  </div>
	                </div>
	                <div class="footer"> <a href="#">Ver todas las notificaciones</a></div>
	              </li>
	            </ul>
	          </li>
	          <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="icon mdi mdi-apps"></span></a>
	            <ul class="dropdown-menu be-connections">
	              <li>
	                <div class="list">
	                  <div class="content">
	                    <div class="row">
	                      <div class="col"><a href="#" class="connection-item"><img src="<?php echo $ruta;?>assets/img/github.png" alt="Github"><span>GitHub</span></a></div>
	                      <div class="col"><a href="#" class="connection-item"><img src="<?php echo $ruta;?>assets/img/bitbucket.png" alt="Bitbucket"><span>Bitbucket</span></a></div>
	                      <div class="col"><a href="#" class="connection-item"><img src="<?php echo $ruta;?>assets/img/slack.png" alt="Slack"><span>Slack</span></a></div>
	                    </div>
	                    <div class="row">
	                      <div class="col"><a href="#" class="connection-item"><img src="<?php echo $ruta;?>assets/img/dribbble.png" alt="Dribbble"><span>Dribbble</span></a></div>
	                      <div class="col"><a href="#" class="connection-item"><img src="<?php echo $ruta;?>assets/img/mail_chimp.png" alt="Mail Chimp"><span>Mail Chimp</span></a></div>
	                      <div class="col"><a href="#" class="connection-item"><img src="<?php echo $ruta;?>assets/img/dropbox.png" alt="Dropbox"><span>Dropbox</span></a></div>
	                    </div>
	                  </div>
	                </div>
	                <div class="footer"> <a href="#">Más</a></div>
	              </li>
	            </ul>
	          </li>
	           <li class="nav-item dropdown"><a href="#" role="button" aria-expanded="false" class="nav-link be-toggle-right-sidebar"><span class="icon mdi mdi-settings"></span></a></li>
	        </ul>
	      </div>
	    </div>
	</nav>
	<div class="be-left-sidebar">
	    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Menú</a>
	      <div class="left-sidebar-spacer">
	        <div class="left-sidebar-scroll">
	          <div class="left-sidebar-content">
	            <ul class="sidebar-elements">
	              <li class="divider">Menu</li>
	              <li class=""><a href="<?php echo $ruta; ?>php/inicio/inicio.php"><i class="icon mdi mdi-home"></i><span>Inicio</span></a>
	              </li>
	              <li class="parent"><a href="#"><i class="icon mdi mdi-money-box"></i><span>Ventas</span></a>
                    <ul class="sub-menu">
                      <li><a href="<?php echo $ruta; ?>php/ventas/clientes/clientes.php">Clientes</a>
                      </li>
                      <li><a href="<?php echo $ruta; ?>php/ventas/listadeprecios/listadeprecios.php">Lista de precios</a>
                      </li>
                      <li><a href="<?php echo $ruta; ?>php/ventas/cotizaciones/cotizaciones.php">Cotizaciones</a>
                      </li>
                      <li><a href="<?php echo $ruta; ?>php/ventas/pedidos/pedidos.php">Pedidos</a>
                      </li>
                    </ul>
                  </li>
	              <li class="parent"><a href="#"><i class="icon mdi mdi-lock"></i><span>Administración</span></a>
                    <ul class="sub-menu">
                      <li><a href="<?php echo $ruta; ?>php/administracion/usuarios/usuarios.php">Usuarios</a>
                      </li>
                      <li><a href="<?php echo $ruta; ?>php/administracion/marcas/marcas.php">Marcas</a>
                      </li>
                    </ul>
                  </li>	              
	              <li class="divider">Features</li>
	              <li class="parent"><a href="#"><i class="icon mdi mdi-inbox"></i><span>Email</span></a>
	                <ul class="sub-menu">
	                  <li><a href="email-inbox.html">Inbox</a>
	                  </li>
	                  <li><a href="email-read.html">Email Detail</a>
	                  </li>
	                  <li><a href="email-compose.html">Email Compose</a>
	                  </li>
	                </ul>
	              </li>
	              <li class="parent"><a href="#"><i class="icon mdi mdi-view-web"></i><span>Layouts</span></a>
	                <ul class="sub-menu">
	                  <li><a href="layouts-primary-header.html">Primary Header</a>
	                  </li>
	                  <li><a href="layouts-success-header.html">Success Header</a>
	                  </li>
	                  <li><a href="layouts-warning-header.html">Warning Header</a>
	                  </li>
	                  <li><a href="layouts-danger-header.html">Danger Header</a>
	                  </li>
	                  <li><a href="layouts-search-input.html"><span class="badge badge-primary float-right">New</span>Search Input</a>
	                  </li>
	                  <li><a href="layouts-offcanvas-menu.html"><span class="badge badge-primary float-right">New</span>Off Canvas Menu</a>
	                  </li>
	                  <li><a href="layouts-nosidebar-left.html">Without Left Sidebar</a>
	                  </li>
	                  <li><a href="layouts-nosidebar-right.html">Without Right Sidebar</a>
	                  </li>
	                  <li><a href="layouts-nosidebars.html">Without Both Sidebars</a>
	                  </li>
	                  <li><a href="layouts-fixed-sidebar.html">Fixed Left Sidebar</a>
	                  </li>
	                  <li><a href="layouts-boxed-layout.html"><span class="badge badge-primary float-right">New</span>Boxed Layout</a>
	                  </li>
	                  <li><a href="pages-blank-aside.html">Page Aside</a>
	                  </li>
	                  <li><a href="layouts-collapsible-sidebar.html">Collapsible Sidebar</a>
	                  </li>
	                  <li><a href="layouts-sub-navigation.html"><span class="badge badge-primary float-right">New</span>Sub Navigation</a>
	                  </li>
	                </ul>
	              </li>
	              <li class="parent"><a href="#"><i class="icon mdi mdi-pin"></i><span>Maps</span></a>
	                <ul class="sub-menu">
	                  <li><a href="maps-google.html">Google Maps</a>
	                  </li>
	                  <li><a href="maps-vector.html">Vector Maps</a>
	                  </li>
	                </ul>
	              </li>
	              <li class="parent"><a href="#"><i class="icon mdi mdi-folder"></i><span>Menu Levels</span></a>
	                <ul class="sub-menu">
	                  <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 1</span></a>
	                    <ul class="sub-menu">
	                      <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
	                      </li>
	                      <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
	                        <ul class="sub-menu">
	                          <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
	                          </li>
	                          <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
	                          </li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </li>
	                  <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 1</span></a>
	                    <ul class="sub-menu">
	                      <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
	                      </li>
	                      <li class="parent"><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 2</span></a>
	                        <ul class="sub-menu">
	                          <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
	                          </li>
	                          <li><a href="#"><i class="icon mdi mdi-undefined"></i><span>Level 3</span></a>
	                          </li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </li>
	                </ul>
	              </li>
	            </ul>
	          </div>
	        </div>
	      </div>
	      <div class="progress-widget">
	        <div class="progress-data"><span class="progress-value">60%</span><span class="name">Current Project</span></div>
	        <div class="progress">
	          <div style="width: 60%;" class="progress-bar progress-bar-primary"></div>
	        </div>
	      </div>
	    </div>
    </div>
