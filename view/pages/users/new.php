<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: {$_SESSION['root']}view/pages/login.php");
}

if ($_SESSION['id_rol'] != 1) {
    header("location: {$_SESSION['root']}");
}

spl_autoload_register(function ($clase) {
    require_once ('../../../model/' . $clase . '.php');
});
$menu = "users";
$rol = new Rol();

$roles = $rol->list();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../templates/header.php' ?>
</head>
<body id="page-top">
    <?php include '../templates/nav.php' ?>
    <div id="wrapper">
        <?php include '../templates/sidebar.php' ?>
        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Page Content -->
                <h1>New User</h1>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <form action="<?php echo $_SESSION['root'] . 'controller/users_controller.php'; ?>" method="POST">
                            <input type="hidden" name="opt" value="new">
                            <input type="hidden" name="created_by" value="<?php echo $_SESSION['user_id']; ?>">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Last Name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" aria-describedby="titleHelp" autofocus="on" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="password">Rol</label>
                                <select name="id_rol" class="form-control">
                                    <?php
                                    foreach ($roles as $row) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" disabled="">Active</option>
                                    <option value="Suspended" disabled="">Suspended</option>
                                    <option value="Uncompleted" selected="true">Uncompleted</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

            <?php include '../templates/footer.php' ?>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php include '../templates/scripts.php' ?>
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
</body>
</html>
