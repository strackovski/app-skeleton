AppSkeleton
============

### This is a web application skeleton based on CodeIgniter, Doctrine ORM, Twig and Assetic.

I use it for several of my web projects. It is supposed to ease the pain when starting a project
using a custom framework.

CodeIgniter is used because of it's micro footprint. However, lately Silex has caught my interest,
and I've been working to adapt this skeleton to Silex as well.

[I'm an inline-style link with title](https://www.google.com "Google's Homepage")

Features
--------
- What is integrated?
- What is changed in CI?
- What about folder structure?
- FW independency: depends on how you implement controllers
- Silex instead of CI (different controllers, different integration!), todo
- App setup - enables configuration after composer install/update
- Scripts - bash scripts for skeleton project instantiation

Usage
----
##### Install with composer
```php
$s = "PHP syntax highlighting";
alert(s);
```

##### Install with git clone

##### Implement application controllers in src/Controllers
When using CodeIgniter just implement the controllers like the default AppController, or ApiController
for REST API.
```php
But let's throw in a <b>tag</b>.
```

For Silex, controllers as services are the recommended way:
```php
But let's throw in a <b>tag</b>.
```

##### Model entities and repositories in src/Model
Use the power of Doctrine annotations, currently only docblock annotation are supported.

##### Manage assets with Assetic
Put asset files in the appropriate Assets/ folder and use Assetic to build minified static files.

Requirements & Dependencies
------------------------
- PHP 5.3.3
- Doctrine ORM
- Twig and Twig Extensions
- Assetic asset management (with JSMin and CSSMin filters by default)
- Twitter Bootstrap 3
- jQuery

License
--------
This project is released under the MIT license. For more information, please see the
[license agreement](http://github.com/strackovski/app-skeleton/license.md "License").