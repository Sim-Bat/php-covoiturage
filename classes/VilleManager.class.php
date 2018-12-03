<?php
class VilleManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

    public function add($ville){
        $requete = $this->db->prepare(
				'INSERT INTO VILLE (vil_nom) VALUES (:nomVille);');

				$requete->bindValue(':nomVille',$ville->getNomVille());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllVilles(){
				$listeVilles = array();

				$sql = 'SELECT vil_num, vil_nom FROM VILLE';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeVilles[] = new Ville($ville);
				}
				$requete->closeCursor();
				return $listeVilles;
		}

		public function getNbVille() {
			$sql = 'SELECT COUNT(vil_num) AS nbVille FROM VILLE';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreVille = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreVille->nbVille;
		}

		public function getVille($num) {

			$sql = 'SELECT vil_nom FROM VILLE WHERE vil_num = '.$num;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$ville = $requete->fetch(PDO::FETCH_OBJ);
			return $ville->vil_nom;
		}
}
?>
