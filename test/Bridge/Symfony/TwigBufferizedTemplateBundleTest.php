<?php
/*
* This file is part of the Twig Bufferized Template package, an RunOpenCode project.
*
* (c) 2017 RunOpenCode
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig\Bridge\Symfony;

use PHPUnit\Framework\TestCase;
use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection\Extension;
use RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\TwigBufferizedTemplateBundle;

class TwigBufferizedTemplateBundleTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsExtension()
    {
        $this->assertInstanceOf(Extension::class, (new TwigBufferizedTemplateBundle())->getContainerExtension());
    }
}
