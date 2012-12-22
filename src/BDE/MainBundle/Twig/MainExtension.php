<?php

namespace BDE\MainBundle\Twig;

class MainExtension extends \Twig_Extension
{

    public function __construct()
    {
    }

    public function getFunctions()
    {
        return array(
            'getSchoolYear' => new \Twig_Function_Method($this, 'getSchoolYear'),
            'min'           => new \Twig_Function_Method($this, 'min'),
            'max'           => new \Twig_Function_Method($this, 'max'),
        );
    }

    function getSchoolYear() {
        return date('Y');
    }

    function min() {
        return call_user_func_array('min', func_get_args());
    }
    function max() {
        return call_user_func_array('max', func_get_args());
    }

    public function getName()
    {
        return 'main_extension';
    }
}