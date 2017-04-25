<?php

namespace AppBundle\Entity;

use Neo4jBundle\Annotation\AnnotationClass;
use Neo4jBundle\Entity\GlobalEntity;
use Doctrine\Common\Collections\ArrayCollection;



   /**
 * @AnnotationClass(label="User")
 */
class User extends GlobalEntity {

    

        
    public function __construct()
    {
        parent::__construct();
    }

        
     function getClassPossible()
    {
        $classPossible = new ArrayCollection();
        $classPossible->add('Person');
        return $classPossible;
    }


}