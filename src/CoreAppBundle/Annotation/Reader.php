<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 09/04/2017
 * Time: 17:37
 */

namespace CoreAppBundle\Annotation;


use CoreAppBundle\InfoClass\InfoClass;
use Doctrine\Common\Annotations\AnnotationReader;

class Reader
{


    private $annotationReader;
    /**
     * Reader constructor.
     */
    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }

    public function updateProperty(InfoClass $infoClass)
    {
        $reflexionClass = $infoClass->getLoader()->getReflexionCLass();
        if($reflexionClass != null)
        {
            foreach ($reflexionClass->getProperties() as $property) {
                $readerProperty = $this->annotationReader->getPropertyAnnotation($property, 'CoreAppBundle\Annotation\Core');
                if ($readerProperty)
                {
                    if ($readerProperty->className != null)
                    {
                        $infoClass->addClassCall(array($readerProperty->className, "collection",$property->name,"enity"));
                    }
                }
                $readerProperty1 = $this->annotationReader->getPropertyAnnotation($property, 'Neo4jBundle\Annotation\AnnotationProperty');
                if ($readerProperty1)
                {
                    if($readerProperty1->name != null)
                    {
                        $infoClass->addPropertyCall($property->name);
                    }
                }
            }
        }
        return $infoClass;
    }
}