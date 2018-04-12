<?php 
include 'includes/dbFunctions.inc.php';
require_once('config.php');

$user = $_GET['username'];
$pass = $_GET['password'];

if ((isset($user) || !empty($user)) && (isset($pass) || !empty($pass))) {
    $db = new UsersLoginGateway($connection);
    
    try {
        $statement = $db->findAllParam(array('UserName','=',$user));
        
        //check if username exists
        if (count($statement) == 1) {
            //check if password is correct
            $row = $statement[0];
            $salt = $row['Salt'];
            $checkPass = md5($pass.$salt);
            
            if($checkPass==$row['Password']) {
                $id = $row['UserID'];
                $expiryTime = time()+60*60*24;
                
                setcookie('login', $id, $expiryTime);
                
                header('Location: user-profile.php?id='.$login);
            } else {
                header('Location: login.php?passError=true&user='.$user);
            }
        } else {
            header('Location: login.php?userError=true&user='.$user);
        }
        
    } catch(PDOExeption $e) {
        die($e->getMessage());
    }
}


?>