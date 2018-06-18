<?php
namespace App\Transformers;

use App\Traits\TextTransform  as TT;

class Partnership_LPsTransformer extends Transformer
{
	use TT;

	public function transform($partnership_lp)
	{
		return [
			'company_name'          => trim($partnership_lp['company_name']),
			'email'                 => TT::tl($partnership_lp['email_address']),
			'send_mails'            => (TT::tl($partnership_lp['we_support'])    == 'tak') ? true : false,
			'send_mail6'            => (TT::tl($partnership_lp['share_address']) == 'tak') ? true : false,
			'payroll'               => (TT::tl($partnership_lp['payroll'])       == 'tak') ? true : false,
			'vat'                   => (TT::tl($partnership_lp['vat'])           == 'tak') ? true : false,
			'registration_date'     => TT::ed_ymd($partnership_lp['registration_date']),
			'first_period_start'    => TT::ed_ymd($partnership_lp['first_set_period']),
			'next_periods_start'    => TT::ed_dm( $partnership_lp['b_c_billing_periods']),
			'period_end'            => TT::ed_dm( $partnership_lp['end_of_set_period']),
			'first_period_deadline' => TT::ed_ymd($partnership_lp['eof_first_settlement']),
			'next_periods_deadline' => TT::ed_dm( $partnership_lp['end_of_periods']),
			'vat_period_1' => TT::ed_dm($partnership_lp['date_periods_1']),
			'vat_period_2' => TT::ed_dm($partnership_lp['date_periods_2']),
			'vat_period_3' => TT::ed_dm($partnership_lp['date_periods_3']),
			'vat_period_4' => TT::ed_dm($partnership_lp['date_periods_4']),
		];
	}
}