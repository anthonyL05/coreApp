<?php

namespace AppBundle\Entity;

use CoreAppBundle\Annotation\Core;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Person;
use Neo4jBundle\Annotation\AnnotationClass;


/**
 * @AnnotationClass(label="User")
 */
class CoreApp {

        /**
    *@Core(className="Person")
    */
    private $persons;

        
    public function __construct()
    {
        $this->persons = new ArrayCollection();
    }

        
    public function getPerson()
    {
        return $this->persons;
    }
    
    public function removePerson( $person )
    {
        $this->persons->remove($person);
    }
    
    public function addPerson( $person )
    {
        $this->persons->add($person);
    }


}