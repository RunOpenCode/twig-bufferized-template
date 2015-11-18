<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2015 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize;

/**
 * Class Node
 *
 * Bufferize node denotes node in AST which ought to be buffered.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize
 */
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