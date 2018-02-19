<?php

namespace simplon\entities;

class Articles {
    private $id;
    private $id_user;
    private $titre;
    private $contenu;
    private $date;

    public function __construct(
                               \DateTime $date,
                                string $titre,
                                string $contenu,                                
                                int $id=null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->date = $date;
    }
    

    /**
     * Get the value of id
     */ 
    public function getId():int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }


        /**
         * Get the value of titre
         */ 
        public function getTitre()
        {
                return $this->titre;
        }

        /**
         * Set the value of titre
         *
         * @return  self
         */ 
        public function setTitre($titre)
        {
                $this->titre = $titre;

                return $this;
        }

        /**
         * Get the value of contenu
         */ 
        public function getContenu()
        {
                return $this->contenu;
        }

        /**
         * Set the value of contenu
         *
         * @return  self
         */ 
        public function setContenu($contenu)
        {
                $this->contenu = $contenu;

                return $this;
        }

        /**
         * Get the value of date
         */ 
        public function getDate()
        {
                return $this->date;
        }

        /**
         * Set the value of date
         *
         * @return  self
         */ 
        public function setDate($date)
        {
                $this->date = $date;

                return $this;
        }
}