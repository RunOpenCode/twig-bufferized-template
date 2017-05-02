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
 * Class Terminate
 *
 * Terminate last buffer and display output.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 *
 * @internal
 */
final class Terminate extends \Twig_Node
{
    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler
            ->write(sprintf('}, $this), %s);', $this->getAttribute('execution_priority')))
            ->write("\n");

        $compiler
            ->write(sprintf('%s->display();', $this->getAttribute('bufferized_context_variable_name')))
            ->write("\n");
    }
}
