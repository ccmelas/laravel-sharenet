<?php
/*
 * This file is part of the Laravel Sharenet package.
 * (c) Chiemela Chinedum <chiemelachinedum@gmail.com>
 */

namespace Melas\Sharenet\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Melas\Sharenet\Exceptions\NotificationFailedException;
use Melas\Sharenet\Sharenet;

class SharenetChannel
{
    /**
     * @var Dispatcher $events
     */
    protected $events;

    /**
     * @var Sharenet $sharenet;
     */
    protected $sharenet;

    public function __construct(Sharenet $sharenet, Dispatcher $events)
    {
        $this->sharenet = $sharenet;
        $this->events = $events;
    }
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return mixed
     * @throws NotificationFailedException
     * @throws NotificationFailed
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $payload = $notification->toSharenet($notifiable);
            $sender = config('sharenet.sender_name');
            
            if(is_array($payload)) {
                if(isset($payload['sender']) && $payload['sender'] !== '') {
                    $sender = $payload['sender'];
                }
                $message= $this->getMessage($payload);    
            } else {
                $message = $payload;
            }

            $data = [
                'to' => $this->getReceiver($notifiable),
                'from' => $sender,
                'message' => $message,
            ];
            return $this->sharenet->send($data);
        } catch (Exception $exception) {
            $this->events->fire(
                new NotificationFailed($notifiable, $notification, 'sharenet', ['message' => $exception->getMessage()])
            );
        }
    }

    /**
     * Get the phone number to send the notification to.
     *
     * @param mixed $notifiable
     * @return mixed
     * @throws NotificationFailedException
     */
    protected function getReceiver($notifiable)
    {
        if ($notifiable->routeNotificationFor('sharenet')) {
            return $notifiable->routeNotificationFor('sharenet');
        }
        if (isset($notifiable->phone)) {
            return $notifiable->phone;
        }
        throw NotificationFailedException::invalidReceiver();
    }

    /**
     * Get the notification message.
     *
     * @param $payload
     * @return mixed
     * @throws NotificationFailedException
     */
    protected function getMessage(array $payload)
    {
        if (isset($payload['message']) && $message = $payload['message']) {
            return $message;
        }

        throw NotificationFailedException::emptyMessageBody();
    }
}