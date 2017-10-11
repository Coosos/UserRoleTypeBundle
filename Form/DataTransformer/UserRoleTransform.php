<?php

namespace Coosos\UserRoleTypeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * This class will only be useful for transforming checked checkboxes into array for the role attribute
 * @author Lescallier Rémy <lescallier1@gmail.com>
 */
class UserRoleTransform implements DataTransformerInterface
{
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
