<?php
require_once __DIR__.'/back.php';

function getUserPost($email){
    global $db;
    try {
        $db->beginTransaction();
        
        // insert
        $request = 'SELECT * FROM POST WHERE eMailUser = ?;';
        $result = $db->prepare($request);
        $result->execute([$email]);
        $resultAll = $result->fetchAll();
        
        $db->commit();
        $result->closeCursor();
        if($resultAll){
            return $resultAll;
        }
        
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $result->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }
}

function deletePost($numPost){
    //check si tag associé
    
    $numTag = existingTag($numPost);
    if ($numTag != false){
        deleteRgrp($numPost, $numTag);
        deleteTag($numTag);
        deleteLikePost($numPost);
        deleteThePost($numPost);

        header('Location: ./MesPosts.php');

    }


}

function existingTag($numPost){
    global $db;
    try {
        $db->beginTransaction();
        
        // insert
        $request = 'SELECT * FROM REGROUPEMENT WHERE numPost = ?;';
        $result = $db->prepare($request);
        $result->execute([$numPost]);
        $resultAll = $result->fetch();
        
        $db->commit();
        $result->closeCursor();
        if($resultAll){
            return $resultAll['numTag'];
        }else{
            return false;
        }
        
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $result->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }

}
function deleteRgrp($numPost, $numTag){
    global $db;
		
    try {
        $db->beginTransaction();

        // delete
        $query = 'DELETE FROM REGROUPEMENT WHERE numPost=? AND numTag=?';

        // prepare
        $request = $db->prepare($query);
        // execute
        $request->execute([$numPost, $numTag]);

        
        $db->commit();
        $request->closeCursor();
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur delete CLASSE : ' . $e->getMessage());
    }
}

function deleteTag($numTag){
    global $db;
		
    try {
        $db->beginTransaction();

        // delete
        $query = 'DELETE FROM TAG WHERE numTag=?';

        // prepare
        $request = $db->prepare($query);
        // execute
        $request->execute([$numTag]);

        
        $db->commit();
        $request->closeCursor();
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur delete CLASSE : ' . $e->getMessage());
    }

}
function deleteThePost($numPost){
    global $db;
		
    try {
        $db->beginTransaction();

        // delete
        $query = 'DELETE FROM POST WHERE numPost=?';

        // prepare
        $request = $db->prepare($query);
        // execute
        $request->execute([$numPost]);

        
        $db->commit();
        $request->closeCursor();
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur delete CLASSE : ' . $e->getMessage());
    }

}
function deleteLikePost($numPost){
    global $db;
		
    try {
        $db->beginTransaction();

        // delete
        $query = 'DELETE FROM LIKEPOST WHERE numPost=?';

        // prepare
        $request = $db->prepare($query);
        // execute
        $request->execute([$numPost]);

        
        $db->commit();
        $request->closeCursor();
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur delete CLASSE : ' . $e->getMessage());
    }

}