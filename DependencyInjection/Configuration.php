<?php

namespace Coosos\UserRoleTypeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('coosos_user_role_type');
        if (40200 > Kernel::VERSION_ID) {
            $treeBuilder->root('coosos_user_role_type');
        }

        return $treeBuilder;
    }
}
