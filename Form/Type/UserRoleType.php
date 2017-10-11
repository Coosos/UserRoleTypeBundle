<?php

namespace Coosos\UserRoleTypeBundle\Form\Type;

use Coosos\UserRoleTypeBundle\Form\DataTransformer\UserRoleTransform;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Role form
 * @author Lescallier Rémy <lescallier1@gmail.com>
 */
class UserRoleType extends AbstractType
{
    /**
     * @var array
     */
    private $roleHierarchy;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * UserRoleType constructor.
     * @param array                         $roleHierarchy
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(array $roleHierarchy = [], AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->roleHierarchy = $roleHierarchy;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();
            $user = $event->getForm()->getParent()->getData();
            $permissionData = $event->getData();

            foreach ($this->roleHierarchy as $key => $value) {
                $options = ["required" => false];

                if ($form->getConfig()->getOptions()["coosos_security_checked"] == "strict"
                    && !$this->authorizationChecker->isGranted($key, $user)) {
                    $options["disabled"] = true;
                }

                if (in_array($key, $permissionData)) {
                    $options["attr"]["checked"] = true;
                }

                $form->add($key, CheckboxType::class, $options);
            }
        });

        $builder->addModelTransformer(new UserRoleTransform($builder));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("coosos_security_checked", "strict");
    }
}
