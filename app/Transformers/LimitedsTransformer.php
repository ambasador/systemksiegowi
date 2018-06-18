<?php
namespace App\Transformers;

use App\Traits\TextTransform  as TT;

class LimitedsTransformer extends Transformer
{
	use TT;

	public function transform($limited)
	{
		return [
			'company_name'          => trim($limited['company_name']),
			'email'                 => TT::tl($limited['address_email']),
			'send_mails'            => (TT::tl($limited['we_share'])      == 'tak') ? true : false,
			'send_mail6'            => (TT::tl($limited['share_address']) == 'tak') ? true : false,
			'payroll'               => (TT::tl($limited['payroll'])       == 'tak') ? true : false,
			'vat'                   => (TT::tl($limited['vat'])           == 'tak') ? true : false,
			'registration_date'     => TT::ed_ymd($limited['registration_date']),
			'first_period_start'    => TT::ed_ymd($limited['first_set_period']),
			'next_periods_start'    => TT::ed_dm( $limited['b_c_billing_periods']),
			'period_end'            => TT::ed_dm( $limited['end_of_set_period']),
			'first_period_deadline' => TT::ed_ymd($limited['Eof_first_settlement']),
			'next_periods_deadline' => TT::ed_dm( $limited['end_of_periods']),
			'vat_period_1' => TT::ed_dm($limited['date_periods_1']),
			'vat_period_2' => TT::ed_dm($limited['date_periods_2']),
			'vat_period_3' => TT::ed_dm($limited['date_periods_3']),
			'vat_period_4' => TT::ed_dm($limited['date_periods_4']),
		];
	}
}

