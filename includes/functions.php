<?php
    function checkUser($username){
        global $conn;
        $checkUserSql = "SELECT * FROM users where userName = '$username' ";
        $checkUserQuery = $conn->query($checkUserSql);

        if($checkUserQuery->num_rows > 0){
            return true;
        }else{
            return false;
        }

    }
function logInAttempt($userEmail,$password)
        {
            global $pdo;
            $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail = '$userEmail' AND password = '$password'");
            $select->execute();
                        
            
            
            if($select->rowCount() > 0)
                {
                    return $foundAccnt = $select->fetch(PDO::FETCH_ASSOC);
                }
            else
                {
                   return null;
                }
        }

function confirmAdminLogin()
{
    
    if(isset($_SESSION['userName']) && $_SESSION['accType']=='admin')
        {
            return true;
          
        }
    else
        {
            $_SESSION['ErrorMessage'] = "Login Required!";
            Redirect_to("index.php");
        }
        
}
function confirmUserLogin()
{
    
    if(isset($_SESSION['userName']) && $_SESSION['accType']=='user')
        {
            return true;
          
        }
    else
        {
            $_SESSION['ErrorMessage'] = "Login Required!";
            Redirect_to("index.php");
        }
        
}

function Redirect_to($New_Location)
{
    
    header("Location:".$New_Location);
    exit;        
}

?>