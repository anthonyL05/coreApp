<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 25/02/2017
 * Time: 14:09
 */

namespace CoreAppBundle\Annotation;


use Doctrine\ORM\Mapping\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Core
 * @package Neo4jAccesBundle\Annotation
 * Read the anotation of Core property
 */

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Core
{

    /** contains name of each class contains in the collection*/
    public $className;
}