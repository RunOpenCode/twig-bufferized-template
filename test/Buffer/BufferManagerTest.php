<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Tests\Buffer;

use PHPUnit\Framework\TestCase;
use RunOpenCode\Twig\BufferizedTemplate\Buffer\BufferManager;

/**
 * Class BufferManagerTest
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Tests\Buffer
 *
 * @internal
 */
class BufferManagerTest extends TestCase
{
    /**
     * @test
     */
    public function itManagesExecutionAndRenderingOrder()
    {
        $manager = new BufferManager();
        $executionOrder = [];

        $manager->bufferize(function() use (&$executionOrder) {
            $executionOrder[] = 10;
            echo '10';
        }, 10);
        $manager->bufferize(function() use (&$executionOrder) {
            $executionOrder[] = 6;
            echo '6';
        }, 6);
        $manager->bufferize(function() use (&$executionOrder) {
            $executionOrder[] = 20;
            echo '20'; 
        }, 20);
        $manager->bufferize(function() use (&$executionOrder) {
            $executionOrder[] = 17;
            echo '17';
        }, 17);
        $manager->bufferize(function() use (&$executionOrder) {
            $executionOrder[] = 3;
            echo '3';
        }, 3);

        $this->assertEquals('10620173', $manager->render());
        $this->assertEquals([ 20, 17, 10, 6, 3 ], $executionOrder);

        ob_start();
        $manager->display();
        $this->assertEquals('10620173', ob_get_clean());
    }
}
