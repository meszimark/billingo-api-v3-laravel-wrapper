<?php

namespace Deviddev\BillingoApiV3Wrapper\Tests;

use Orchestra\Testbench\TestCase;
use Deviddev\BillingoApiV3Wrapper\BillingoApiV3WrapperServiceProvider;
use Deviddev\BillingoApiV3Wrapper\BillingoApiV3Wrapper as Billingo;

class ExampleTest extends TestCase
{

    /**
     * Partner data
     *
     * @var array
     */
    protected $partner = [
        'name' => 'Test Company',
        'address' => [
            'country_code' => 'HU',
            'post_code' => '1010',
            'city' => 'Budapest',
            'address' => 'Nagy Lajos 12.',
        ],
        'emails' => ['test@company.hu'],
        'taxcode' => '',
    ];

    /**
     * Partner update data
     *
     * @var array
     */
    protected $partnerUpdate = [
        'name' => 'Test Company updated',
        'address' => [
            'country_code' => 'HU',
            'post_code' => '1010',
            'city' => 'Budapest',
            'address' => 'Nagy Lajos 12.',
        ],
        'emails' => ['test@company.hu'],
        'taxcode' => '',
    ];

    /**
     * Set up partner id accross tests
     *
     * @return integer|null
     */
    protected function &getPartnerId(): ?int
    {
        static $partnerId = null;
        return $partnerId;
    }

    /**
     * Get package provider
     *
     * @param [type] $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [BillingoApiV3WrapperServiceProvider::class];
    }

    /**
     * Test that partner create contains partner id
     *
     * @return void
     */
    public function testPartnerApiCreateContainsId(): void
    {
        $billingoApi = new Billingo();
        $billingoApi = $billingoApi->api('Partner')->model('PartnerUpsert', $this->partner)->create()->getId();

        $partnerId = &$this->getPartnerId();

        $partnerId = $billingoApi;

        $this->assertIsInt($billingoApi);
    }

    /**
     * Test that partner create response contains partner name
     *
     * @return void
     */
    public function testPartnerApiCreateResponseContainsPartner(): void
    {
        $billingoApi = new Billingo();
        $billingoApi = $billingoApi->api('Partner')->model('PartnerUpsert', $this->partner)->create()->getResponse();

        $this->assertContains('Test Company', $billingoApi);
    }

    /**
     * Test that partner update conatins partner id
     *
     * @return void
     */
    public function testPartnerApiUpdateContainsId(): void
    {
        $partnerId = &$this->getPartnerId();

        $billingoApi = new Billingo();
        $billingoApi = $billingoApi->api('Partner')->model('PartnerUpsert', $this->partner)->update($partnerId)->getId();

        $this->assertIsInt($billingoApi);
    }

    /**
     * Test that partner update response contains partner name
     *
     * @return void
     */
    public function testPartnerApiUpdateResponseContainsPartner(): void
    {
        $partnerId = &$this->getPartnerId();

        $billingoApi = new Billingo();
        $billingoApi = $billingoApi->api('Partner')->model('PartnerUpsert', $this->partnerUpdate)->update($partnerId)->getResponse();

        $this->assertContains('Test Company updated', $billingoApi);
    }
}
