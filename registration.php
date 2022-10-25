<?php 
include_once('./includes/connectDB.php');
include_once('./includes/sessions.php');
include_once('./includes/functions.php');
confirmAdminLogin();
include_once('./includes/header.php');
?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php echo SuccessMessage();?>

        <h1>
            Registration
            <small>Optional description</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Level</a>
            </li>
            <li class="active">Here</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="nameReg" placeholder="Enter email" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="emailReg" placeholder="Enter email"
                                name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="passwordReg" placeholder="Password"
                                name="password">
                        </div>
                        <div class="form-group">
                            <label>Account Type</label>
                            <select class="form-control">
                                <option>admin</option>
                                <option>user</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>PASSWORD</th>
                                    <th>ACCOUNT TYPE</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $select = $pdo->prepare("SELECT * from tbl_user order by userid asc");
                                    $select->execute();
                                    
                                    while($row=$select->fetch(PDO::FETCH_OBJ)){
                                        echo '
                                            <tr>
                                                <td>'.$row->userid.'</td>
                                                <td>'.$row->username.'</td>
                                                <td>'.$row->useremail.'</td>
                                                <td>'.$row->password.'</td>
                                                <td>'.$row->accType.'</td>
                                                <td></td>
                                            </tr>

                                        ';
                                    }


                                
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<?php include_once('./includes/footer.php');?>

</body>

</html>