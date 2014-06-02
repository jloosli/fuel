<?php

class VoucherTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testGetRoute()
	{
		$this->client->request('GET', '/api/v1/vouchers');
		$this->assertTrue($this->client->getResponse()->isOk());
        try {
            $this->client->request( 'GET', '/api/v2/vouchers' );
        } catch (Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            $this->assertTrue(true);
        }

	}

}
