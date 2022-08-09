<?php


namespace App\Storage;

use App\Entity\OrderSession;
use App\Repository\OrderSessionRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSessionStorage
{
    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The cart repository.
     *
     * @var OrderSessionRepository
     */
    private $cartRepository;

    /**
     * @var string
     */
    public const CART_KEY_NAME = 'cart_id';

    /**
     * CartSessionStorage constructor.
     */
    public function __construct(RequestStack $requestStack, OrderSessionRepository $cartRepository)
    {
        $this->requestStack = $requestStack;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Gets the cart in session.
     */
    public function getCart(): ?OrderSession
    {
        return $this->cartRepository->findOneBy([
            'id' => $this->getCartId(),
            'status' => OrderSession::STATUS_CART,
        ]);
    }

    /**
     * Sets the cart in session.
     */
    public function setCart(OrderSession $cart): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $cart->getId());
    }

    /**
     * Returns the cart id.
     */
    private function getCartId(): ?int
    {
        return $this->getSession()->get(self::CART_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}