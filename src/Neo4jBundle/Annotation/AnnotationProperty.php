<?php


namespace Neo4jBundle\Annotation;
use Doctrine\Common\Annotations\Annotation;


/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class AnnotationProperty extends Annotation
{
    public $name;

    public $nullable;

    public $type;


}
