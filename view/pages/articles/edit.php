<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("location: {$_SESSION['root']}view/pages/login.php");
}

spl_autoload_register(function ($clase) {
	require_once ('../../../model/' . $clase . '.php');
});
$menu = "NewPost";
if(isset($_GET['id'])){
	$article = new Article();
	$article->setShopifyPostId($_GET['id']);
	$data = $article->get();
	if($data == false){
		header("location: {$_SESSION['root']}");
	}else{
		if($_SESSION['id_rol'] != 1){
			if($_SESSION['user_id'] != $data['user_id']){
				header("location: {$_SESSION['root']}");
			}
		}
		$user = new User();
		$user->setId($_SESSION['user_id']);
		$userdata = $user->get();
	}
}else{
	header("location: {$_SESSION['root']}");
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
		<h1>Edit <?php echo $data['title']?></h1>
		<hr>
		<?php
		if(isset($_GET['msg'])){
			if($_GET['msg'] == "success"){
		?>
		<div class="col-xs-12">
			<div class="alert alert-success" role="alert">
				The article has been updated successfully.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button>
			</div>
		</div>
		<?php
			}
			if($_GET['msg'] == "new"){
		?>
		<div class="col-xs-12">
			<div class="alert alert-success" role="alert">
				The article has been created successfully.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button>
			</div>
		</div>
		<?php
			}
		}
		?>
		<div class="row">
			<div class="col-md-8">
				<form action="<?php echo $_SESSION['root'].'controller/articles_controller.php'; ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="opt" value="edit">
					<input type="hidden" name="shopify_post_id" value="<?php echo $data['shopify_post_id'] ?>">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" id="title" value="<?php echo $data["title"]; ?>" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Title">
					</div>
					<div class="form-group">
						<label for="image">Featured Image</label>
						<br>
						<input type="file" data-input="false" id="image" name="image" aria-describedby="featued_image">
						<small id="emailHelp" class="form-text text-muted">Resolution of images: 4133 x 2755px.</small>
					</div>
					<div class="form-group">
						<label for="content">Content</label>
						<textarea class="form-control" name="content" id="content" rows="10"><?php echo $data["content"]; ?></textarea>
					</div>
					<div class="form-group col-3" style="padding-right:0 !important;padding-left:0 !important;">
						<label for="tags">Tag</label>
						<select name="tags" class="form-control" required="true">
							<option value="">Select...</option>
							<?php
							$tags_list = ["Read Meat","Poultry","Pork","Seafood","Vegetables","Appetizer","Side Dish","Dessert"];
							foreach ($tags_list as $tag){
								if($tag == $data["tags"]){
									echo '<option value="'.$tag.'" selected="">'.$tag.'</option>';
								}else{
									echo '<option value="'.$tag.'">'.$tag.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="d-none form-group">
						<label for="featured_image">Featured Image</label>
						<textarea class="form-control" rows="5" name="featured_image" id="featured_image"></textarea>
					</div>
					<input type="hidden" name="author" value="<?php echo $data['author']; ?>">
					<input type="hidden" name="blog_id" value="<?php echo $userdata['handle_blog']; ?>">
					<button type="submit" class="btn btn-primary">Save Post</button>
					<button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#deletePost">
						Delete Post
					</button>
				</form>
			</div>
			<div class="col-md-4">
				<img src="<?php echo $data['featured_image']; ?>" id="preview_image" class="img-fluid" alt="Preview Image">
			</div>
		</div>
	  </div>
	  <!-- /.container-fluid -->
	  <!-- Delete Post Modal -->
		<div class="modal fade" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        Are you sure?
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <a href="<?php echo $_SESSION['root'].'controller/articles_controller.php?opt=delete&post='.$data['shopify_post_id']; ?>" class="btn btn-danger">Delete</a>
		      </div>
		    </div>
		  </div>
		</div>

	  <?php include '../templates/footer.php'?>

	</div>
	<!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <?php include '../templates/scripts.php'?>
  <script type="text/javascript">
  	$(document).ready(function(){
  		$('#content').summernote({
  			placeholder: "Article's body",
			height: 250
  		});

  		var img = new Image();
		img.crossOrigin = 'Anonymous';
		img.src = $("#preview_image").attr("src");
		
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
