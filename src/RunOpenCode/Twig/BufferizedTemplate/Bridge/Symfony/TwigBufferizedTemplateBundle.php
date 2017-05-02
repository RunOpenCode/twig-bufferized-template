<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony;

use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TwigBufferizedTemplateBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new Extension();
    }
}
