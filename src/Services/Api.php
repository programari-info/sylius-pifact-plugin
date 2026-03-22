<?php
declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\Services;



use Programari\SyliusPifactPlugin\Entity\PifactInvoice;
use Programari\SyliusPifactPlugin\Entity\PiFactResponse;
use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatter;
use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatterInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Api
{
    const BASE_PROD = 'https://api.pifact.com/api/';
    const BASE_DEV = 'https://www.pierp.test/api/';
    const SEND_TO_VERIFACTU_PROD = 'sylius_invoices';
    const SEND_TO_VERIFACTU_DEV = 'sylius_invoices?XDEBUG_SESSION_START=api';


    public function __construct(
        private HttpClientInterface $client,
        private readonly MoneyFormatterInterface $moneyFormatter,
        private SerializerInterface $serializer,
        #[Autowire('%kernel.environment%')]
        private string $pifactEnv,
    ) {
    }

    /**
     * @return
     *
     * @throws \RuntimeException if the call did not work
     */
    public function sendInvoice(PifactInvoice $invoice): PiFactResponse
    {

        $bearer = $invoice->getInvoice()->channel()->getBearer();



        $payload = $this->serializer->serialize($invoice, 'json', [
            'groups' => ['pifact:write'],
        ]);
        if ('dev' === $this->pifactEnv) {
            $endpoint = self::BASE_DEV . self::SEND_TO_VERIFACTU_DEV;
            $dev = [
                'verify_peer' => false,
                'verify_host' => false,
            ];
        } else {
            $endpoint = self::BASE_PROD . self::SEND_TO_VERIFACTU_PROD;
            $dev = [];
        }
        $array=[];
        try {
            $response = $this->client->request('POST', $endpoint, array_merge([
                    'body' => $payload,
                    'auth_bearer' => $bearer,
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ], $dev)
            );
            //$headers = $response->getHeaders();
            $array = $response->toArray();
        } catch(\Exception $e) {
            $array['status']='KO';
            $array['message']=$e->getMessage();
            $array['number']=$invoice->getOrderNumber();
        }


        $piFactResponse = new PiFactResponse();
        $piFactResponse->fromArray($array);
        return $piFactResponse;
    }

    /**
     * @param InvoiceInterface $invoice
     * @param OrderInterface $order
     * @return PifactInvoice
     */
    public function getPifactInvoice(InvoiceInterface $invoice, OrderInterface $order): PifactInvoice
    {
        $pifactInvoice = new PifactInvoice();
        // Add fields required by the API to send email to customer and do the invoice.
        $pifactInvoice->setInvoice($invoice);
        $pifactInvoice->setApiTest(false); // false = save
        $pifactInvoice->setCustomerId($order->getCustomer()->getId());
        $pifactInvoice->setCustomerTaxId($order->getBillingAddress()?->getPifactTaxId());
        $pifactInvoice->setEmail($invoice->order()->getCustomer()?->getEmail());
        $pifactInvoice->setOrderNumber($order->getNumber());
        $pifactInvoice->setMoneyBase($this->getBasePrice());
        $pifactInvoice->setPaymentMethod($order->getLastPayment()?->getMethod()?->getCode() ?? '');
        return $pifactInvoice;
    }

    public function getBasePrice()
    {
        // In some installation the decimal part is base 1000 or 10000, not 100
        $val = $this->moneyFormatter->format(100, 'USD');
        $val = floatval(str_replace('$', '', $val)); // Remove simbol
        return intval(100 / $val);
    }
}
