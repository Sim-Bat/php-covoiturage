<?php
class ParcoursManager{
	private $db;

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
				$listeParcours = array();

				$sql = 'SELECT par_num, par_km, v1.vil_nom AS vil_nom1, v2.vil_nom AS vil_nom2 FROM VILLE v1, PARCOURS p, VILLE v2
				WHERE v1.vil_num = p.vil_num1 AND v2.vil_num = p.vil_num2';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($parcours = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeParcours[] = new Parcours($parcours);
				}
				$requete->closeCursor();
				return $listeParcours;
		}

		public function getAllVilles(){
				$listeVilles = array();

				$sql = 'SELECT DISTINCT * FROM (SELECT vil_num, vil_nom FROM VILLE, PARCOURS WHERE  vil_num = vil_num1
					UNION SELECT vil_num, vil_nom FROM PARCOURS, VILLE WHERE vil_num = vil_num2)T1
					ORDER BY vil_nom';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeVilles[] = new Ville($ville);
				}
				$requete->closeCursor();
				return $listeVilles;
		}

		public function getVillesReliees($num){
				$listeVilles = array();

				$sql = "SELECT DISTINCT * FROM
				(SELECT vil_num, vil_nom FROM VILLE, PARCOURS pa, PROPOSE pr
					WHERE pr.par_num = pa.par_num AND vil_num = vil_num1
					AND vil_num2 = $num AND pro_sens = 1
				UNION
				SELECT vil_num, vil_nom FROM VILLE, PARCOURS pa, PROPOSE pr
					WHERE pr.par_num = pa.par_num AND vil_num = vil_num2
					AND vil_num1 = $num AND pro_sens= 0
				)T1
					ORDER BY vil_nom";

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeVilles[] = new Ville($ville);
				}
				$requete->closeCursor();
				return $listeVilles;
		}

		public function getNbParcours() {
			$sql = 'SELECT COUNT(par_num) AS nbParcours FROM PARCOURS';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreParcours = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreParcours->nbParcours;
		}

		public function getVilleNom($num) {

			$sql = 'SELECT * FROM VILLE WHERE vil_num = '.$num;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$ville = new Ville($requete->fetch(PDO::FETCH_OBJ));
			return $ville->getNomVille();
		}
}
?>
