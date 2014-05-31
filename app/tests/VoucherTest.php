<?php

class VoucherTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', '/vouchers');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}
