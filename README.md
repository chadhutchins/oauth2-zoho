# Zoho Online Provider for OAuth 2.0 Client

[![Latest Stable Version](https://poser.pugx.org/chadhutchins/oauth2-zoho/v/stable)](https://packagist.org/packages/chadhutchins/oauth2-zoho)
[![Total Downloads](https://poser.pugx.org/chadhutchins/oauth2-zoho/downloads)](https://packagist.org/packages/chadhutchins/oauth2-zoho)
[![License](https://poser.pugx.org/chadhutchins/oauth2-zoho/license)](https://packagist.org/packages/chadhutchins/oauth2-zoho)
[![Build Status](https://travis-ci.org/multidimension-al/oauth2-zoho.svg?branch=master)](https://travis-ci.org/multidimension-al/oauth2-zoho)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/multidimension-al/oauth2-zoho/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/multidimension-al/oauth2-zoho/?branch=master)


This package provides Zoho OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require chadhutchins/oauth2-zoho
```

### Usage

Usage is the same as The League's OAuth client, using `\Chadhutchins\OAuth2\Client\Provider\Zoho` as the provider.

### Authorization Code Flow

```php
$provider = new Chadhutchins\OAuth2\Client\Provider\Zoho([
    'clientId'          => '{zoho-app-id}',
    'clientSecret'      => '{zoho-app-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {
    $options = [
        'scope' => ['com.intuit.zoho.accounting'] // array or string
    ];

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl($options);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

### Managing Scopes

When creating your Zoho authorization URL, you can specify the state and scopes your application may authorize.

```php
$options = [
    'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
    'scope' => ['read_orders','write_orders'] // array or string
];

$authorizationUrl = $provider->getAuthorizationUrl($options);
```
If neither are defined, the provider will utilize internal defaults.

At the time of authoring this documentation, the [following scopes are available](https://www.zoho.com/crm/developer/docs/api/oauth-overview.html).

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/chadhutchins/oauth2-zoho/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Nile Suan](https://github.com/nilesuan)
- [All Contributors](https://github.com/chadhutchins/oauth2-zoho/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/chadhutchins/oauth2-zoho/blob/master/LICENSE) for more information.
