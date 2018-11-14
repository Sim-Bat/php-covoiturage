<?php
$pdo=new Mypdo();
$PersonneManager = new PersonneManager($pdo);
$personnes=$PersonneManager->getAllPersonnes();
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
      <th>Prenom</th>
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
    
}
?>
