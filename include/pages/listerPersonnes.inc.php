<?php
$pdo=new Mypdo();
$EtudiantManager = new EtudiantManager($pdo);
$SalarieManager = new SalarieManager($pdo);
$PersonneManager = new PersonneManager($pdo);
$personnes = $PersonneManager->getAllPersonnes();
$nbPersonnes = $PersonneManager->getNbPersonnes();

if(empty($_GET["perNum"])){
?>
<h1>Liste des personnes enregistrées</h1>
<?php
  echo "Actuellement $nbPersonnes personnes sont enregistrées";
?>
<table border=1>
		<tr>
      <th>Numéro</th>
      <th>Nom</th>
      <th>Prénom</th>
    </tr>
<?php
    foreach ($personnes as $personne) {
			echo "<tr>";
      echo "<td><a href=\"index.php?page=2&perNum=".$personne->getPerNum()."\">".$personne->getPerNum()."</a></td>";
      echo "<td>".$personne->getPerNom()."</td>";
      echo "<td>".$personne->getPerPrenom()."</td>";
      echo "</tr>";
    }
?>
</table>

<?php
}
else
{
    $num = $_GET["perNum"];
    $pers = $PersonneManager->getPersonne($num);
    if($PersonneManager->isEtudiant($num)) {

      echo "<h1>Détail sur l'étudiant ".$PersonneManager->getPersonne($num)->getPerNom()."</h1>";
?>
      <table border=1>
      		<tr>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Tel</th>
            <th>Département</th>
            <th>Ville</th>
          </tr>
<?php
        echo "<tr>";
          echo "<td>".$pers->getPerPrenom()."</td>";
          echo "<td>".$pers->getPerMail()."</td>";
          echo "<td>".$pers->getPerTel()."</td>";
          echo "<td>".$EtudiantManager->getDepNomEtu($num)."</td>";
          echo "<td>".$EtudiantManager->getDepVilleEtu($num)."</td>";
        echo "</tr>";
      echo "</table>";
    }
    else
    {
      $sal = new Salarie($SalarieManager->getSalarie($num));

      echo "<h1>Détail sur le salarié".$pers->getPerNom()."</h1>";
?>
      <table border=1>
          <tr>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Tel</th>
            <th>Tel pro</th>
            <th>Fonction</th>
          </tr>
<?php
        echo "<tr>";
          echo "<td>".$pers->getPerPrenom()."</td>";
          echo "<td>".$pers->getPerMail()."</td>";
          echo "<td>".$pers->getPerTel()."</td>";
          echo "<td>".$SalarieManager->gettelProSal($num)."</td>";
          echo "<td>".$SalarieManager->getFonNomSal($num)."</td>";
        echo "</tr>";
      echo "</table>";
    }
}
?>
