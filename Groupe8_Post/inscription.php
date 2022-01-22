<?php
require_once __DIR__.'/back.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
      echo ($_POST["name"] . $_POST["email"]); 
      insert_user($_POST["email"], $_POST["name"]);
    }
}
?>

<body>
    <h1>Inscription</h1> 

    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 
        <label>Email</label> 
        <input type="text" name="email" value=""/> 
        <label>Name</label> 
        <input type="text" name="name" value=""/> 
        <input type="submit" name="submit" value="s'inscrire"/>
    </form>
</body>