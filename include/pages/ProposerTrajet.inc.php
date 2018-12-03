<h1>Proposer un trajet</h1>
<form action="index.php?page=9" id="insert" method="post">
<?php
  $pdo=new Mypdo();
  $ParcoursManager = new ParcoursManager($pdo);
  $ProposeManager = new ProposeManager($pdo);
  $villes = $ParcoursManager->getAllVilles();

  if(empty($_POST["vil_num1"]) AND (empty($_POST["vil_num2"]) AND empty($_POST["pro_date"]) AND empty($_POST["pro_time"])
  AND empty($_POST["pro_place"]))) {
?>
    Ville de départ : <select name="vil_num1" size="1">
      <option value="0"> Choisissez</option>
<?php
    foreach ($villes as $ville) {
      echo "<option value=\"".$ville->getNumVille()."\">".$ville->getNomVille()."</option>";
    }
?>
</select>
    <br /><br />
    <input type="submit" name="bouton" value="Valider">
<?php
}
elseif (!empty($_POST["vil_num1"]) AND (empty($_POST["vil_num2"]) AND empty($_POST["pro_date"]) AND empty($_POST["pro_time"])
AND empty($_POST["pro_place"]))) {

    $_SESSION["vil_num1"] = $_POST["vil_num1"];
    $num1 = $_SESSION["vil_num1"];
    $villes2 = $ParcoursManager->getVillesReliees($num1);

    echo "Ville de départ : ".$ParcoursManager->getVilleNom($num1);
?>
    <br /><br />
    Ville d'arrivée : <select name="vil_num2" size="1">
    <option value="0"> Choisissez</option>
    <?php
    foreach ($villes2 as $ville) {
      echo "<option value=\"".$ville->getNumVille()."\">".$ville->getNomVille()."</option>";
    }
    ?>
  </select>
    <br /><br />
<?php
    echo 'Date de départ : <input type="date" name="pro_date" size="10" value="'.getEnglishDate(date('d/m/Y')).'">';
?>
    <br /><br />
<?php
    echo 'Heure de départ : <input type="time" name="pro_time" size="10" value="'.date("H:i:s").'">';
?>
    <br /><br />
    Nombre de places : <input type="text" name="pro_place" size="10">
    <br /><br />
    <input type="submit" name="bouton" value="Valider">
<?php
  }
  else
  {
      $par_num = $ProposeManager->getParcoursNum($_SESSION["vil_num1"], $_POST["vil_num2"]);
      $per_num = $_SESSION["per_num"];
      $pro_date = $_POST["pro_date"];
      $pro_time = $_POST["pro_time"];
      $pro_place = $_POST["pro_place"];
      $pro_sens = $ProposeManager->getProSens($_SESSION["vil_num1"], $_POST["vil_num2"]);

      $arrayPropose = array('par_num' => $par_num, 'per_num' => $per_num, 'pro_date' => $pro_date, 'pro_time' => $pro_time, 'pro_place' => $pro_place, 'pro_sens' => $pro_sens);
      $propose = new Propose($arrayPropose);
      $retour=$ProposeManager->add($propose);

      if ($retour != 0) {
        echo "	<img src=\"image/valid.png\" alt=\"valid\" title=\"insertionValide\">";
        echo "    La trajet a été proposé." ;
      }
      else
      {
        echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"insertionInvalide\">";
        echo "    Erreur, le trajet n'a pas été proposé." ;
      }
    }
?>
</form>
