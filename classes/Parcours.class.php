<?php
class Parcours{
	private $numParcours;
  private $kmParcours;
	private $numVille1;
  private $numVille2;
	private $nomVille1;
	private $nomVille2;

	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur){
					switch ($attribut){
							case 'par_num': $this->setNumParcours($valeur); break;
							case 'par_km': $this->setKmParcours($valeur); break;
              case 'vil_num1': $this->setNumVille1Parcours($valeur); break;
              case 'vil_num2': $this->setNumVille2Parcours($valeur); break;
							case 'vil_nom1': $this->setNomVille1Parcours($valeur); break;
							case 'vil_nom2': $this->setNomVille2Parcours($valeur); break;
					}
			}
	}

	public function getNumParcours() {
					return $this->numParcours;
	}
	public function setNumParcours($id){
					$this->numParcours=$id;
	}

  public function getKmParcours() {
          return $this->kmParcours;
  }
  public function setKmParcours($km){
          $this->kmParcours=$km;
  }

  public function getNumVille1Parcours() {
          return $this->numVille1;
  }
  public function setNumVille1Parcours($ville1Parcours){
          $this->numVille1=$ville1Parcours;
  }
	public function getNomVille1Parcours() {
					return $this->nomVille1;
	}
	public function setNomVille1Parcours($ville1Parcours){
					$this->nomVille1=$ville1Parcours;
	}

  public function getNumVille2Parcours() {
          return $this->numVille2;
  }
  public function setNumVille2Parcours($ville2Parcours){
          $this->numVille2=$ville2Parcours;
  }
	public function getNomVille2Parcours() {
					return $this->nomVille2;
	}
	public function setNomVille2Parcours($ville2Parcours){
					$this->nomVille2=$ville2Parcours;
	}
}
?>
