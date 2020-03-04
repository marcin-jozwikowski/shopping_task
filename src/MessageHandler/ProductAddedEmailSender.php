<?php


namespace App\MessageHandler;


use App\Message\ProductAddedMessage;
use Swift_Mailer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProductAddedEmailSender implements MessageHandlerInterface
{
    /** @var Swift_Mailer */
    private $mailer;
    /** @var string */
    private $sender;
    /** @var mixed */
    private $recipient;

    public function __construct(Swift_Mailer $mailer, ParameterBagInterface $params)
    {
        $this->mailer    = $mailer;
        $this->sender    = $params->get('product_notifications.email.sender');
        $this->recipient = $params->get('product_notifications.email.recipient');
    }

    public function __invoke(ProductAddedMessage $productAddedMessage)
    {
        if (!empty($this->sender) && !empty($this->recipient)) {
            $email = (new \Swift_Message('Product Added'))
                ->setTo($this->recipient)
                ->setFrom($this->sender)
                ->addPart(
                    sprintf(
                        "Product '%s' added by '%s'",
                        $productAddedMessage->getProduct()->getName(),
                        $productAddedMessage->getUser()->getUsername()
                    ),
                    'text/plain'
                );

            $this->mailer->send($email);
        }
    }
}