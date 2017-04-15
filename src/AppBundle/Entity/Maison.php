<?php

namespace AppBundle\Entity;

use Neo4jBundle\Entity\GlobalEntity;
use Doctrine\Common\Collections\ArrayCollection;


class Maison extends GlobalEntity {

    

        
    public function __construct()
    {
        parent::__construct();
    }

        
     function classPossible( $className )
    {
        $containClass = new ArrayCollection();
        return $this->getClassPossible($containClass,$className);
    }


}