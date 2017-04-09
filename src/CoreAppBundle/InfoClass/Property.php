<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 17:15
 */

namespace CoreAppBundle\InfoCLass;


class Property
{

    private $propertyName;

    private $phpdoc;

    private $modifier;

    /**
     * @return mixed
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param mixed $propertyName
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return mixed
     */
    public function getPhpdoc()
    {
        return $this->phpdoc;
    }

    /**
     * @param mixed $phpdoc
     */
    public function setPhpdoc($phpdoc)
    {
        $this->phpdoc = trim($phpdoc);
    }

    /**
     * @return mixed
     */
    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * @param mixed $modifier
     */
    public function setModifier($modifier)
    {
        $this->modifier = $modifier;
    }






}