# PHPMentorsWorkflowerBundle

A Symfony bundle for [Workflower](https://github.com/phpmentors-jp/workflower)

[![Total Downloads](https://poser.pugx.org/phpmentors/workflower-bundle/downloads)](https://packagist.org/packages/phpmentors/workflower-bundle)
[![Latest Stable Version](https://poser.pugx.org/phpmentors/workflower-bundle/v/stable)](https://packagist.org/packages/phpmentors/workflower-bundle)
[![Latest Unstable Version](https://poser.pugx.org/phpmentors/workflower-bundle/v/unstable)](https://packagist.org/packages/phpmentors/workflower-bundle)

## Features

* Integration with the service container by the `phpmentors_workflower.process_aware` tag
* Integration with the security system for Workflower's participants
* Transparent serialization/deserialization support for entities with Doctrine ORM
* Multiple workflow contexts (BPMN2 definition directories) with configuration

## Installation

`PHPMentorsWorkflowerBundle` can be installed using [Composer](http://getcomposer.org/).

First, add the dependency to `phpmentors/workflower-bundle` into your `composer.json` file as the following:

**Stable version:**

```
composer require phpmentors/workflower-bundle "1.0.*"
```

**Development version:**

```
composer require phpmentors/workflower-bundle "~1.1@dev"
```

Second, add `PHPMentorsWorkflowerBundle` into your bundles to register in `AppKernel::registerBundles()` as the following:

```php
...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new PHPMentors\WorkflowerBundle\PHPMentorsWorkflowerBundle(),
        );
        ...
```

## Support

If you find a bug or have a question, or want to request a feature, create an issue or pull request for it on [Issues](https://github.com/phpmentors-jp/workflower-bundle/issues).

## Copyright

Copyright (c) 2015 KUBO Atsuhiro, All rights reserved.

## License

[The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause)
