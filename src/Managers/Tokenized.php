<?php

namespace Shipu\Bkash\Managers;

use Shipu\Bkash\Apis\Tokenized\AgreementApi;
use Shipu\Bkash\Apis\Tokenized\CheckoutApi;
use Shipu\Bkash\Apis\Tokenized\GeneralApi;
use Shipu\Bkash\Apis\Tokenized\PaymentApi;
use Shipu\Bkash\Enums\BkashSubDomainType;

/**
 * Class Tokenized
 * @package Shipu\Bkash\Managers
 */
class Tokenized extends BkashManager
{
    /**
     *
     * @var AgreementApi
     */
    protected $agreementApi;

    /**
     *
     * @var CheckoutApi
     */
    protected $checkoutApi;

    /**
     *
     * @var PaymentApi
     */
    protected $paymentApi;

    /**
     *
     * @var GeneralApi
     */
    protected $generalApi;

    /**
     * Tokenized constructor.
     *
     * @param $config
     */
    public function __construct( $config )
    {
        parent::__construct($config);

        $this->agreementApi = new AgreementApi($config);
        $this->checkoutApi  = new CheckoutApi($config);
        $this->paymentApi   = new PaymentApi($config);
        $this->generalApi   = new GeneralApi($config);
    }

    /**
     * @return string
     */
    public function subDomainType()
    {
        return BkashSubDomainType::TOKENIZED;
    }

    /**
     * @return \Apiz\AbstractApi|bool
     */
    public function agreement()
    {
        return ( new AgreementApi($this->config) )->authorization($this->getToken());
    }

    /**
     * @return \Apiz\AbstractApi|bool
     */
    public function checkout()
    {
        return ( new CheckoutApi($this->config) )->authorization($this->getToken());
    }

    /**
     * @return \Apiz\AbstractApi|bool
     */
    public function payment()
    {
        return ( new PaymentApi($this->config) )->authorization($this->getToken());
    }

    /**
     * @return \Apiz\AbstractApi|bool
     */
    public function general()
    {
        return ( new GeneralApi($this->config) )->authorization($this->getToken());
    }

    /**
     * @param $mode
     * @param null $callbackUrl
     * @param null $payerReference
     * @param null $agreementId
     * @param null $amount
     * @param null $merchantInvoiceNumber
     * @param string $currency
     * @param null $intent
     *
     * @return mixed
     */
    public function create( $mode, $callbackUrl = null, $payerReference = null, $agreementId = null, $amount = null, $merchantInvoiceNumber = null, $currency = 'BDT', $intent = null )
    {
        $response = $this->checkoutApi->authorization($this->getToken())->create(
            $mode, $callbackUrl, $payerReference, $agreementId, $amount, $merchantInvoiceNumber, $currency, $intent
        );

        return $response();
    }

    /**
     * @param $paymentId
     *
     * @return mixed
     */
    public function execute( $paymentId )
    {
        $response = $this->checkoutApi->authorization($this->getToken())->execute($paymentId);

        return $response();
    }

    /**
     * @param $trxId
     *
     * @return mixed
     */
    public function searchTransaction( $trxId )
    {
        $response = $this->generalApi->authorization($this->getToken())->searchTransaction($trxId);

        return $response();
    }

    /**
     * @param $payerReference
     *
     * @return mixed
     */
    public function createAgreement( $payerReference )
    {
        $response = $this->agreementApi->authorization($this->getToken())->create($payerReference);

        return $response();
    }

    /**
     * @param $paymentId
     *
     * @return mixed
     */
    public function executeAgreement( $paymentId )
    {
        $response = $this->agreementApi->authorization($this->getToken())->create($paymentId);

        return $response();
    }

    /**
     * @param $agreementId
     *
     * @return mixed
     */
    public function statusAgreement( $agreementId )
    {
        $response = $this->agreementApi->authorization($this->getToken())->status($agreementId);

        return $response();
    }

    /**
     * @param $agreementId
     *
     * @return mixed
     */
    public function cancelAgreement( $agreementId )
    {
        $response = $this->agreementApi->authorization($this->getToken())->cancel($agreementId);

        return $response();
    }

    /**
     * Create Payment for Tokenized
     *
     * @param $agreementId
     * @param $amount
     * @param $merchantInvoiceNumber
     * @param $intent
     * @param string $currency
     * @param null $callbackUrl
     *
     * @return mixed
     */
    public function createPayment( $agreementId, $amount, $merchantInvoiceNumber, $intent, $currency = 'BDT', $callbackUrl = null )
    {
        $response = $this->paymentApi->authorization($this->getToken())->create(
            $agreementId, $amount, $merchantInvoiceNumber, $intent, $currency, $callbackUrl
        );

        return $response();
    }

    /**
     * @param $paymentId
     *
     * @return mixed
     */
    public function executePayment( $paymentId )
    {
        $response = $this->paymentApi->authorization($this->getToken())->execute($paymentId);

        return $response();
    }

    /**
     * @param $paymentId
     *
     * @return mixed
     */
    public function statusPayment( $paymentId )
    {
        $response = $this->paymentApi->authorization($this->getToken())->status($paymentId);

        return $response();
    }
}
