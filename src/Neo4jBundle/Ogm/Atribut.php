<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 21/01/2017
 * Time: 00:19
 */

namespace Neo4jBundle\Ogm;


class Atribut
{

    /**
     * @var  string $name */
    private $name;

    /** @var  string $type */
    private $type;

    /** @var  $value */
    private $value;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }




    public function isNameValid($name)
    {
        /**
         * Todo check if the name of the attribut is valid
         */
        return true;
    }

    public function isTypeValid($type)
    {
        /**
         * Todo check if the type is valid
         */
        return false;
    }



}