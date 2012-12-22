<?php

namespace Thiktak\CoreBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

/**
 * @author Olivarès Georges <dev@olivares-georges.fr>
 ****************
 *  How To use  *
 ****************
 *
 * $entity = new ObjectEntity();
 *
 * $this->get('thiktak.core.form')->bind($entity);
 * // $this->get('thiktak.core.form')->bind($entity, array('key' => 'value'));
 * // ...
 *
 * $form = $this->createForm(new DocumentType(), $entity);
 */
Class FormService
{
  protected $request;
  protected $em;

  public function __construct(Request $request, EntityManager $em)
  {
    $this->request = $request;
    $this->em      = $em;
  }

  public function bind($entity, array $values = null)
  {
    $values = array_merge((array) $values, $this->request->query->all());

    $o = new \ReflectionClass($entity);
    foreach( $values as $key => $value )
      if( method_exists($entity, 'set' . $key) ) {
        $m = new \ReflectionMethod($entity, 'set' . $key);
        $params = array();
        foreach( $m->getParameters() as $param )
          if( $param->getClass() )
            $params[] = $this->em->getRepository($param->getClass()->getName())->find($value);

          else
            $params[] = $value/* ?$param->getDefaultValue()*/;

        $m->invokeArgs($entity, $params);
      }

  }
}