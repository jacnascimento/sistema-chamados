<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Encryption Keys
    |--------------------------------------------------------------------------
    |
    | Passport uses encryption keys while generating secure access tokens for
    | your application. By default, the keys are stored as local files but
    | can be set via environment variables when that is more convenient.
    |
    */

    'private_key' => env('PASSPORT_PRIVATE_KEY'),

    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Personal Access Client
    |--------------------------------------------------------------------------
    |
    | If you enable client hashing, you should set the personal access client
    | ID here. This client ID will be used to issue personal access tokens
    | to your users.
    |
    */

    'personal_access_client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),

    'personal_access_client_secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Personal Access Client
    |--------------------------------------------------------------------------
    |
    | "Personal access" clients are OAuth 2.0 clients that may be used to
    | generate access tokens for your users. These are typically used for
    | mobile applications or web applications that need to make API calls
    | on behalf of a user.
    |
    */

    'personal_access_client' => [
        'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
        'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Grant Client
    |--------------------------------------------------------------------------
    |
    | The password grant client is used to exchange a user's username and
    | password for an access token. This is primarily useful for creating
    | a "first party" mobile application or web application.
    |
    */

    'password_grant_client' => [
        'id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
        'secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Client UUIDs
    |--------------------------------------------------------------------------
    |
    | Since this package is a fork of the official Laravel Passport package,
    | we maintain this configuration option in order to support package
    | discovery of the official package.
    |
    */

    'client_uuids' => false,

    /*
    |--------------------------------------------------------------------------
    | Storage Driver
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to customize the storage options
    | for Passport, such as database table names. Feel free to adjust
    | these options as needed.
    |
    */

    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Lifetimes
    |--------------------------------------------------------------------------
    |
    | Here you may define the number of seconds a token may be used before
    | they expire. This option overrides the default configuration in
    | the "config/auth.php" file.
    |
    */

    'tokens' => [
        'access_token' => [
            'lifetime' => env('PASSPORT_ACCESS_TOKEN_LIFETIME', 60 * 24), // 24 hours
        ],
        'refresh_token' => [
            'lifetime' => env('PASSPORT_REFRESH_TOKEN_LIFETIME', 60 * 24 * 30), // 30 days
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    | Passport allows you to define scopes for your API. Scopes are used
    | to grant limited access to your users' accounts. You can define
    | as many scopes as you need. Here are some common examples:
    |
    */

    'scopes' => [
        'read' => 'Read user data',
        'write' => 'Write user data',
        'delete' => 'Delete user data',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Scopes
    |--------------------------------------------------------------------------
    |
    | Passport allows you to define default scopes for your API. These
    | scopes will be applied to all tokens by default.
    |
    */

    'default_scopes' => [
        'read',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Client Hashing
    |--------------------------------------------------------------------------
    |
    | By default, Passport hashes client secrets before storing them in
    | your database. This is more secure and prevents client secrets
    | from being exposed if your database is compromised.
    |
    */

    'hash_client_secrets' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Password Grant
    |--------------------------------------------------------------------------
    |
    | The password grant allows your application to issue access tokens
    | to users in exchange for their username and password. This is
    | primarily useful for creating a "first party" mobile application
    | or web application.
    |
    */

    'enable_password_grant' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Client Credentials Grant
    |--------------------------------------------------------------------------
    |
    | The client credentials grant allows your application to issue access
    | tokens to clients in exchange for their client ID and secret. This
    | is primarily useful for machine-to-machine authentication.
    |
    */

    'enable_client_credentials_grant' => false,

    /*
    |--------------------------------------------------------------------------
    | Enable Authorization Code Grant
    |--------------------------------------------------------------------------
    |
    | The authorization code grant allows your application to issue access
    | tokens to users in exchange for an authorization code. This is
    | primarily useful for third-party applications.
    |
    */

    'enable_auth_code_grant' => false,

    /*
    |--------------------------------------------------------------------------
    | Enable Implicit Grant
    |--------------------------------------------------------------------------
    |
    | The implicit grant allows your application to issue access tokens
    | to users without exchanging an authorization code. This is
    | primarily useful for JavaScript applications.
    |
    */

    'enable_implicit_grant' => false,

    /*
    |--------------------------------------------------------------------------
    | Enable Refresh Token Grant
    |--------------------------------------------------------------------------
    |
    | The refresh token grant allows your application to issue new access
    | tokens to users in exchange for a refresh token. This is primarily
    | useful for mobile applications.
    |
    */

    'enable_refresh_token_grant' => true,

];
