<?php
namespace App\Transformers;

use App\Traits\TextTransform  as TT;

class Self_EmploymentsTransformer extends Transformer
{
	use TT;

	public function transform($self_employment)
	{
		return [
			'company_name'      => trim($self_employment['trade_name']),
			'email'             => TT::tl($self_employment['email_address']),
			'send_mails'        => (TT::tl($self_employment['we_support']) == 'tak') ? true : false,
			'payroll'           => (TT::tl($self_employment['payroll'])    == 'tak') ? true : false,
			'vat'               => (TT::tl($self_employment['vat'])        == 'tak') ? true : false,
			'registration_date' => TT::ed_ymd($self_employment['registration_date']),
			'vat_period_1' => TT::ed_dm($self_employment['end_date_1']),
			'vat_period_2' => TT::ed_dm($self_employment['end_date_2']),
			'vat_period_3' => TT::ed_dm($self_employment['end_date_3']),
			'vat_period_4' => TT::ed_dm($self_employment['end_date_4']),
		];
	}
}
