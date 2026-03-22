<?php

namespace Programari\SyliusPifactPlugin\Controller;



use Programari\SyliusPifactPlugin\Entity\PiFactResponse;

use Programari\SyliusPifactPlugin\Services\Api;
use Sylius\Bundle\ChannelBundle\Doctrine\ORM\ChannelRepository;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\InvoicingPlugin\Entity\Invoice;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Sylius\InvoicingPlugin\Exception\InvoiceAlreadyGenerated;
use Sylius\InvoicingPlugin\Generator\InvoiceGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PifactApiController
{

    #[Route(methods: ['GET'], path: '/admin/pifact-test-api/{channel_code}', name: 'pifact_test_api', format: 'json')]
    public function testApi(ChannelRepositoryInterface $channelRepository
                            , OrderRepositoryInterface $orderRepository
                            , InvoiceGeneratorInterface $invoiceGenerator
                            , Api $api
                            , string $channel_code='') {
        $channel = $channelRepository->findOneBy(['code' => $channel_code]);
        if (!$channel) {
            $result = new PiFactResponse();
            $result->setStatus('KO');
            $result->setMessage('No channel found for code: ' . htmlspecialchars($channel_code) . '. Please create one.');
            return new JsonResponse($result);
        }
        /** @var OrderInterface $order */
        $order = $orderRepository->findOneBy(['channel' => $channel, 'state' => 'new'], ['id' => 'DESC']);
        if (!$order) {
            $result = new PiFactResponse();
            $result->setStatus('KO');
            $result->setMessage('No orders found. Please create one.');
            return new JsonResponse($result);
        }

        /** @var Invoice $invoice */
        $invoice = $invoiceGenerator->generateForOrder($order, new \DateTime());
        // Add fields required by the API to send email to customer and do the invoice.
        $pifactInvoice = $api->getPifactInvoice($invoice, $order);
        $pifactInvoice->setApiTest(true); // Don't save
        // Cridar a l'API per a crear la factura amb el json de $invoice
        // Call API to create invoice with json of $invoice
        $result = $api->sendInvoice($pifactInvoice);
        if ($result->getStatus() === 'OK') {
            $result->setMessage('OK');
        }
        $result->setNumber($order->getNumber());
        return new JsonResponse($result);
    }


}
