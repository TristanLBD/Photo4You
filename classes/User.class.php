<?php
class User {
	//! Attributs
	private $_id;
	private $_nom;
	private $_prenom;
	private $_type;
	private $_mail;
	private $_mdp;
	private $_credit;
	private $_banned;
	

	public function __construct(array $donnees) {
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees) {
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}

	//! Getters
	public function getId() {
		return $this->_id;
	}

	public function getNom() {
		return $this->_nom;
	}

	public function getPrenom() {
		return $this->_prenom;
	}

	public function getMail() {
		return $this->_mail;
	}

	public function getType() {
		return $this->_type;
	}

	public function getCredit() {
		return $this->_credit;
	}

	public function getMdp() {
		return $this->_mdp;
	}

	public function getBanned() {
		return $this->_banned;
	}
	//! Setters
	public function setId($id) {
		$id = (int) $id;
		if ($id > 0) {
			$this->_id = $id;
		}
	}

	public function setCredit($credits) {
        if(is_numeric($credits) && $credits >= 0) {
			$this->_credit = $credits;
		} else {
			throw new Exception("Veuillez renseigner un nombre de crédits de 0 minimum !");
		}
	}

	public function setNom($nom) {
		if(strlen($nom) > 0 && strlen($nom) <= 30 && is_string($nom)) {
			$this->_nom = $nom;
		} else {
			throw new Exception("Veuillez renseigner un nom valide !");
		}
	}

	public function setPrenom($prenom) {
		if(strlen($prenom) > 0 && strlen($prenom) <= 30 && is_string($prenom)) {
			$this->_prenom = $prenom;
		} else {
			throw new Exception("Veuillez renseigner un prenom valide !");
		}
	}

	public function setType($type) {
		if(strlen($type) > 0 && is_string($type)) {
			$this->_type = $type;
		} else {
			throw new Exception("Veuillez renseigner un type !");
		}
	}
	
	public function setMail($mail) {
		if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
			if(strlen($mail) <= 80) {
				$this->_mail = $mail;
			} else {
				throw new Exception("Votre adresse mail est trop longue");
			}
		} else {
			throw new Exception("Veuillez renseigner mail valide !");
		}
	}

	public function setMdp($mdp) {
		$this->_mdp = $mdp;
	}

	public function setBanned($mdp) {
		$this->_banned = $mdp;
	}
}
?>