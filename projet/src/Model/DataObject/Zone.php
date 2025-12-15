<?php 
namespace App\Covoiturage\Model\DataObject;

class Zone extends AbstractDataObject{

     // Propriétés

    private int $id_zone;

    private string $nom_zone;

    // le constructeur
     public function __construct($id_zone, $nom_zone) {

        $this->id_zone=$id_zone;
        $this->nom_zone= $nom_zone;

    }

    //les getter de chaque attribut 

    public function getId_zone() {
        return $this->id_zone;
    }


    public function getNom_zone() {
        return $this->nom_zone;
    }



    // les setter de chaque attribut 

    public function setId_zone($id_zone){
        $this->id_zone= $id_zone;
    }
  
    public function setNom_zone($nom_zone){
        $this->nom_zone= $nom_zone;
    }



    public function formatTableau(): array{
    return [
        "id_zone"=> $this->getId_zone(),
        "nom_zone" => $this->getNom_zone()
    ];}


}

?>