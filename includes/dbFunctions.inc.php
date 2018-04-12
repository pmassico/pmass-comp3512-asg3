<?php 
function connect() {
    require_once('config.php');
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die( $e->getMessage() );
    }
    return $pdo;
}

function sanitize($pdo, $sql) {
    //$sql = array(SQL with ?, ? declaration)
    $prepared = $pdo->prepare($sql[0]);
    $prepared->execute(array($sql[1]));
    //OMITTED $prepared = $prepared->fetch(); in case fetchAll(); is needed, and
    //to be able to use this function before a while loop
    return $prepared;
}

function validImgID($id) {
    //is valid if id is a number 
    if (is_numeric($id)) {
        //turn into a number to compare it 
        $id = (int)$id;
        
        //and if it's within the acceptable range (not negative, lower or equal to highest-numbered post
        if (0<$id && $id<=115) {
            return true;
        }
    } else {
        return false;
    } 
}

function validPostID($id) {
    //is valid if id is a number 
    if (is_numeric($id)) {
        //turn into a number to compare it 
        $id = (int)$id;
        
        //and if it's within the acceptable range (not negative, lower or equal to highest-numbered post
        if (0<$id && $id<=30) {
            return true;
        }
    } else {
        return false;
    } 
}

function validUserID($id) {
    //is valid if id is a number 
    if (is_numeric($id)) {
        //turn into a number to compare it 
        $id = (int)$id;
        
        //and if it's within the acceptable range (not negative, lower or equal to highest-numbered post
        if (0<$id && $id<=31) {
            return true;
        }
    } else {
        return false;
    } 
}

function validCountry($id, $countries) {
    //convert to upper
    strtoupper($id);
    
    //check if id is in array
    if (in_array($id, $countries)) {
        return true;
    } else {
        return false;
    }
}
?>