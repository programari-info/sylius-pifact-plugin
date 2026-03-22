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
$ composer config extra.symfony.allow-contrib true
$ composer require programari-info/sylius-pifact-plugin
```



# Configuration

If you allowed symfony/flex to install recipes of the plugin, you may skip the next steps. Check it.

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



# Use
1. Go to your Sylius admin panel and create Payment methods, USE THE SAME CODE AS IN PIFACT Payment Methods.
2. Go to your Sylius admin panel and configure provinces if you need to calculate taxes based on them.
3. Check the Sylius tax configuration. It will be tested on next steps.
4. Go to your PiFact account at https://www.pifact.com, go to Configuration/Company and get your API Bearer code.
5. Go to your Sylius admin panel and edit your channel.
6. Add your API Bearer code in the API Bearer field.
7. Save your changes.
8. Use the button to Test It. It will check for some typical configuration errors. You need to have an order to test it `and solve all errors to be able to receive orders`.

When an order is paid, Sylius Invoicing plugin will create an invoice. 
SyliusPifact plugin will post it to your account at PiFact and send it to the customer.
Is recommended to disable PDF generation in Sylius Invoicing plugin because it is done at PiFact.

Enjoy!
