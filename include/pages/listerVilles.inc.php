<?php
$pdo=new Mypdo();
$VilleManager = new VilleManager($pdo);
$villes=$VilleManager->getAllVilles();
$nbVille = $VilleManager->getNbVille();
?>
<h1>Liste des villes</h1>
<?php
  echo "Actuellement $nbVille villes sont enregistrées";
?>
<table border=1>
		<tr>
      <th>Numéro</th>
      <th>Nom</th>
    </tr>

<?php
    foreach ($villes as $ville) {
			echo "<tr>";
      echo "<td>".$ville->getNumVille()."</td>";
      echo "<td>".$ville->getNomVille()."</td>";
      echo "</tr>";
    }
?>
</table>
