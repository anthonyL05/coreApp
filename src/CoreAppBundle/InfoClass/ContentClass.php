<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 08/04/2017
 * Time: 17:06
 */

namespace CoreAppBundle\InfoClass;


class ContentClass
{

    private $content;

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }




}