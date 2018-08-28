<?php

namespace Newsletter2Go\Traits;

trait VoucherTrait
{
	public function generateVoucherCode(): string
	{
		$bytes = random_bytes(5);
		return strtoupper(bin2hex($bytes));
	}
}
