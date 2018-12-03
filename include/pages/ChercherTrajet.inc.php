<h1>Rechercher un trajet</h1>
<form action="index.php?page=10" id="insert" method="post">
<?php
  $pdo=new Mypdo();
  $PersonneManager = new PersonneManager($pdo);
  $VilleManager = new VilleManager($pdo);
  $ParcoursManager = new ParcoursManager($pdo);
  $ProposeManager = new ProposeManager($pdo);

  if (empty($_POST["villeDep"]) AND (empty($_POST["villeArr"])
  AND empty($_POST["pro_date"]) AND empty($_POST["pro_time"])
  AND empty($_POST["pro_prec"]))) {

    $villes = $ProposeManager->getAllVilleDepart();
?>
    Ville de départ : <select name="villeDep" size="1">
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
  elseif (!empty($_POST["villeDep"]) AND (empty($_POST["villeArr"])
  AND empty($_POST["pro_date"]) AND empty($_POST["pro_time"])
  AND empty($_POST["pro_prec"]))) {

    $_SESSION["villeDep"] = $_POST["villeDep"];
    $villes2 = $ParcoursManager->getVillesReliees($_SESSION["villeDep"]);

    echo "Ville de départ : ".$ParcoursManager->getVilleNom($_SESSION["villeDep"]);
?>
    <br /><br />
    Ville d'arrivée : <select name="villeArr" size="1">
    <option value="0"> Choisissez</option>
    <?php
    foreach ($villes2 as $ville) {
      echo "<option value=\"".$ville->getNumVille()."\">".$ville->getNomVille()."</option>";
    }
    ?>
    </select>
    <br /><br />
<?php
    $date = getEnglishDate(date('d/m/Y'));
    echo "Date de départ : <input type=\"date\" name=\"pro_date\" size=\"10\" value=\"$date\">";
?>
    <br /><br />
    A partir de  : <select name="pro_time" size="1">
<?php
    for ($i=0; $i < 24 ; $i++) {
      if ($i < 10){
        $i = '0'.$i;
      }
      echo "<option value=\"$i\">$i h</option>";
    }
?>
    </select>
    <br /><br />
    Précision : <select name="pro_prec" size="1">
      <option value="0">Ce jour</option>
      <option value="1">+/- 1 jour</option>
      <option value="2">+/- 2 jour</option>
      <option value="3">+/- 3 jour</option>
    </select>
    <br /><br />
    <input type="submit" name="bouton" value="Valider">
<?php
  }
  else
  {
      $villeDepart = $_SESSION["villeDep"];
      $villeArrivee = $_POST["villeArr"];
      $pro_date = $_POST["pro_date"];
      $pro_time = $_POST["pro_time"].":00:00";
      $pro_prec = $_POST["pro_prec"];
      $dateMin = removeJours($pro_date, $pro_prec);
      $dateMax = addJours($pro_date, $pro_prec);

      $trajetPropose = $ProposeManager->getAllTrajets($villeDepart, $villeArrivee, $dateMin, $dateMax, $pro_time);

      if (!empty($trajetPropose)) {
?>
        <table border=1>
          <tr>
            <th>Ville départ</th>
            <th>Ville arrivée</th>
            <th>Date départ</th>
            <th>Heure départ</th>
            <th>Nombre de place(s)</th>
            <th>Nom du covoitureur</th>
          </tr>
<?php
        $villeDep = $VilleManager->getVille($_SESSION["villeDep"]);
        $villeArr = $VilleManager->getVille($_POST["villeArr"]);

        foreach ($trajetPropose as $trajet) {

          $pernum = $trajet->getPerNum();
          $personne = $PersonneManager->getPersonne($pernum);
          $pers = $personne->getPerNom()." ".$personne->getPerPrenom();
          $date = $trajet->getProDate();
          $time = $trajet->getProTime();
          $nbPlace = $trajet->getProPlace();

            echo "<tr>";
              echo "<td>$villeDep</td>";
              echo "<td>$villeArr</td>";
              echo "<td>$date</td>";
              echo "<td>$time</td>";
              echo "<td>$nbPlace</td>";
              echo "<td>$pers</td>";
            echo "</tr>";
        }
        echo "</table>";
      }
      else
      {
        echo "<img src=\"image/erreur.png\" alt=\"erreur\" title=\"trajetInvalide\">";
        echo "    Désolé, pas de trajet disponible !" ;
      }
    }
?>
</form>
