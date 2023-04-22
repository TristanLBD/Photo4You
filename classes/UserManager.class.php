<?php
class UserManager
{
	private $_db;

	public function __construct($db) {
		$this->setDB($db);
	}

	public function add(User $user) {
		$q = $this->_db->prepare('INSERT INTO utilisateurs(nom,prenom,type,mail,mdp) VALUES(:nom, :prenom, :type, :mail, :mdp)');
		$q->bindValue(':nom', $user->getNom());
		$q->bindValue(':prenom', $user->getPrenom());
		$q->bindValue(':type', $user->getType());
		$q->bindValue(':mail', $user->getMail());
		$q->bindValue(':mdp', $user->getMdp());
		$q->execute();

		$user->hydrate([
			'Id' => $this->_db->lastInsertId(),
			'Credit' => 0]);
	}

	public function updateCredits(User $user) {
		$q = $this->_db->prepare('UPDATE utilisateurs set Credit = :mcredit WHERE Id = :mid');
		$q->bindValue(':mcredit', $user->getCredit());
		$q->bindValue(':mid', $user->getId());
		$q->execute();

		$user->hydrate([
			'Id' => $this->_db->lastInsertId(),
			'Credit' => 0]);
	}

	public function banUser($idUser) {
		$q = $this->_db->prepare('UPDATE utilisateurs set Banned = 1 WHERE Id = :mid');
		$q->bindValue(':mid', $idUser);
		$q->execute();
	}

	public function unbanUser($idUser) {
		$q = $this->_db->prepare('UPDATE utilisateurs set Banned = 0 WHERE Id = :mid');
		$q->bindValue(':mid', $idUser);
		$q->execute();
	}

	public function delete($id, PhotoManager $managerPhoto) {
		$managerPhoto->deleteByProprietaire($id,$managerPhoto);
		$q = $this->_db->prepare('DELETE FROM utilisateurs WHERE Id = :id');
		$q->bindValue(':id', $id);
		$q->execute();
	}

	public function getUserByMail($sonMail) {
		$q= $this->_db->prepare('SELECT Id, Nom, Prenom, Mail, Mdp, Type, Credit,Banned FROM utilisateurs WHERE Mail = :mail');
		// $q= $this->_db->query('SELECT Id, Nom, Prenom, Mail, Mdp, Type, Credit,Banned FROM utilisateurs WHERE Mail = "'. $sonMail .'"');
		$q->bindValue(':mail', $sonMail);
		$q->execute();
		$userInfo = $q->fetch(PDO::FETCH_ASSOC);
		if ($userInfo) {
			return new User($userInfo);
		} else {
			return $userInfo;
		}
	}

	public function getUser($sonID) {
		$q= $this->_db->prepare("SELECT Id,Nom, Prenom,Credit, Mail, Mdp, Type FROM utilisateurs WHERE Id = :iduser");
		$q->execute([':iduser'=> $sonID]);
		$userInfo = $q->fetch(PDO::FETCH_ASSOC);
		if ($userInfo) {
			return new User($userInfo);
		} else {
			return $userInfo;
		}
	}

	public function countUsers() {
		return $this->_db->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();
	}

	public function exists($mailUser, $mdpUser) {
		$q= $this->_db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE mail = :mail AND mdp = :mdp');
		$q->execute([':mail'=> $mailUser, ':mdp'=> $mdpUser]);
		return (bool) $q->fetchColumn();
	}

	public function getAllList() {
		$req =  $this->_db->prepare('SELECT * FROM utilisateurs');
		try {
			$req->execute();
			return $req->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getBannedList() {
		$req =  $this->_db->prepare('SELECT * FROM utilisateurs WHERE banned = 1');
		try {
			$req->execute();
			return $req->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}


	public function getNonBannedList() {
		$req =  $this->_db->prepare('SELECT * FROM utilisateurs WHERE banned = 0');
		try {
			$req->execute();
			return $req->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	

	public function setDb(PDO $db) {
		$this->_db = $db;
	}
}
?>