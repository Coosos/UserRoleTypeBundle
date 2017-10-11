# Coosos/UserRoleTypeBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f839d923-ae63-4cdf-b452-920415c5f731/mini.png)](https://insight.sensiolabs.com/projects/f839d923-ae63-4cdf-b452-920415c5f731)

## Requirements

* Symfony 3.0 and greater
* PHP 5.5.9 and greater

## Installation

### Step 1 : Download the bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle :

    $ composer require coosos/user-role-type-bundle
    
This command is used if composer is installed in your system.

### Step 2: Enable the Bundle

Then, enable the bundle by adding the following line in the ``app/AppKernel.php``
file of your project :

    // app/AppKernel.php
    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new Coosos\UserRoleTypeBundle\CoososUserRoleTypeBundle(),
            );
            // ...
        }
        // ...
    }
    
## Usage

### Form type

    use Coosos\UserRoleTypeBundle\Form\Type;
    ...
    $builder->add("roles", UserRoleType::class);

### Form twig

_example_

    {{ form_start(userForm) }}
    {{ form_row(userForm.roles.ROLE_ADMIN) }}
    {{ form_end(userForm) }}
