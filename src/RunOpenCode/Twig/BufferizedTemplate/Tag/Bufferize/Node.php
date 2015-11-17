<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize;

class Node extends \Twig_Node
{
    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write("\n");

        $compiler->subcompile($this->getNode('body'));
    }

    public function getPriority()
    {
        return $this->getAttribute('priority');
    }
}