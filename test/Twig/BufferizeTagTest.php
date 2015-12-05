<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2015 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig;

use RunOpenCode\Twig\BufferizedTemplate\Extension;
use RunOpenCode\Twig\BufferizedTemplate\Tests\Mockup\DummyTwigExtension;

class BufferizeTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var \Twig_Loader_Filesystem
     */
    protected $loader;

    public function setUp()
    {
        $this->loader = new \Twig_Loader_Filesystem(array(
            realpath(__DIR__ . '/../Resources/twig')
        ));

        $this->environment = new \Twig_Environment($this->loader, array());

        $this->environment->addExtension(new Extension(array(
            'nodes' => array(
                'RunOpenCode\Twig\BufferizedTemplate\Tests\Mockup\DummyTwigNode' => 20
            )
        )));
        $this->environment->addExtension(new DummyTwigExtension());
    }

    public function testBufferizeTag()
    {
        $html = $this->environment->render('page.html.twig');
        $this->assertContains('Some var: 10', $html);
    }

    public function testBufferizeCustomTag()
    {
        $html = $this->environment->render('bufferize_custom_tag.html.twig');
        $this->assertContains('Some var: 20', $html);
    }
}
