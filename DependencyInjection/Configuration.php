<?php

namespace Coosos\UserRoleTypeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('coosos_user_role_type');
        $rootNode = (method_exists($treeBuilder, 'getRootNode'))
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root("coosos_user_role_type");

        return $treeBuilder;
    }
}
