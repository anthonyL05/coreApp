<?php

namespace AppBundle\Controller;

use AppBundle\Service\App;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $app = $this->get('core.app');
        $app->generateClass();
        die();
    }
}
