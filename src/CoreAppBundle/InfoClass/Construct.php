<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 12:22
 */

namespace CoreAppBundle\InfoClass;


use Doctrine\Common\Collections\ArrayCollection;

class Construct
{

    private $content;
    private $phpDoc;
    /** @var  ArrayCollection */
    private $parameters;

    /**
     * Construct constructor.
     */
    public function __construct()
    {
        $this->parameters = new ArrayCollection();
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



    /**
     * @return mixed
     */
    public function getPhpDoc()
    {
        return $this->phpDoc;
    }

    /**
     * @param mixed $phpDoc
     */
    public function setPhpDoc($phpDoc)
    {
        $this->phpDoc = trim($phpDoc);
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



}