<?php

namespace Coosos\UserRoleTypeBundle\Tests;

use Coosos\UserRoleTypeBundle\Form\Type\UserRoleType;
use Coosos\UserRoleTypeBundle\Tests\Form\Type\TestUserType;
use Generator;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserRoleTypeTest
 *
 * @package Coosos\UserRoleTypeBundle\Tests
 * @author  Remy Lescallier <lescallier1@gmail.com>
 */
class UserRoleTypeTest extends TypeTestCase
{
    /**
     * @var array
     */
    private $roles;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->roles = ['ROLE_ADMIN' => ['ROLE_USER'], 'ROLE_SUPER_ADMIN' => ['ROLE_USER', 'ROLE_ADMIN']];
        $this->authorizationChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();

        parent::setUp();
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtensions()
    {
        return [
            new PreloadedExtension([new UserRoleType($this->roles, $this->authorizationChecker)], []),
        ];
    }

    /**
     * Test generate form
     *
     * @param UserInterface $currentUser
     * @param UserInterface $targetUser
     * @param array         $visibilitiesField
     *
     * @dataProvider listTest
     */
    public function testGenerateForm(UserInterface $currentUser, UserInterface $targetUser, array $visibilitiesField)
    {
        $this->authorizationChecker->expects($this->any())->method('isGranted')->will(
            $this->returnCallback(function ($role) use ($currentUser, $visibilitiesField) {
                return [] !== array_intersect($this->roles[$role], $currentUser->getRoles());
            })
        );

        $form = $this->factory->create(TestUserType::class, $targetUser);
        $rolesField = $form->get('roles');

        $this->assertEquals(count($this->roles), $rolesField->count());
        foreach ($rolesField->all() as $roleField) {
            $this->assertTrue(isset($this->roles[$roleField->getName()]));
            $this->assertEquals(
                $visibilitiesField[$roleField->getName()] === 1,
                $roleField->getConfig()->getOption('disabled')
            );
        }
    }

    /**
     * List for test
     *
     * @return Generator
     */
    public function listTest()
    {
        yield [
            $this->generateUser(['ROLE_USER']), // Current user
            $this->generateUser(['ROLE_USER']), // TargetUser user
            ['ROLE_ADMIN' => 0, 'ROLE_SUPER_ADMIN' => 0]
        ];

        yield [
            $this->generateUser(['ROLE_USER']),
            $this->generateUser(['ROLE_ADMIN']),
            ['ROLE_ADMIN' => 0, 'ROLE_SUPER_ADMIN' => 0]
        ];

        yield [
            $this->generateUser(['ROLE_ADMIN']),
            $this->generateUser(['ROLE_USER']),
            ['ROLE_ADMIN' => 1, 'ROLE_SUPER_ADMIN' => 0]
        ];

        yield [
            $this->generateUser(['ROLE_ADMIN']),
            $this->generateUser(['ROLE_SUPER_ADMIN']),
            ['ROLE_ADMIN' => 1, 'ROLE_SUPER_ADMIN' => 0]
        ];

        yield [
            $this->generateUser(['ROLE_SUPER_ADMIN']),
            $this->generateUser(['ROLE_SUPER_ADMIN']),
            ['ROLE_ADMIN' => 1, 'ROLE_SUPER_ADMIN' => 1]
        ];

        yield [
            $this->generateUser(['ROLE_SUPER_ADMIN']),
            $this->generateUser(['ROLE_USER']),
            ['ROLE_ADMIN' => 1, 'ROLE_SUPER_ADMIN' => 1]
        ];
    }

    /**
     * Generate user
     *
     * @param array $roles
     *
     * @return User
     */
    private function generateUser($roles = [])
    {
        return new User('test' . uniqid(), '', $roles);
    }
}
