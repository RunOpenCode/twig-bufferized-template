<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Twig;

use RunOpenCode\Twig\BufferizedTemplate\Extension;

class BufferizeTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var \Twig_Loader_Array
     */
    protected $loader;

    /**
     * @var string
     */
    protected $cachedir;

    public function setUp()
    {
        $this->loader = new \Twig_Loader_Filesystem(array(
            realpath(__DIR__ . '/../Resources/twig')
        ));

        $this->cachedir = realpath(__DIR__ . '/../') . '/cache';

        $this->environment = new \Twig_Environment($this->loader, array());

        $this->environment->addExtension(new Extension());
    }

    public function testBufferizeTag()
    {
        $html = $this->environment->render('page.html.twig');
        $this->assertContains('Some var: 10', $html);
    }
}