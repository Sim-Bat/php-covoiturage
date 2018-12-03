<?php
class ProposeManager{
	private $dbo;

	public function __construct($db){
		$this->db = $db;
	}

  public function add($propose){
      $requete = $this->db->prepare(
			'INSERT INTO PROPOSE (par_num, per_num, pro_date, pro_time, pro_place, pro_sens)
			VALUES (:par_num, :per_num, :pro_date, :pro_time, :pro_place, :pro_sens);');

			$requete->bindValue(':par_num',$propose->getParNum());
      $requete->bindValue(':per_num',$propose->getPerNum());
      $requete->bindValue(':pro_date',$propose->getProDate());
      $requete->bindValue(':pro_time',$propose->getProTime());
      $requete->bindValue(':pro_place',$propose->getProPlace());
      $requete->bindValue(':pro_sens',$propose->getProSens());

      $retour=$requete->execute();
			return $retour;
  }

	public function delete($pernum){
		$requete = $this->db->prepare(
		'DELETE FROM propose WHERE per_num = :per_num;');

		$requete->bindValue(':per_num',$pernum);

		$retour=$requete->execute();
		return $retour;
}

  public function getParcoursNum($villeDepart, $villeArrivee) {
    $sql = "SELECT par_num FROM PARCOURS WHERE vil_num1 = $villeDepart AND vil_num2 = $villeArrivee";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    if ($requete->rowCount() == 0) {
      $sql = "SELECT par_num FROM PARCOURS WHERE vil_num1 = $villeArrivee AND vil_num2 = $villeDepart";

      $requete = $this->db->prepare($sql);
      $requete->execute();
    }

    $numParc = $requete->fetch(PDO::FETCH_OBJ);

    return $numParc->par_num;
  }

  public function getProSens($villeDepart, $villeArrivee) {
    $sql = "SELECT par_num FROM PARCOURS WHERE vil_num1 = $villeDepart AND vil_num2 = $villeArrivee";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    if ($requete->rowCount() == 0) {
      return 0;
    }
    else
    {
      return 1;
    }
  }

	public function getAllVilleDepart () {
		$listeVillesDep = array();

		$sql = 'SELECT DISTINCT * FROM (SELECT vil_num, vil_nom FROM PROPOSE pr, VILLE, PARCOURS pa WHERE  vil_num = vil_num1
			AND pr.par_num = pa.par_num AND pro_sens = 0
			UNION SELECT vil_num, vil_nom FROM PROPOSE pr, PARCOURS pa, VILLE WHERE vil_num = vil_num2 AND pr.par_num = pa.par_num AND pro_sens = 1)T1
			ORDER BY vil_nom';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
				$listeVillesDep[] = new Ville($ville);
		}
		$requete->closeCursor();
		return $listeVillesDep;
	}

	public function getAllTrajets($vilDep, $vilArr, $dateDepMin, $dateDepMax, $heureDep){
		$listePropose = array();

		$sql = "SELECT * FROM
		(SELECT per_num, pro_date, pro_time, pro_place FROM PROPOSE pr, PARCOURS pa
			WHERE pr.par_num = pa.par_num AND vil_num1 = $vilArr AND vil_num2 = $vilDep AND pro_sens = 1
			UNION
			SELECT per_num, pro_date, pro_time, pro_place FROM PROPOSE pr, PARCOURS pa
			WHERE pr.par_num = pa.par_num AND vil_num1 = $vilDep AND vil_num2 = $vilArr AND pro_sens = 0
		)T1
		WHERE pro_place > 0 AND pro_time >= \"$heureDep\" AND pro_date >= \"$dateDepMin\" AND pro_date <=\"$dateDepMax\"
		ORDER BY pro_date, pro_time";

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while ($propose = $requete->fetch(PDO::FETCH_OBJ)) {
			$listePropose[] = new Propose($propose);
		}
		$requete->closeCursor();
		return $listePropose;
	}
}
?>
