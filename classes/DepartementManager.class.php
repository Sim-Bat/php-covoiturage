<?php
class DepartementManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
    public function add($departement){
        $requete = $this->db->prepare(
				'INSERT INTO DEPARTEMENT (dep_num, dep_nom, vil_num) VALUES (:dep_num, :dep_nom, :vil_num);');

				$requete->bindValue(':dep_num',$departement->getDepNum());
        $requete->bindValue(':dep_nom',$departement->getDepNom());
        $requete->bindValue(':vil_num',$departement->getVilNum());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllDepartements(){
				$listeDepartements = array();

				$sql = 'SELECT dep_num, dep_nom, vil_num FROM DEPARTEMENT';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($departement = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeDepartements[] = new Departement($departement);
				}
				$requete->closeCursor();
				return $listeDepartements;
		}

		public function getNbDepartements() {
			$sql = 'SELECT COUNT(dep_num) AS nbDepartements FROM DEPARTEMENT';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreDepartements = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreDepartements->nbDepartements;
		}
}
?>
