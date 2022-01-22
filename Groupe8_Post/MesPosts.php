<?php
require_once __DIR__.'/back.php';
require_once __DIR__.'/TablePosts.php';

$nameUser = getName(urldecode($_COOKIE['user']));
$mailUser = urldecode($_COOKIE['user']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title><?php echo($nameUser) ?>-Posts</title>
</head>
<body>
    <header>
        <h5><?php echo($nameUser) ?></h5>
        <a href="./afficherPost.php">Les posts</a>
        <a href="./MesPosts.php">Mes posts</a>
        <a href="./createPost.php">Créer un post</a>
        <a href="./index.php">Se déconnecter</a>
    </header>
    
<?php


$allUserPosts = getUserPost($mailUser);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["like"])){
        
        like($_POST['numP'], $_POST['url']);
        
    }
    if(isset($_POST["delete"])){
        
        
        deletePost($_POST['numP']);
        
    }
    
}






//affichage => Pur chaque tuple de ma table Post j'affiche les colonnes que je souhaite
?>

    <section class="SecPost">
    <h2 style="color: black;display:block;margin:0 auto;width:fit-content;">Mes posts</h2>
    

<?php
foreach($allUserPosts as $key => $element){
    // if (already_Liked($element['eMailUser'], $element['numPost'])){
    //     $value = "vous aimez ce post";
    // }else{
    //     $value = "appuyer pour aimer";
    // }
?>
        <a href="./post.php?numPost=<?php echo($element['numPost'])?>">
        <div class="post" onclick="">
            <div class="NameTitle">
                <h3> <?php echo(getName($element['eMailUser'])) ?></h3>
                <h4> <?php echo($element['libPost']) ?></h4>
            </div>
            
            <h4>En résumé: <?php echo($element['resumPost'])?></h4>

            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" value="<?php echo($element['numPost']) ?>" name="numP">
                <input type="hidden" value="<?php echo("./MesPosts.php") ?>" name="url">
                <input type="submit" value="<?php //echo($value) ?> aimer" name="like">
                <br>
                <input type="submit" value="supprimer le post" name="delete">
                <br>
            </form>

        </div>
        </a>




<?php
}
?>  </section>
</body>
</html>