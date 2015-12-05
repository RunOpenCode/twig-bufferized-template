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
 * Class Terminate
 *
 * Terminate last buffer and display output.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 */
final class Terminate extends BaseBufferNode
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
            ->write(sprintf('%s->display();', $this->getContextVariableName()))
            ->write("\n");
    }

}
