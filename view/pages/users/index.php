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

$user = new User();

$list = $user->list();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../../pages/templates/header.php'?>
  <style type="text/css">
    tr.users-link{
      cursor:pointer !important;
    }
  </style>
</head>
<body id="page-top">
  <?php include '../../pages/templates/nav.php'?>
  <div id="wrapper">
    <?php include '../../pages/templates/sidebar.php'?>

	<div id="content-wrapper">
      <div class="container-fluid">
        <!-- Page Content -->
        <h1>Users</h1>
        <hr>
        <div class="col-md-12" style="padding: 0 !important;margin-bottom:1rem;">
          <a href="<?php echo $_SESSION['root'].'view/pages/users/new.php' ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New
          </a>
        </div>
        <?php
          if(isset($_GET['msg'])){
            if($_GET['msg'] == "success"){
          ?>
          <div class="col-xs-12">
            <div class="alert alert-success" role="alert">
              User has been created successfully.
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
            if($_GET['msg'] == "success_edit"){
          ?>
          <div class="col-xs-12">
            <div class="alert alert-success" role="alert">
              User has been edited successfully.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
          </div>
          <?php
            }
            if($_GET['msg'] == "delete_success"){
          ?>
          <div class="col-xs-12">
            <div class="alert alert-success" role="alert">
              User has been suspended.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
          </div>
          <?php
            }
            if($_GET['msg'] == "reactivated"){
          ?>
          <div class="col-xs-12">
            <div class="alert alert-success" role="alert">
              User has been reactivated.
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
            <i class="fas fa-table"></i> Users
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">email</th>
                    <th class="text-center">Rol</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(count($list) > 0){
                    foreach ($list as $row){
                  ?>
                  <tr class="users-link <?php if($row['id'] == $_SESSION['user_id']){ echo "table-success";} ?> <?php if($row['status'] == "Suspended"){ echo "table-danger"; } ?>" data-href="<?php echo $_SESSION['root'].'view/pages/users/edit.php?id='.$row['id']; ?>">
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['name'].' '.$row['last_name']; ?>
                      <?php if($row['id'] == $_SESSION['user_id']){ echo "(me)";} ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['email']; ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php
                        $roles = [1,2];
                        if($row['id_rol'] == 1){
                          echo "Admin";
                        }else{
                          echo "Ambassador";
                        }
                      ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php
                      $date = date_create($row['created_date']);
                      echo date_format($date, 'M d, h:ia');
                      ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php echo $row['created_name'].' '.$row['created_lastname']; ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php
                      echo $row['status'];
                      ?>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                      <?php if($row['id'] != $_SESSION['user_id']){ ?>
                      <?php if($row['status'] == "Active"){ ?>
                      <a title="Suspend" href="<?php echo $_SESSION['root'].'controller/users_controller.php?opt=delete&id='.$row['id']; ?>">
                        <button type="button" class="btn btn-danger">
                          <i class="fas fa-fw fa-trash-alt"></i>
                        </button>
                      </a>
                      <?php
                      }else{
                      ?>
                      <a title="Activate" href="<?php echo $_SESSION['root'].'controller/users_controller.php?opt=reactivate&id='.$row['id']; ?>">
                        <button type="button" class="btn btn-info">
                          <i class="fas fa-fw fa-check"></i>
                        </button>
                      </a>
                      <?php
                      }
                    }
                      ?>
                    </td>
                  </tr>
                  <?php
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

      <?php include '../../pages/templates/footer.php'?>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <?php include '../../pages/templates/scripts.php'?>
  <script type="text/javascript">
    $(document).ready(function(){
      $("tr.users-link").on("click",function(){
        var link = $(this).data("href");
        //console.log(link);
        window.location.href = link;
      });
    });
  </script>
</body>
</html>
