<?php
namespace App\Http\Controllers;
use DB;

class VehiclesController extends Controller {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';

	public function __construct(){
		if(app('request')->header('Authorization') != ""){
			$this->middleware('jwt.auth');
		}else{
			$this->middleware('authApplication');
		}

		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = $this->panelInit->getAuthUser();
		if(!isset($this->data['users']->id)){
			return \Redirect::to('/');
		}

		if(!$this->panelInit->hasThePerm('Vehicles')){
			exit;
		}
	}

	public function listAll()
	{

/*
	return	\vehicles::leftJoin('vehicle-service', function($join) {
      $join->on('vehicles.vehicle_id', '=', 'vehicle-service.vehicle_id');
    })->get();

  */  

    $data =	DB::table('vehicles')
    ->select('vehicles.*','vehicle-service.*','driver-details.*')
    ->leftJoin('vehicle-service','vehicles.vehicle_id','=','vehicle-service.vehicle_id')
    ->leftJoin('driver-details','vehicles.vehicle_id','=','driver-details.vehicle_id')
    ->orderBy('vehicles.vehicle_id', 'desc')
    ->get();


return $data;
/*
		return \vehicles::get();
		*/
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		if ( DB::table('vehicles')->where('vehicle_id', $id)->delete())
        {
            DB::table('vehicle-service')->where('vehicle_id', $id)->delete();
            DB::table('driver-details')->where('vehicle_id', $id)->delete();
            return $this->panelInit->apiOutput(true,'Vehicle Deleted Successfully','Vehicle Deleted Successfully');
        }else{
            return $this->panelInit->apiOutput(false,'Vehicle Not Exist','Vehicle Not Exist');
        }
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;


		$vehicles = new \vehicles();
		$vehicles->vehicle_number = \Input::get('vehicle_number');
		$vehicles->year = \Input::get('year');
		$vehicles->make = \Input::get('make');
		$vehicles->vehicle_model = \Input::get('vehicle_model');
		$vehicles->type = \Input::get('type');
		$vehicles->capacity = \Input::get('capacity');
		$vehicles->save();

		$vehicle_id = $vehicles->id;
		$service1 = new \vehicle_service();
		$service1->vehicle_id = $vehicle_id;
		$service1->service_type = \Input::get('service_type');
		$service1->prev_service_date = \Input::get('prev_service_date');
		$service1->next_service_date = \Input::get('next_service_date');		
		$service1->save();
		if(!empty(\Input::get('vehiclesmul'))){
			$vehiclesmul = \Input::get('vehiclesmul');
			while (list($key, $value) = each($vehiclesmul)) {
			$service = new \vehicle_service();
			$service->vehicle_id = $vehicle_id;
			$service->service_type = 	$vehiclesmul[$key]['service_type'];
			$service->prev_service_date = 	date("Y-m-d", strtotime($vehiclesmul[$key]['prev_service_date']));
			$service->next_service_date = 	date("Y-m-d", strtotime($vehiclesmul[$key]['next_service_date']));
			$service->save();
			}
		}

		/*
		$service->service_type = \Input::get('service_type');
		$service->prev_service_date = \Input::get('prev_service_date');
		$service->next_service_date = \Input::get('next_service_date');
		*/
		/*
		$prev_service_date = explode('/', \Input::get('prev_service_date'));
		$prev_service_date = $prev_service_date[2]."-".$prev_service_date[1]."-".$prev_service_date[0];
		$service->prev_service_date = $prev_service_date;
		$next_service_date = explode('/', \Input::get('next_service_date'));
		$next_service_date = $next_service_date[2]."-".$next_service_date[1]."-".$next_service_date[0];

		$service->next_service_date = $next_service_date;
		*/
		//$service->save();

		$driver = new \driver_details();
		$driver->vehicle_id = $vehicle_id;
		$driver->name = \Input::get('name');
		$driver->phone = trim(\Input::get('phone'));
		$driver->license_number = \Input::get('license_number');
		$driver->license_issue_date = \Input::get('license_issue_date');
		$driver->license_expiry_date = \Input::get('license_expiry_date');
		$driver->work_begin_date = \Input::get('work_begin_date');
		$driver->work_end_date = \Input::get('work_end_date');
		/*
		$license_issue_date = explode('/', \Input::get('license_issue_date'));
		$license_issue_date = $license_issue_date[2]."-".$license_issue_date[1]."-".$license_issue_date[0];
		$driver->license_issue_date = $license_issue_date;
		$license_expiry_date = explode('/', \Input::get('license_expiry_date'));
		$license_expiry_date = $license_expiry_date[2]."-".$license_expiry_date[1]."-".$license_expiry_date[0];
		$driver->license_expiry_date = $license_expiry_date;
		$work_begin_date = explode('/', \Input::get('work_begin_date'));
		$work_begin_date = $work_begin_date[2]."-".$work_begin_date[1]."-".$work_begin_date[0];
		$driver->work_begin_date = $work_begin_date;
		$work_end_date = explode('/', \Input::get('work_end_date'));
		$work_end_date = $work_end_date[2]."-".$work_end_date[1]."-".$work_end_date[0];
		$driver->work_end_date = $work_end_date;
		*/
		$driver->save();

		return $this->panelInit->apiOutput(true,'Vehicle Added Successfully','Vehicle Added Successfully',$vehicles->toArray() );
	}

	function fetch($id){


		$vehicle = \vehicles::where('vehicle_id',$id)->first();
		$service = \vehicle_service::where('vehicle_id',$id)->first();
		$vehiclesmul = \vehicle_service::where('vehicle_id',$id)->get()->toArray();

		if(!empty($vehiclesmul)){

			foreach ($vehiclesmul as $key => $value) {
				if($service->service_id != $value['service_id'])
				{
				$vehiclesmul2[$key]['service_type'] = $value['service_type'];
				$vehiclesmul2[$key]['prev_service_date'] = $value['prev_service_date'];
				$vehiclesmul2[$key]['next_service_date'] = $value['next_service_date'];
			}
			}


if(empty($vehiclesmul2))
{
	$vehiclesmul2 = array();
}
/*
			while (list($key, $value) = each($vehiclesmul)) {
				$vehiclesmul2[$key]['service_type'] = print_r($vehiclesmul);
				$vehiclesmul2[$key]['prev_service_date'] = print_r($vehiclesmul);
				$vehiclesmul2[$key]['next_service_date'] = print_r($vehiclesmul);
			}
			*/
		}else{
			$vehiclesmul2 = array();
		}


		$driver = \driver_details::where('vehicle_id',$id)->first();
		$data = [ 'vehicle' => $vehicle, 'service' => $service,'vehiclesmul' => $vehiclesmul2, 'driver' => $driver];


		

		return $data;
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;

/*
		$prev_service_date = explode('/', \Input::get('prev_service_date'));
		$prev_service_date = $prev_service_date[2]."-".$prev_service_date[1]."-".$prev_service_date[0];
		$next_service_date = explode('/', \Input::get('next_service_date'));
		$next_service_date = $next_service_date[2]."-".$next_service_date[1]."-".$next_service_date[0];
		$license_issue_date = explode('/', \Input::get('license_issue_date'));
		$license_issue_date = $license_issue_date[2]."-".$license_issue_date[1]."-".$license_issue_date[0];
		$license_expiry_date = explode('/', \Input::get('license_expiry_date'));
		$license_expiry_date = $license_expiry_date[2]."-".$license_expiry_date[1]."-".$license_expiry_date[0];
		$work_begin_date = explode('/', \Input::get('work_begin_date'));
		$work_begin_date = $work_begin_date[2]."-".$work_begin_date[1]."-".$work_begin_date[0];
		$work_end_date = explode('/', \Input::get('work_end_date'));
		$work_end_date = $work_end_date[2]."-".$work_end_date[1]."-".$work_end_date[0];
*/
		DB::table('vehicles')
            ->where('vehicle_id', $id)
            ->update(['vehicle_number' => \Input::get('vehicle_number'),
		'year' => \Input::get('year'),
		'make' => \Input::get('make'),
		'vehicle_model' => \Input::get('vehicle_model'),
		'type' => \Input::get('type'),
		'capacity' => \Input::get('capacity')]);

/*
            DB::table('vehicle-service')
            ->where('vehicle_id', $id)
            ->update(['service_type' => \Input::get('service_type'),
		'prev_service_date' => \Input::get('prev_service_date'),
		'next_service_date' => \Input::get('next_service_date')]);
*/
		DB::table('vehicle-service')->where('vehicle_id', $id)->delete();
            $vehicle_id = $id;
		$service1 = new \vehicle_service();
		$service1->vehicle_id = $vehicle_id;
		$service1->service_type = \Input::get('service_type');
		$service1->prev_service_date = \Input::get('prev_service_date');
		$service1->next_service_date = \Input::get('next_service_date');		
		$service1->save();
		if(!empty(\Input::get('vehiclesmul'))){
			$vehiclesmul = \Input::get('vehiclesmul');
			while (list($key, $value) = each($vehiclesmul)) {
			$service = new \vehicle_service();
			$service->vehicle_id = $vehicle_id;
			$service->service_type = 	$vehiclesmul[$key]['service_type'];
			$service->prev_service_date = 	date("Y-m-d", strtotime($vehiclesmul[$key]['prev_service_date']));
			$service->next_service_date = 	date("Y-m-d", strtotime($vehiclesmul[$key]['next_service_date']));
			$service->save();
			}
		}

            DB::table('driver-details')
            ->where('vehicle_id', $id)
            ->update(['name' => \Input::get('name'),
            	'phone' => trim(\Input::get('phone')),
		'license_number' => \Input::get('license_number'),
		'license_issue_date' => \Input::get('license_issue_date'),
		'license_expiry_date' => \Input::get('license_expiry_date'),
		'work_begin_date' => \Input::get('work_begin_date'),
		'work_end_date' => \Input::get('work_end_date')]);


/*
		$vehicles =  \vehicles::where('vehicle_id',$id)->first();
		
		$vehicles->vehicle_number = \Input::get('vehicle_number');
		$vehicles->year = \Input::get('year');
		$vehicles->make = \Input::get('make');
		$vehicles->vehicle_model = \Input::get('vehicle_model');
		$vehicles->type = \Input::get('type');
		$vehicles->capacity = \Input::get('capacity');
		$vehicles->save();

		$service =  \vehicle_service::where('vehicle_id',$id)->first();
		$service->service_type = \Input::get('service_type');
		$service->prev_service_date = \Input::get('prev_service_date');
		$service->next_service_date = \Input::get('next_service_date');
		$service->save();

		$driver =  \driver_details::where('vehicle_id',$id)->first();
		$driver->name = \Input::get('name');
		$driver->license_number = \Input::get('license_number');
		$driver->license_issue_date = \Input::get('license_issue_date');
		$driver->license_expiry_date = \Input::get('license_expiry_date');
		$driver->work_begin_date = \Input::get('work_begin_date');
		$driver->work_end_date = \Input::get('work_end_date');
		$driver->save();
*/
		return $this->panelInit->apiOutput(true,'Vehicle Updated Successfully','Vehicle Updated Successfully','');
	}


	public function details($id){
		$vehicle = \vehicles::where('vehicle_id',$id)->first();
		$service = \vehicle_service::where('vehicle_id',$id)->get();
		$driver = \driver_details::where('vehicle_id',$id)->first();

		if($vehicle->count() > 0){
			$vehicle = $vehicle->toArray();
			$service = $service;
			$driver = $driver->toArray();
			

			$return = array();
			$return['title'] = "";

			$return['content'] = "<div class='text-center'>";

			$return['content'] .= "<h4>Vehicle Details</h4>";

			$return['content'] .= "<table class='table table-bordered'><tbody>
	                          <tr>
	                              <td align='right'>Vehicle Number</td>
	                              <td align='right'>".$vehicle['vehicle_number']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Year</td>
	                              <td align='right'>".$vehicle['year']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Make</td>
	                              <td align='right'>".$vehicle['make']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Model</td>
	                              <td align='right'>".$vehicle['vehicle_model']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Type</td>
	                              <td align='right'>".$vehicle['type']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Fuel Type</td>
	                              <td align='right'>".$vehicle['capacity']."</td>
	                          </tr></table>";

	           $return['content'] .= "<h4>Vehicle service Details</h4>";
	           $return['content'] .= "<table class='table table-bordered'><thead>
	           <tr><th align='right'>Service Type</th><th align='right'>Prev Service Date</th><th align='right'>Next Service Date</th></tr>
	           </thead>
	           <tbody>";
	           foreach ($service as $key => $value) {
	        	$return['content'] .= "
	                          <tr>
	                              <td align='right'>".$value->service_type."</td>
	                          
	                              <td align='right'>".$value->prev_service_date."</td>
	                          
	                              <td align='right'>".$value->next_service_date."</td>
	                          </tr>";                  	
	           }
			$return['content'] .= "</tbody></table>";

	          $return['content'] .= "<h4>Driver Details</h4>";

			$return['content'] .= "<table class='table table-bordered'><tbody>
	                          <tr>
	                              <td align='right'>Name</td>
	                              <td align='right'>".$driver['name']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Phone Number</td>
	                              <td align='right'>".$driver['phone']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>License Number</td>
	                              <td align='right'>".$driver['license_number']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Work Begin Date</td>
	                              <td align='right'>".$driver['work_begin_date']."</td>
	                          </tr>
	                          <tr>
	                              <td align='right'>Work End Date</td>
	                              <td align='right'>".$driver['work_end_date']."</td>
	                          </tr></table>";                               
		}

		return $return;
	}

	 function service_cron(){
		

			
		  $data =	DB::table('vehicles')
    ->select('vehicles.*','vehicle-service.*','driver-details.*')
    ->leftJoin('vehicle-service','vehicles.vehicle_id','=','vehicle-service.vehicle_id')
    ->leftJoin('driver-details','vehicles.vehicle_id','=','driver-details.vehicle_id')
    ->get();

return $data;
	}

	
}
