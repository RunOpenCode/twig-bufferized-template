<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer;

class BufferStart extends BaseBufferNode
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