<?php

namespace BDE\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IndexController extends Controller
{
    /**
     * @Route("/", name="_welcome")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/search", name="search", defaults={"query" = null})
     * @Route("/search/{query}", name="search_query")
     * @Template()
     */
    public function searchAction(Request $request, $query)
    {
        if( ($q = $request->query->get('query')) )
          return $this->redirect($this->generateUrl('search_query', array('query' => $q)));

        $query = preg_replace('` {1,}`', ' ', trim($query));

        $code = null;
        $em = $this->getDoctrine()->getManager();
        $entities = array('member' => array(), 'student' => array());

          if( preg_match('`(e|b|\#|)([0-9]{7,8})`', $query, $m) && $m[2] ) {
            $code = $m[2];

            $result = $em->getRepository('BDEMemberBundle:Member')->findOneById(intval(substr($code, 1, 7)));
            if( count($result) == 1 )
            {
              if( $result->getCode() == $code)
                return $this->redirect($this->generateUrl('member_show', array('id' => $result->getId(), 'b' => $code)));
              else
                $this->get('session')->getFlashBag()->add('error', 'Erreur ! Code invalide (' . $code . ' != ' . $result->getCode() . ')');
            }
          }
          else {
            //$entities['member'] = $em->getRepository('BDEMemberBundle:Member')->findById(substr($code, 1, 7));
          }


        return array(
          'query' => $query,
          'code'  => $code,
          'codeb' => substr($code, 0, 7),
          'entities' => $entities
        );
    }
}
