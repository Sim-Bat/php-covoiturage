<?php
class PersonneManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
    public function add($personne){
        $requete = $this->db->prepare(
				'INSERT INTO PERSONNE (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd);');

				$requete->bindValue(':per_nom',$personne->getPerNom());
        $requete->bindValue(':per_prenom',$personne->getPerPrenom());
        $requete->bindValue(':per_tel',$personne->getPerTel());
        $requete->bindValue(':per_mail',$personne->getPerMail());
        $requete->bindValue(':per_login',$personne->getPerLogin());
        $requete->bindValue(':per_pwd',$personne->getPerPwd());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllPersonnes(){
				$listePersonnes = array();

				$sql = 'SELECT per_num, per_nom, per_prenom FROM PERSONNE';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($personne = $requete->fetch(PDO::FETCH_OBJ)) {
						$listePersonnes[] = new Personne($personne);
				}
				$requete->closeCursor();
				return $listePersonnes;
		}

		public function getNbPersonnes() {
			$sql = 'SELECT COUNT(per_num) AS nbPersonnes FROM PERSONNE';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbrePersonnes = $requete->fetch(PDO::FETCH_OBJ);
			return $nbrePersonnes->nbPersonnes;
		}

		public function getLastId() {
			$pdo = new Mypdo();
			return $pdo->lastInsertId();
		}

		public function isEtudiant($num) {
			
		}
}
?>
