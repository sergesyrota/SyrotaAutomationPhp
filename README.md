# SyrotaAutomationPhp
PHP library to communicate using SyrotaAutomation protocol with Gearman

# Prerequisites

 - Gearman worker for serial communication (See https://github.com/sergesyrota/serial-communication-gearman-worker)
 
# Usage

Add dependency using composer:

```
"repositories" : [
    {
        "type": "vcs",
        "url": "https://github.com/sergesyrota/SyrotaAutomationPhp.git"
    }
],
"require": {
    "sergesyrota/syrota-automation": "dev-master"
}
```

Example of usage:

```
require __DIR__ . "/vendor/autoload.php";
use \SyrotaAutomation\Gearman;
// Gearman task ID that is configured with the worker
$gm = new Gearman('rs485');
$gm->command('device', 'command');
```

