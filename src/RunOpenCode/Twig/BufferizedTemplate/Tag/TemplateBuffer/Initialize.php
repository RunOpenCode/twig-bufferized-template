<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer;

use RunOpenCode\Twig\BufferizedTemplate\Buffer\BufferManager;

/**
 * Class Initialize
 *
 * Initialize buffer manager and start new buffer.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 *
 * @internal
 */
final class Initialize extends AbstractBufferNode
{
    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler
            ->write(sprintf('%s = new \\%s();', $this->getContextVariableName(), BufferManager::class))
            ->write("\n");

        $compiler
            ->write(sprintf('%s->bufferize(Closure::bind(function() use (&$context, &$blocks) {', $this->getContextVariableName()))
            ->write("\n");
    }
}
