<?php
    class PhotoManager {
        private $_db;

        public function __construct($db) {
            $this->setDB($db);
        }

        
        public function photosWithoutCategorie() {
            $req = $this->_db->prepare('SELECT * FROM photos WHERE photos.id NOT IN(SELECT Photo FROM appartenir);');
            try {
                $req->execute();
                return $req->fetchAll();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
        
        public function countNotBoughPhotos() {
            $req = $this->_db->prepare('SELECT COUNT(*) as nombre FROM photos WHERE photos.vendeur = photos.proprietaire AND photos.checked = 1;');
            try {
                $req->execute();
                return $req->fetch()['nombre'];
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function countBoughPhotos() {
            $req = $this->_db->prepare('SELECT COUNT(*) as nombre FROM photos WHERE photos.vendeur != photos.proprietaire AND photos.checked = 1;');
            try {
                $req->execute();
                return $req->fetch()['nombre'];
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function countAll() {
            $req = $this->_db->prepare('SELECT COUNT(*) as nombre FROM photos');
            try {
                $req->execute();
                return $req->fetch()['nombre'];
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function getPhoto($idPhoto) {
            $req = $this->_db->prepare("SELECT * FROM photos where Id = :mid");
            $req->execute(array(':mid' => $idPhoto));
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return new Photo($result);
        }

        public function delete(Photo $photo) {
            $req = $this->_db->prepare('DELETE FROM photos WHERE Id = :mid');
            try {
                $req->bindValue(':mid', $photo->getId());
                $req->execute();
                unlink("./images/ventes/".$photo->getUrl());
                return "Photo supprimée";
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function deleteByProprietaire($idUser) :void {
            $req = $this->_db->prepare('DELETE FROM photos WHERE Proprietaire = :mid');
            try {
                $req->bindValue(':mid', $idUser);
                $req->execute();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
        
        public function isChecked($idPhoto) {
            $req = $this->_db->prepare('SELECT checked FROM photos WHERE Id = :mid');
            try {
                $req->bindValue(':mid', $idPhoto);
                $req->execute();
                return $req->fetch()['checked'];
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function check($idPhoto) {
            $req = $this->_db->prepare('UPDATE photos set checked = 1 WHERE Id = :mid');
            try {
                $req->bindValue(':mid', $idPhoto);
                $req->execute();
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function add(Photo $photo) {
            $req = $this->_db->prepare('INSERT INTO photos(nom,description,prix,vendeur,proprietaire,url,DatePublication) VALUES (:nom,:desc,:prix,:vendeur,:proprietaire,:url,:datepublication)');
            
            try {
                $req->execute(array(
                    ':nom' => $photo->getNom(),
                    ':desc' => $photo->getDescription(),
                    ':prix' => $photo->getPrix(),
                    ':vendeur' => $photo->getVendeur(),
                    ':proprietaire' => $photo->getProprietaire(),
                    ':url' => $photo->getUrl(),
                    ':datepublication' => $photo->getDatePublication(),
                ));

                $photo->hydrate(['Id' => $this->_db->lastInsertId()]);
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function update(Photo $photo) {
            $q = $this->_db->prepare('UPDATE photos SET Nom = :nom, Prix = :prix, Description = :description WHERE Id = :id');
            $q->bindValue(':nom', $photo->getNom());
            $q->bindValue(':prix', $photo->getPrix());
            $q->bindValue(':description', $photo->getDescription());
            $q->bindValue(':id', $photo->getId());
            $q->execute();
        }

        public function updateProprietaire(Photo $photo) {
            $q = $this->_db->prepare('UPDATE photos SET proprietaire = :proprietaire, DateAcquisition = :dateacquisition WHERE Id = :id');
            $q->bindValue(':proprietaire', $photo->getProprietaire());
            $q->bindValue(':dateacquisition', $photo->getAcquisition());
            $q->bindValue(':id', $photo->getId());
            $q->execute();
        }
                
        public function getNonConfirmedPhotos() {
            $req = $this->_db->prepare("SELECT utilisateurs.nom as nomVendeur, photos.vendeur as vendeur,photos.description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        JOIN utilisateurs ON utilisateurs.Id = photos.vendeur
                                        WHERE photos.Proprietaire = photos.Vendeur
                                        AND checked = 0
                                        GROUP BY photos.Id
                                        LIMIT 0, 9");

            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getMesVentes($idVendeur) {
            $req = $this->_db->prepare("SELECT checked,photos.DatePublication, photos.DateAcquisition, photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        WHERE photos.Vendeur = :mid
                                        AND photos.Vendeur = photos.Proprietaire
                                        GROUP BY photos.Id
                                        ORDER BY checked ASC");


            $req->execute(array(':mid' => $idVendeur));
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getMesAchats($idAcheteur) {
            $req = $this->_db->prepare("SELECT photos.DatePublication, photos.DateAcquisition, utilisateurs.nom as vendeur, photos.vendeur as idVendeur,photos.description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        JOIN utilisateurs ON utilisateurs.Id = photos.vendeur
                                        WHERE photos.Proprietaire = :mid
                                        GROUP BY photos.Id");
            $req->execute(array(':mid' => $idAcheteur));
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPhotoById($idPhoto) {
            $req = $this->_db->prepare("SELECT photos.DatePublication, photos.DateAcquisition,description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        WHERE photos.id = :mid
                                        GROUP BY photos.Id");

            $req->execute(array(':mid' => $idPhoto));
            return $req->fetch(PDO::FETCH_ASSOC);
        }

        public function getBuyablePhotos($page,$photos_par_page) {
            $index_debut = ($page - 1) * $photos_par_page;

            $req = $this->_db->prepare("SELECT utilisateurs.nom as vendeur, photos.vendeur as idVendeur,photos.description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        JOIN utilisateurs ON utilisateurs.Id = photos.vendeur
                                        WHERE photos.Proprietaire = photos.Vendeur
                                        AND checked = 1
                                        GROUP BY photos.Id
                                        LIMIT :id_deb, :photos;");
            $req->bindValue(':id_deb', $index_debut, PDO::PARAM_INT);
            $req->bindValue(':photos', $photos_par_page, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getLastPhotos($page,$photos_par_page) {
            $index_debut = ($page - 1) * $photos_par_page;

            $req = $this->_db->prepare("SELECT utilisateurs.nom as vendeur, photos.vendeur as idVendeur,photos.description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        JOIN utilisateurs ON utilisateurs.Id = photos.vendeur
                                        WHERE photos.Proprietaire = photos.Vendeur
                                        AND checked = 1
                                        GROUP BY photos.Id
                                        ORDER BY DatePublication DESC
                                        LIMIT :id_deb, :photos;");
            $req->bindValue(':id_deb', $index_debut, PDO::PARAM_INT);
            $req->bindValue(':photos', $photos_par_page, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getBuyablePhotoById($idPhoto) {
            $req = $this->_db->prepare("SELECT photos.DatePublication, utilisateurs.nom as nomVendeur, utilisateurs.id as idVendeur, photos.vendeur as vendeur,photos.description,photos.Id,Url,photos.Nom, photos.Prix, GROUP_CONCAT(categories.Nom SEPARATOR ', ') AS Categories
                                        FROM photos
                                        JOIN appartenir ON photos.Id = appartenir.Photo
                                        JOIN categories ON categories.Id = appartenir.Categorie
                                        JOIN utilisateurs ON utilisateurs.Id = photos.vendeur
                                        WHERE photos.id = :mid 
                                        AND photos.vendeur = photos.proprietaire 
                                        GROUP BY photos.Id");
            $req->execute(array(':mid' => $idPhoto));
            return $req->fetch(PDO::FETCH_ASSOC);
        }

        public function transaction(Photo $photo, User $vendeur, User $acheteur, UserManager $managerUser, PhotoManager $managerPhoto) {
            if($acheteur->getCredit() >= $photo->getPrix()) {
                $vendeur->setCredit($vendeur->getCredit() + $photo->getPrix());
                $acheteur->setCredit($acheteur->getCredit() - $photo->getPrix());
                $managerUser->updateCredits($vendeur);
                $managerUser->updateCredits($acheteur);
                $photo->setProprietaire($acheteur->getId());
                $photo->setDateAcquisition(date('Y-m-d'));
                $managerPhoto->updateProprietaire($photo);
            } else {
                return "Inferieur ".$acheteur->getCredit(). " : " .$photo->getPrix();
            }
        }

        public function getMaxPrice() {
            $req = $this->_db->prepare("SELECT MAX(Prix) as prix FROM photos;");
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC)['prix'];
        }

        public function getMaxPriceOfAvailablesPhotos() {
            $req = $this->_db->prepare("SELECT MAX(Prix) as prix FROM photos WHERE photos.vendeur = photos.proprietaire AND photos.checked = 1;");
            $req->execute();
            $value = $req->fetch(PDO::FETCH_ASSOC)['prix'];
            if($value == null) {
                $value = 1;
            }
            return $value;
        }

        public function urlExist($url) :bool { 
            $req = $this->_db->prepare("SELECT COUNT(*) as bool FROM photos WHERE Url = :url");
            $req->bindValue(':url', $url);
            $req->execute();
            $value = $req->fetch(PDO::FETCH_ASSOC)['bool'];
            if($value == null) {
                $value = 0;
            }
            return  $value;
        }

        public function customRequest($req, array $values) {
            $req = $this->_db->prepare($req);
            foreach ($values as $key => $value) {
                switch ($key) {
                    case ':id_deb':
                        $req->bindValue($key, $value, PDO::PARAM_INT);
                        break;

                    case ':photos':
                        $req->bindValue($key, $value, PDO::PARAM_INT);
                        break;

                    default:
                        $req->bindValue($key, $value);
                        break;
                }
            }
            $req->execute();
            // return $values;
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function setDb(PDO $db) {
            $this->_db = $db;
        }        
    } 
?>