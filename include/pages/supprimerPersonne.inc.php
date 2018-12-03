<form action="index.php?page=4" id="insert" method="post">
<h1>Modifier une personne</h1>
<?php
  $pdo=new Mypdo();
  $PersonneManager = new PersonneManager($pdo);
  $EtudiantManager = new EtudiantManager($pdo);
  $SalarieManager = new SalarieManager($pdo);
  $ProposeManager = new ProposeManager($pdo);

  $personnes = $PersonneManager->getAllPersonnes();

  if (empty($_POST["per_num"])) {
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
  else
  {
    if ($PersonneManager->isEtudiant($_POST["per_num"])) {
      $retour=$EtudiantManager->delete($_POST["per_num"]);
    }
    else {
      $retour=$SalarieManager->delete($_POST["per_num"]);
    }
    $retour=$ProposeManager->delete($_POST["per_num"]);
    $retour=$PersonneManager->delete($_POST["per_num"]);

    if ($retour != 0) {
      echo "	<img src=\"image/valid.png\" alt=\"valid\" title=\"supValide\">";
      echo "    La personne a été supprimée." ;
    }
    else
    {
      echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"supInvalide\">";
      echo "    Erreur, la personne n'a pas été supprimée." ;
    }
}
?>
</form>
