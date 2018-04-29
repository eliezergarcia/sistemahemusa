	
<header class="mdl-layout__header">
	<nav class="navbar navbar-expand fixed-top be-top-header">
	    <div class="container-fluid">
	      <div class="be-navbar-header"><a href="<?php echo $ruta;?>php/inicio/inicio.php" class=""><img src="<?php echo $ruta; ?>media/images/logo_hemusa.png" alt="logo" width="140" height="60" class="logo-img"></a>
	      </div>
	      <div class="be-right-navbar">
	        <ul class="nav navbar-nav float-right be-user-nav">
	          <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><img src="<?php echo $ruta; ?>assets/img/avatar.png" alt="Avatar"><span class="user-name"><?php echo $usuario." ".$usuarioApellido; ?></span></a>
	            <div role="menu" class="dropdown-menu">     
	              <div class="user-info">
	                <div class="user-name"><?php echo $usuario." ".$usuarioApellido; ?></div>
	                <div class="user-position online">Disponible</div>
	              </div><a href="pages-profile.html" class="dropdown-item"><span class="icon mdi mdi-face"></span> Cuenta</a><a href="#" class="dropdown-item"><span class="icon mdi mdi-settings"></span> Configuración</a><a href="<?php echo $logoutGoTo; ?>" class="dropdown-item"><span class="icon mdi mdi-power"></span> Cerrar sesión</a>
	            </div>
	          </li>
	        </ul>
	        <!-- <div class="page-title"><span>Dashboard</span></div> -->
	        <ul class="nav navbar-nav float-right be-icons-nav">
	          <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="icon mdi mdi-notifications"></span><span class="indicator"></span></a>
	            <ul class="dropdown-menu be-notifications">
	              <li>
	                <div class="title">Notifications<span class="badge badge-pill">3</span></div>
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
	                <div class="footer"> <a href="#">View all notifications</a></div>
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
	                <div class="footer"> <a href="#">More</a></div>
	              </li>
	            </ul>
	          </li>
	           <li class="nav-item dropdown"><a href="#" role="button" aria-expanded="false" class="nav-link be-toggle-right-sidebar"><span class="icon mdi mdi-settings"></span></a></li>
	        </ul>
	      </div>
	    </div>
	</nav>
</header>  	