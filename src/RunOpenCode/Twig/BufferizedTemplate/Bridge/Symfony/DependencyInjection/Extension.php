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


        if ($container->hasDefinition('roc.twig.bufferized_template')) {
            $definition = $container->getDefinition('roc.twig.bufferized_template');
            $definition->setArguments(array($config));
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
        return "run_open_code_twig_bufferized_template";
    }

}
