# Coosos/UserRoleTypeBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f839d923-ae63-4cdf-b452-920415c5f731/mini.png)](https://insight.sensiolabs.com/projects/f839d923-ae63-4cdf-b452-920415c5f731)

## Requirements

| Package       | Version          |
| ------------- | ---------------- |
| PHP           | ^7.1, ^7.2       |
| Symfony       | ^3.4, ^4.0, ~5.0 |

## Installation

### Step 1 : Download the bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle :

```sh
composer require "coosos/user-role-type-bundle" "^2.0"
```
    
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
    $builder->add("roles", UserRoleType::class, ["coosos_security_checked" => "strict"]);

### Form twig

_example_

    {{ form_start(userForm) }}
    {{ form_row(userForm.roles.ROLE_ADMIN) }}
    {{ form_end(userForm) }}

## Option

* **coosos_security_checked (default="strict")**
  * strict = Prevents from being able to attribute a higher grade than his own
* **coosos_input_type (default="Symfony\Component\Form\Extension\Core\Type\CheckboxType")**
  * Allows you to select another type of input (interesting for customize)  
