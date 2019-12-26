<?php

namespace Coosos\UserRoleTypeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Coosos\UserRoleTypeBundle\DependencyInjection
 * @author  Remy Lescallier <lescallier1@gmail.com>
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
            : $treeBuilder->root('coosos_user_role_type');

        return $treeBuilder;
    }
}
