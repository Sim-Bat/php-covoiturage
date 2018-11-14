<h1>Ajouter un parcours</h1>
<form action="index.php?page=5" id="insert" method="post">
<?php
  $pdo=new Mypdo();
  $VilleManager = new VilleManager($pdo);
  $villes=$VilleManager->getAllVilles();

  if(empty($_POST["vil_num1"]) OR empty($_POST["vil_num2"]) OR empty($_POST["par_km"])) {
?>
    Ville 1 : <select name="vil_num1" size="1">
      <option value="0"> Ville 1</option>
<?php
    foreach ($villes as $ville) {
      echo "<option value=\"".$ville->getNumVille()."\">".$ville->getNomVille()."</option>";
    }
?>
    </select>
      Ville 2 : <select name="vil_num2" size="1">
      <option value="0"> Ville 2</option>
<?php
      foreach ($villes as $ville) {
        echo "<option value=\"".$ville->getNumVille()."\">".$ville->getNomVille()."</option>";
      }
?>
    </select>
    Nombre de kilomètre(s) : <input type="text" name="par_km" size="10">
    <br /><br />
    <input type="submit" name="bouton" value="Valider">
<?php
}
else
{
  if ($_POST["vil_num1"] == $_POST["vil_num2"]) {
    echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"insertionInvalide\">";
    echo "    Erreur, ce parcours n'est pas valide.";
  }
  else
  {
      $parcoursManager = new ParcoursManager($pdo);
      $parcours = new Parcours($_POST);
      $retour=$parcoursManager->add($parcours);

      if ($retour != 0) {
        echo "	<img src=\"image/valid.png\" alt=\"valid\" title=\"insertionValide\">";
        echo "    La parcours a été ajoutée." ;
      }
      else
      {
        echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"insertionInvalide\">";
        echo "    Erreur, le parcours n'a pas été ajoutée." ;
      }
    }
  }
?>
</form>
