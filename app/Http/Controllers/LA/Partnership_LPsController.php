<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Partnership_LP;

class Partnership_LPsController extends Controller
{
	public $show_action = true;
	public $view_col = 'company_name';
	public $listing_cols = ['id', 'company_name', 'we_support', 'share_address', 'registration_date', 'company_number', 'contact_person', 'phone_number', 'email_address', 'contact_person_2', 'phone_number_2', 'email_address_2', 'additional_remarks', 'first_set_period', 'b_c_billing_periods', 'end_of_set_period', 'eof_first_settlement', 'end_of_periods', 'payroll', 'vat', 'vat_number', 'date_periods_1', 'date_periods_2', 'date_periods_3', 'date_periods_4'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Partnership_LPs', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Partnership_LPs', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Partnership_LPs.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Partnership_LPs');
		
		if(Module::hasAccess($module->id)) {
			return View('la.partnership_lps.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new partnership_lp.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created partnership_lp in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Partnership_LPs", "create")) {
		
			$rules = Module::validateRules("Partnership_LPs", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Partnership_LPs", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.partnership_lps.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified partnership_lp.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Partnership_LPs", "view")) {
			
			$partnership_lp = Partnership_LP::find($id);
			if(isset($partnership_lp->id)) {
				$module = Module::get('Partnership_LPs');
				$module->row = $partnership_lp;
				
				return view('la.partnership_lps.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('partnership_lp', $partnership_lp);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("partnership_lp"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified partnership_lp.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Partnership_LPs", "edit")) {			
			$partnership_lp = Partnership_LP::find($id);
			if(isset($partnership_lp->id)) {	
				$module = Module::get('Partnership_LPs');
				
				$module->row = $partnership_lp;
				
				return view('la.partnership_lps.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('partnership_lp', $partnership_lp);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("partnership_lp"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified partnership_lp in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Partnership_LPs", "edit")) {
			
			$rules = Module::validateRules("Partnership_LPs", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Partnership_LPs", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.partnership_lps.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified partnership_lp from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Partnership_LPs", "delete")) {
			Partnership_LP::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.partnership_lps.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('partnership_lps')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Partnership_LPs');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/partnership_lps/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Partnership_LPs", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/partnership_lps/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Partnership_LPs", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.partnership_lps.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
