<?php

namespace AppBundle\Entity;

use Neo4jBundle\Annotation\AnnotationClass;
use Neo4jBundle\Annotation\AnnotationProperty;
use Neo4jBundle\Entity\GlobalEntity;
use Doctrine\Common\Collections\ArrayCollection;



   /**
 * @AnnotationClass(label="Person")
 */
class Person extends GlobalEntity {

        /**
     * @var string $nom
     * @AnnotationProperty(name="person_name")
     *
     */
    private $nom;

        
    public function __construct()
    {
        parent::__construct();
    }

        
    public function getClassPossible()
    {
        $classPossible = new ArrayCollection();
        $classPossible->add('User');
        return $classPossible;
    }
    
    public function getNom()
    {
        return $this->nom;
    }
    
    public function setNom( $nom )
    {
        $this->nom = $nom;        
        return $this;
    }


}