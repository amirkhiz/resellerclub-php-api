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
$resellerClub = new \habil\ResellerClub\ResellerClub('<userId>', '<apiKey>', true, 60.0); // Last arguments are for testMode and timeout of the request in seconds.

// Get Available TLDs
$resellerClub->domains()->getTLDs();

// Check Domain Availability
$resellerClub->domains()->available(['google', 'example'], ['com', 'net']); // This will check google.com, google.net, example.com and example.net
```

Currently all of the domains, contacts and customers API are available.

# Todos
- Make ResellerClub::class to get `ClientInterface` from constructor instead of create it in constructor
- Create .env file for API endpoints
