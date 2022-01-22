<?php

require_once __DIR__.'/BDDConnect.php';


//***************************Account creation and connection SECTION************************** */
function insert_user($email, $name) {
    global $db;

    try {
        $db->beginTransaction();

        $query = 'INSERT INTO USER (eMailUser, loginUser, passUser, cdDroitUser) VALUES (?,?,?,?);'; //requete
        $request = $db->prepare($query); //prepare
        $pass = "lol";
        $cdDroitUser = "2";
        $request->execute([$email, $name, $pass, $cdDroitUser]); //execute
        $db->commit();
        $request->closeCursor();
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }
  }

function connect_user($email) {
    global $db; 

    $query = 'SELECT * FROM USER WHERE eMailUser = ?;';
    $result = $db->prepare($query);
    $result->execute([$email]);
    $user = $result->fetch();

    if($user) {
        setcookie('user', $user ['eMailUser']);
        return true;
    }else{
        return false;
    }
    
}

//***************************Like and unlike SECTION************************** */
function already_Liked($email, $numPo){
    global $db; 

    try {
        $db->beginTransaction();
        $query = 'SELECT * FROM LIKEPOST WHERE eMailUser = ?;';
        $result = $db->prepare($query);
        $result->execute([$email]);
        $user = $result->fetchAll();

        foreach($user as $key => $element){
            if($element) {
                if($element['numPost'] == $numPo){
                    
                    $db->commit();
                    $result->closeCursor();
                    return true;
                }
            }else if ($element['numPost'] != $numPo){
                
                
            }
        }
        $db->commit();
        $result->closeCursor();
        return false;
    }
    catch (PDOException $e) {
        $db->rollBack();
        $result->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }
    

    
}
function addLikePost($mail, $numPost){
    global $db;

    try {
        $db->beginTransaction();
        
        $query = 'INSERT INTO LIKEPOST (eMailUser, numPost) VALUES (?,?);'; //requete
        $request = $db->prepare($query); //prepare
        
        $request->execute([$mail, $numPost]); //execute
        $db->commit();
        $request->closeCursor();
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }


}
function removeLikePost($mail, $numPost){
    global $db;
		
    try {
        $db->beginTransaction();

        // delete
        $query = 'DELETE FROM LIKEPOST WHERE eMailUser=? AND numPost=?';

        // prepare
        $request = $db->prepare($query);
        // execute
        $request->execute([$mail, $numPost]);

        $count = $request->rowCount(); //
        $db->commit();
        $request->closeCursor();
        return($count); //
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur delete CLASSE : ' . $e->getMessage());
    }
}

// Fonction mère de like et unlike
function like($numPost, $saveurl){
    //get email of the profil who likes
    
    $mail = urldecode($_COOKIE['user']);

    //the numPost has been received in the variable function $numPost


    //checking if the post is already liked
    if (already_Liked($mail, $numPost) == true){
        removeLikePost($mail, $numPost);
        
        
    }else if (already_Liked($mail, $numPost) == false){
        
        addLikePost($mail, $numPost);
        
    }
}
//***************************Autre************************** */

function getName($mail){
    global $db; 

    $query = 'SELECT * FROM USER WHERE eMailUser = ?;';
    $result = $db->prepare($query);
    $result->execute([$mail]);
    $user = $result->fetch();

    return $user['loginUser'];

}