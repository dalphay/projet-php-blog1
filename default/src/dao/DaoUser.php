<?php

namespace simplon\dao;
use simplon\entities\User;
use simplon\dao\Articles;

class DaoUser {
    
    
    /**
     * La méthode getAll renvoie toutes les persons stockées en bdd
     * @return User[] la liste des person ou une liste vide
     */
    public function getAll():array {
       
        $tab = [];
      
        try {
           
            $query = Connect::getInstance()->prepare('SELECT * FROM user');
            
            $query->execute();
           
            while($row = $query->fetch()) {
             
                $users = new User($row['name'], 
                            $row['email'], 
                            $row['password'],
                            $row['id']);
            
                $tab[] = $users;
            }
        }catch(\PDOException $e) {
            echo $e;
        }
        
        return $tab;
    }
   
    public function getById(int $id) {
        
        try {
          
            $query = Connect::getInstance()->prepare('SELECT * FROM user WHERE id=:id');
         
            $query->bindValue(':id', $id, \PDO::PARAM_INT);
            
            $query->execute();
            //Si le fetch nous renvoie quelque chose
            if($row = $query->fetch()) {
                //On crée une instance de User
                $pers = new User($row['name'], 
                            $row['email'], 
                            $row['password'],
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

    
    
     public function getByEmail($email) {
         
         try {
           
             $query = Connect::getInstance()->prepare('SELECT * FROM user WHERE email=:email');
          
             $query->bindValue(':email', $email, \PDO::PARAM_STR);
             
             $query->execute();
             //Si le fetch nous renvoie quelque chose
             if($row = $query->fetch()) {
                 //On crée une instance de User
                 $pers = new User($row['name'], 
                        $row['email'], 
                        $row['password'],
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
    public function add(User $users) {
        
        try {
            //On prépare notre requête, avec les divers placeholders
            $query = Connect::getInstance()->prepare('INSERT INTO user (name,email,password) VALUES (:name, :email, :password)');
            /**
             * On bind les différentes values qu'on récupère de l'instance
             * de Person qui nous est passée en argument, via ses
             * accesseurs get*()
             */
            $query->bindValue(':name',$pers->getName(),\PDO::PARAM_STR);
            /**
             * Pour la date, PDO attend une date en string au format 
             * aaaa-mm-dd, hors, la birthdate de notre Person est une
             * instance de DateTime, on utilise donc la méthode format()
             * de DateTime pour la convertir au format textuel souhaité.
             */
            $query->bindValue(':email',$Users->getEmail(),\PDO::PARAM_STR);
            $query->bindValue(':password',$pers->getPassword(),\PDO::PARAM_INT);

            $query->execute();
            /**
             * On fait en sorte de récupérer le dernier id généré par SQL 
             * afin de l'assigner à l'id de notre instance de Person
             */
            $pers->setId(Connect::getInstance()->lastInsertId());
            
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