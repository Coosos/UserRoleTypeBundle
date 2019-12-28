<?php

namespace Coosos\UserRoleTypeBundle\Tests;

use Coosos\UserRoleTypeBundle\DependencyInjection\CoososUserRoleTypeExtension;
use Coosos\UserRoleTypeBundle\Form\Type\UserRoleType;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ExtensionTest
 *
 * @package Coosos\UserRoleTypeBundle\Tests
 * @author  Remy Lescallier <lescallier1@gmail.com>
 */
class ExtensionTest extends AbstractExtensionTestCase
{
    /**
     * Test services
     */
    public function testAfterLoadingParametersAreSet()
    {
        $this->load();
        $this->assertContainerBuilderHasService('coosos_user_role_type.form.user_role_type', UserRoleType::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'coosos_user_role_type.form.user_role_type',
            'form.type'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'coosos_user_role_type.form.user_role_type',
            0,
            '%security.role_hierarchy.roles%'
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'coosos_user_role_type.form.user_role_type',
            1,
            new Reference('security.authorization_checker')
        );
    }

    /**
     * @inheritDoc
     */
    protected function getContainerExtensions(): array
    {
        return [new CoososUserRoleTypeExtension()];
    }
}
