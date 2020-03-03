<?php


namespace App\MessageHandler;


use App\Message\ProductAddedMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProductAddedMessageHandler implements MessageHandlerInterface
{
    public function __invoke(ProductAddedMessage $productAddedMessage)
    {
    }
}