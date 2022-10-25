<?php 

include_once('./includes/connectDB.php');
include_once('./includes/sessions.php');
include_once('./includes/functions.php');
confirmAdminLogin();
include_once('./includes/header.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $findQuery = $pdo->prepare("SELECT * FROM tbl_user WHERE userid = '$id'");
    $findQuery->execute();
    $result = $findQuery->fetch(PDO::FETCH_ASSOC);
    $user =  $result['username'];
    if($user == 'kenortz'){
        echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal("Error!", "Cannot delete '.$user.'", "error");
                });
                </script>';
    }else if($findQuery->rowCount() > 0){
        $deleteQuery = $pdo->prepare("DELETE FROM tbl_user WHERE userid = '$id'");
        if($deleteQuery->execute()){
            echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal("Success", "Successfully deleted '.$user.'", "success");
                    });
                    </script>';
        }
    }else{
        echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal("ID not found!", "Something went wrong!", "error");
                });
                </script>';
    }


    

    
    
   

}

if(isset($_POST['submitBtn'])){
    $userName = $_POST['nameTxt'];
    $userEmail = $_POST['emailTxt'];
    $userPassword = $_POST['passwordTxt'];
    $userAccType = $_POST['selectTxt'];
    
    $selectQuery = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail = '$userEmail'");
    $selectQuery->execute();

    if($selectQuery->rowCount() > 0){
        echo '<script type="text/javascript">
        jQuery(function validation(){
          swal("Registration Failed", "email already taken!", "error");
        });
        </script>';
    }else{
        $insertQuery = $pdo->prepare("INSERT INTO tbl_user(username,useremail,password,accType)
        VALUES(:name,:email,:pass,:Type)");
    
        $insertQuery->bindParam(':name',$userName);
        $insertQuery->bindParam(':email',$userEmail);
        $insertQuery->bindParam(':pass',$userPassword);
        $insertQuery->bindParam(':Type',$userAccType);

    
        if($insertQuery->execute()){
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal("Good Job!", "Successfully created new account!", "success");
                });
                </script>';
        }
    }

    
    
                       
}

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
                <div class="col-md-4">
                    <h3 class="box-title">Registration Form</h3>
                </div>
                <div class="col-md-8">
                    <h3 class="box-title">Existing Users</h3>
                </div>
            </div>


            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" placeholder="Enter email" name="nameTxt" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="emailTxt" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="passwordTxt"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Account Type</label>
                            <select class="form-control" name="selectTxt" required>
                                <option value="" disabled selected>Select Account Type</option>
                                <option>admin</option>
                                <option>user</option>
                            </select>
                        </div>
                        <!-- <div class="box-footer"> -->
                        <button type="submit" class="btn btn-primary" name="submitBtn">Submit</button>
                        <!-- </div> -->

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
                                    <th>DELETE</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $select = $pdo->prepare("SELECT * from tbl_user order by userid desc");
                                    $select->execute();
                                    
                                    while($row=$select->fetch(PDO::FETCH_OBJ)){
                                        echo '
                                            <tr>
                                                <td>'.$row->userid.'</td>
                                                <td>'.$row->username.'</td>
                                                <td>'.$row->useremail.'</td>
                                                <td>'.$row->password.'</td>
                                                <td>'.$row->accType.'</td>
                                                <td>
                                                    <a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button">
                                                        <span class="glyphicon glyphicon-trash" title="delete"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        ';
                                    }


                                
                                ?>
                            </tbody>
                        </table>
                    </div>
            </form>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<?php include_once('./includes/footer.php');?>

</body>

</html>