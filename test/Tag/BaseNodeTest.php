<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseNodeTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Tag
 */
abstract class BaseNodeTest extends TestCase
{
    /**
     * @param \Twig_Environment|null $environment
     * @return \Twig_Compiler
     */
    protected function getCompiler(\Twig_Environment $environment = null)
    {
        return new \Twig_Compiler(null === $environment ? $this->getEnvironment() : $environment);
    }

    /**
     * @return \Twig_Environment
     */
    protected function getEnvironment()
    {
        return new \Twig_Environment(new \Twig_Loader_Array(array()));
    }
}
