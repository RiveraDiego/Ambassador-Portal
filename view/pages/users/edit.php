<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("location: {$_SESSION['root']}view/pages/login.php");
}

if($_SESSION['id_rol'] != 1){
	header("location: {$_SESSION['root']}");
}
spl_autoload_register(function ($clase) {
	require_once ('../../../model/' . $clase . '.php');
});
$menu = "users";

if(isset($_GET['id'])){
	$user = new User();
	$user->setId($_GET['id']);
	$data = $user->get();
	$rol = new Rol();
	$roles = $rol->list();
}else{
	header("location: {$_SESSION['root']}view/pages/users/");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../templates/header.php'?>
</head>
<body id="page-top">
  <?php include '../templates/nav.php'?>
  <div id="wrapper">
	<?php include '../templates/sidebar.php'?>

	<div id="content-wrapper">
	  <div class="container-fluid">
		<!-- Page Content -->
		<h1>Edit <?php echo $data['name'].' '.$data["last_name"] ?></h1>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<form action="<?php echo $_SESSION['root'].'controller/users_controller.php'; ?>" method="POST">
					<input type="hidden" name="opt" class="form-control" value="edit">
					<input type="hidden" name="id_user" class="form-control" value="<?php echo $data['id']; ?>">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" value="<?php echo $data['name']; ?>" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Name">
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" name="last_name" class="form-control" value="<?php echo $data['last_name']; ?>" id="last_name" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Last Name">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" id="email" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Email">
					</div>
					<?php if($data['id'] != $_SESSION['user_id']){ ?>
					<div class="form-group">
						<label for="password">Rol</label>
						<select name="id_rol" class="form-control">
							<?php
							$roles_names = [1=>"Administrator", 2=>"Ambassador"];
							foreach($roles as $rol){
								if($rol['id'] == $data["id_rol"]){
									echo "<option value='{$rol['id']}' selected='true'>{$rol['name']}</option>";
								}else{
									echo "<option value='{$rol['id']}'>{$rol['name']}</option>";
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="password">Status</label>
						<select name="status" class="form-control">
							<?php
							if($data["id_rol"] == 1){
								$status = ["Active", "Suspended"];
							}else{
								$status = ["Active", "Suspended", "Uncompleted"];
							}
								
									foreach ($status as $row){
										if($row == $data['status']){
											echo "<option value='{$row}' selected='true'>{$row}</option>";
										}else{
											echo "<option value='{$row}'>{$row}</option>";
										}
									}
								?>
						</select>
					</div>
				<?php } ?>
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
		</div>

	  </div>
	  <!-- /.container-fluid -->

	  <?php include '../templates/footer.php'?>

	</div>
	<!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <?php include '../templates/scripts.php'?>
  <script type="text/javascript">
  	$(document).ready(function(){
  		
  	});
  </script>
</body>
</html>
