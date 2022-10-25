<?php

include_once('./includes/connectDB.php');
include_once('./includes/sessions.php');
include_once('./includes/functions.php');

if($_SESSION['userEmail']==""){
  Redirect_to('index.php');  
}

if($_SESSION['accType'] == 'admin'){
  include_once('./includes/header.php');
}else{
  include_once('./includes/headerUser.php');
}


// when user clicked update button set all values from input into a variable.

if(isset($_POST['updateBtn'])){
  $oldPassword = $_POST['oldPass'];
  $newPassword = $_POST['newPass'];
  $confirmPassword = $_POST['confirmPass'];

  $email = $_SESSION['userEmail'];
  
  
  $select = $pdo->prepare("SELECT * FROM `tbl_user` WHERE useremail = 'kenortz@gmail.com'");
  $select->execute();
  $row=$select->fetch(PDO::FETCH_ASSOC);

   $userEmail_db = $row['useremail'];
   $userPassword_db = $row['password'];

   //compare userInput vs dbValue
    if($oldPassword == $userPassword_db){
        if($newPassword == $confirmPassword){
          try{
              $updatePass = $pdo->prepare("UPDATE tbl_user SET password =:passWord WHERE useremail =:email ");
              $updatePass->bindParam('passWord',$newPassword);
              $updatePass->bindParam('email',$email);
              $updatePass->execute();
              echo '<script type="text/javascript">
              jQuery(function validation(){
                swal("Updated Successfully", "New password updated successfully!", "success");
              });
              </script>';
          }catch(PDOException $e){
              echo "Error: " . $e->getMessage();
          }
          
        }else{
          echo '<script type="text/javascript">
          jQuery(function validation(){
            swal("Update Failed", "New and confirm password mismatched!", "warning");
          });
          </script>';
        }
    }else{
      echo '<script type="text/javascript">
          jQuery(function validation(){
            swal("Update Failed", "Old password did not match!", "warning");
          });
          </script>';
    }
   
}
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <?php echo SuccessMessage();?>
        
          <h1>          
            Change Password
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
              <h3 class="box-title">Change Password Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="text" class="form-control" id="oldPassId" placeholder="Password" name="oldPass" >
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="newPassId" placeholder="Password" name="newPass" >
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassId" placeholder="Password" name="confirmPass" >
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="updateBtn" >Update</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <?php include_once('./includes/footer.php');?>
                                    
  </body>
</html>
