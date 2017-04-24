<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 09/04/2017
 * Time: 17:12
 */

namespace CoreAppBundle\ClassGestion;


use CoreAppBundle\Annotation\Reader;
use CoreAppBundle\InfoClass\InfoClass;
use CoreAppBundle\InfoClass\Methode;
use CoreAppBundle\InfoClass\Parameter;
use CoreAppBundle\InfoClass\Property;
use Doctrine\Common\Collections\ArrayCollection;

class UpdateClass
{
    /** @var  Reader $reader */
    private $reader;

    public function update(InfoClass $infoClass)
    {
        $this->reader = new Reader();
        $infoClass = $this->reader->updateProperty($infoClass);
        $infoClass = $this->updateMethode($infoClass);
        $infoClass->generateOtherClass();
        return $infoClass;
    }

    public function updateMethode(InfoClass $infoClass)
    {
        foreach ($infoClass->getClassCall() as $class)
        {
            $infoClass = $this->checkMethode($infoClass,$class);
        }
        /** @var Property $property */
        foreach ($infoClass->getPropertyCall() as $property) {
            $infoclass = $this->checkMethode($infoClass,$property,1);
        }
        return $infoClass;
    }

    public function checkMethode(InfoClass $infoClass,$class,$property = 0)
    {
        if($property == 1)
        {

            $get = 0;
            $set = 0;
            $add = 1;
            $remove = 1;
            $propertyName = $class;
            $class = ucfirst($class);
        }
        else {
            $type = $class[1];
            $propertyName = $class[2];
            $class = ucfirst($class[0]);
            if ($propertyName != "null") {
                if ($type = "collection") {
                    $get = 0;
                    $set = 1;
                    $add = 0;
                    $remove = 0;
                    $infoClass->getLoader()->addUse("use Doctrine\\Common\\Collections\\ArrayCollection;");
                    $this->addArrayCollectionConstruct($infoClass, $propertyName);
                } else {
                    $get = 0;
                    $set = 0;
                    $add = 1;
                    $remove = 1;
                }
            }
            return $infoClass;
        }
            /** @var Methode $methode */
            foreach ($infoClass->getLoader()->getMethodes() as $methode) {
                if ($methode->getMethodeName() == "get" . $class) {
                    $get = 1;
                } elseif ($methode->getMethodeName() == "set" . $class) {
                    $set = 1;
                } elseif ($methode->getMethodeName() == "remove" . $class) {
                    $remove = 1;
                } elseif ($methode->getMethodeName() == "add" . $class) {
                    $add = 1;
                }
            }
            if ($get == 0) {
                $methode = $this->generateMethode($class, "get", $propertyName);
                $infoClass->getLoader()->addMethode($methode);
            }
            if ($set == 0) {
                $methode = $this->generateMethode($class, "set", $propertyName,1);
                if($property == 0)
                {
                    $infoClass->getLoader()->addUse("use AppBundle\\Entity\\" . $class . ";");
                }
                $infoClass->getLoader()->addMethode($methode);
            }
            if ($remove == 0) {
                $methode = $this->generateMethode($class, "remove", $propertyName);
                $infoClass->getLoader()->addUse("use AppBundle\\Entity\\" . $class . ";");
                $infoClass->getLoader()->addMethode($methode);
            }
            if ($add == 0) {
                $methode = $this->generateMethode($class, "add", $propertyName);
                $infoClass->getLoader()->addUse("use AppBundle\\Entity\\" . $class . ";");
                $infoClass->getLoader()->addMethode($methode);
            }
        return $infoClass;
    }

    public function generateMethode($className,$type,$propertyName, $typeParameter = 0)
    {
        $methode = new Methode();
        $parameter = new Parameter();
        $methode->setMethodeName($type.$className);
        if($type != "get")
        {
            $parameter->setName(lcfirst($className));
            if($typeParameter == 0)
            {
                $parameter->setType($className);
            }
            $methode->addParameters($parameter);
        }
        $methode->setModifier("public");
        $returnGet = "return \$this->".$propertyName;
        $returnthis = "return \$this";
        $set = "\$this->".$propertyName." = $".lcfirst($className);
        $add = "\$this->".$propertyName."->add($".lcfirst($className).")";
        $remove = "\$this->".$propertyName."->remove($".lcfirst($className).")";
        if($type == "get")
        {
            $content = <<<EOF
    $returnGet;
EOF;
        }
        elseif($type == "set")
        {
            $content = <<<EOF
    $set;        
        $returnthis;
EOF;
        }
        elseif($type == "add")
        {
            $content = <<<EOF
    $add;
EOF;
        }
        elseif($type == "remove")
        {
            $content = <<<EOF
    $remove;
EOF;
        }
        $methode->setContent($content);
        return $methode;
    }
    public function addArrayCollectionConstruct(InfoClass $infoClass,$propertyName)
    {
        $contentConstruct = $infoClass->getLoader()->getConstruct()->getContent();
        $contentConstruct = explode(";",$contentConstruct);
        $find = 0;
        foreach ($contentConstruct as $lignContent)
        {
            if(trim($lignContent) == '$this->'.$propertyName.' = new ArrayCollection()')
            {
                $find = 1;
            }
        }
        if($find == 0)
        {
            $infoClass->getLoader()->getConstruct()->setContent($infoClass->getLoader()->getConstruct()->getContent().'$this->'.$propertyName.' = new ArrayCollection();');
        }
        return $infoClass;
    }


}