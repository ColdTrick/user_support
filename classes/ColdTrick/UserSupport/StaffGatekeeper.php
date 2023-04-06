<?php

namespace ColdTrick\UserSupport;

use Elgg\Exceptions\Http\GatekeeperException;
use Elgg\Request;

/**
 * Allow access to resources for Support staff
 */
class StaffGatekeeper extends \Elgg\Router\Middleware\Gatekeeper {
	
	/**
	 * {@inheritdoc}
	 */
	public function __invoke(Request $request) {
		parent::__invoke($request);
		
		if (user_support_is_support_staff()) {
			return;
		}
		
		throw new GatekeeperException(elgg_echo('user_support:staff_gatekeeper'));
	}
}
