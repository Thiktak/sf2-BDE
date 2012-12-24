<?php

namespace Thiktak\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FilterController extends Controller
{
    /**
     * @Route("/filter:{type}/{key}/{value}", name="filter_apply", defaults={"type"="set"})
     */
    public function applyAction(Request $request, $type, $key, $value)
    {
        $_session = $this->get('session');
        $key = 'filter.' . $key;

        switch($type) {
          case 'set' :
            if( $value == '*' )
              $_session->remove($key);
            else
              $_session->set($key, (array) $value);
            break;

          case 'add' :
            
            $value2 = (array) $_session->get($key, null);
            
            if( ($arrayKey = array_search($value, $value2)) !== false )
              unset($value2[$arrayKey]);
            else
              $value2[] = $value;

            $_session->set($key, $value2);
            break;

          default:
            exit('!');
            break;
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
