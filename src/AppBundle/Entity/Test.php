<?php

namespace AppBundle\Entity;



class Test {

        /**
     * @var string $troll
     */
    private $troll;

        /**
     * Test constructor
     */
    public function __construct()
    {
        if("a" == "a")
        {
            $this->troll = "je troll";
        }
        else
        {
            $this->troll = "impossible";
        }
    }

        /**
     * @return mixed
     */
    public function getTroll()
    {
        return $this->troll;
    }

    
    /**
     * @param mixed $troll
     */
    public function setTroll($troll )
    {
        $this->troll = $troll;
    }

    


}