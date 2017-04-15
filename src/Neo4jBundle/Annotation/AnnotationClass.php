<?php

namespace Neo4jBundle\Annotation;
use Doctrine\Common\Annotations\Annotation;


/**
 * @Annotation
 * @Target("CLASS")
 */
class AnnotationClass extends Annotation
{
    public $label;

}