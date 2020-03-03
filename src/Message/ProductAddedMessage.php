<?php


namespace App\Message;


use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductAddedMessage
{
    /** @var User */
    private $user;

    /** @var Product */
    private $product;

    public function __construct(UserInterface $user, Product $product)
    {
        $this->user    = $user;
        $this->product = $product;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
}