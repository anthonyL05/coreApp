<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 10/04/2017
 * Time: 12:15
 */

namespace CoreAppBundle\ClassGestion;


use CoreAppBundle\InfoClass\Construct;
use CoreAppBundle\InfoClass\InfoClass;

class GeneratorOtherClass
{
    public function checkOtherClass(InfoClass $infoClass,$rootDir)
    {
        foreach ( $infoClass->getClassCall() as $otherClass)
        {
            $className = $otherClass[0];
            if(class_exists("AppBundle\\Entity\\".$className))
            {
                $infoClassNew = new InfoClass(true,$rootDir,$className);
            }
            else
            {
                $infoClassNew = new InfoClass(false,$rootDir,$className);
            }
            $infoClassNew->getLoader()->addUse("use Neo4jBundle\\Entity\\GlobalEntity;");
            $infoClassNew->getLoader()->getConstruct()->setContent($this->addParentConstruct($infoClassNew->getLoader()->getConstruct()->getContent()));
            $infoClassNew->addExtends("GlobalEntity");
            $infoClass->addInfoClassContain($infoClassNew);
        }
        return $infoClass;
    }

    public function addParentConstruct($contentConstruct)
    {
        if(strstr("parent::__construct();",$contentConstruct) != false)
        {
            $contentConstruct = "parent::__construct(); \r\n".$contentConstruct;
        }
        return $contentConstruct;
    }

}