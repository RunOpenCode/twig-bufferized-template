<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer;

final class Initialize extends BaseBufferNode
{
    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->write(sprintf('%s = $this->env->getExtension(\RunOpenCode\Twig\BufferizedTemplate\Extension::NAME)->createBuffer();', $this->getContextVariableName()))
            ->write("\n");

        $compiler
            ->write(sprintf('%s->bufferize(Closure::bind(function() use (&$context, &$blocks) { ', $this->getContextVariableName()))
            ->write("\n");

    }
}