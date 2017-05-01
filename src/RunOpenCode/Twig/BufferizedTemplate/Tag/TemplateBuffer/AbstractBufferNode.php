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
 * Class AbstractBufferNode
 *
 * Base buffer node containing base methods and settings.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 *
 * @internal
 */
abstract class AbstractBufferNode extends \Twig_Node
{
    /**
     * Default execution priority
     *
     * @var int
     */
    private $defaultExecutionPriority;

    /**
     * AbstractBufferNode constructor.
     *
     * @param int $defaultExecutionPriority
     * @param array $nodes
     * @param array $attributes
     * @param int $lineno
     * @param null|string $tag
     */
    public function __construct($defaultExecutionPriority, array $nodes = array(), array $attributes = array(), $lineno = 0, $tag = null)
    {
        $this->defaultExecutionPriority = $defaultExecutionPriority;
        parent::__construct($nodes, $attributes, $lineno, $tag);
    }

    /**
     * Get context random variable name.
     *
     * @return string
     */
    public function getContextVariableName()
    {
        return '$_________runopencode_twig_bufferized_template_environment_variable_______iByUtNtcGcwrjomGoxjFQNuKmmOSVpZjLuKersvpdImnPTfXsCrfWXNrkpTV';
    }

    /**
     * Get execution priority.
     *
     * @return int
     */
    public function getExecutionPriority()
    {
        if ($this->hasAttribute('bufferized_execution_priority')) {
            return $this->getAttribute('bufferized_execution_priority');
        }

        return $this->defaultExecutionPriority;
    }
}
