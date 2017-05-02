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

/**
 * Class BufferBreakPoint
 *
 * Terminate previous buffer and start new one.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 *
 * @internal
 */
final class BufferBreakPoint extends \Twig_Node
{
    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->write(sprintf('}, $this), %s);', $this->getAttribute('execution_priority')))
            ->write("\n");

        $compiler
            ->write(sprintf('%s->bufferize(Closure::bind(function() use (&$context, &$blocks) { ', $this->getAttribute('bufferized_context_variable_name')))
            ->write("\n");
    }
}
