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
use CoreAppBundle\InfoClass\Methode;
use CoreAppBundle\InfoClass\Parameter;

class GeneratorOtherClass
{
    public function checkOtherClass(InfoClass $infoClass,$rootDir,UpdateClass $updateClass)
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
            $infoClassNew = $this->addOtherClassPossible($infoClassNew);
            $infoClassNew->generateOtherClass();
            $infoClassNew = $updateClass->update($infoClassNew);
            $infoClass->addInfoClassContain($infoClassNew);
            $this->checkOtherClass($infoClassNew,$rootDir,$updateClass);
        }
        return $infoClass;
    }

    public function addParentConstruct($contentConstruct)
    {
        if(substr_count($contentConstruct,"parent::__construct();") == 0)
        {
            $contentConstruct = "parent::__construct(); \r\n".$contentConstruct;
        }
        return $contentConstruct;
    }

    public function addOtherClassPossible(InfoClass $infoClass)
    {
        /** @var Methode $methodeExist */
        foreach ($infoClass->getLoader()->getMethodes() as $methodeExist)
        {
            if($methodeExist->getMethodeName() == "getClassPossible")
            {
                return $infoClass;
            }
        }
        $methode = new Methode();
        $methode->setMethodeName("getClassPossible");
        $contains = '$classPossible = new ArrayCollection();';
        $return = 'return $classPossible;';
        $content = <<<EOF
    $contains
        $return
EOF;
        $methode->setContent($content);
        $infoClass->getLoader()->addMethode($methode);
        $infoClass->getLoader()->addUse("use Doctrine\\Common\\Collections\\ArrayCollection;");
        return $infoClass;

    }


}