<?php
class ParcoursManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
    public function add($parcours){
        $requete = $this->db->prepare(
				'INSERT INTO PARCOURS (par_km, vil_num1, vil_num2) VALUES (:kmParcours, :numVille1, :numVille2);');

				$requete->bindValue(':kmParcours',$parcours->getKmParcours());
        $requete->bindValue(':numVille1',$parcours->getNumVille1Parcours());
        $requete->bindValue(':numVille2',$parcours->getNumVille2Parcours());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllParcours(){
				$listeVilles = array();

				$sql = 'SELECT par_num, par_km, v1.vil_nom AS vil_nom1, v2.vil_nom AS vil_nom2 FROM VILLE v1, PARCOURS p, VILLE v2 WHERE v1.vil_num=p.vil_num1 AND v2.vil_num = p.vil_num2';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($parcours = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeParcours[] = new Parcours($parcours);
				}
				$requete->closeCursor();
				return $listeParcours;
		}

		public function getNbParcours() {
			$sql = 'SELECT COUNT(par_num) AS nbParcours FROM PARCOURS';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreParcours = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreParcours->nbParcours;
		}
}
?>
