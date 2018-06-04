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
		$service = new \vehicle_service();
		$service->vehicle_id = $vehicle_id;
		$service->service_type = \Input::get('service_type');
		$service->prev_service_date = \Input::get('prev_service_date');
		$service->next_service_date = \Input::get('next_service_date');
		/*
		$prev_service_date = explode('/', \Input::get('prev_service_date'));
		$prev_service_date = $prev_service_date[2]."-".$prev_service_date[1]."-".$prev_service_date[0];
		$service->prev_service_date = $prev_service_date;
		$next_service_date = explode('/', \Input::get('next_service_date'));
		$next_service_date = $next_service_date[2]."-".$next_service_date[1]."-".$next_service_date[0];

		$service->next_service_date = $next_service_date;
		*/
		$service->save();

		$driver = new \driver_details();
		$driver->vehicle_id = $vehicle_id;
		$driver->name = \Input::get('name');
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
		$driver = \driver_details::where('vehicle_id',$id)->first();
		$data = [ 'vehicle' => $vehicle, 'service' => $service, 'driver' => $driver];


		

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

            DB::table('vehicle-service')
            ->where('vehicle_id', $id)
            ->update(['service_type' => \Input::get('service_type'),
		'prev_service_date' => \Input::get('prev_service_date'),
		'next_service_date' => \Input::get('next_service_date')]);

            DB::table('driver-details')
            ->where('vehicle_id', $id)
            ->update(['name' => \Input::get('name'),
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
		$service = \vehicle_service::where('vehicle_id',$id)->first();
		$driver = \driver_details::where('vehicle_id',$id)->first();

		if($vehicle->count() > 0){
			$vehicle = $vehicle->toArray();
			$service = $service->toArray();
			$driver = $driver->toArray();
			

			$return = array();
			$return['title'] = "";

			$return['content'] = "<div class='text-center'>";

			$return['content'] .= "<h4>Vehicle Details</h4>";

			$return['content'] .= "<table class='table table-bordered'><tbody>
	                          <tr>
	                              <td>License Plate Number</td>
	                              <td>".$driver['license_number']."</td>
	                          </tr>
	                          <tr>
	                              <td>Year</td>
	                              <td>".$vehicle['year']."</td>
	                          </tr>
	                          <tr>
	                              <td>Make</td>
	                              <td>".$vehicle['make']."</td>
	                          </tr>
	                          <tr>
	                              <td>Model</td>
	                              <td>".$vehicle['vehicle_model']."</td>
	                          </tr>
	                          <tr>
	                              <td>Type</td>
	                              <td>".$vehicle['type']."</td>
	                          </tr>
	                          <tr>
	                              <td>Fuel Type</td>
	                              <td>".$vehicle['capacity']."</td>
	                          </tr></table>";

	           $return['content'] .= "<h4>Vehicle service Details</h4>";

			$return['content'] .= "<table class='table table-bordered'><tbody>
	                          <tr>
	                              <td>Service Type</td>
	                              <td>".$service['service_type']."</td>
	                          </tr>
	                          <tr>
	                              <td>Prev Service Date</td>
	                              <td>".$service['prev_service_date']."</td>
	                          </tr>
	                          <tr>
	                              <td>Next Service Date</td>
	                              <td>".$service['next_service_date']."</td>
	                          </tr></table>";               

	          $return['content'] .= "<h4>Driver Details</h4>";

			$return['content'] .= "<table class='table table-bordered'><tbody>
	                          <tr>
	                              <td>Name</td>
	                              <td>".$driver['name']."</td>
	                          </tr>
	                          <tr>
	                              <td>License Number</td>
	                              <td>".$driver['license_number']."</td>
	                          </tr>
	                          <tr>
	                              <td>Work Begin Date</td>
	                              <td>".$driver['work_begin_date']."</td>
	                          </tr>
	                          <tr>
	                              <td>Work End Date</td>
	                              <td>".$driver['work_end_date']."</td>
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
