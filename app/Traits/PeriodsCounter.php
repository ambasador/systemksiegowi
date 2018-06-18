<?php
namespace App\Traits;

trait PeriodsCounter
{
	public static function shiftDate( $date, $shift_days, $shift_months=0 )
	{
		if( !isset($date['y']) ) return self::shiftDateWithoutYear( $date, $shift_days, $shift_months );

		$time = mktime( 0, 0, 0, ($date['m']+$shift_months), ($date['d']+$shift_days), $date['y'] );
		$date = date('Y-m-d', $time);
		$date = explode('-', $date);

		return ['y'=>(int)$date[0],'m'=>(int)$date[1],'d'=>(int)$date[2]];
	}

	public static function getLastPeriod($registration_date, $first_period_start, $next_periods_start, $periods_end, $delay)
	{
		$first = self::isFirstPeriod($registration_date, $delay);

		$last_period_end = self::getLastPeriodEnd($delay);

		if($first)
		{
			return [
			'start' => $first_period_start,
			'end'   => ['d'=>$periods_end['d'],'m'=>$periods_end['m'],'y'=>$registration_date['y']]
			];
		}
		else
		{
			return [
			'start' => ['d'=>$next_periods_start['d'],'m'=>$next_periods_start['m'],'y'=>($last_period_end['y']-1)],
			'end'   => ['d'=>$periods_end['d'],'m'=>$periods_end['m'],'y'=>$last_period_end['y']]
			];
		}
	}

	public static function getPaymentDeadline($registration_date, $delay, $first_period_deadline, $next_periods_deadline, $last_period_end)
	{
		$first = self::isFirstPeriod($registration_date, $delay);

		if($first)
		{
			return $first_period_deadline;
		}
		else
		{
			$year = date('Y', strtotime($last_period_end['d']."-".$last_period_end['m']."-".$last_period_end['y']." + 21 months") );
			return ['d'=>$next_periods_deadline['d'], 'm'=>$next_periods_deadline['m'], 'y'=>$year ];
		}
	}

	public static function getVatPeriod($period_end_key_nr,$periods,$vat_delay)
	{
		$current_date    = self::getCurrentDate();
		$period_end      = self::shiftDate( $current_date, -$vat_delay['d'], -$vat_delay['m'] );
		$period_end_year = $period_end['y'];

		$period_end      = $periods['vat_period_'.$period_end_key_nr];
		$period_end['y'] = $period_end_year;

		if( $period_end_key_nr == 1 )
		{
			$period_start_key_nr = 4;
			$period_start_year   = $period_end_year-1;
		}
		else
		{
			$period_start_key_nr = $period_end_key_nr-1;
			$period_start_year   = $period_end_year;
		}

		$period_start      = $periods['vat_period_'.$period_start_key_nr];
		$period_start['y'] = $period_start_year;

		$period_start = self::shiftDate( $period_start, 1, 0 );

		return [
			'start' => $period_start,
			'end'   => $period_end
		];
	}

	public function getVatDeadline($period_end)
	{
		$dim = [null,31,28,31,30,31,30,31,31,30,31,30,31];
		$output = [
			'd' => $period_end['d'],
			'm' => $period_end['m'],
			'y' => $period_end['y'],
		];

		$output['m']++;
		if( $output['m'] == 13 )
		{
			$output['m'] = 1;
			$output['y']++;
		}
		$output['d'] = $dim[$output['m']];

		return $output;
	}


	private static function isFirstPeriod($registration_date, $delay)
	{
		$last_period_end = self::getLastPeriodEnd($delay);

		return ($last_period_end['y'] == $registration_date['y']);
	}

	private static function getLastPeriodEnd($delay)
	{
		$current_date = self::getCurrentDate();

		return self::shiftDate( $current_date, -$delay['d'], -$delay['m'] );
	}




	private static function getCurrentDate()
	{
		$current_date = date('Y-m-d');
		$current_date = explode('-', $current_date);

		$current_year  = (int)$current_date[0];
		$current_month = (int)$current_date[1];
		$current_day   = (int)$current_date[2];

		return ['y' => $current_year, 'm' => $current_month, 'd' => $current_day];
	}

	private static function shiftDateWithoutYear( $date, $shift_days, $shift_months=0 )
	{
		if( $date['m'] == 2 && $date['d'] == 29 ) $date['d'] = 28;

		$dim = [null,31,28,31,30,31,30,31,31,30,31,30,31];
		$shift_months = $shift_months % 12;
		$date['m'] += $shift_months;
		if( $date['m'] > 12 ) $date['m'] -= 12;
		$date['d'] += $shift_days;
		while( $date['d'] > $dim[$date['m']] )
		{
			$date['d'] -= $dim[$date['m']];
			$date['m']++;
			if( $date['m'] > 12 ) $date['m'] -= 12;
		}

		return $date;
	}

}