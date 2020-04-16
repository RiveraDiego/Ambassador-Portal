<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("location: view/pages/login.php");
}
spl_autoload_register(function ($clase) {
	require_once ('../../../model/' . $clase . '.php');
});
$menu = "NewPost";
if($_SESSION['user_status'] == "Uncompleted"){
	header("location: {$_SESSION['root']}view/pages/users/info.php?us=uc");
}
$user = new User();
$user->setId($_SESSION['user_id']);
$userdata = $user->get();
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
		<h1>New Article</h1>
		<hr>
		<div class="row">
			<div class="col-md-8">
				<form action="<?php echo $_SESSION['root'].'controller/articles_controller.php'; ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="opt" value="new">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" id="title" aria-describedby="titleHelp" autofocus="on" required="true" title="Please set a title for your post" placeholder="Enter Title">
					</div>
					<div class="form-group">
						<label for="image">Featured Image</label>
						<br>
						<input type="file" data-input="false" id="image" name="image" aria-describedby="featured_image">
						<small id="emailHelp" class="form-text text-muted">Resolution of images: 4133 x 2755px.</small>
					</div>
					<div class="form-group">
						<label for="content">Content</label>
						<textarea class="form-control" name="content" id="content" rows="10"></textarea>
					</div>
					<div class="form-group col-3" style="padding-right:0 !important;padding-left:0 !important;">
						<label for="tags">Tag</label>
						<select name="tags" class="form-control" pattern="Read Meat|Poultry" required="true">
							<option value="">Select...</option>
							<option value="Read Meat">Read Meat</option>
							<option value="Poultry">Poultry</option>
							<option value="Pork">Pork</option>
							<option value="Seafood">Seafood</option>
							<option value="Vegetables">Vegetables</option>
							<option value="Appetizer">Appetizer</option>
							<option value="Side Dish">Side Dish</option>
							<option value="Dessert">Dessert</option>
						</select>
					</div>
					<div class="d-none form-group">
						<label for="featured_image">Featured Image</label>
						<textarea class="form-control" rows="5" name="featured_image" id="featured_image"></textarea>
					</div>
					<input type="hidden" name="author" value="<?php echo $_SESSION['user_name']; ?>">
					<input type="hidden" name="blog_id" value="<?php echo $userdata['handle_blog']; ?>">
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
			<div class="col-md-4">
				<img src="<?php echo $_SESSION['root'].'view/files/no-image.png'; ?>" id="preview_image" class="img-fluid" alt="Preview Image">
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
  		$("#content").summernote({
  			placeholder: "Article's body",
			height: 250
  		});
  		
  		$("#image").jfilestyle({
  			dragdrop: true,
  			input: false,
  			text: "Upload image",
  			theme: 'asphalt',
			onChange: function(files) {
				var file = files[0];
				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onloadend = function (e) {
					//console.log(file);
					$("#preview_image").attr("src",reader.result);
					
					$("#img_ext").val(file.name);


					var img = new Image();
					img.crossOrigin = 'Anonymous';
					img.src= reader.result;
				
					// The magic begins after the image is successfully loaded
					img.onload = function () {
						var canvas = document.createElement('canvas'),
					    ctx = canvas.getContext('2d');

						canvas.height = img.naturalHeight;
						canvas.width = img.naturalWidth;
						ctx.drawImage(img, 0, 0);

						// Unfortunately, we cannot keep the original image type, so all images will be converted to PNG
						// For this reason, we cannot get the original Base64 string
						var uri = canvas.toDataURL('image/jpeg'),
						b64 = uri.replace(/^data:image.+;base64,/, '');
						$("#featured_image").val(b64);
					}
				}
			}
		});
  	});
  </script>
</body>
</html>
