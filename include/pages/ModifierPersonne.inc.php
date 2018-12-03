<form action="index.php?page=3" id="insert" method="post">
<h1>Modifier une personne</h1>
<?php
  $pdo=new Mypdo();
  $PersonneManager = new PersonneManager($pdo);

  $personnes = $PersonneManager->getAllPersonnes();

  if (empty($_POST["per_num"]) AND (empty($_POST["per_nom"]) OR empty($_POST["per_prenom"]) OR empty($_POST["per_tel"])
   OR empty($_POST["per_mail"]) OR empty($_POST["per_login"]) OR empty($_POST["per_pwd"]))) {
?>
    Personne : <select name="per_num" size="1">
      <option value="0"> Choisissez</option>
<?php
    foreach ($personnes as $personne) {
      echo "<option value=\"".$personne->getPerNum()."\">".$personne->getPerPrenom()." ".$personne->getPerNom()."</option>";
    }
    echo "</select>";
    echo "<br /> <br />";
    echo "<input type=\"submit\" name=\"bouton\" value=\"Valider\">";
  }
  elseif(!empty($_POST["per_num"]) AND (empty($_POST["per_nom"]) OR empty($_POST["per_prenom"]) OR empty($_POST["per_tel"])
   OR empty($_POST["per_mail"]) OR empty($_POST["per_login"]) OR empty($_POST["per_pwd"]))) {

     $_SESSION["per_num"] = $_POST["per_num"];
     $personne = $PersonneManager->getPersonne($_POST["per_num"]);

     $_SESSION["per_nom"] = $personne->getPerNom();
     $_SESSION["per_prenom"] = $personne->getPerPrenom();
     $_SESSION["per_tel"] = $personne->getPerTel();
     $_SESSION["per_mail"] = $personne->getPerMail();
     $_SESSION["per_login"] = $personne->getPerLogin();
     $_SESSION["per_pwd"] = $personne->getPerPwd();
     $_SESSION["categorie"] = $PersonneManager->isEtudiant($_SESSION["per_num"]);

     echo 'Nom : <input type="text" name="per_nom" size="10" value="'.$_SESSION["per_nom"].'">';
     echo 'Prenom : <input type="text" name="per_prenom" size="10" value="'.$_SESSION["per_prenom"].'">';
     echo "<br /><br />";
     echo 'Téléphone : <input type="text" name="per_tel" size="10" value="'.$_SESSION["per_tel"].'">';
     echo 'Mail : <input type="email" name="per_mail" size="10" value="'.$_SESSION["per_mail"].'">';
     echo "<br /><br />";
     echo 'Login : <input type="text" name="per_login" size="10" value="'.$_SESSION["per_login"].'">';
     echo 'Mot de passe : <input type="password" name="per_pwd" size="10">';
     echo "<br /><br />";
     echo '<input type="submit" name="bouton" value="Valider">';
  }
  else
  {
    $per_nom = $_POST["per_nom"];
    $per_prenom = $_POST["per_prenom"];
    $per_tel = $_POST["per_tel"];
    $per_mail = $_POST["per_mail"];
    $per_login = $_POST["per_login"];
    $per_pwd = sha1(sha1($_POST["per_pwd"]). SALT);

    $arrayPers = array('per_nom' => $per_nom, 'per_prenom' => $per_prenom, 'per_tel' => $per_tel, 'per_mail' => $per_mail, 'per_login' => $per_login, 'per_pwd' => $per_pwd);
    $personne = new Personne($arrayPers);
    $retour=$PersonneManager->update($personne, $_SESSION["per_num"]);

    if ($retour != 0) {
      echo "	<img src=\"image/valid.png\" alt=\"valid\" title=\"modifValide\">";
      echo "    La personne a été modifiée." ;
    }
    else
    {
      echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"modifInvalide\">";
      echo "    Erreur, la personne n'a pas été modifiée." ;
    }
}
?>
</form>
