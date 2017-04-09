<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 17:31
 */

namespace CoreAppBundle\InfoCLass;


use Doctrine\Common\Collections\ArrayCollection;

class Methode
{
    private $methodeName;

    private $phpdoc;

    private $modifier;

    private $content;

    /** @var  ArrayCollection $parameter */
    private $parameters;

    /**
     * Methode constructor.
     */
    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getMethodeName()
    {
        return $this->methodeName;
    }

    /**
     * @param mixed $methodeName
     */
    public function setMethodeName($methodeName)
    {
        $this->methodeName = $methodeName;
    }


    /**
     * @return mixed
     */
    public function getPhpdoc()
    {
        return $this->phpdoc;
    }

    /**
     * @param mixed $phpdoc
     */
    public function setPhpdoc($phpdoc)
    {
        $this->phpdoc = trim($phpdoc);
    }

    /**
     * @return mixed
     */
    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * @param mixed $modifier
     */
    public function setModifier($modifier)
    {
        $this->modifier = $modifier;
    }

    public function addParameters(Parameter $parameter)
    {
        $this->parameters->add($parameter);
        return $this;
    }
    public function removeParameters(Parameter $parameter)
    {
        $this->parameters->remove($parameter);
        return $this;
    }
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }






}