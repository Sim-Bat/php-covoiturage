<?php
class Ville{
	private $numVille;
	private $nomVille;

	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur){
					switch ($attribut){
							case 'vil_num': $this->setNumVille($valeur); break;
							case 'vil_nom': $this->setNomVille($valeur); break;
					}
			}
	}
	public function getNomVille() {
	        return $this->nomVille;
 	}
	public function setNomVille($nom){
	        $this->nomVille=$nom;
	}

	public function getNumVille() {
					return $this->numVille;
	}
	public function setNumVille($id){
					$this->numVille=$id;
	}
}
?>
