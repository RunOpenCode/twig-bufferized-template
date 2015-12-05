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
 * Class BaseBufferNode
 *
 * Base buffer node containing base methods and settings.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer
 */
abstract class BaseBufferNode extends \Twig_Node
{
    const CONTEXT_VARIABLE_NAME = '$_________run_open_code_twig_bufferized_template_environment_variable_______iByUtNtcGcwrjomGoxjFQNuKmmOSVpZjLuKersvpdImnPTfXsCrfWXNrkpTV';
    const BUFFERIZED_EXECUTION_PRIORITY_ATTRIBUTE_NAME = 'bufferized_execution_priority';

    private $defaultExecutionPriority;

    public function __construct($defaultExecutionPriority, array $nodes = array(), array $attributes = array(), $lineno = 0, $tag = null)
    {
        $this->defaultExecutionPriority = $defaultExecutionPriority;
        parent::__construct($nodes, $attributes, $lineno, $tag);
    }

    public function getContextVariableName()
    {
        return self::CONTEXT_VARIABLE_NAME;
    }

    public function getExecutionPriority()
    {
        if ($this->hasAttribute(self::BUFFERIZED_EXECUTION_PRIORITY_ATTRIBUTE_NAME)) {
            return $this->getAttribute(self::BUFFERIZED_EXECUTION_PRIORITY_ATTRIBUTE_NAME);
        }

        return $this->defaultExecutionPriority;
    }
}
