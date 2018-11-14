<?php
class Etudiant{
	private $per_num;
  private $div_num;
	private $dep_num;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur){
					switch ($attribut){
							case 'per_num': $this->setPerNum($valeur); break;
							case 'dep_num': $this->setDepNum($valeur); break;
              case 'div_num': $this->setDivNum($valeur); break;
					}
			}
	}

	public function getPerNum() {
					return $this->per_num;
	}
	public function setPerNum($id){
					$this->per_num=$id;
	}

  public function getDepNum() {
					return $this->dep_num;
	}
	public function setDepNum($num){
					$this->dep_num=$num;
	}

  public function getDivNum() {
					return $this->div_num;
	}
	public function setDivNum($num){
					$this->div_num=$num;
	}
}
?>
