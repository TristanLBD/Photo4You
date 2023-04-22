<?php
class CategorieManager {
	private $_db;

	public function __construct($db) {
		$this->setDB($db);
	}

	public function add(Categorie $categorie) {
		$q = $this->_db->prepare('INSERT INTO categories(nom,libelle) VALUES(:nom, :libelle)');
		$q->bindValue(':nom', $categorie->getNom());
		$q->bindValue(':libelle', $categorie->getLibelle());
		$q->execute();
	}

	public function delete($id) {
		$q = $this->_db->prepare('DELETE FROM categories WHERE Id = :id');
		$q->bindValue(':id', $id);
		$q->execute();
	}

	public function update(Categorie $categorie) {
		$q = $this->_db->prepare('UPDATE categories SET Nom = :nom, Libelle = :libelle WHERE Id = :id');
		$q->bindValue(':nom', $categorie->getNom());
		$q->bindValue(':libelle', $categorie->getLibelle());
		$q->bindValue(':id', $categorie->getId());
		$q->execute();
	}

	public function countCategories() {
		return $this->_db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
	}

	public function getCategorie($id) {
		$req =  $this->_db->prepare('SELECT * FROM categories WHERE Id = :id');
		try {
			$req->bindValue(':id', $id);
			$req->execute();
			return new Categorie($req->fetch(PDO::FETCH_ASSOC));
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getList() {
		$req =  $this->_db->prepare('SELECT * FROM categories');
		try {
			$req->execute();
			return $req->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function exists($id) {
		$q = $this->_db->prepare('SELECT COUNT(*) FROM categories WHERE Id = :id');
		$q->bindValue(':id', $id);
		$q->execute();
		return (bool) $q->fetchColumn();
	}

	public function setDb(PDO $db) {
		$this->_db = $db;
	}
}
?>