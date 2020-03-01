<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
	<a class="navbar-brand mr-1" href="<?php echo $_SESSION['root']; ?>">FOGO Ambassadors</a>
	<button class="btn btn-link btn-sm text-white " id="sidebarToggle" href="#">
		<i class="fas fa-bars"></i>
	</button>
	<!-- Navbar -->
	<?php
	if(isset($_GET['us'])){
		if($_GET['us'] == 'uc'){
	?>
	<div class="col text-center text-warning">
		You need to complete your extra information. <i class="fas fa-arrow-down"></i>
	</div>
	<?php
		}
	}
	?>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-user-circle fa-fw"></i>
				<?php
				if($_SESSION['user_status'] == "Uncompleted"){
						echo '<i class="fas fa-exclamation fa-fw text-danger"></i>';
					}
				?>
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="<?php echo $_SESSION['root']."view/pages/users/info.php"; ?>">
				Profile <?php
				if($_SESSION['user_status'] == "Uncompleted"){
						echo '<i class="fas fa-exclamation fa-fw text-danger"></i>';
					}
				?>
				</a>
				<!--<a class="dropdown-item" href="<?php echo $_SESSION['root']; ?>">My Info</a>-->
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
			</div>
		</li>
	</ul>
</nav>

<style type="text/css">
	.dropdown-toggle{
		transition:all 0.2s ease;
		border-radius:0.25rem;
	}
	.dropdown-toggle:hover, .dropdown-toggle:focus{
		background-color:rgba(200,200,200,0.3);
	}
</style>