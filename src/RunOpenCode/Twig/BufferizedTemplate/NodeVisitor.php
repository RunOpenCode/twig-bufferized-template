<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate;

use RunOpenCode\Twig\BufferizedTemplate\Tag\Bufferize\Node as BufferizeNode;
use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\BreakPoint;
use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\Initialize;
use RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer\Terminate;

/**
 * Class NodeVisitor
 *
 * Parses AST adding buffering tags on required templates.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate
 *
 * @internal
 */
final class NodeVisitor extends \Twig_BaseNodeVisitor
{
    const CONTEXT_VARIABLE_NAME = '$_________runopencode_twig_bufferized_template_environment_variable_______iByUtNtcGcwrjomGoxjFQNuKmmOSVpZjLuKersvpdImnPTfXsCrfWXNrkpTV';

    /**
     * @var array
     */
    private $settings;

    /**
     * @var string Current template name.
     */
    protected $templateName;

    /**
     * @var bool Denotes if current template body should be bufferized.
     */
    private $shouldBufferize = false;

    /**
     * @var string Denotes current scope of AST (block or body).
     */
    private $currentScope;

    /**
     * @var \Twig_Node[] List of blocks for current template.
     */
    private $blocks;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * {@inheritdoc}
     */
    protected function doEnterNode(\Twig_Node $node, \Twig_Environment $env)
    {
        if ($node instanceof \Twig_Node_Module) {
            $this->templateName = $node->getTemplateName();
        }

        if ($this->shouldProcess()) {

            if ($this->isBufferizingNode($node)) {
                $this->shouldBufferize = true;
            }

            if ($node instanceof \Twig_Node_Module) {
                $this->blocks = $node->getNode('blocks')->getIterator()->getArrayCopy();
            }

            if ($node instanceof \Twig_Node_Body) {
                $this->currentScope = null;
            } elseif ($node instanceof \Twig_Node_Block) {
                $this->currentScope = $node->getAttribute('name');
            }
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(\Twig_Node $node, \Twig_Environment $env)
    {
        if ($node instanceof \Twig_Node_Module) {
            $this->templateName = null;
        }


        if ($this->shouldProcess()) {

            if ($node instanceof \Twig_Node_Module) {

                if ($this->shouldBufferize) {

                    $node->setNode('body', new \Twig_Node([
                        new Initialize([], [
                            'bufferized_context_variable_name' => self::CONTEXT_VARIABLE_NAME
                        ]),
                        $node->getNode('body'),
                        new Terminate([], [
                            'bufferized_context_variable_name' => self::CONTEXT_VARIABLE_NAME,
                            'execution_priority' => $this->settings['default_execution_priority']
                        ])
                    ]));
                }

                $this->shouldBufferize = false;
                $this->blocks = [];
            }

            if ($this->isBufferizingNode($node) || ($node instanceof \Twig_Node_BlockReference && $this->hasBufferizingNode($this->blocks[$node->getAttribute('name')]))) {

                return new \Twig_Node([
                    new BreakPoint([], [
                        'bufferized_context_variable_name' => self::CONTEXT_VARIABLE_NAME,
                        'execution_priority' => $this->settings['default_execution_priority']
                    ]),
                    $node,
                    new BreakPoint([], [
                        'bufferized_context_variable_name' => self::CONTEXT_VARIABLE_NAME,
                        'execution_priority' => $this->getNodeExecutionPriority($node)
                    ])
                ]);

            } elseif ($this->currentScope && $node instanceof \Twig_Node_Block && $this->hasBufferizingNode($node)) {

                $node->setNode('body', new \Twig_Node([
                    new Initialize([], [
                        'bufferized_context_variable_name' => self::CONTEXT_VARIABLE_NAME
                    ]),
                    $node->getNode('body'),
                    new Terminate([], [
                        'bufferized_context_variable_name' => self::CONTEXT_VARIABLE_NAME,
                        'execution_priority' => $this->settings['default_execution_priority']
                    ])
                ]));

                return $node;
            }

        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->settings['node_visitor_priority'];
    }

    /**
     * Check if current template should be processed with node visitor based on whitelist or blacklist.
     *
     * @return bool
     */
    private function shouldProcess()
    {
        if (count($this->settings['whitelist']) > 0) {
            return in_array($this->templateName, $this->settings['whitelist'], true);
        }

        if (count($this->settings['blacklist']) > 0) {
            return !in_array($this->templateName, $this->settings['blacklist'], true);
        }

        return true;
    }

    /**
     * Check if provided node is node for bufferizing.
     *
     * @param \Twig_Node $node
     * @return bool
     */
    private function isBufferizingNode(\Twig_Node $node)
    {
        foreach ($this->settings['nodes'] as $nodeClass => $priority) {

            if ($node instanceof $nodeClass) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if current node is asset injection node, or if such node exists in its sub-tree.
     *
     * @param \Twig_Node $node Node to check.
     * @return bool TRUE if this subtree has bufferizing node.
     */
    private function hasBufferizingNode(\Twig_Node $node)
    {
        if ($this->isBufferizingNode($node)) {
            return true;
        }

        $has = false;

        foreach ($node as $n) {

            if (
                ($has |= $this->hasBufferizingNode($n))
                ||
                ($n instanceof \Twig_Node_BlockReference && $this->hasBufferizingNode($this->blocks[$n->getAttribute('name')]))
            ) {
                return true;
            }
        }

        return $has;
    }

    /**
     * Get execution priority of bufferized node.
     *
     * Get execution priority of bufferized node based on the node settings or configuration of the extension.
     *
     * @param \Twig_Node $node
     *
     * @return mixed
     */
    private function getNodeExecutionPriority(\Twig_Node $node)
    {
        if ($node instanceof BufferizeNode && null !== $node->getExecutionPriority()) {
            return $node->getExecutionPriority();
        }

        foreach ($this->settings['nodes'] as $nodeClass => $priority) {

            if (null !== $priority && $node instanceof $nodeClass) {
                return $priority;
            }
        }

        return $this->settings['default_execution_priority'];
    }
}
