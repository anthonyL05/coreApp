<?php


namespace Neo4jBundle\Entity ;


use Doctrine\Common\Collections\ArrayCollection;

class GlobalEntity
{


    /** @var  \Doctrine\Common\Collections\ArrayCollection $class */
    private $class;

    /** @var  \Doctrine\Common\Collections\ArrayCollection $relation */
    private $relation;

    /** @var  \Doctrine\Common\Collections\ArrayCollection $relationPossible */
    private $relationPossible;

    /**
     * generalEntity constructor.
     */
    public function __construct()
    {
        $this->class = new ArrayCollection();
        $this->relation = new ArrayCollection();
        $this->relationPossible = new ArrayCollection();
    }

    public function addClass($entity)
    {
        $className = explode("\\",get_class($entity));
        $className = array_pop($className);
        $classPossible = $this->getClassPossible();
        /** @var ArrayCollection $classPossible */
        if($classPossible->contains("$className"))
        {
            $this->class->add($entity);
        }
        else
        {
            /**
             * TODO exeption this class cant be contain
             */
        }
    }
    public function getClass($className = null)
    {
        if($className == null)
        {
            return $this->class;
        }
        else
        {
            /** TODO
             * return the class ask
             */
        }
    }
}