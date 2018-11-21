Many thanks to [Ahmet Bora](https://github.com/afbora "Ahmet Bora"). This repository based on his [ResellerClub PHP SDK](https://github.com/afbora/resellerclub-php-sdk "ResellerClub PHP SDK") repository.
# Installation
`composer.json`:
```
"repositories": [
      {
          "type": "vcs",
          "url":  "https://github.com/amirkhiz/resellerclub-php-api.git"
      }
  ],
  "require": {
    "habil/resellerclub-php-api": "dev-master"
  }
  ```

# Usage
Note: All functions return raw response from ResellerClubs's API. (This will change in the future)
```
// string $userId
// string $apiKey
// boolean $testMode Default is false.
// float $timeout Timeout of the request in seconds. Default is 0 (wait indefinitely)
// string $bindIp Source IP address for Guzzle connections (CURLOPT_INTERFACE and socket context option bindto). Default is '0' which means let the system choose the IP.
$resellerClub = new \habil\ResellerClub\ResellerClub('<userId>', '<apiKey>', true, 60.0, '127.0.0.1');

// Get Available TLDs
$resellerClub->domains()->getTLDs();

// Check Domain Availability
$resellerClub->domains()->available(['google', 'example'], ['com', 'net']); // This will check google.com, google.net, example.com and example.net
```

Currently all of the domains, contacts and customers API are available.

# Todos
- Make ResellerClub::class to get `ClientInterface` from constructor instead of create it in constructor
- Create .env file for API endpoints
