<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Pagerfanta\Twig\Extension\PagerfantaExtension;


class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
