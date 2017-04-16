<?php


namespace Neo4jBundle\Repository;




use Doctrine\Common\Collections\ArrayCollection;
use Neo4jBundle\Annotation\Reader;
use Neo4jBundle\Ogm\Label;
use Neo4jBundle\Service\Connection;

class Repository
{

    /** @var RepositoryInfo $repositoryInfo */
    private $repositoryInfo;

    /** @var  Reader $reader */
    private $reader;

    /** @var  Connection $connection */
    private $connection;

    /**
     * Repository constructor.
     */
    public function __construct($entityName ,$conection)
    {
        $this->repositoryInfo = new RepositoryInfo($entityName);
        $this->reader = new Reader();
        $this->connection = $conection;
    }



    public function findAll()
    {
        /** @var Label $label */
        $label = $this->reader->getLabelEntity($this->repositoryInfo);
        $request = "MATCH( p:".$label->getValue().") RETURN p";
        $requestResult = $this->connection->executRequete($request);
        $entities = new ArrayCollection();
        foreach($requestResult->records() as $record)
        {
            $entity = $this->reader->getResult($record,$this->repositoryInfo,"findAll");
            $entities->add($entity);
        }
        return $entities;
    }

    /**
     * @return RepositoryInfo
     */
    public function getRepositoryInfo()
    {
        return $this->repositoryInfo;
    }




}