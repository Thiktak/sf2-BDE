<?php

namespace Thiktak\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller
{
    /**
     * @Template()
     */
    public function menuAction()
    {
        return array();
    }
}
