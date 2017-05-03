<?php
/*
 * This file is part of the Twig Bufferized Template package, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as BaseExtension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class Extension
 *
 * @package RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection
 */
class Extension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return "runopencode_twig_bufferized_template";
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return 'http://www.runopencode.com/xsd-schema/twig-bufferized-template-bundle';
    }

    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('twig.extension.xml');


        $container
            ->getDefinition('runopencode.twig.bufferized_template')
            ->setArguments([
                $config
            ]);
    }
}
