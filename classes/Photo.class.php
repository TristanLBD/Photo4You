<?php
class Photo {
	// Attributs
	private $_id;
	private $_nom;
	private $_description;
	private $_prix;
	private $_vendeur;
	private $_proprietaire;
	private $_url;
	private $_datePublication;
	private $_dateAcquisition;

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

	public function getDescription() {
		return $this->_description;
	}

	public function getPrix() {
		return $this->_prix;
	}

	public function getVendeur() {
		return $this->_vendeur;
	}

	public function getProprietaire() {
		return $this->_proprietaire;
	}

	public function getUrl() {
		return $this->_url;
	}

	public function getDatePublication() {
		return $this->_datePublication;
	}
	public function getAcquisition() {
		return $this->_dateAcquisition;
	}

	//! Setters
	public function setId($id) {
		$id = (int) $id;
		if ($id > 0) {
			$this->_id = $id;
		}
	}

	public function setNom($nom) {
		if (is_string($nom)  && strlen($nom) > 0 && strlen($nom) <= 65) {
			$this->_nom = $nom;
		}
	}

	public function setdescription($description) {
		if (is_string($description)  && strlen($description) > 0 && strlen($description) <= 75) {
			$this->_description = $description;
		}
	}

	public function setPrix($prix) {
		$prix = (int) $prix;
		if ($prix >= 0) {
			$this->_prix = $prix;
		}
	}

    public function setVendeur($vendeur) {
		$vendeur = (int) $vendeur;
		if ($vendeur > 0) {
			$this->_vendeur = $vendeur;
		} else {
			$this->_vendeur = null;
		}
	}

    public function setProprietaire($proprietaire) {
		$proprietaire = (int) $proprietaire;
		if ($proprietaire > 0) {
			$this->_proprietaire = $proprietaire;
		} else {
			$this->_proprietaire = null;
		}
	}

	public function setDatePublication($date) {
		if(validateDate($date)) {
			$this->_datePublication = $date;
		} else {
			throw new Exception($date);
		}
	}

	public function setDateAcquisition($date) {
		if(validateDate($date) || is_null(null)) {
			$this->_dateAcquisition = $date;
		} else {
			throw new Exception("Date d'acquisition incorecte");
		}
	}

	public function setUrl($image) {
		$this->_url = $image;
	}
}
?>