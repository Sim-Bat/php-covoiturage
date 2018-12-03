<?php
class SalarieManager{
	private $db;

		public function __construct($db){
			$this->db = $db;
		}

    public function add($salarie){
        $requete = $this->db->prepare(
				'INSERT INTO SALARIE (per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num);');

				$requete->bindValue(':per_num',$salarie->getPerNum());
        $requete->bindValue(':sal_telprof',$salarie->getSalTelProf());
        $requete->bindValue(':fon_num',$salarie->getFonNum());

        $retour=$requete->execute();
				return $retour;
    }

		public function delete($pernum){
				$requete = $this->db->prepare(
				'DELETE FROM SALARIE WHERE per_num = :per_num;');

				$requete->bindValue(':per_num',$pernum);

				$retour=$requete->execute();
				return $retour;
		}

		public function getAllSalaries(){
				$listeSalaries = array();

				$sql = 'SELECT per_num, sal_telprof, fon_num FROM SALARIE';

				$requete = $this->db->prepare($sql);
				$requete->execute();

				while ($salarie = $requete->fetch(PDO::FETCH_OBJ)) {
						$listeSalaries[] = new Salarie($salarie);
				}
				$requete->closeCursor();
				return $listeSalaries;
		}

		public function getNbSalaries() {
			$sql = 'SELECT COUNT(per_num) AS nbSalaries FROM SALARIE';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbreSalaries = $requete->fetch(PDO::FETCH_OBJ);
			return $nbreSalaries->nbSalaries;
		}

		public function getSalarie($num) {

			$sql = 'SELECT * FROM SALARIE WHERE per_num = '.$num;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$sal = new Salarie($requete->fetch(PDO::FETCH_OBJ));
			return $sal;
		}

		public function getTelProSal($num) {
			$sal = new Salarie($this->getSalarie($num));
			return $sal->getSalTelProf();
		}

		public function getFonctionSal($num) {
			$salarie = new Salarie($this->getSalarie($num));

			$fonnum = $salarie->getFonNum();

			$sql = 'SELECT fon_libelle FROM FONCTION WHERE fon_num = '.$fonnum;

			$requete = $this->db->prepare($sql);
			$requete->execute();

			$fon = new Fonction($requete->fetch(PDO::FETCH_OBJ));
			return $fon;
		}

		public function getFonNomSal($num) {
			$fon = new Fonction($this->getFonctionSal($num));
			return $fon->getFonLibelle();
		}
}
?>
