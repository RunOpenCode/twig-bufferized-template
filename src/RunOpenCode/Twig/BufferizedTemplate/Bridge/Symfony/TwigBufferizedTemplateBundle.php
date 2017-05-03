<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony;

use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class TwigBufferizedTemplateBundle
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony
 */
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
