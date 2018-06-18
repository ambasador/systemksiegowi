<?php
namespace App\Transformers;

use App\Traits\TextTransform  as TT;

class PartnershipsTransformer extends Transformer
{
	use TT;

	public function transform($partnership)
	{
		return [
			'company_name'      => trim($partnership['partnership_name']),
			'email'             => TT::tl($partnership['email_address']),
			'send_mails'        => (TT::tl($partnership['we_supprot']) == 'tak') ? true : false,
			'payroll'           => (TT::tl($partnership['payroll'])    == 'tak') ? true : false,
			'vat'               => (TT::tl($partnership['vat'])        == 'tak') ? true : false,
			'registration_date' => TT::ed_ymd($partnership['registration_date']),
			'vat_period_1' => TT::ed_dm($partnership['date_periods_1']),
			'vat_period_2' => TT::ed_dm($partnership['date_periods_2']),
			'vat_period_3' => TT::ed_dm($partnership['date_periods_3']),
			'vat_period_4' => TT::ed_dm($partnership['date_periods_4']),
		];
	}
}
