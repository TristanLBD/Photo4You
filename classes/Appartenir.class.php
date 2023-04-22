<?php
    class Appartenir {
        // Attributs
        private $_categorie;
        private $_photo;

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
        public function getPhoto() {
            return $this->_photo;
        }

        public function getCategorie() {
            return $this->_categorie;
        }


        //! Setters
        public function setPhoto($id) {
            $id = (int) $id;
            if ($id > 0) {
                $this->_photo = $id;
            }	
        }

        public function setCategorie($id) {
            $id = (int) $id;
            if ($id > 0) {
                $this->_categorie = $id;
            }	
        }
    }
?>