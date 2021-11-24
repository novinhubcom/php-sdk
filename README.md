# Novinhub
Novinhub php sdk

## Requirements

PHP 5.6 and later

## Installation and Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), run following command:

```
composer require novinhubcom/php-sdk
```

## Getting Started

After Installation The API can be used as easy as the following

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

try{
    //Initialize Novinhub Client Instance...
    $api = new Novinhub\Client('your_token_here');
    
    /*
     * Instance Usage:
     * $api->Method('Path', Parameters(IF EXISTS));
     */
    //Example1: Get all accounts assigned to your token
    $accounts = $api->get('account');
    
    /*
     * Example2: Create Caption...
     * 
     * If Successful, The $response will contain an Array including 
     * the new caption Id, Title, Caption and Date of creation.
     * If not, there is an error message in $response.
     */
    $response = $api->post('caption', ['title'=> 'Caption Title', 'caption'=> 'Caption Text']);
    
    //Example 3: Update an existing Caption you created...
    $response = $api->put('caption/your_caption_id', ['title'=> 'Caption New Title', 'caption'=> 'caption New Text']);
    
    /*
     * Example 4: Create file...
     * In order to create a file you can use 
     * Method getFile('FileAddress') of $api...
     * hint: You can use 'Absolute' or 'Relative' addressing for FileAddress
     * 
     * If Successful, The $response will contain an Array including
     * the new file Id, Title, File size, Date of creation and 
     * the URL that contains The file.
     * If not, there is an error message in $response.
     */
    $response = $api->post('file', ['file'=> $api->getFile('fileAddress')]);
}
catch (Novinhub\ServerException $e){
    echo $e->getMessage() . ' ' . $e->getTraceId();
}
?>
```

## Documentation for API Endpoints

You can find the documentation [on the website](https://novinhub.com/developers).

## Author

support@novinhub.com


