<?php

namespace AppBundle\Entity;

use CoreAppBundle\Annotation\Core;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Person;
use AppBundle\Entity\Maison;


class CoreApp {

        /**
    *@Core(className="Person")
    */
    private $persons;    /**
     *@Core(className="Maison")
     */
    private $maison;

        
    public function __construct()
    {
        $this->persons = new ArrayCollection();$this->maison = new ArrayCollection();
    }

        
    public function getPerson()
    {
        return $this->persons;
    }
    
    public function removePerson(Person $person )
    {
        $this->persons->remove($person);
    }
    
    public function addPerson(Person $person )
    {
        $this->persons->add($person);
    }
    
    public function getMaison()
    {
        return $this->maison;
    }
    
    public function removeMaison(Maison $maison )
    {
        $this->maison->remove($maison);
    }
    
    public function addMaison(Maison $maison )
    {
        $this->maison->add($maison);
    }


}