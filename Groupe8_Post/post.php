<?php

require_once __DIR__ . '/BDDConnect.php';
require_once __DIR__ . '/back.php';

$nameUser = getName(urldecode($_COOKIE['user']));

//Cette page affiche 1 post en particulier 

function getOnePost($numPost)
{
    global $db;
    try {
        $db->beginTransaction();
    
        // insert
        $query = 'SELECT * FROM POST WHERE numPost = ?;';
        
        $request = $db->prepare($query);
        $request->execute([$numPost]);
        $resultAll = $request->fetchAll();
        
        $db->commit();
        $request->closeCursor();
        return $resultAll;
        
    }
    catch (PDOException $e) {
        $db->rollBack();
        $request->closeCursor();
        die('Erreur insert CLASSE : ' . $e->getMessage());
    }
}

//On récupere via GET le numPost qui nous sert dans la fonction du dessus a afficher ce post
if(isset($_GET['numPost'])){
    $NumPost = $_GET['numPost'];
    $post = getOnePost($NumPost);
    //on a besoin de garder l'url actuel car quand la fonction like, rafraichit la page
    //or en rafraichissant, on pert la valeur Get 
    $saveurl = "./post.php?numPost=$NumPost";
 

    
    
}
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["like"])){
        $saveurl = $_POST['url'];
        like($_POST['numP'], $saveurl);
        
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
    <title><?php echo($nameUser) ?>-Post</title>
</head>
<body>
    <header>
        <h5><?php echo($nameUser) ?></h5>
        <a href="./afficherPost.php">Les posts</a>
        <a href="./MesPosts.php">Mes posts</a>
        <a href="./createPost.php">Créer un post</a>
        <a href="./index.php">Se déconnecter</a>
    </header>
    
    <section class="SecPost">
<?php
//pour chaque tuple(ligne) de la table POST on affiche : 
    
    foreach($post as $key => $element){

?>
        
        <div class="post" onclick="">
            <div class="NameTitle">
                <h3> <?php echo(getName($element['eMailUser'])) ?></h3>
                <h4> <?php echo($element['libPost']) ?></h4>
            </div>
            <h4>email : <?php echo($element['eMailUser'])?></h4>
            <br>
            
            <h4>description : <?php echo($element['descripPost'])?></h4>
            <br>
            <h4>En résumé: <?php echo($element['resumPost'])?></h4>

            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" value="<?php echo($element['numPost']) ?>" name="numP">
                <input type="hidden" value="<?php echo($saveurl) ?>" name="url">
                <input type="submit" value="j'aime" name="like">
            </form>

        </div>
        




<?php
}
?>  </section>
</body>
</html>