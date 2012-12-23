<?php

namespace BDE\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;

class ImportController extends Controller
{
    /**
     * @Route("/import", name="import")
     * @Template()
     */
    public function indexAction(Request $request)
    {
      $form = $this->createFormBuilder()
              ->add('file', 'file') // If I remove this line data is submitted correctly
              ->getForm();

      if ($request->getMethod() == 'POST') {
        $request = $this->getRequest();
        $form->bindRequest($request);

        $data = $form->getData();
        
        if( $form->isValid() && isset($data['file']) ) {
          if( !in_array($data['file']->getMimeType(), array('text/plain')) )
            $form->addError(new FormError('MimeType du fichier incorrecte. Text/plain demandé (CSV)'));
          else {
            $id = uniqid() . '-' . time();
            if( $data['file']->move('uploads/imports/', $id) )
              return $this->redirect($this->generateUrl('import_make', array('id' => $id)));
            else
              $form->addError(new FormError('Import impossible'));
          }
        }
      }

      return array(
        'form' => $form->createView(),
      );
    }

    /**
     * @Route("/import/i{id}", name="import_make")
     * @Template()
     */
    public function makeAction($id)
    {
        $file = 'uploads/imports/' . $id;
        $file = file_get_contents($file);

        return array(
          'th' => array('a', 'b'),
        );
    }


    /**
     * @Route("/import-upload", name="import_upload")
     * @Template()
     */
    public function uploadAction(Request $request)
    {
      $form = $this->createFormBuilder()
              ->add('file', 'file') // If I remove this line data is submitted correctly
              ->getForm();

      if ($request->getMethod() == 'POST') {
        $request = $this->getRequest();
        $form->bindRequest($request);

        $data = $form->getData();
        var_dump($data);
      }

      return array(
        'form' => $form->createView(),
      );
    }
}
