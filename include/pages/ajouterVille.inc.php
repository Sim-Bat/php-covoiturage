<h1>Ajouter une ville</h1>
<form action="index.php?page=7" id="insert" method="post">
<?php
  if(empty($_POST["vil_nom"])) {
?>
    Nom : <input type="text" name="vil_nom" size="10">
    <br /><br />
    <input type="submit" name="bouton" value="Valider">

<?php
}
else
{
  $pdo=new Mypdo();
  $villeManager = new VilleManager($pdo);
  $ville = new Ville($_POST);
  $retour=$villeManager->add($ville);

  if ($retour != 0) {
   echo "	<img src=\"image/valid.png\" alt=\"valid\" title=\"insertionValide\">";
   echo "    La ville ".$_POST["vil_nom"]." a été ajoutée." ;
 } else {
   echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"insertionInvalide\">";
   echo "    Erreur, la ville ".$_POST["vil_nom"]." n'a pas été ajoutée." ;
 }
}
?>
</form>
