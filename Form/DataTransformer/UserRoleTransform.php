<?php

namespace Coosos\UserRoleTypeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This class will only be useful for transforming checked checkboxes into array for the role attribute
 * @author Lescallier Rémy <lescallier1@gmail.com>
 */
class UserRoleTransform implements DataTransformerInterface
{
    /**
     * @var FormBuilderInterface
     */
    private $builder;

    /**
     * UserRoleTransform constructor.
     * @param FormBuilderInterface $builder
     */
    public function __construct(FormBuilderInterface $builder)
    {
        $this->builder = $builder;

    }

    /**
     * {@inheritdoc}
     */
    public function transform($array)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($array)
    {
        $returnArray = [];

        foreach ($array as $role => $isChecked) {
            if ($isChecked) {
                $returnArray[] = $role;
            }
        }

        return $returnArray;
    }
}
