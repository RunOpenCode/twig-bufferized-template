<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Fixtures\Mockup;

class DummyTwigExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getTokenParsers() {

        return array(
            new DummyTwigTokenParser()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'run_open_code_test_extension';
    }
}
