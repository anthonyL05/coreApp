<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/a", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $app = $this->get('core.app');
        $app->generateCore();
        die();
    }


    public function FindAllTesteAction()
    {
        $em = $this->get('neo4j_manager');
        $personRepository = $em->getRepository('Person');
        $persons = $personRepository->findAll();
        die();
    }

    /**
     * @Route("/")
     */
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
