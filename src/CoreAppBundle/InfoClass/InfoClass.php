<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 11:45
 */

namespace CoreAppBundle\InfoCLass;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;

class InfoClass
{

    /** @var  Loader $loader */
    private $loader;

    private $className;


    private $namespace;

    /** @var  Generator $generatorClass */
    private $generatorClass;

    private $rootDir;

    /**
     * infoClass constructor.
     */
    public function __construct($rootDir ,$className,$path = "AppBundle\\Entity")
    {
        $this->rootDir = $rootDir;
        $this->className = $className;
        $this->namespace = $path;
        $this->generatorClass =  new GeneratorClass($this);
        $this->loader = new Loader($this);
    }

    public function generateClass()
    {
        $this->generatorClass->generateClass();
    }

    /**
     * @return Loader
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @return mixed
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }





















    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }




}