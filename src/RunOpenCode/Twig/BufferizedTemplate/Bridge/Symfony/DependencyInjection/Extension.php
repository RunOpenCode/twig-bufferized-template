<?php

namespace RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as BaseExtension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Extension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('twig.extension.xml');


        if ($container->hasDefinition('runopencode.twig.bufferized_template')) {

            $container
                ->getDefinition('runopencode.twig.bufferized_template')
                ->setArguments([
                    $config
                ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return "runopencode_twig_bufferized_template";
    }

}
