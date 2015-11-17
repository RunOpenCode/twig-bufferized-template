<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tag\TemplateBuffer;

abstract class BaseBufferNode extends \Twig_Node
{
    const CONTEXT_VARIABLE_NAME = '$_________run_open_code_twig_bufferized_template_environment_variable_______iByUtNtcGcwrjomGoxjFQNuKmmOSVpZjLuKersvpdImnPTfXsCrfWXNrkpTV';

    private $defaultExecutionPriority;

    public function __construct($defaultExecutionPriority, array $nodes = array(), array $attributes = array(), $lineno = 0, $tag = null)
    {
        $this->defaultExecutionPriority = $defaultExecutionPriority;
        parent::__construct($nodes, $attributes, $lineno, $tag);
    }

    protected function getContextVariableName()
    {
        return self::CONTEXT_VARIABLE_NAME;
    }

    public function getExecutionPriority()
    {
        if ($this->hasAttribute('bufferized_execution_priority')) {
            return $this->getAttribute('bufferized_execution_priority');
        }

        return $this->defaultExecutionPriority;
    }
}