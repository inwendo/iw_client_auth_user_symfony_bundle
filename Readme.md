Inwendo Auth Login Bundle
========================

Installation
------------

### Step 1: Download the Bundle

Edit the composer.json and add the following information:

````json
    //...

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/inwendo/iw_client_auth_user_symfony_bundle"
        }
    ],
    //...
    "require": {
        "inwendo/iw_client_auth_user_symfony_bundle": "dev-master"
    }
    //...
````

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer update
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Inwendo\Auth\LoginBundle\InwendoAuthLoginBundle(),
        );

        // ...
    }

    // ...
}
```

### Step 3: Add the config to the config.yml file:

```yaml
inwendo_auth_login:
    userrepository: "AppBundle:User"
```

### Step 5: Usage:

### TODO