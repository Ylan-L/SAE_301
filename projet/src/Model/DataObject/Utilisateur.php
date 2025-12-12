<?php 
namespace App\Covoiturage\Model\DataObject;

class Utilisateur extends AbstractDataObject{

     // Propriétés
    private $username;
    private $email;
    private $password_hash;
    private $role;

    private $date_creation;

    // le constructeur
     public function __construct($username, $email, $password_hash, $role, $date_creation) {
        $this->username= $username;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->role = $role;
        $this->date_creation = $date_creation;

    }

    //les getter de chaque attribut 


    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword_hash() {
        return $this->password_hash;
    }

    public function getRole() {
        return $this->role;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }


    // les setter de chaque attribut 

  
    public function setUsername($username){
        $this->username= $username;
    }

    public function setEmail($email){
        $this->email= $email;
    }

    public function setPassword_hash($password_hash){
        $this->password_hash= $password_hash;
    }

    public function setRole($role){
        $this->role= $role;
    }

    public function setDate_creation($date_creation){
        $this->date_creation= $date_creation;
    }

    public function formatTableau(): array{
    return [
    
        "username"    => $this->getUsername(),
        "email" => $this->getEmail(),
        "password_hash" => $this->getPassword_hash(),
        "role" => $this->getRole(),
        "date_creation" => $this->getDate_creation()

    ];}


}

?>