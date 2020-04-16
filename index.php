<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("location: view/pages/login.php");
}
spl_autoload_register(function ($clase) {
	require_once ('model/' . $clase . '.php');
});
$menu = "Dashboard";
$article = new Article();

$userblog = new User();
$userblog->setId($_SESSION['user_id']);
$userdata = $userblog->get();

if($_SESSION['id_rol'] == 1){
  $list = $article->listArticlesForAdmin();
  //$list = $article->listShopify($data, '1');
}else{
  $data = $article->listByUser($_SESSION['user_id']);
  $list = $article->listShopify($data, $userdata["handle_blog"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'view/pages/templates/header.php'?>
  <style type="text/css">
    tr.articles-link{
      cursor:pointer !important;
    }
  </style>
</head>
<body id="page-top">
  <?php include 'view/pages/templates/nav.php'?>
  <div id="wrapper">
    <?php include 'view/pages/templates/sidebar.php'?>

	<div id="content-wrapper">
      <div class="container-fluid">
        <!-- Page Content -->
        <h1>Dashboard</h1>
        <hr>
        <?php 
          if(isset($_GET['msg'])){
            if($_GET['msg'] == "delete_success"){
          ?>
          <div class="col-xs-12">
            <div class="alert alert-success" role="alert">
              The article has been deleted successfully.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
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
          }
          ?>
        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i> Articles
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th class="text-center">Image</th>
                    <th class="text-center">Title</th>
                    <?php
                    if($_SESSION['id_rol'] == 1){
                    ?>
                    <th class="text-center">Author</th>
                    <?php }?>
                    <th class="text-center">
                    <?php
                      if($_SESSION['id_rol'] == 1){
                        echo "Tag";
                      }else{
                        echo "Published";
                      }
                    ?>
                    </th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(count($list) > 0){
                    foreach ($list as $row){
                      if($_SESSION['id_rol'] != 1){
                  ?>
                  <tr class="articles-link" data-href="<?php echo $_SESSION['root'].'view/pages/articles/edit.php?id='.$row['id']; ?>">
                    <td style="width:5%;vertical-align: middle;">
                      <img src="<?php echo $row['image']['src'] ?>" title="<?php echo $row['image']['width'].'x'.$row['image']['height']; ?>" class="img-fluid" alt="<?php echo $row['title'] ?>">
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['title']; ?>
                    </td>
                    <?php
                    if($_SESSION['id_rol'] == 1){
                    ?>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['author']; ?>
                    </td>
                    <?php
                    }
                    ?>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php
                      if($row['published_at'] == ""){
                        echo "Pending";
                      }else{
                        echo "Approved";
                      }
                      ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php
                      $date = date_create($row['created_at']);
                      echo date_format($date, 'M d, h:ia');
                      ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <a href="<?php echo $_SESSION['root'].'view/pages/articles/edit.php?id='.$row['id']; ?>">
                        <i class="fas fa-fw fa-edit"></i>
                      </a>
                    </td>
                  </tr>
                  <?php
                      }else{
                  ?>
                  <tr class="articles-link" data-href="<?php echo $_SESSION['root'].'view/pages/articles/edit.php?id='.$row['id']; ?>">
                    <td style="width:5%;vertical-align: middle;">
                      <img src="<?php echo $row['featured_image'] ?>" title="<?php echo $row['image']['width'].'x'.$row['image']['height']; ?>" class="img-fluid" alt="<?php echo $row['title'] ?>">
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['title']; ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['author']; ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['tags']; ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php
                      $date = date_create($row['created_date']);
                      echo date_format($date, 'M d, h:ia');
                      ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <a href="<?php echo $_SESSION['root'].'view/pages/articles/edit.php?id='.$row['id']; ?>">
                        <i class="fas fa-fw fa-edit"></i>
                      </a>
                    </td>
                  </tr>
                  <?php
                      }
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

      <?php include 'view/pages/templates/footer.php'?>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <?php include 'view/pages/templates/scripts.php'?>
  <script type="text/javascript">
    $(document).ready(function(){
      $("tr.articles-link").on("click",function(){
        var link = $(this).data("href");
        //console.log(link);
        window.location.href = link;
      });
    });
  </script>
</body>
</html>
