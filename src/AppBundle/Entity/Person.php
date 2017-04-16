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

        
     function classPossible( $className )
    {
        $containClass = new ArrayCollection();
        return $this->getClassPossible($containClass,$className);
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }




}