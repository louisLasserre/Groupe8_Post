<?php

require_once __DIR__ . '/BDDConnect.php';
require_once __DIR__ . '/back.php';//pour avoir accès à getName

$nameUser = getName(urldecode($_COOKIE['user']));

//création d'un post 
function createPost($libelle, $description, $resumPost){
    global $db;
    try {
        $db->beginTransaction();

        // insert
        $query = 'INSERT INTO POST (libPost, descripPost, resumPost,statutPost, positPost, eMailUser) VALUES (?, ?, ?, ?, ?, ?);';
    

        $request = $db->prepare($query);

        $positPostt = 1;
        $statutPost = "testStatut";
        
        $mail = urldecode($_COOKIE['user']);
        
        
        // execute
        $request->execute([$libelle, $description, $resumPost,$statutPost, $positPostt, $mail]);



        $db->commit();
        $request->closeCursor();
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }
}

//insertion du tag rensseigné par l'utilisateur lors de la création du post dans la table tag
function tag($libTag){
    global $db;
    try {
        $db->beginTransaction();
        // insert
        $query = 'INSERT INTO TAG (libTag, dtCreaTag) VALUES (?, NOW());';
        $request = $db->prepare($query);
        // execute
        
        

        $request->execute([$libTag]);
        
        


        $db->commit();
        $request->closeCursor();
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }


}
//***********Récupération de numTag et numPost puis ajout dans REGROUPEMENT************* */

//dans la table POST on récupère la valeur de numPost 
function getNumPost($libPost){
    global $db;
    try {
        $db->beginTransaction();
        // insert
        $query = 'SELECT * FROM POST WHERE libPost = ?;';
        $request = $db->prepare($query);

		$request->execute([$libPost]);
        $posts = $request->fetch();

        $result = $posts['numPost'];
        print_r($result);
		
        $db->commit();
        $request->closeCursor();
        
        return($result);
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }

}
//on récupère le numTag de la table TAG
function getNumTag($tag){
    
    global $db;
    try {
        $db->beginTransaction();
        
        // insert
        $query = 'SELECT * FROM TAG WHERE libTag = ?;';
        $request = $db->prepare($query);
        
		$request->execute([$tag]);
        
        $posts = $request->fetch();
        

        $result = $posts['numTag'];
        $db->commit();
        $request->closeCursor();
		return($result);
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }

}

//et on ajoute ces deux valeurs récupérées dans la table de jointure REGROUPEMENT
function regroup($libPost, $tag){
    //get numPost
    $numPost = getNumPost($libPost);
    print_r("numPost : " . $numPost);
    //get numTag
    $numTag = getNumTag($tag);
    print_r("<br>numtag : " . $numTag);

    //insert them into REGROUPEMENT database
    global $db;
    try {
        $db->beginTransaction();
        // insert
        $query = 'INSERT INTO REGROUPEMENT (numPost, numTag, dtCreaRegroup) VALUES (?, ?, NOW());';
        $request = $db->prepare($query);
        // execute
        $request->execute([$numPost, $numTag]);
        
        $db->commit();
        $request->closeCursor();
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }




}



//POUR ÉVITER des erreurs, deux posts ne peuvent pas avoir le même libellé
//cette fonction vérifie si un post contient déja le même libellé
function checkLibPost($libPost){
    global $db;
    try {
        $db->beginTransaction();
        
        // insert
        $query = 'SELECT * FROM POST WHERE libPost = ?;';
        $request = $db->prepare($query);
        
		$request->execute([$libPost]);
        
        $posts = $request->fetch();
        $db->commit();
        $request->closeCursor();
        if($posts){
            return true;
        }else{
            return false;
        }
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }

}


//**************************FIN des FONCTIONS********************************* */

if($_SERVER["REQUEST_METHOD"] === "POST"){
        
    if(isset($_POST["postValues"])){
        
        $libValid = checkLibPost($_POST["libPost"]);
        if($libValid == false){
            createPost($_POST["libPost"], $_POST["descriptPost"], $_POST["resumPost"]);
            tag($_POST["tag"]);
        
            regroup($_POST["libPost"], $_POST["tag"]);
        }
        
        
    }
    
    

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title><?php echo($nameUser) ?>-New Post</title>
</head>
<body>
    <header>
        <a href="./afficherPost.php">Les posts</a>
        <a href="./MesPosts.php">Mes posts</a>
        <a href="./createPost.php">Créer un post</a>
        <a href="./index.php">Se déconnecter</a>
    </header>
    






    <section class="createPost">
        <div class="NameTitle">
            <h3>Création d'un Post</h3>
        </div>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            

            <div>
                <h4 class="formText">Libellé du post</h4>
                <input type="text" name="libPost" size="40"required>
                <p class="erreur"> <?php if($libValid == true){echo('Erreur : Un post portant ce nom existe déja');}?></p>
            </div>
            
            <div>
                <h4 class="formText">description</h4>
                <input type="text" name="descriptPost"size="40">
            </div>
            
            <div>
                <h4 class="formText">résumé</h4>
                <input type="text" name="resumPost"size="40">
            </div>
            
            <div>
                <h5 class="formText"> tag </h5>
                <input type="text" name="tag" required size="40">
            </div>
            

            <input type="submit" name="postValues"value="Creer le post">
        </form>
    </section>
</body>
</html>