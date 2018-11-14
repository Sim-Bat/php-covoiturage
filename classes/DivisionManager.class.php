<?php
class DivisionManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
    public function add($division){
        $requete = $this->db->prepare(
				'INSERT INTO DIVISION (div_num, div_nom) VALUES (:div_num, :div_nom);');

				$requete->bindValue(':div_num',$division->getDivNum());
        $requete->bindValue(':div_nom',$division->getDivNom());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllDivisions(){
				$listeDivisions = array();

				$sql = 'SELECT div_num, div_nom FROM DIVISION';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($division = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeDivisions[] = new Division($division);
				}
				$requete->closeCursor();
				return $listeDivisions;
		}

		public function getNbDivisions() {
			$sql = 'SELECT COUNT(div_num) AS nbDivision FROM DIVISION';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreDivisions = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreDivisions->nbDivisions;
		}
}
?>
