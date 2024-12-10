<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax_controller extends CI_Controller {


   
	public function get_app_users_ajx(){
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$order = $this->input->post("order");
		$search = $this->input->post("search");
		$search = $search['value'];
		$col = 0;
		$dir = "";
		if(!empty($order)){
			foreach($order as $o){
				$col = $o['column'];
				$dir= $o['dir'];
			}
		}
		if($dir != "asc" && $dir != "desc"){
			$dir = "desc";
		}		

		$document = $this->Admin_model->get_app_users_list_ajx($length, $start, $search);
		// echo '<pre>'; print_r($document); exit;
		$data = array();
		if(!empty($document)){
			$page = $start / $length + 1;
			$offset = ($page - 1) * $length + 1;
			foreach($document as $print){
				if($print->is_active_login == '1'){
					$login_details = '<span class="badge badge-success" style="background-color: green;">Active</span>';
					// $login_details .= $print->last_login_on != "" ? '<br>Last Login On: '.date('d M, Y h:i A',strtotime($print->last_login_on)) : '';
				}else{
					$login_details = '<span class="badge badge-danger" background-color: orange;>Inactive</span>';
					$login_details .= $print->last_logout_on != "" ? '<br><small>Logout On:<br>'.date('d M, Y h:i A',strtotime($print->last_logout_on)).'</small>' : '';
				}
				
				$project = $print->project;

				$sub_array = array();
				$sub_array[] = $offset++;
				$sub_array[] = $login_details;
				$sub_array[] = $print->last_login_on != "" ? date('d M, Y h:i A',strtotime($print->last_login_on)) : '';
				// $sub_array[] = $project;
				$sub_array[] = $print->username;
				$sub_array[] = ($print->name != "" ? '<p><b>Name:</b> '.$print->name.'</p>' : '') . '' . ($print->mobile_no != "" ? '<p><b>Mobile:</b> '.$print->mobile_no.'</p>' : '') . '' . ($print->email != "" ? '<p><b>Email:</b> '.$print->email.'</p>' : '');
				$sub_array[] = $print->device_id;
				$device_Details_table = '
					<button type="button" onclick="showDevicePopup(\'exampleModal_'.$print->id.'\')" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_'.$print->id.'">
						View
					</button>
					<div class="modal fade" id="exampleModal_'.$print->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_'.$print->id.'" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel_'.$print->id.'">Device Details</h5>
									<button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDevicePopup(\'exampleModal_'.$print->id.'\')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="device_Details_table table table-bordered">
										<thead>
											<tr>
												<th>Key</th>
												<th>Value</th>
											</tr>
										</thead>
										<tbody>';

					$device_details = json_decode($print->device_details, true);
					foreach ($device_details as $key => $value) {
						$display_name = ucwords(str_replace('_', ' ', $key));
						$device_Details_table .= '<tr>
													<td><strong>' . htmlspecialchars($display_name) . '</strong></td>
													<td>' . ($value !== null ? htmlspecialchars($value) : 'N/A') . '</td>
												</tr>';
					}

					$device_Details_table .= '    </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<script>
					$(document).ready(function() {
						// Initialize DataTable when the modal is shown
						$("#exampleModal_'.$print->id.'").on("shown.bs.modal", function() {
							$(this).find(".device_Details_table").DataTable({ 
								dom: "Blfrtip",
								lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
								buttons: [				
									{
										extend: "excel",
										filename: "Device Details",
										exportOptions: {
											columns: [0, 1] 
										}
									},	
								],
								destroy: true // Allow reinitialization
							});
						});
					});
					</script>';
				$sub_array[] = $device_Details_table;
				$permission_Details_table = '
					<button type="button" onclick="showLocationPopup(\'examplePermissionModal_'.$print->id.'\')" class="btn btn-primary" data-toggle="modal" data-target="#examplePermissionModal_'.$print->id.'">
						View
					</button>
					<div class="modal fade" id="examplePermissionModal_'.$print->id.'" tabindex="-1" role="dialog" aria-labelledby="examplePermissionModalLabel_'.$print->id.'" aria-hidden="true">
						<div class="modal-dialog" role="document" style="width: 750px;">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="examplePermissionModalLabel_'.$print->id.'">Permission Details</h5>
									<button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal" aria-label="Close" onclick="closeLocationPopup(\'examplePermissionModal_'.$print->id.'\')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="permission_details_table table table-bordered">
										<thead>
											<tr>
												<th>Permission</th>
												<th>Is Required</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>';

					$permission_details = json_decode($print->permission_details, true);
					foreach ($permission_details as $permission) {
						$permission_name = htmlspecialchars($permission['permission']);
						$is_required = isset($permission['is_required']) ? htmlspecialchars($permission['is_required']) : '-';
						$status = htmlspecialchars($permission['status']);
						
						$permission_Details_table .= '<tr>
											<td>' . $permission_name . '</td>
											<td>' . $is_required . '</td>
											<td>' . $status . '</td>
										</tr>';
					}

					$permission_Details_table .= '    </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<script>
					$(document).ready(function() {
						$("#examplePermissionModal_'.$print->id.'").on("shown.bs.modal", function() {
							$(this).find(".permission_details_table").DataTable({ 
								dom: "Blfrtip",
								lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
								buttons: [				
									{
										extend: "excel",
										filename: "Permission Details",
										exportOptions: {
											columns: [0, 1, 2] 
										}
									},	
								],
								destroy: true // Allow reinitialization
							});
						});
					});
					</script>';
				$sub_array[] = $permission_Details_table;
				$data[] = $sub_array; 
			}
		}
		$TotalProducts = $this->Admin_model->get_app_users_count_ajx($search);
		
		$output = array(
			"draw" 				=> $draw,
			"recordsTotal" 		=> $TotalProducts,
			"recordsFiltered" 	=> $TotalProducts,
			"data" 				=> $data
		);
		echo json_encode($output);
		exit();
	}

}