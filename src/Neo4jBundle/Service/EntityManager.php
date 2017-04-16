<?php

namespace Neo4jBundle\Service;



use Doctrine\Common\Collections\ArrayCollection;
use GraphAware\Bolt\Result\Result;
use Neo4jBundle\Annotation\Reader;
use Neo4jBundle\Ogm\Atribut;
use Neo4jBundle\Ogm\Label;
use Neo4jBundle\Ogm\Node;
use Neo4jBundle\Repository\Repository;

class EntityManager
{


    /** @var  Connection $conection */
    private $conection;

    /** @var  Reader $reader */
    private $reader;


    /** @var  ArrayCollection $persistNode */
    private $persistNode;



    /**
     * EntityManager constructor.
     */
    public function __construct()
    {
        $this->persistNode = new ArrayCollection();
    }

    public function setConnection(Connection $connection)
    {
        $this->conection = $connection ;
        $this->reader = new Reader();
    }

    public function getRepository($entityName)
    {
        return new Repository($entityName,$this->conection);
    }

    public function Persist($entity)
    {
        $pathEntity = get_class($entity);
        $pathEntityExplode = explode("\\",$pathEntity);
        $entityName = array_pop($pathEntityExplode);
        $repository = new Repository($entityName,$this->conection);
        $node = $this->reader->get($entity,$repository->getRepositoryInfo());
        /** todo check if the node is already persist then modify it */
        $this->persistNode->add(array('node'=>$node , 'action' => 'CREATE'));
    }
    public function flush()
    {
        if(count($this->persistNode) > 0)
        {
            foreach ($this->persistNode as $nodeAction)
            {
                if($nodeAction['action'] == "CREATE")
                {
                    $this->CreeNode($nodeAction['node']);
                }
            }
        }
    }

    /** TODO function need to be move in an other file */
    public function CreeNode(Node $node)
    {
        $request = "CREATE ( p";
        /** @var Label $label */
        foreach ($node->getLabels() as $label)
        {
            $request = $request.":".$label->getValue();
        }
        if(count($node->getAtributs()) > 0)
        {
            $request = $request." { ";
            /** @var Atribut $atribut */
            for($i = 0; $i < count($node->getAtributs()) ; $i++)
            {
                if($i != 0)
                {
                    $request = $request.', ';
                }
                $atribut = $node->getAtributs()[$i];
                $request = $request.$atribut->getName().": ";
                if($atribut->getType() == "string")
                {
                    $request = $request."'".$atribut->getValue()."'";
                }
                elseif($atribut->getType() == "integer")
                {
                    $request = $request.$atribut->getValue();
                }
                else{
                    /**
                     * Todo faire les autres type de donner suporte
                     */
                }
            }
            $request = $request." }";
        }
        $request = $request.") RETURN p";

        /** @var Result $requestResult */
        $requestResult = $this->conection->executRequete($request);

        dump($requestResult);
    }



}