<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer;

class Terminate extends BaseBufferNode
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