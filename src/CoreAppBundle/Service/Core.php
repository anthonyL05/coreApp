<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 11:42
 */

namespace CoreAppBundle\Service;



use CoreAppBundle\InfoCLass\InfoClass;

class Core
{
    /**
     * @var InfoClass $infoclass;
     */
    private $infoClass;

    /** @var  $rootDir */
    private $rootDir;

    /**
     * test constructor.
     */
    public function __construct($rootDir)
    {
        $this->rootDir = realpath($rootDir . '/../src');
        $this->infoClass = new InfoClass($this->rootDir,"Test");
    }
    public function generateClass()
    {
        $this->infoClass->generateClass();
    }
}