<?php


namespace App\MessageHandler;


use App\Message\ProductAddedMessage;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProductAddedHangoutsNotifier implements MessageHandlerInterface
{
    /** @var mixed */
    private $webhook;
    /** @var Client */
    private $client;

    public function __construct(ParameterBagInterface $params)
    {
        $this->webhook = $params->get('product_notifications.hangouts.webhook');
        $this->client  = new Client();
    }

    public function __invoke(ProductAddedMessage $productAddedMessage)
    {
        $message = sprintf(
            "User '%s' added product: '%s'",
            $productAddedMessage->getUser()->getUsername(),
            $productAddedMessage->getProduct()->getName()
        );

        $this->client->post($this->webhook, [
            'headers' => ['Content-Type' => 'application/json; charset=UTF-8'],
            'body'    => json_encode(['text'=>$message])
        ]);
    }
}