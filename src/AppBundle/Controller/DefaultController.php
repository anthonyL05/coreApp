<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $app = $this->get('core.app');
        $app->generateCore();
        die();
    }

    /**
     * @Route("/")
     */
    public function FindAllTesteAction()
    {
        $em = $this->get('neo4j_manager');
        $personRepository = $em->getRepository('Person');
        $persons = $personRepository->findAll();
        dump($persons);
        die();
    }


    public function PersistTestAction()
    {
        $em = $this->get('neo4j_manager');
        $person = new Person();
        $person->setName("lempriere");
        $em->persist($person);
        $em->flush();
        die();
    }
}
