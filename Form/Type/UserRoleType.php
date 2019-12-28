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
 *
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
     *
     * @param array                         $roleHierarchy
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(array $roleHierarchy, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->roleHierarchy = $roleHierarchy;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $formOptions = $form->getConfig()->getOptions();
            $user = $event->getForm()->getParent()->getData();
            $permissionData = $event->getData();

            foreach ($this->roleHierarchy as $key => $value) {
                $options = ['required' => false];

                if ($formOptions['coosos_security_checked'] === 'strict'
                    && !$this->authorizationChecker->isGranted($key, $user)) {
                    $options['disabled'] = true;
                }

                if (in_array($key, $permissionData)) {
                    $options['attr']['checked'] = true;
                }

                $form->add($key, $formOptions['coosos_input_type'], $options);
            }
        });

        $builder->addModelTransformer(new UserRoleTransform());
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'coosos_security_checked' => 'strict',
            'coosos_input_type' => CheckboxType::class,
        ]);
    }
}
