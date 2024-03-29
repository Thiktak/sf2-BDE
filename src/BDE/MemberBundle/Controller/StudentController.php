<?php

namespace BDE\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use BDE\MemberBundle\Entity\Student;
use BDE\MemberBundle\Form\StudentType;

/**
 * Student controller.
 *
 * @Route("/student")
 */
class StudentController extends Controller
{
    /**
     * @Template()
     */
    public function menuAction() {
        $Y = $this->get('bde.twig.main')->getSchoolYear();

        $filters = array();

        $filters['class']['values'] = $this->get('session')->get('filter.class', 'all');
        $filters['class']['choices']['set']['*']    = 'Toutes les classes';
        $filters['class']['choices']['add']['AS']   = 'AS';
        $filters['class']['choices']['add']['IR']   = 'IR';
        $filters['class']['choices']['add']['FIP']  = 'FIP';
        $filters['class']['choices']['add']['ME']   = 'ME';
        $filters['class']['choices']['add']['TF']   = 'TF';


        $filters['years']['values'] = $this->get('session')->get('filter.years', $Y);
        $filters['years']['choices']['set']['*'] = 'Toutes les années';
        foreach( range($Y, 2009) as $year )
            $filters['years']['choices']['set'][$year]  = $year;

        return compact('filters');
    }


    /**
     * Lists all Student entities.
     *
     * @Route("/", name="student")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BDEMemberBundle:Student')->createQueryBuilder('s')
                       ->getQuery()
                       ->getResult();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Student entity.
     *
     * @Route("/{id}/show", name="student_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BDEMemberBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Student entity.
     *
     * @Route("/new", name="student_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Student();
        $form   = $this->createForm(new StudentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Student entity.
     *
     * @Route("/create", name="student_create")
     * @Method("POST")
     * @Template("BDEMemberBundle:Student:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Student();
        $form = $this->createForm(new StudentType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('student_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Student entity.
     *
     * @Route("/{id}/edit", name="student_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BDEMemberBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $editForm = $this->createForm(new StudentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Student entity.
     *
     * @Route("/{id}/update", name="student_update")
     * @Method("POST")
     * @Template("BDEMemberBundle:Student:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BDEMemberBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new StudentType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('student_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Student entity.
     *
     * @Route("/{id}/delete", name="student_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BDEMemberBundle:Student')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Student entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('student'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
