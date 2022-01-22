<?php
require_once __DIR__.'/back.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
      
      connect_user($_POST["email"]);
      header('Location: ./afficherPost.php' );
    }
}
?>

<body>
    <h1>Connexion</h1> 

    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 
        <label>Email</label> 
        <input type="text" name="email" value=""/> 
        <input type="submit" name="submit" value="se connecter"/>
    </form>
</body>