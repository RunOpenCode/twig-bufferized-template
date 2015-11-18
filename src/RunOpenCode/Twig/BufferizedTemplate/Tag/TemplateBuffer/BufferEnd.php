<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2015 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer;

/**
 * Class BufferEnd
 *
 * Terminate buffer and start a new one.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 */
final class BufferEnd extends BaseBufferNode
{
    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->write(sprintf('}, $this), %s);', $this->getExecutionPriority()))
            ->write("\n");

        $compiler
            ->write(sprintf('%s->bufferize(Closure::bind(function() use (&$context, &$blocks) { ', $this->getContextVariableName()))
            ->write("\n");
    }
}