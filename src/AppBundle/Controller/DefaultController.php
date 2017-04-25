<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $app = $this->get('core.app');
        $app->generateCore();
        die();
    }


    public function FindAllTesteAction()
    {
        $em = $this->get('neo4j_manager');
        $personRepository = $em->getRepository('User');
        $persons = $personRepository->findAll();
        dump($persons);
        die();
    }


    public function PersistTestAction()
    {
        $em = $this->get('neo4j_manager');
        $person = new Person();
        $user = new User();
        $person->setNom("lempriere");
        $user->setPseudo("antho");
        $person->addClass($user);
        dump($person);
        $em->persist($person);
        $em->flush();
        die();
    }
}
