<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 11:45
 */

namespace CoreAppBundle\InfoClass;

use CoreAppBundle\ClassGestion\GeneratorClass;
use CoreAppBundle\ClassGestion\Loader;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\GeneratorBundle\Generator\Generator;

class InfoClass
{

    /** @var  Loader $loader */
    private $loader;

    private $className;


    private $namespace;

    /** @var  Generator $generatorClass */
    private $generatorClass;

    private $rootDir;

    /** @var  ArrayCollection */
    private $classCall;

    /** @var  ArrayCollection $infoClassContain */
    private $infoClassContain;

    /** @var  ArrayCollection $extends */
    private $extends;

    /** @var  ArrayCollection $propertyCall */
    private $propertyCall;

    /**
     * infoClass constructor.
     */
    public function __construct($exist , $rootDir ,$className,$path = "AppBundle\\Entity")
    {
        $this->propertyCall = new ArrayCollection();
        $this->classCall = new ArrayCollection();
        $this->infoClassContain = new ArrayCollection();
        $this->extends = new ArrayCollection();
        $this->rootDir = $rootDir;
        $this->className = $className;
        $this->namespace = $path;
        $this->generatorClass =  new GeneratorClass($this);
        $this->loader = new Loader($this,$exist);
    }

    public function generateOtherClass()
    {
        if(method_exists($this->getLoader()->getClass(),"getClassPossible"))
        {
            foreach ($this->getLoader()->getClass()->getClassPossible() as $classPossible)
            {
                $this->addClassCall(array($classPossible, "inside","null","enity"));
            }
        }
    }

    public function generateClass()
    {
        /** @var InfoClass $infoClass */
        foreach ($this->infoClassContain as $infoClass)
        {
            $infoClass->generateClass();
        }
        $this->generatorClass->generateClass();
    }

    /**
     * @return Loader
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @return mixed
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }


    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function addClassCall($classCall)
    {
        if(!$this->getClassCall()->contains($classCall))
        {
            $this->classCall->add($classCall);
        }
    }

    public function addPropertyCall($property)
    {
        if(!$this->propertyCall->contains($property))
        {
            $this->propertyCall->add($property);
        }
    }

    public function getPropertyCall()
    {
        return $this->propertyCall;
    }

    public function getClassCall()
    {
        return $this->classCall;
    }
    public function removeClassCall($classCall)
    {
        $this->infoClassContain->remove($classCall);
    }
    public function addInfoClassContain($infoClassContain)
    {
        if(!$this->getInfoClassContain()->contains($infoClassContain))
        {
            $this->infoClassContain->add($infoClassContain);
        }
    }
    public function getInfoClassContain()
    {
        return $this->infoClassContain;
    }
    public function removeInfoClassContain($infoClassContain)
    {
        $this->infoClassContain->remove($infoClassContain);
    }


    public function getExtends()
    {
        return $this->extends;
    }

    public function addExtends($extend)
    {
        if(!$this->getExtends()->contains($extend))
        {
            $this->extends->add($extend);
        }
    }
    public function removeExtend($extend)
    {
        $this->extends->remove($extend);
    }


}