<h1>Pour vous connecter</h1>
<form action="index.php?page=11" id="insert" method="post">
<?php
  $pdo=new Mypdo();
  $PersonneManager = new PersonneManager($pdo);

  if (empty($_POST["per_login"]) OR empty($_POST["per_pwd"])
  OR empty($_POST["code_ctrl"])) {
      $random1 = rand(1,9);
      $random2 = rand(1,9);

      $_SESSION['random1'] = $random1;
      $_SESSION['random2'] = $random2;

      $img1 = "image/nb/".$random1.".jpg";
      $img2 = "image/nb/".$random2.".jpg";
?>
      Nom d'utilisateur : <input type="text" name="per_login" size="10">
      <br /><br />
      Mot de passe : <input type="password" name="per_pwd" size="10">
      <br /><br />
    <?php
      echo "<img src=\"".$img1."\" alt=\"img1\"> +
      <img src=\"".$img2."\" alt=\"img2\"> =
      <input type=\"text\" name=\"code_ctrl\" size=\"10\">";
    ?>
      <br /><br />
      <input type="submit" name="bouton" value="Valider">
    </form>
<?php
  }
  else
  {
    $login = $_POST["per_login"];
    $pwd = sha1(sha1($_POST["per_pwd"]). SALT);

    if ($PersonneManager->checkPersonne($login, $pwd) != false
    AND $_POST["code_ctrl"] == ($_SESSION["random1"] + $_SESSION["random2"])) {

      $_SESSION["user"] = $_POST["per_login"];
      $_SESSION["per_num"] = $PersonneManager->checkPersonne($login, $pwd);

      echo "<img src=\"image/valid.png\" alt=\"valid\" title=\"connexionValide\">";
      echo "    Vous êtes à présent connecté et allez être redirigé !";

      //redirection
      header("Location: index.php?page=0");
      exit;
    }
    else
    {
      echo "<img src=\"image/erreur.png\" alt=\"erreur\" title=\"connexionInvalide\">";
      echo "    Erreur de saisie !";
    }
  }
?>
