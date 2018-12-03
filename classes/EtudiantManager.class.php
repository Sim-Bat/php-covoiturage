<?php
class EtudiantManager{
	private $db;

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

		public function delete($pernum){
				$requete = $this->db->prepare(
				'DELETE FROM ETUDIANT WHERE per_num = :per_num;');

				$requete->bindValue(':per_num',$pernum);

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

		public function getEtudiant($num) {

			$sql = 'SELECT * FROM ETUDIANT WHERE per_num = '.$num;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$etu = new Etudiant($requete->fetch(PDO::FETCH_OBJ));
			return $etu;
		}

		public function getDepEtu($num) {

			$etu = new Etudiant($this->getEtudiant($num));

			$depnum = $etu->getDepNum();

			$sql = 'SELECT * FROM DEPARTEMENT WHERE dep_num = '.$depnum;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$dep = new Departement($requete->fetch(PDO::FETCH_OBJ));
			return $dep;
		}

		public function getDepNomEtu($num) {
			$dep = new Departement($this->getDepEtu($num));
			return $dep->getDepNom();
		}

		public function getDepVilleEtu($num) {
			$dep = new Departement($this->getDepEtu($num));

			$vilnum = $dep->getVilNum();

			$sql = 'SELECT * FROM VILLE WHERE vil_num = '.$vilnum;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$vil = new Ville($requete->fetch(PDO::FETCH_OBJ));
			return $vil->getNomVille();
		}
}
?>
