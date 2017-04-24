<?php

namespace AppBundle\Entity;

use Neo4jBundle\Annotation\AnnotationClass;
use Neo4jBundle\Annotation\AnnotationProperty;
use Neo4jBundle\Entity\GlobalEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @AnnotationClass(label="User")
 */
class User extends GlobalEntity {

        /**
     * @var string $pseudo
     * @AnnotationProperty(name="pseudo")
     *
     */
    private $pseudo;

        
    public function __construct()
    {
        parent::__construct();
    }

        
    public function getClassPossible()
    {
        $classPossible = new ArrayCollection();
        $classPossible->add('Person');
        return $classPossible;
    }
    
    public function getPseudo()
    {
        return $this->pseudo;
    }
    
    public function setPseudo( $pseudo )
    {
        $this->pseudo = $pseudo;        
        return $this;
    }


}