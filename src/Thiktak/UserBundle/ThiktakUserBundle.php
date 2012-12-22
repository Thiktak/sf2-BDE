<?php

namespace Thiktak\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ThiktakUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
