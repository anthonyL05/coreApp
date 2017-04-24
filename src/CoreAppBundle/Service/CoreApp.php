<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 11:42
 */

namespace CoreAppBundle\Service;



use CoreAppBundle\ClassGestion\GeneratorOtherClass;
use CoreAppBundle\ClassGestion\UpdateClass;
use CoreAppBundle\InfoClass\InfoClass;

class CoreApp
{
    /**
     * @var InfoClass $infoclass;
     */
    private $infoClassCore;

    /** @var  $rootDir */
    private $rootDir;

    /** @var  UpdateClass $updateClass */
    private $updateClass;

    /** @var  GeneratorOtherClass $generatorOtherClass */
    private $generatorOtherClass;

    /**
     * test constructor.
     */
    public function __construct($rootDir,$coreAppName)
    {
        $this->updateClass = new UpdateClass();
        $this->generatorOtherClass = new GeneratorOtherClass();
        $this->rootDir = realpath($rootDir . '/../src');
        $this->infoClassCore = new InfoClass("true",$this->rootDir,$coreAppName);
    }
    public function generateCore()
    {
        $this->infoClassCore = $this->updateClass->update($this->infoClassCore);
        $this->infoClassCore = $this->generatorOtherClass->checkOtherClass($this->infoClassCore,$this->rootDir,$this->updateClass);
        $this->infoClassCore->generateClass();
    }
}