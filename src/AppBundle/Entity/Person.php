<?php

namespace AppBundle\Entity;

use Neo4jBundle\Annotation\AnnotationProperty;
use Neo4jBundle\Annotation\AnnotationClass;
use Neo4jBundle\Entity\GlobalEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @AnnotationClass(label="Person")
 */
class Person extends GlobalEntity {

    /**
     * @AnnotationProperty(name="person_name")
     */
    private $name;

        
    public function __construct()
    {
        parent::__construct();
    }

        
     function classPossible( $className )
    {
        $containClass = new ArrayCollection();
        return $this->getClassPossible($containClass,$className);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }




}