<?php
/*
 * This file is part of the Laravel Sharenet package.
 * (c) Chiemela Chinedum <chiemelachinedum@gmail.com>
 */
namespace Melas\Sharenet\Exceptions;

class NotificationFailedException extends \Exception
{
    /**
     * @return static
     */
    public static function invalidReceiver()
    {
        return new static(
            'The notifiable does not have a receiving phone number.'
        );
    }

    /**
     * @return static
     */
    public static function emptyMessageBody()
    {
        return new static(
            'The body of your message is empty or not defined.'
        );
    }
}