<?php

namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        return $this->render('@Dashboard/Default/index.html.twig', [
            'rdv' => null,
            'rdv_demain' => null,
            'rdv_next' => null,
            'ca_last_year' => null,
            'ca_this_year' => null,
        ]);
    }
}
