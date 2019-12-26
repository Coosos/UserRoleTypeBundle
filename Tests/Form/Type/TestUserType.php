<?php

namespace Coosos\UserRoleTypeBundle\Tests\Form\Type;

use Coosos\UserRoleTypeBundle\Form\Type\UserRoleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TestUserType
 *
 * @package Coosos\UserRoleTypeBundle\Tests\Form\Type
 * @author  Remy Lescallier <lescallier1@gmail.com>
 */
class TestUserType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('roles', UserRoleType::class);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInterface::class,
        ]);
    }
}
