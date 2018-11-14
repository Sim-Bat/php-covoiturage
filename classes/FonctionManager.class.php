<?php
class FonctionManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
    public function add($fonction){
        $requete = $this->db->prepare(
				'INSERT INTO FONCTION (fon_num, fon_libelle) VALUES (:fon_num, :fon_libelle);');

				$requete->bindValue(':fon_num',$fonction->getFonNum());
        $requete->bindValue(':fon_libelle',$fonction->getFonLibelle());

        $retour=$requete->execute();
				return $retour;
    }

		public function getAllFonctions(){
				$listeFonctions = array();

				$sql = 'SELECT fon_num, fon_libelle FROM FONCTION';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($fonction = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeFonctions[] = new Fonction($fonction);
				}
				$requete->closeCursor();
				return $listeFonctions;
		}

		public function getNbFonctions() {
			$sql = 'SELECT COUNT(fon_num) AS nbFonctions FROM FONCTION';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreFonctions = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreFonctions->nbFonctions;
		}
}
?>
