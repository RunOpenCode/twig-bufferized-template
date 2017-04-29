<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Buffer;

use RunOpenCode\Twig\BufferizedTemplate\Exception\LogicException;

/**
 * Class TemplateBuffer
 *
 * Template buffer is pointer to callable that wraps portion of compiled bufferized Twig template.
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Buffer
 *
 * {@internal}
 */
final class TemplateBuffer
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var string
     */
    private $output;

    public function __construct(callable $callable, $priority = 0)
    {
        $this->callable = $callable;
        $this->priority = $priority;
    }

    /**
     * Execute template.
     *
     * @return TemplateBuffer $this
     */
    public function execute()
    {
        if (null === $this->output) {
            ob_start();
            call_user_func($this->callable);
            $this->output = ob_get_clean();
        }

        return $this;
    }

    /**
     * Get execution priority.
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get template buffer output.
     *
     * @return string
     */
    public function getOutput()
    {
        if (null === $this->output) {
            throw new LogicException('TemplateBuffer output can not be acquired prior to its execution.');
        }

        return $this->output;
    }
}
