<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("location: {$_SESSION['root']}view/pages/login.php");
}

spl_autoload_register(function ($clase) {
	require_once ('../../../model/' . $clase . '.php');
});
$menu = "users";

$user = new User();
$user->setId($_SESSION['user_id']);
$data = $user->get();
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
				<h1>My Info - <small> <?php echo $data['name'].' '.$data["last_name"] ?></small></h1>
				<hr>
				<?php 
				if(isset($_GET['msg'])){
					if($_GET['msg'] == "success"){
				?>
				<div class="col-xs-12">
					<div class="alert alert-success" role="alert">
						Your info has been updated successfully.
						<a href="<?php echo $_SESSION['root'].'view/pages/users/info.php'; ?>" class="btn close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</a>
					</div>
				</div>
				<?php
				}
				if($_GET['msg'] == "error"){
				?>
				<div class="col-xs-12">
					<div class="alert alert-danger" role="alert">
						An unexpected error has occurred.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
				<?php
					}
					if($_GET['msg'] == "sue"){
				?>
				<div class="col-xs-12">
					<div class="alert alert-success" role="alert">
						Your extra info has been updated successfully.
						<a href="<?php echo $_SESSION['root'].'view/pages/users/info.php'; ?>" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</a>
					</div>
				</div>
				<?php
					}
				}
				?>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<form action="<?php echo $_SESSION['root'].'controller/users_controller.php'; ?>" autocomplete="off" method="POST">
							<input type="hidden" name="opt" class="form-control" value="edit_info">
							<input type="hidden" name="id_user" class="form-control" value="<?php echo $data['id']; ?>">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" id="name" value="<?php echo $data['name']; ?>" aria-describedby="titleHelp"  placeholder="Enter Name">
							</div>
							<div class="form-group">
								<label for="last_name">Last Name</label>
								<input type="text" name="last_name" class="form-control" value="<?php echo $data['last_name']; ?>" id="last_name" placeholder="Enter Last Name">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" autocomplete="off" id="email" placeholder="Enter Email">
							</div>
							<div class="form-group">
								<label for="password">Password <strong>••••••••••</strong></label>
							</div>
							<div class="form-group">
								<label for="password">New Password</label>
								<input type="password" name="password" class="form-control" id="password" autocomplete="off" placeholder="Enter New Password">
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
						</form>
					</div>
					<?php if($data["id_rol"] != "1"){ ?>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<h2>Extra Info</h2>
						<form action="<?php echo $_SESSION['root'].'controller/users_controller.php' ?>" method="POST" autocomplete="off">
							<input type="hidden" name="opt" value="edit_other_info" class="form-control" required="true">
							<input type="hidden" name="id_user" class="form-control" value="<?php echo $data['id']; ?>" required="true">
							<input type="hidden" name="blog_url" class="form-control" value="<?php echo $data['blog_url']; ?>">
							<input type="hidden" name="handle_blog" class="form-control" value="<?php echo $data['handle_blog']; ?>">
							<input type="hidden" name="handle_article" class="form-control" value="<?php echo $data['handle_article']; ?>">
							<input type="hidden" value="years" name="experience_timeframe" class="form-control" required="true">
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="known_as">Known as</label>
										<input type="text" name="known_as" class="form-control" id="known_as" required="true" value="<?php echo $data['known_as']; ?>" placeholder="Enter your nickname">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="age">Age</label>
										<input type="number" name="age" class="form-control" id="age" min="1" required="true" value="<?php echo $data['age']; ?>" placeholder="Enter your age">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="region">Region</label>
										<input type="text" name="region" class="form-control" id="region" required="true" value="<?php echo $data['region']; ?>" placeholder="Enter your region">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="signature_dish_name">Signature Dish</label>
										<input type="text" name="signature_dish_name" class="form-control" required="true" id="signature_dish_name" value="<?php echo $data['signature_dish_name']; ?>" placeholder="Enter your signature dish name">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="signature_dish_link">Link of your recipe</label>
										<input type="url" name="signature_dish_link" class="form-control" required="true" id="signature_dish_link" value="<?php echo $data['signature_dish_link']; ?>" placeholder="Enter link for signature dish recipe">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-row">
										<div class="col">
											<label for="experience_number">Years of grilling</label>
											<input type="number" name="experience_number" min="1" class="form-control" required="true" id="experience_number" value="<?php echo $data['experience_number']; ?>" placeholder="Enter quantity of years grilling">
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="grill_of_choice">Grill of choice</label>
										<input type="text" name="grill_of_choice" class="form-control" id="grill_of_choice" required="true" value="<?php echo $data['grill_of_choice']; ?>" placeholder="Enter grill of choice">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="biggest_inspiration">Biggest Inspiration</label>
										<input type="text" name="biggest_inspiration" class="form-control" required="true" id="biggest_inspiration" value="<?php echo $data['biggest_inspiration']; ?>" placeholder="Enter the biggest inspiration">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="equipment_preferred">Equipment Preferred</label>
										<input type="text" name="equipment_preferred" class="form-control" required="true" id="equipment_preferred" value="<?php echo $data['equipment_preferred']; ?>" placeholder="Enter the equipment preferred">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="instagram_link">Instagram Link</label>
										<input type="url" name="instagram_link" class="form-control" required="true" id="instagram_link" value="<?php echo $data['instagram_link']; ?>" placeholder="Enter the instagram link">
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="twitter_link">Twitter Link</label>
										<input type="url" name="twitter_link" class="form-control" required="true" id="twitter_link" value="<?php echo $data['twitter_link']; ?>" placeholder="Enter the twitter link">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="facebook_link">Facebook Link</label>
										<input type="url" name="facebook_link" class="form-control" required="true" id="facebook_link" value="<?php echo $data['facebook_link']; ?>" placeholder="Enter the facebook link">
									</div>
								</div>
							</div>
							<div class="form-row">
								<?php
									if($data['featured_image'] == "" || $_SESSION['user_status'] == "Uncompleted"){
								?>
								<div class="col-md-6">
									<div class="form-group">
										<label for="image">Featured Image</label>
										<br>
										<input type="file" data-input="false" id="image" accept='image/*' class="cropit-image-input" name="image" aria-describedby="featured_image">
										<small id="emailHelp" class="form-text text-muted">Resolution of images: 4133 x 2755px.</small>
									</div>
								</div>
								<?php
									}
								?>
								<div class="col-md-6">
								<?php
								if($data['featured_image'] == ""){
								?>
								<img src="<?php echo $_SESSION['root'].'view/files/no-image.png'; ?>" id="featured_image_preview" class="img-fluid" alt="Preview Image">
								<?php
								}else{
								?>
									<img src="<?php echo "data:image/jpeg;base64,".$data["featured_image"]; ?>" class="img-fluid" id="featured_image_preview">
								<?php
								}
								?>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<div class=" form-group">
										<input type="hidden" class="form-control"  name="featured_image" id="featured_image" value="<?php echo $data["featured_image"]; ?>" />
									</div>
								</div>
							</div>
							<?php
							if($_SESSION['user_status'] == "Uncompleted"){
							?>
							<div class="form-group text-right">
								<button type="submit" class="btn btn-info btn-lg btn-block">Save</button>
							</div>
							<?php
							}
							?>
						</form>
					</div>
					<?php } ?>
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
			$("#image").jfilestyle({
				dragdrop: true,
				input: false,
				text: "Upload Image",
				theme: 'asphalt',
				onChange: function(files){
					var file = files[0];
					var reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onloadend = function(e){
						//console.log(file);
						$("#preview_image").attr("src",reader.result);

						$("#img_ext").val(file.name);
						
						var img = new Image();
						img.crossOrigin = 'Anonymous';
						img.src = reader.result;

						//The magic begins after the image is successfully loaded
						img.onload = function(){
							var canvas = document.createElement('canvas');
							ctx = canvas.getContext('2d');

							canvas.height = img.naturalHeight;
							canvas.width = img.naturalWidth;
							ctx.drawImage(img, 0, 0);

							// Unfortunately, we cannot keep the original image type, so all images will be converted to PNG
							// For this reason, we cannot get the original Base64 string
							var uri = canvas.toDataURL('image/jpeg');
							console.log(uri);
							b64 = uri.replace(/^data:image.+;base64,/,'');
							$("#featured_image").val(b64);
							$("#featured_image_preview").attr("src",uri);
						}
					}
				}
			});
		});
	</script>
</body>
</html>