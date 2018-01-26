# laravel-sharenet

A Laravel Package for sending SMS using Sharenet (Nigeria only)

## Installation

In the composer.json folder in the root of your laravel installation, add the following in the require block
```
    "ccmelas/laravel-sharenet": "dev-master"
```

Then run:

```
composer update
```

In the providers array of `config/app.php`, add the following line:
```
Melas\Sharenet\SharenetServiceProvider::class
```

In the aliases array of the same file, add the following:
```
'Sharenet' => Melas\Sharenet\Facades\Sharenet::class
```

## Configuration

Add your Sharenet key to your .env file like so:
```
SHARENET_SECRET='XXXXX'
```

To get a Sharenet Key, visit [app.sharenet.io]('http://app.sharenet.io'), login or create an account if you don't have one already. On the top-right, click on your avatar and then your profile. In the developer tab, create a new `Personal Access Token`. A modal will come up with your Secret Key.

You wouldn't need to but if you wish to publish the sharenet.php config file, run the following
```
php artisan vendor:publish --provider="Melas\Sharenet\SharenetServiceProvider" --tag="config"
```

## Usage

Here's a simple snippet showing how you can use this package

```PHP
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sharenet;

class TestController extends Controller
{
    public function index()
    {
        $data = [
            'to' => '08034503911',
            'from' => 'Melas',
            'message' => 'This is a test message'
        ];
        Sharenet::send($data);
    }
}
```

You can chain a `getResponse()` method to get a response in the form
```PHP
    Sharenet::send($data)->getResponse();

    //sample response    
    {
        "status": "success"
        "message": "Message Sent Successfully"
    }
```

You can directly check if your message was sent successfully like so: 
`Sharenet::send($data)->isSuccessful()`

## Contributing

This package is open for contributions. Feel free to fork it and make enhancements.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Wanna talk?

You can always shoot me an email @ *chiemelachinedum@gmail.com*

Love  the package? Leave a star.

Don't forget to [follow me on twitter](https://twitter.com/ccmelas)!