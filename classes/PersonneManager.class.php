<?php
class PersonneManager{
	private $db;

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

	public function update($personne, $pernum){
			$requete = $this->db->prepare(
			'UPDATE PERSONNE SET per_nom = :per_nom, per_prenom = :per_prenom, per_tel = :per_tel, per_mail = :per_mail, per_login = :per_login, per_pwd = :per_pwd
			WHERE per_num = :per_num;');

			$requete->bindValue(':per_num',$pernum);
			$requete->bindValue(':per_nom',$personne->getPerNom());
			$requete->bindValue(':per_prenom',$personne->getPerPrenom());
			$requete->bindValue(':per_tel',$personne->getPerTel());
			$requete->bindValue(':per_mail',$personne->getPerMail());
			$requete->bindValue(':per_login',$personne->getPerLogin());
			$requete->bindValue(':per_pwd',$personne->getPerPwd());

			$retour=$requete->execute();
			return $retour;
	}

	public function delete($pernum){
			$requete = $this->db->prepare(
			'DELETE FROM PERSONNE WHERE per_num = :per_num;');

			$requete->bindValue(':per_num',$pernum);

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
		$sql = 'SELECT per_num AS numPer FROM ETUDIANT WHERE per_num ='.$num;

		$requete = $this->db->prepare($sql);
		$requete->execute();

		$numPersonnes = $requete->fetch(PDO::FETCH_OBJ);

		if(!empty($numPersonnes->numPer)){
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getPersonne($num) {

		$sql = 'SELECT * FROM PERSONNE WHERE per_num = '.$num;

		$requete = $this->db->prepare($sql);
		$requete->execute();

		$personne = new Personne($requete->fetch(PDO::FETCH_OBJ));
		return $personne;
	}

	public function checkPersonne($login, $pwd) {
		$sql = "SELECT per_num AS numPer FROM PERSONNE WHERE per_login = \"$login\" AND per_pwd = \"$pwd\"";

		$requete = $this->db->prepare($sql);
		$requete->execute();

		$numPersonnes = $requete->fetch(PDO::FETCH_OBJ);

		if(!empty($numPersonnes->numPer)){
			return $numPersonnes->numPer;
		}
		else
		{
			return false;
		}
	}
}
?>
