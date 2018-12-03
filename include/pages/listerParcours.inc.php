<?php
$pdo=new Mypdo();
$ParcoursManager = new ParcoursManager($pdo);
$parcours=$ParcoursManager->getAllParcours();
$nbParcours = $ParcoursManager->getNbParcours();
?>
<h1>Liste des parcours</h1>
<?php
  echo "Actuellement $nbParcours parcours sont enregistrées";
?>
<table border=1>
		<tr>
      <th>Numéro</th>
      <th>Nom ville 1</th>
      <th>Nom ville 2</th>
      <th>Nombre de Km</th>
    </tr>

<?php
    foreach ($parcours as $parcours) {
			echo "<tr>";
      echo "<td>".$parcours->getNumParcours()."</td>";
      echo "<td>".$parcours->getNomVille1Parcours()."</td>";
      echo "<td>".$parcours->getNomVille2Parcours()."</td>";
      echo "<td>".$parcours->getKmParcours()."</td>";
      echo "</tr>";
    }
?>
</table>
