<?php
class SalarieManager{
	private $dbo;

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
}
?>
