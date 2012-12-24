<?php

namespace BDE\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PrintController extends Controller
{
    /**
     * @Template
     */
    public function menuAction()
    {
      $files = array();
      foreach( scandir(dirname(__FILE__) . '/../Resources/views/Print/') as $file )
        if( !in_array($file, array('.', '..', 'index.html.twig', 'menu.html.twig')) )
          $files[] = substr(str_replace('.html.twig', '', $file), 4);

      return compact('files');
    }

    /**
     * @Route("/print-{file}", name="print", defaults={"file"=null})
     * @Template
     */
    public function indexAction($file)
    {
      return compact('file');
    }

    /**
     * @Route("/print/{file}", name="print_show", defaults={"file"="empty_file"})
     */
    public function showAction($file)
    {
      $vars = array();
      $em = $this->getDoctrine()->getManager();

      switch($file)
      {
        case 'barcode':
        case 'ag':
          $vars['entities'] = $em->getRepository('BDEMemberBundle:Member')->findAll();
          break;

        default :
          return new Response('Rien à imprimer !');
          break;
      }

      return $this->render('BDEMemberBundle:Print:tpl.' . $file . '.html.twig', $vars);
    }
}
