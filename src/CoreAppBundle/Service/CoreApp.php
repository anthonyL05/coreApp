<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 11:42
 */

namespace CoreAppBundle\Service;



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

    /** @var  $updateClass */
    private $updateClass;

    /**
     * test constructor.
     */
    public function __construct($rootDir,$coreAppName)
    {
        $this->updateClass = new UpdateClass();
        $this->rootDir = realpath($rootDir . '/../src');
        $this->infoClassCore = new InfoClass($this->rootDir,$coreAppName);
        $this->infoClassCore = $this->updateClass->update($this->infoClassCore);

    }
    public function generateCore()
    {
        $this->infoClassCore->generateClass();
    }
}