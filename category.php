<?php 
include_once('./includes/connectDB.php');
include_once('./includes/sessions.php');
include_once('./includes/functions.php');
confirmAdminLogin();
include_once('./includes/header.php');


if(isset($_POST['addCategoryBtn'])){
    $categoryName = $_POST['categoryTxt'];
    

    if(empty($categoryName)){
        echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal("Empty field!", "Category field is empty", "warning");
                });
            </script>';
    }else{
        $insertQuery = $pdo->prepare("INSERT INTO tbl_category(categoryName) VALUES (:catName)");
        $insertQuery->bindParam(':catName',$categoryName);
    
        if($insertQuery->execute()){
            echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal("Success!", "Successfully created '.$categoryName.' category!", "success");
                    });
                 </script>';
        }
    }
    
    
} 
// <<<<<----add category code ends here---->>>>>

if(isset($_POST['updateBtn'])){
    
    $newCategoryName = $_POST['updateCategoryTxt'];
    $updateID = $_POST['updateIdTxt'];
    $_SESSION['view']==true;
    if(empty($newCategoryName)){
        echo sweetError("Empty Field!", "Please fill up input field!");
        
    }else{
        $updateQuery = $pdo->prepare("UPDATE tbl_category SET categoryName = :catName WHERE categoryID = :updateId");
        $updateQuery->bindParam('catName',$newCategoryName);
        $updateQuery->bindParam('updateId',$updateID);

        if($updateQuery->execute()){
            echo sweetSuccess("Updated!","Successfully updated ".$newCategoryName." category");
            $_SESSION['view'] == false;
        }
    }   
}
// <<<<<----update category code ends here---->>>>>

if(isset($_POST['btnDelete'])){
    $deleteID = $_POST['btnDelete'];
    $deleteQuery = $pdo->prepare("DELETE FROM tbl_category where categoryID = '$deleteID' ");

    if($deleteQuery->execute()){
        echo sweetSuccess("Deleted!","Successfully deleted the category!");
    }else{
        echo sweetError("Failed!","Failed to delete the category!");
    }
}

?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php echo SuccessMessage();?>

        <h1>
            Category
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
        <div class="box box-warning">

            <div class="box-header with-border">
                <div class="col-md-4">
                    <h3 class="box-title">Category Form</h3>
                </div>
                <div class="col-md-8">
                    <h3 class="box-title">Category List</h3>
                </div>
            </div>


            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">
                <form role="form" action="" method="post">
                    <?php 
                        if(isset($_POST['btnEdit'])){
                            $id = $_POST['btnEdit'];
                            $select = $pdo->prepare("SELECT * FROM tbl_category WHERE categoryID = '$id'");
                            $select->execute();
                            
                            if($select){
                                $row = $select->fetch(PDO::FETCH_OBJ);
                                echo '
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="hidden" value="'.$row->categoryID.'"class="form-control"  name="updateIdTxt">
                                            <input type="text" value="'.$row->categoryName.'"class="form-control"  name="updateCategoryTxt">
                                        </div>
                                           
                                        <button type="submit" class="btn btn-info" name="updateBtn">Update</button>
                                            
            
                                    </div>
                                    ';                                
                            }

                        }else{
                            echo '
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Category" name="categoryTxt">
                                </div>
                            
                                <button type="submit" class="btn btn-warning" name="addCategoryBtn">Save</button>
                                
    
                            </div>
                            ';
                        }
                    ?>
                    

                    <div class="col-md-8">

                        <table id="categoryTable" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CATEGORY</th>
                                    <th>EDIT</th>
                                    <th>DELETE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectQuery = $pdo->prepare("SELECT * FROM tbl_category ORDER BY categoryID DESC");
                                $selectQuery->execute();

                                while($row = $selectQuery->fetch(PDO::FETCH_OBJ)){
                                    echo    '<tr>
                                                <td>'.$row->categoryID.'</td>
                                                <td>'.$row->categoryName.'</td>
                                                <td>
                                                    <button type="submit" value="'.$row->categoryID.'" class="btn btn-success" name="btnEdit">Edit</button>
                                                </td>
                                                <td>
                                                    <button type="submit" value="'.$row->categoryID.'" class="btn btn-danger" name="btnDelete">Delete</button>
                                                </td>
                                            </tr>';
                                }
                                
                            ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Call this single function  -->
<script>
    $(document).ready( function () {
        $('#categoryTable').DataTable();
    } );
</script>
<!-- Main Footer -->
<?php include_once('./includes/footer.php');?>

</body>

</html>