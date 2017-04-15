<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 21/01/2017
 * Time: 00:29
 */

namespace Neo4jBundle\Ogm;


class Label
{
    /** @var  string $value */
    private $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }




}