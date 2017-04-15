<?php


namespace Neo4jBundle\Service;



use GraphAware\Neo4j\Client\ClientBuilder;

/**
 * Class Connection
 * @package Neo4jAccesBundle\Service
 */
class Connection
{

    /**
     * @var \GraphAware\Neo4j\Client\ClientInterface $client
     *
     * Contain the client conection
     */
    private $client;


    /**
     * Connection constructor.
     * @param $informationConection
     */
    public function __construct($informationConection)
    {
        /**
         * Todo check what the default do
         */
        $client = ClientBuilder::create()
            ->addConnection('default', $informationConection)
            ->build();
        $this->client = $client;
    }

    public function executRequete($request)
    {
        return $this->client->run($request);
    }






}
