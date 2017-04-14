<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 18:08
 */

namespace CoreAppBundle\ClassGestion;


use CoreAppBundle\InfoClass\InfoClass;
use CoreAppBundle\InfoClass\Methode;
use CoreAppBundle\InfoClass\Parameter;
use CoreAppBundle\InfoClass\Property;

class GeneratorClass
{

    /** @var  InfoClass $infoClass */
    private $infoClass;

    public function __construct(InfoClass $infoClass)
    {
        $this->infoClass = $infoClass;
    }

    public function generateClass()
    {
        $infoClass = $this->infoClass;
        $namespace = "namespace ".$infoClass->getNamespace().";";
        $className = "class ".$infoClass->getCLassName();
        if(count($infoClass->getExtends()) > 0)
        {
            $className = $className ." extends";
            foreach ($infoClass->getExtends() as $extend)
            {
                $className .= " ".$extend;
            }
        }

        $property = $this->generateProperty();
        $construct = $this->generatConstruct();
        $methode  = $this->generateMethode();
        $use = $this->generateUse();
        $contentClass = <<<EOF
<?php

$namespace

$use

$className {

    $property

    $construct

    $methode

}
EOF;

        file_put_contents($infoClass->getRootDir().'\\' . $infoClass->getNamespace()."\\".$infoClass->getClassName() . ".php",$contentClass);
    }

    public function generateUse()
    {
        $useGenere = "";
        foreach ($this->infoClass->getLoader()->getUse() as $use)
        {
            $useGenere .= $use."\n";
        }
        return $useGenere;
    }


    public function generateProperty()
    {
        $retourProperty = "";
        /** @var Property $properti */
        foreach ($this->infoClass->getLoader()->getProperties() as $properti)
        {
            $phpdoc = $properti->getPhpdoc();
            $modifer = $properti->getModifier();
            $name = $properti->getPropertyName();
            $retourProperty .= <<<EOF
    $phpdoc
    $modifer $$name;
EOF;

        }
        return $retourProperty;
    }

    public function generatConstruct()
    {
        $infoClass = $this->infoClass;
        $retourConstruct = "";
        $phpDoc = $infoClass->getLoader()->getConstruct()->getPhpDoc();
        $params = $infoClass->getLoader()->getConstruct()->getParameters();
        $paramsReturn = "";
        /** @var Parameter $param */
        foreach ($params as $param)
        {
            $paramsReturn .= $param->getType().' $'.$param->getName()." ";
        }
        $content = trim($infoClass->getLoader()->getConstruct()->getContent());

        $retourConstruct = <<<EOF
    $phpDoc
    public function __construct($paramsReturn)
    {
        $content
    }
EOF;
        return $retourConstruct;
    }

    public function generateMethode()
    {
        $retourMethode = "";
        /** @var Methode $methode */
        foreach ($this->infoClass->getLoader()->getMethodes() as $methode)
        {
            $phpDoc = $methode->getPhpdoc();
            $params = $methode->getParameters();
            $paramsReturn = "";
            /** @var Parameter $param */
            foreach ($params as $param)
            {
                $paramsReturn .= $param->getType().' $'.$param->getName()." ";
            }
            $modifier = $methode->getModifier();
            $content = trim($methode->getContent());
            $methodeName = $methode->getMethodeName();
            $retourMethode .= <<<EOF
    $phpDoc
    $modifier function $methodeName($paramsReturn)
    {
        $content
    }\r\n
EOF;

        }
        return $retourMethode;
    }

}