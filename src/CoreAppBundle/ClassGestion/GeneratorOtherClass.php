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
            if(class_exists("AppBundle\\entity\\".$className))
            {
                $infoClassNew = new InfoClass(true,$rootDir,$className);
            }
            else
            {
                $infoClassNew = new InfoClass(false,$rootDir,$className);
            }
            $infoClass->addInfoClassContain($infoClassNew);
        }
        return $infoClass;
    }

}