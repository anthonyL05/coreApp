<?php


namespace Neo4jBundle\Ogm;


use Doctrine\Common\Collections\ArrayCollection;

class Node
{

    /** @var  ArrayCollection $labels */
    private $labels;

    /** @var  ArrayCollection $atributs*/
    private $atributs;

    /** @var $identifier */
    private $identifier;

    /** @var  ArrayCollection */
    private $relations;


    public function __construct( )
    {
    }

    /**
     * @return ArrayCollection
     */
    public function getLabels()
    {
        return $this->labels;
    }


    public function addLabel(Label $label)
    {
        $this->labels[] = $label;

        return $this;
    }

    public function removeLabel(Label $label)
    {
        $this->labels->removeElement($label);
        return $this;
    }



    /**
     * @return ArrayCollection
     */
    public function getAtributs()
    {
        return $this->atributs;
    }

    public function addAtribut(Atribut $atribut)
    {
        $this->atributs[] = $atribut;

        return $this;
    }

    public function removeAtribut(Atribut $atribut)
    {
        $this->atributs->removeElement($atribut);
        return $this;
    }






    public function getIdentifier()
    {
        return $this->identifier;
    }


    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return ArrayCollection
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param ArrayCollection $relations
     */
    public function addRelations($relations)
    {
        $this->relations[] = $relations;
    }









}