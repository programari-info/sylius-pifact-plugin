# SyliusPifactPlugin
Use pifact.com to create legal invoices with Verifactu for Spain Sylius e-Commerce.

This plugin for Sylius ads functionality by using apiservices of pifact.com to create legal invoices with VeriFactu and Electronic Invoices for Spain companies.

Get more info about what PiFact can do for you at https://www.pifact.com

You need an account at pifact.com to use this plugin. There is a free level you can use to test.

# SyliusPifactPlugin
Utiliza pifact.com para crear facturas legales con Verifactu para comercios en España que usen Sylius.

Este plugin para Sylius añade funcionalidades mediante los servicios API de pifact.com para crear facturas legales con VeriFactu y facturas electrónicas para empresas españolas.

Obtén más información sobre lo que PiFact puede hacer por ti en https://www.pifact.com

Necesitas una cuenta en pifact.com para usar este plugin. Hay una versión gratuita que puedes usar para probarlo.

# Installation

You need a running Sylius 2.+ installation.
You can install Sylius 2.x with the [Sylius](https://github.com/Sylius/Sylius) project.

This project requires Sylius Invoicing plugin, it will be installed automatically when you install this plugin.

You may need to add the following to your composer.json file:

```composer
"repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/programari-info/sylius-pifact-plugin.git"
    }
  ],
```

Use composer to install the plugin after Sylius is installed:

```bash
$ composer require programari-info/sylius-pifact-plugin
```

If you found this error then you need to add repository to your composer.json file:
```
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Root composer.json requires programari-info/sylius-pifact-plugin, it could not be found in any version, there may be a typo in the package name.

```


# Configuration
## Add configuration
Create a file called `config/packages/programari_sylius_pifact.yaml` and add the following configuration:
```
imports:
    - { resource: "@ProgramariSyliusPifactPlugin/config/config.yaml" }

```
## Add routes
Create a file called `config/routes/programari_sylius_pifact.yaml` and add the following configuration:
```
programari_sylius_pifact:
    resource: "@ProgramariSyliusPifactPlugin/config/routes.yaml"

```

## Extend entities
This plugin adds some fields to Channel (API Bearer) and Address (TaxId) entities.

Add PifactAddressTrait to: src/Entity/Addressing/Address.php
```php

declare(strict_types=1);

namespace App\Entity\Addressing;

use Doctrine\ORM\Mapping as ORM;
use Programari\SyliusPifactPlugin\Entity\PifactAddressTrait;
use Sylius\Component\Core\Model\Address as BaseAddress;
#[ORM\Entity]
#[ORM\Table(name: 'sylius_address')]
class Address extends BaseAddress
{
  use PifactAddressTrait;
}

```


Add PifactChannelTrait to: src/Entity/Channel/Channel.php
```php

declare(strict_types=1);

namespace App\Entity\Channel;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Programari\SyliusPifactPlugin\Entity\PifactChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel')]
class Channel extends BaseChannel
{
    use PifactChannelTrait;
}

```

# Database migrations
After configuration, run the following command at project root to create the database tables:

```bash
$ bin/console doctrine:migrations:migrate
```
