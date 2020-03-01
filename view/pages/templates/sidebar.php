<!-- Sidebar -->
<ul class="sidebar navbar-nav">
	<li class="nav-item <?php if($menu == 'Dashboard'){ ?> active <?php } ?>">
		<a class="nav-link" href="<?php echo $_SESSION['root']; ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span>
		</a>
	</li>
	<!--
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-fw fa-folder"></i>
			<span>Pages</span>
		</a>
		<div class="dropdown-menu" aria-labelledby="pagesDropdown">
			<h6 class="dropdown-header">Login Screens:</h6>
			<a class="dropdown-item" href="login.html">Login</a>
			<a class="dropdown-item" href="register.html">Register</a>
			<a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
			<div class="dropdown-divider"></div>
			<h6 class="dropdown-header">Other Pages:</h6>
			<a class="dropdown-item" href="404.html">404 Page</a>
			<a class="dropdown-item" href="blank.html">Blank Page</a>
		</div>
	</li>
	-->
	<li class="nav-item <?php if($menu == 'NewPost'){ ?> active <?php } ?>">
		<a class="nav-link" href="<?php echo $_SESSION['root'].'view/pages/articles/new.php'; ?>">
			<i class="fas fa-fw fa-plus"></i>
			<span>New Article</span>
		</a>
	</li>
	<?php if($_SESSION['id_rol'] == 1){ ?>
		<li class="nav-item <?php if($menu == 'users'){ ?> active <?php } ?>">
		<a class="nav-link" href="<?php echo $_SESSION['root'].'view/pages/users/'; ?>">
			<i class="fas fa-fw fa-users"></i>
			<span>Users</span>
		</a>
	</li>
	<?php } ?>
	
</ul>