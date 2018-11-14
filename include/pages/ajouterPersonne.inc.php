<form action="index.php?page=1" id="insert" method="post">
<?php
  $pdo=new Mypdo();
  $PersonneManager = new PersonneManager($pdo);
  $EtudiantManager = new EtudiantManager($pdo);
  $DivisionManager = new DivisionManager($pdo);
  $DepartementManager = new DepartementManager($pdo);
  $SalarieManager = new SalarieManager($pdo);
  $FonctionManager = new FonctionManager($pdo);

  $divisions = $DivisionManager->getAllDivisions();
  $departements = $DepartementManager->getAllDepartements();
  $fonctions = $FonctionManager->getAllFonctions();

  if((empty($_POST["per_nom"]) OR empty($_POST["per_prenom"]) OR empty($_POST["per_tel"])
   OR empty($_POST["per_mail"]) OR empty($_POST["per_login"]) OR empty($_POST["per_pwd"]))
   AND (empty($_POST["dep_num"]) AND empty($_POST["div_num"]) AND empty($_POST["fon_num"]) AND empty($_POST["sal_telprof"]))) {
?>
    <h1>Ajouter une personne</h1>
    Nom : <input type="text" name="per_nom" size="10">
    Prenom : <input type="text" name="per_prenom" size="10">
    <br /><br />
    Téléphone : <input type="text" name="per_tel" size="10">
    Mail : <input type="text" name="per_mail" size="10">
    <br /><br />
    Login : <input type="text" name="per_login" size="10">
    Mot de passe : <input type="password" name="per_pwd" size="10">
    <br /><br />
    Catégorie : <input type="radio" name="categorie" value="Etudiant"> Etudiant
      <input type="radio" name="categorie" value="Personnel"> Personnel
    <br /><br />
    <input type="submit" name="bouton" value="Valider">

<?php
}
else if (!empty($_POST["categorie"]))
{
    $_SESSION["per_nom"] = $_POST["per_nom"];
    $_SESSION["per_prenom"] = $_POST["per_prenom"];
    $_SESSION["per_tel"] = $_POST["per_tel"];
    $_SESSION["per_mail"] = $_POST["per_mail"];
    $_SESSION["per_login"] = $_POST["per_login"];
    $_SESSION["per_pwd"] = sha1(sha1($_POST["per_pwd"]). SALT);
    $_SESSION["categorie"] = $_POST["categorie"];

    if ($_POST["categorie"] == "Etudiant") {
      ?>
      <h1>Ajouter un étudiant</h1>
      Année  : <select name="div_num" size="1">
      <option value="0"> Année</option>
      <?php
      foreach ($divisions as $division) {
        echo "<option value=\"".$division->getDivNum()."\">".$division->getDivNom()."</option>";
      }
      echo "</select>";
      ?>
      <br /><br />
      Département  : <select name="dep_num" size="1">
      <option value="0"> Département</option>
      <?php
      foreach ($departements as $departement) {
        echo "<option value=\"".$departement->getDepNum()."\">".$departement->getDepNom()."</option>";
      }
      echo "</select>";
      ?>
      <br /><br />
      <input type="submit" name="bouton" value="Valider">
      <?php
    }
    else
    {
      ?>
      <h1>Ajouter un salarie</h1>
      Téléphone professionnel : <input type="text" name="sal_telprof" size="10">
      <br /><br />
      Fonction  : <select name="fon_num" size="1">
      <option value="0"> Fonction</option>
      <?php
      foreach ($fonctions as $fonction) {
        echo "<option value=\"".$fonction->getFonNum()."\">".$fonction->getFonLibelle()."</option>";
      }
      echo "</select>";
      ?>
      <br /><br />
      <input type="submit" name="bouton" value="Valider">
      <?php
    }
  }
  else
  {
    $per_nom = $_SESSION["per_nom"];
    $per_prenom = $_SESSION["per_prenom"];
    $per_tel = $_SESSION["per_tel"];
    $per_mail = $_SESSION["per_mail"];
    $per_login = $_SESSION["per_login"];
    $per_pwd = $_SESSION["per_pwd"];

    $arrayPers = array('per_nom' => $per_nom, 'per_prenom' => $per_prenom, 'per_tel' => $per_tel, 'per_mail' => $per_mail, 'per_login' => $per_login, 'per_pwd' => $per_pwd);
    $personne = new Personne($arrayPers);
    $retour=$PersonneManager->add($personne);

    $_SESSION["per_num"] = $PersonneManager->getLastId();

    $per_num = $_SESSION["per_num"];

    if ($retour == 0) {
      echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"insertionInvalide\">";
      echo "    Erreur, la personne n'a pas été ajoutée." ;
    }
    else
    {
      if ($_SESSION["categorie"] == "Personnel") {
        $_SESSION["sal_telprof"] = $_POST["sal_telprof"];
        $_SESSION["fon_num"] = $_POST["fon_num"];

        $sal_telprof = $_SESSION["sal_telprof"];
        $fon_num = $_SESSION["fon_num"];

        $arraySal = array('per_num' => $per_num,'sal_telprof' => $sal_telprof, 'fon_num' => $fon_num);
        $salarie = new Salarie($arraySal);
        $retour=$SalarieManager->add($salarie);
      }
      else
      {
        $_SESSION["dep_num"] = $_POST["dep_num"];
        $_SESSION["div_num"] = $_POST["div_num"];

        $dep_num = $_SESSION["dep_num"];
        $div_num = $_SESSION["div_num"];

        $arrayEtu = array('per_num' => $per_num,'dep_num' => $dep_num, 'div_num' => $div_num);
        $etudiant = new Etudiant($arrayEtu);
        $retour=$EtudiantManager->add($etudiant);
      }
    }
    ?>
    <h1>Ajouter une personne</h1>
    <?php
    if ($retour != 0 ) {
     echo "	<img src=\"image/valid.png\" alt=\"valid\" title=\"insertionValide\">";
     echo "    La personne a été ajoutée." ;
   }
   else
   {
     echo "	<img src=\"image/erreur.png\" alt=\"erreur\" title=\"insertionInvalide\">";
     echo "    Erreur, la personne n'a pas été ajoutée." ;
   }
}
?>
</form>
