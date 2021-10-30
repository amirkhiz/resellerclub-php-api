# Description
This client is used to interact with one of the following APIs:
 * ResellerClub ([Docs](https://resellerclub.webpropanel.com/kb/answer/751))
 * BadilHost ([Docs](https://my.badilhost.com//kb/answer/751))
 * LogicBoxes ([Docs](https://manage.logicboxes.com/kb/node/751))
 * Whois ([Docs](https://manage.whois.com/kb/node/751))
 * NetForce ([Docs](https://location-independent.myorderbox.com/kb/node/751))
 
Available API requests: 
* Actions
* Contacts
* Customers
* Domains
* Products

## Installation
```console
composer require habil/resellerclub-php-api
```

## Usage Example
```php
use habil\ResellerClub\ResellerClub;

$resellerClub = new ResellerClub('<userId>', '<apiKey>');
$resellerClub->domains()->available(['google', 'example'], ['com', 'net']);
```
Note: All functions return a raw response from API.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

### Disclaimer
Many thanks to [Ahmet Bora](https://github.com/afbora "Ahmet Bora"). This repository based on his [ResellerClub PHP SDK](https://github.com/afbora/resellerclub-php-sdk "ResellerClub PHP SDK") repository.
