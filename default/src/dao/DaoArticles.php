<?php

namespace simplon\dao;
use simplon\entities\User;
use simplon\entities\Articles;


class DaoArticles {
    
    
    /**
     * La méthode getAll renvoie toutes les persons stockées en bdd
     * @return Articles[] la liste des  ou une liste vide
     */
    public function getAll():array {
       
        $tab = [];
      
        try {
           
            $query = Articles::getInstance()->prepare('SELECT * FROM articles');
            
            $query->execute();
           
            while($row = $query->fetch()) {
             
                $articles = new Articles( new \DateTime($row['date']),
                            $row['titre'], 
                            $row['contenu'],             
                            $row['id']);
            
                $tab[] = $articles;
            }
        }catch(\PDOException $e) {
            echo $e;
        }
        
        return $tab;
    }
   
    public function getById(int $id) {
        
        try {
          
            $query = Connect::getInstance()->prepare('SELECT * FROM articles WHERE id=:id');
         
            $query->bindValue(':id', $id, \PDO::PARAM_INT);
            
            $query->execute();
            //Si le fetch nous renvoie quelque chose
            if($row = $query->fetch()) {
                //On crée une instance de User
                $articles = new Articles( new \DateTime($row['date']),
                            new \DateTime($row['titre']), 
                            $row['contenu'],
                            $row['id']);
                //On return cette User
                return $pers;
            }
        }catch(\PDOException $e) {
            echo $e;
        }
        /**
         * Si jamais on est pas passé dans le if ou autre, on renvoie null
         * qui est une valeur inexistante. C'est quelque chose d'assez
         * utilisé dans beaucoup de langages. 
         */
        return null;
    }
    /**
     * Méthode permettant de faire persister en base de données une 
     * instance de Person passée en argument.
     */
    public function add(Articles $articles) {
        
        try {
            //On prépare notre requête, avec les divers placeholders
            $query = Connect::getInstance()->prepare('INSERT INTO articles (titre,contenu,date) VALUES (:titre, :contenu, :date)');
            /**
             * On bind les différentes values qu'on récupère de l'instance
             * de Person qui nous est passée en argument, via ses
             * accesseurs get*()
             */
            $query->bindValue(':titre',$articles->getTitre(),\PDO::PARAM_STR);
            /**
             * Pour la date, PDO attend une date en string au format 
             * aaaa-mm-dd, hors, la birthdate de notre Person est une
             * instance de DateTime, on utilise donc la méthode format()
             * de DateTime pour la convertir au format textuel souhaité.
             */
            $query->bindValue(':date',$articles->getDate()->format('Y-m-d'),\PDO::PARAM_STR);
            
            $query->bindValue(':contenu',$articles->getContenu(),\PDO::PARAM_INT);

            $query->execute();
            /**
             * On fait en sorte de récupérer le dernier id généré par SQL 
             * afin de l'assigner à l'id de notre instance de Person
             */
            $articles->setId(Connect::getInstance()->lastInsertId());
            
        }catch(\PDOException $e) {
            echo $e;
        }
    }
    /**
     * Une méthode pour mettre à jour les informations d'une Person 
     * déjà existante dans la base de donnée.
     * L'argument $pers doit être une instance de Person complète, avec
     * un id existant en base.
     */

}