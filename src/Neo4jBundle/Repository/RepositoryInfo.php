<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 15/04/2017
 * Time: 17:02
 */

namespace Neo4jBundle\Repository;


class RepositoryInfo
{


    private $entityName;

    private $emptyClass;

    private $reflexionClass;


    /**
     * RepositoryInfo constructor.
     */
    public function __construct($entityName)
    {
        $this->entityName = $entityName;
        $className = "AppBundle\\Entity\\".$entityName;
        $this->emptyClass = new $className;
        $this->reflexionClass = new \ReflectionClass($this->emptyClass);
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflexionClass()
    {
        return $this->reflexionClass;
    }




}