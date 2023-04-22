<?php
class Categorie {
	// Attributs
	private $_id;
	private $_nom;
	private $_libelle;
	

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


	public function getLibelle() {
		return $this->_libelle;
	}

	//! Setters
	public function setId($id) {
		$id = (int) $id;
		if ($id > 0) {
			$this->_id = $id;
		}	
	}

	public function setNom($nom) {
		if (is_string($nom) && strlen($nom) > 0 && strlen($nom) <= 75) {
			$this->_nom = $nom;
		} else {
			throw new Exception("Nom de la catégorie trop longue.");
		}
	}

	public function setLibelle($libelle) {
		if (is_string($libelle)) {
			$this->_libelle = $libelle;
		}
	}
}
?>