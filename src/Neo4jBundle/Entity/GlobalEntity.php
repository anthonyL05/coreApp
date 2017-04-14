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
        $class = new ArrayCollection();
        $relation = new ArrayCollection();
        $relation = new ArrayCollection();
    }




    /**
     * @param $className
     * @param bool $generate
     * @return mixed|null
     * this fonction let the user get on class of the entity contains class
     */
    public function getClass($className = null,$generate = true)
    {
        if($className == null)
        {
            return $this->class;
        }
        /**
         * todo check if the function is create or see for implement
         */
        if($this->classPossible($className))
        {
            return $this->getClassEntiy($className,$generate);
        }
    }

    /**
     * @param $className
     * @param $generate
     * @return mixed|null
     * this function return a class entity contain, a new class or null depend of user choice
     */
    private function getClassEntiy($className,$generate)
    {
        foreach ($this->class as $entity)
        {
            if(get_class($entity)==$className)
            {
                return $entity;
            }
        }
        if($generate == true)
        {
            $obj = new $className();
            $this->class->add($obj);
            return $obj;
        }
        else
        {
            return null;
        }
    }

    protected function getClassPossible(ArrayCollection $containClass ,$className,$get = false, $all = false)
    {
        if($get == true)
        {
            if($all == false)
            {
                foreach ($this->getClass() as $class)
                {
                    $className = get_class($class);
                    if($containClass->contains($className))
                    {
                        $containClass->remove($className);
                    }
                }
            }
            return $containClass;
        }
        if($containClass->contains($className))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


}