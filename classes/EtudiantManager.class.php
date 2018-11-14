<?php
class EtudiantManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
    public function add($etudiant){
        $requete = $this->db->prepare(
				'INSERT INTO ETUDIANT (per_num, dep_num, div_num) VALUES (:per_num, :dep_num, :div_num);');

				$requete->bindValue(':per_num',$etudiant->getPerNum());
        $requete->bindValue(':dep_num',$etudiant->getDepNum());
        $requete->bindValue(':div_num',$etudiant->getDivNum());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllEtudiants(){
				$listeEtudiants = array();

				$sql = 'SELECT per_num, dep_num, div_num FROM ETUDIANT';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($etudiant = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeEtudiants[] = new Etudiant($etudiant);
				}
				$requete->closeCursor();
				return $listeEtudiants;
		}

		public function getNbPersonnes() {
			$sql = 'SELECT COUNT(per_num) AS nbEtudiants FROM ETUDIANT';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreEtudiants = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreEtudiants->nbEtudiants;
		}
}
?>
