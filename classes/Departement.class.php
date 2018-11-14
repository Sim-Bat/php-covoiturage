<?php
class Departement{
  private $dep_num;
	private $dep_nom;
  private $vil_num;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur){
					switch ($attribut){
							case 'dep_num': $this->setdepNum($valeur); break;
							case 'dep_nom': $this->setdepNom($valeur); break;
              case 'vil_num': $this->setVilNum($valeur); break;
					}
			}
	}

  public function getDepNum() {
					return $this->dep_num;
	}
	public function setDepNum($num){
					$this->dep_num=$num;
	}

  public function getDepNom() {
          return $this->dep_nom;
  }
  public function setDepNom($nom){
          $this->dep_nom=$nom;
  }

  public function getVilNum() {
					return $this->vil_num;
	}
	public function setVilNum($num){
					$this->vil_num=$num;
	}
}
?>
