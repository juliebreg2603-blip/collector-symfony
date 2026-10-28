<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add(int $id, CartService $cartService): Response
    {
        $cartService->add($id);
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/decrement/{id}', name: 'app_cart_decrement')]
    public function decrement(int $id, CartService $cartService): Response
    {
        $cartService->remove($id);
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/delete/{id}', name: 'app_cart_delete')]
    public function delete(int $id, CartService $cartService): Response
    {
        $cartService->delete($id); 
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/clear', name: 'app_cart_clear')]
    public function clear(CartService $cartService): Response
    {
        $cartService->clear();
        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/checkout', name: 'app_cart_checkout')]
    public function checkout(CartService $cartService): Response
    {
        $items = $cartService->getFullCart();
        if (empty($items)) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_product_index');
        }
        return $this->render('cart/checkout.html.twig', [
            'items' => $items,
            'total' => $cartService->getTotal()
        ]);
    }

    #[Route('/confirm', name: 'app_cart_confirm')]
    public function confirm(CartService $cartService, EntityManagerInterface $em): Response
    {
        $items = $cartService->getFullCart();
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('danger', 'Veuillez vous connecter pour commander.');
            return $this->redirectToRoute('app_login');
        }

        if (empty($items)) {
            return $this->redirectToRoute('app_product_index');
        }

        $order = new Order();
        $order->setUser($user);
        $order->setTotal($cartService->getTotal());
        $order->setCreatedAt(new \DateTimeImmutable());

        foreach ($items as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if ($product->getStock() < $quantity) {
                $this->addFlash('danger', 'Stock insuffisant pour ' . $product->getTitle());
                return $this->redirectToRoute('app_cart_index');
            }

            $orderLine = new OrderLine();
            $orderLine->setMyOrder($order);
            $orderLine->setProduct($product);
            $orderLine->setQuantity($quantity);
            $orderLine->setPrice($product->getPrice());
            $em->persist($orderLine);

            $product->setStock($product->getStock() - $quantity);
        }

        $em->persist($order);
        $em->flush();

        $cartService->clear();
        $this->addFlash('success', 'Commande validée ! Le stock a été mis à jour.');
        return $this->redirectToRoute('app_product_index');
    }
}
