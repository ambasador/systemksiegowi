<?php

namespace App\Http\Controllers\Mailing;

use Mail;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Limited;
use App\Models\Self_Employment;
use App\Models\Partnership;
use App\Models\Partnership_LP;

use App\Transformers\LimitedsTransformer;
use App\Transformers\Self_EmploymentsTransformer;
use App\Transformers\PartnershipsTransformer;
use App\Transformers\Partnership_LPsTransformer;

use App\Traits\PeriodsCounter  as PC;

class MailingController extends Controller
{
	use PC;

	private $limitedsTransformer;
	private $self_EmploymentsTransformer;
	private $partnershipsTransformer;
	private $partnership_LPsTransformer;

	private $delay;
	private $vat_delay;
	private $reminder_delay;
	private $reminder_vat_delay;

	private $months;

	public function __construct()
	{
		$this -> limitedsTransformer         = new LimitedsTransformer;
		$this -> self_EmploymentsTransformer = new Self_EmploymentsTransformer;
		$this -> partnershipsTransformer     = new PartnershipsTransformer;
		$this -> partnership_LPsTransformer  = new Partnership_LPsTransformer;

		$this -> delay             =['m'=>0,'d'=>2 ];
		$this -> vat_delay         =['m'=>0,'d'=>1 ];
		$this -> reminder_delay    =['m'=>6,'d'=>2 ];
		$this -> reminder_vat_delay=['m'=>0,'d'=>20];

	    $this -> months = [  null,
				        	'Styczeń',
				        	'Luty',
				        	'Marzec',
				        	'Kwiecień',
				        	'Maj',
				        	'Czerwiec',
				        	'Lipiec',
				        	'Sierpień',
				        	'Wrzesień',
				        	'Październik',
				        	'Listopad',
				        	'Grudzień',
			        	  ];
	}

    public function run($schedule)
    {
    	$this -> runLimiteds($schedule);
    	$this -> runSelf_Employments($schedule);
    	$this -> runPartnerships($schedule);
    	$this -> runPartnership_LPs($schedule);
    }

    private function runLimiteds($schedule)
    {


    	$clients = Limited::all()->toArray();
    	$clients = $this -> limitedsTransformer -> transformCollection($clients);

    	foreach($clients as $client)
    	{

    		if( !$client['send_mails'] ) continue; // Jeśli $client['send_mails'] == false, to nie wysylamy zadnych wiadomosci

/**************************************************************/
    		$date = $client['registration_date'];

	        $schedule->call(function($client){

	        	if($client['send_mail6'])
	        	{
	        		$message_data = [
	        		'from'      => env('MAIL_USERNAME'),
	        		'from_name' => 'Firma w Anglii',
	        		'to'        => $client['email'],
	        		'reply_to'  => 'administracja@firmawanglii.pl',
	        		'body'      => 'emails.email6',
	        		'subject'   => $client['company_name'].' - raport strukturalny i adres',
	        		];
	        	}
	        	else
	        	{
	        		$message_data = [
	        		'from'      => env('MAIL_USERNAME'),
	        		'from_name' => 'Firma w Anglii',
	        		'to'        => $client['email'],
	        		'reply_to'  => 'administracja@firmawanglii.pl',
	        		'body'      => 'emails.email7',
	        		'subject'   => $client['company_name'].' - raport strukturalny',
	        		];
	        	}

		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');
/**************************************************************/
/**************************************************************/
	        $schedule->call(function($client){

	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'biuro@firmawanglii.pl',
	    		'body'      => 'emails.email3',
	    		'subject'   => 'Tax Return - rozliczenia osób fizycznych',
	    		];

	    		$client['year'] = date('Y');
	    		$client['year_m2'] = $client['year']-2;
	    		$client['year_m1'] = $client['year']-1;
	    		$client['year_p1'] = $client['year']+1;
	    		$client['year_p2'] = $client['year']+2;


		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 30 4,10 * *');
/**************************************************************/
/**************************************************************/
			$date = $client['period_end'];
			$date = self::shiftDate( $date, $this -> delay['d'], $this -> delay['m'] );

	        $schedule->call(function($client){

				$last_period = $this -> getLastPeriod(
														$client['registration_date'],
														$client['first_period_start'],
														$client['next_periods_start'],
														$client['period_end'],
														$this -> delay);

				$payment_deadline = $this -> getPaymentDeadline(
																$client['registration_date'],
																$this -> delay,
																$client['first_period_deadline'],
																$client['next_periods_deadline'],
																$last_period['end']);

				$client['last_period']      = $last_period;
				$client['payment_deadline'] = $payment_deadline;

				$periods =
				$last_period['start']['d'].'.'.$last_period['start']['m'].'.'.$last_period['start']['y'].' - '.
				$last_period['end']['d'].'.'.$last_period['end']['m'].'.'.$last_period['end']['y'];


	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'tax@firmawanglii.pl',
	    		'body'      => 'emails.email1',
	    		'subject'   => $client['company_name'].' - rozliczenie roczne: '.$periods,
	    		];

		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');

/**************************************************************/
/**************************************************************/
			$date = $client['period_end'];
			$date = self::shiftDate( $date, $this -> reminder_delay['d'], $this -> reminder_delay['m'] );

	        $schedule->call(function($client){

				$last_period = $this -> getLastPeriod(
														$client['registration_date'],
														$client['first_period_start'],
														$client['next_periods_start'],
														$client['period_end'],
														$this -> reminder_delay);

				$payment_deadline = $this -> getPaymentDeadline(
																$client['registration_date'],
																$this -> reminder_delay,
																$client['first_period_deadline'],
																$client['next_periods_deadline'],
																$last_period['end']);

				$client['last_period']      = $last_period;
				$client['payment_deadline'] = $payment_deadline;

				$periods =
				$last_period['start']['d'].'.'.$last_period['start']['m'].'.'.$last_period['start']['y'].' - '.
				$last_period['end']['d'].'.'.$last_period['end']['m'].'.'.$last_period['end']['y'];


	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'tax@firmawanglii.pl',
	    		'body'      => 'emails.email2',
	    		'subject'   => $client['company_name'].' - rozliczenie roczne: '.$periods,
	    		];

		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');

/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$month = date('m');
		        	$month = (int)$month;
		        	$month = $this -> months[$month];

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email9',
		    		'subject'   => $client['company_name'].' - rozliczenie pracownicze: '.$month,
		    		];

		    		$client['month'] = $month;
		    		$client['year']  = date('Y');

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 20 * * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$year = date('Y');
		        	$year = (int)$year;

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email8',
		    		'subject'   => $client['company_name'].' - Employer Return: '.$year,
		    		];

		    		$client['year'] = $year;

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 5 3 * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['vat'] )
			{
	        	foreach( [1,2,3,4] as $vp_end )
	        	{

	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> vat_delay['d'], $this -> vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email4',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');



	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> reminder_vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> reminder_vat_delay['d'], $this -> reminder_vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email5',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');
	        	}
			}
/**************************************************************/
    	}
    }
    private function runSelf_Employments($schedule)
    {
    	$clients = Self_Employment::all()->toArray();
    	$clients = $this -> self_EmploymentsTransformer -> transformCollection($clients);

    	foreach($clients as $client)
    	{

    		if( !$client['send_mails'] ) continue; // Jeśli $client['send_mails'] == false, to nie wysylamy zadnych wiadomosci
/**************************************************************/
	        $schedule->call(function($client){

	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'biuro@firmawanglii.pl',
	    		'body'      => 'emails.email3',
	    		'subject'   => 'Tax Return - rozliczenia osób fizycznych',
	    		];

	    		$client['year'] = date('Y');
	    		$client['year_m2'] = $client['year']-2;
	    		$client['year_m1'] = $client['year']-1;
	    		$client['year_p1'] = $client['year']+1;
	    		$client['year_p2'] = $client['year']+2;


		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 30 4,10 * *');
/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$month = date('m');
		        	$month = (int)$month;
		        	$month = $this -> months[$month];

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email9',
		    		'subject'   => $client['company_name'].' - rozliczenie pracownicze: '.$month,
		    		];

		    		$client['month'] = $month;
		    		$client['year']  = date('Y');

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 20 * * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$year = date('Y');
		        	$year = (int)$year;

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email8',
		    		'subject'   => $client['company_name'].' - Employer Return: '.$year,
		    		];

		    		$client['year'] = $year;

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 5 3 * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['vat'] )
			{
	        	foreach( [1,2,3,4] as $vp_end )
	        	{

	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> vat_delay['d'], $this -> vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email4',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');



	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> reminder_vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> reminder_vat_delay['d'], $this -> reminder_vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email5',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');
	        	}
			}
/**************************************************************/

    	}
    }
    private function runPartnerships($schedule)
    {
    	$clients = Partnership::all()->toArray();
    	$clients = $this -> partnershipsTransformer -> transformCollection($clients);

    	foreach($clients as $client)
    	{

    		if( !$client['send_mails'] ) continue; // Jeśli $client['send_mails'] == false, to nie wysylamy zadnych wiadomosci
/**************************************************************/
	        $schedule->call(function($client){

	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'biuro@firmawanglii.pl',
	    		'body'      => 'emails.email3',
	    		'subject'   => 'Tax Return - rozliczenia osób fizycznych',
	    		];

	    		$client['year'] = date('Y');
	    		$client['year_m2'] = $client['year']-2;
	    		$client['year_m1'] = $client['year']-1;
	    		$client['year_p1'] = $client['year']+1;
	    		$client['year_p2'] = $client['year']+2;


		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 30 4,10 * *');
/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$month = date('m');
		        	$month = (int)$month;
		        	$month = $this -> months[$month];

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email9',
		    		'subject'   => $client['company_name'].' - rozliczenie pracownicze: '.$month,
		    		];

		    		$client['month'] = $month;
		    		$client['year']  = date('Y');

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 20 * * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$year = date('Y');
		        	$year = (int)$year;

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email8',
		    		'subject'   => $client['company_name'].' - Employer Return: '.$year,
		    		];

		    		$client['year'] = $year;

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 5 3 * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['vat'] )
			{
	        	foreach( [1,2,3,4] as $vp_end )
	        	{

	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> vat_delay['d'], $this -> vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email4',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');



	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> reminder_vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> reminder_vat_delay['d'], $this -> reminder_vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email5',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');
	        	}
			}
/**************************************************************/

    	}
    }
    private function runPartnership_LPs($schedule)
    {
    	$clients = Partnership_LP::all()->toArray();
    	$clients = $this -> partnership_LPsTransformer -> transformCollection($clients);

    	foreach($clients as $client)
    	{

    		if( !$client['send_mails'] ) continue; // Jeśli $client['send_mails'] == false, to nie wysylamy zadnych wiadomosci

/**************************************************************/
    		$date = $client['registration_date'];

	        $schedule->call(function($client){

	        	if($client['send_mail6'])
	        	{
	        		$message_data = [
	        		'from'      => env('MAIL_USERNAME'),
	        		'from_name' => 'Firma w Anglii',
	        		'to'        => $client['email'],
	        		'reply_to'  => 'administracja@firmawanglii.pl',
	        		'body'      => 'emails.email6',
	        		'subject'   => $client['company_name'].' - raport strukturalny i adres',
	        		];
	        	}
	        	else
	        	{
	        		$message_data = [
	        		'from'      => env('MAIL_USERNAME'),
	        		'from_name' => 'Firma w Anglii',
	        		'to'        => $client['email'],
	        		'reply_to'  => 'administracja@firmawanglii.pl',
	        		'body'      => 'emails.email7',
	        		'subject'   => $client['company_name'].' - raport strukturalny',
	        		];
	        	}

		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');
/**************************************************************/
/**************************************************************/
	        $schedule->call(function($client){

	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'biuro@firmawanglii.pl',
	    		'body'      => 'emails.email3',
	    		'subject'   => 'Tax Return - rozliczenia osób fizycznych',
	    		];

	    		$client['year'] = date('Y');
	    		$client['year_m2'] = $client['year']-2;
	    		$client['year_m1'] = $client['year']-1;
	    		$client['year_p1'] = $client['year']+1;
	    		$client['year_p2'] = $client['year']+2;


		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 30 4,10 * *');
/**************************************************************/
/**************************************************************/
			$date = $client['period_end'];
			$date = self::shiftDate( $date, $this -> delay['d'], $this -> delay['m'] );

	        $schedule->call(function($client){

				$last_period = $this -> getLastPeriod(
														$client['registration_date'],
														$client['first_period_start'],
														$client['next_periods_start'],
														$client['period_end'],
														$this -> delay);

				$payment_deadline = $this -> getPaymentDeadline(
																$client['registration_date'],
																$this -> delay,
																$client['first_period_deadline'],
																$client['next_periods_deadline'],
																$last_period['end']);

				$client['last_period']      = $last_period;
				$client['payment_deadline'] = $payment_deadline;

				$periods =
				$last_period['start']['d'].'.'.$last_period['start']['m'].'.'.$last_period['start']['y'].' - '.
				$last_period['end']['d'].'.'.$last_period['end']['m'].'.'.$last_period['end']['y'];


	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'tax@firmawanglii.pl',
	    		'body'      => 'emails.email1',
	    		'subject'   => $client['company_name'].' - rozliczenie roczne: '.$periods,
	    		];

		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');

/**************************************************************/
/**************************************************************/
			$date = $client['period_end'];
			$date = self::shiftDate( $date, $this -> reminder_delay['d'], $this -> reminder_delay['m'] );

	        $schedule->call(function($client){

				$last_period = $this -> getLastPeriod(
														$client['registration_date'],
														$client['first_period_start'],
														$client['next_periods_start'],
														$client['period_end'],
														$this -> reminder_delay);

				$payment_deadline = $this -> getPaymentDeadline(
																$client['registration_date'],
																$this -> reminder_delay,
																$client['first_period_deadline'],
																$client['next_periods_deadline'],
																$last_period['end']);

				$client['last_period']      = $last_period;
				$client['payment_deadline'] = $payment_deadline;

				$periods =
				$last_period['start']['d'].'.'.$last_period['start']['m'].'.'.$last_period['start']['y'].' - '.
				$last_period['end']['d'].'.'.$last_period['end']['m'].'.'.$last_period['end']['y'];


	    		$message_data = [
	    		'from'      => env('MAIL_USERNAME'),
	    		'from_name' => 'Firma w Anglii',
	    		'to'        => $client['email'],
	    		'reply_to'  => 'tax@firmawanglii.pl',
	    		'body'      => 'emails.email2',
	    		'subject'   => $client['company_name'].' - rozliczenie roczne: '.$periods,
	    		];

		        $this -> sendFWAMessage($message_data, $client);

	        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');

/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$month = date('m');
		        	$month = (int)$month;
		        	$month = $this -> months[$month];

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email9',
		    		'subject'   => $client['company_name'].' - rozliczenie pracownicze: '.$month,
		    		];

		    		$client['month'] = $month;
		    		$client['year']  = date('Y');

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 20 * * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['payroll'] )
			{
		        $schedule->call(function($client){
		        	$year = date('Y');
		        	$year = (int)$year;

		    		$message_data = [
		    		'from'      => env('MAIL_USERNAME'),
		    		'from_name' => 'Firma w Anglii',
		    		'to'        => $client['email'],
		    		'reply_to'  => 'office@firmawanglii.pl',
		    		'body'      => 'emails.email8',
		    		'subject'   => $client['company_name'].' - Employer Return: '.$year,
		    		];

		    		$client['year'] = $year;

			        $this -> sendFWAMessage($message_data, $client);

		        },['client'=>$client])->cron('0 6 5 3 * *');
			}
/**************************************************************/
/**************************************************************/
			if( $client['vat'] )
			{
	        	foreach( [1,2,3,4] as $vp_end )
	        	{

	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> vat_delay['d'], $this -> vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email4',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');



	        		$vat_period = self::getVatPeriod($vp_end,[
	        													'vat_period_1'=>$client['vat_period_1'],
	        													'vat_period_2'=>$client['vat_period_2'],
	        													'vat_period_3'=>$client['vat_period_3'],
	        													'vat_period_4'=>$client['vat_period_4'],
	        												],$this -> reminder_vat_delay);

	        		$vat_deadline = self::getVatDeadline($vat_period['end']);

	        		$client['last_vat_period'] = $vat_period;
	        		$client['vat_deadline']    = $vat_deadline;

		        	$date = self::shiftDate( $client['vat_period_'.$vp_end], $this -> reminder_vat_delay['d'], $this -> reminder_vat_delay['m'] );
			        $schedule->call(function($client){

			        	$period = $client['last_vat_period']['start']['d'].'.'.$client['last_vat_period']['start']['m'].'.'.$client['last_vat_period']['start']['y'].'-'.
			        			  $client['last_vat_period']['end']['d'].'.'.$client['last_vat_period']['end']['m'].'.'.$client['last_vat_period']['end']['y'];

			    		$message_data = [
			    		'from'      => env('MAIL_USERNAME'),
			    		'from_name' => 'Firma w Anglii',
			    		'to'        => $client['email'],
			    		'reply_to'  => 'vat@firmawanglii.pl',
			    		'body'      => 'emails.email5',
			    		'subject'   => $client['company_name'].' - Rozliczenie VAT: '.$period,
			    		];

				        $this -> sendFWAMessage($message_data, $client);

			        },['client'=>$client])->cron('0 6 '.$date['d'].' '.$date['m'].' * *');
	        	}
			}
/**************************************************************/
    	}
    }




    private function sendFWAMessage($message_data, $client)
    {
        return Mail::send($message_data['body'], ['client' => $client], function ($m) use ($message_data) {
		            $m->from($message_data['from'], $message_data['from_name']);
					$m->replyTo($message_data['reply_to']);
		            $m->to($message_data['to'])->subject($message_data['subject']);
		        });
    }



}
