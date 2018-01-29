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

If your project is using Laravel 5.5 upwards, you can skip the next two instructions in this section and jump straight to *Configuration*.

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
SHARENET_SENDER_NAME='Melas'
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


You can also use Sharenet as a custom driver for your Laravel Notifications like so:
```PHP
    // App/Notifications/TestNotification

    use Melas\Sharenet\Channels\SharenetChannel;

    ...

    public function via($notifiable)
    {
        return [SharenetChannel::class];
    }

    public function toSharenet($notifiable)
    {
        return 'Test message';
    } 

    // App/Controllers/TestController
    use App\Notifications\TestNotification

    ...

    public function testMethod()
    {
        $user = User::first();
        $user->notify(new TestNotification());
    }
    
```

This package expects your `$notifiable` entity to have a `phone` property. You can specify an alternative property by overriding the `routeNotificationForSharenet` method of your notifiable entity.

```PHP
    protected function routeNotificationForSharenet()
    {
        return $this->alternate_field;
    }
```

By default, your notification will use the `SHARENET_SENDER_NAME` value defined in the config file as the sender name. If you wish to override this, you can return an array in the notifications `toSharenet` method like so:

```PHP
    public function toSharenet($notifiable)
    {
        return [
            'message' => 'Test message',
            'sender' => 'Override'
        ];
    }
```
## Contributing

This package is open for contributions. Feel free to fork it and make enhancements.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Wanna talk?

You can always shoot me an email @ *chiemelachinedum@gmail.com*

Love  the package? Leave a star.

Don't forget to [follow me on twitter](https://twitter.com/ccmelas)!