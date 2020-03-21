<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('customerclaim_model');
		$this->load->model('listpart_model');
		$this->load->model('delivery_model');
		$this->load->model('user_model');
		$this->load->helper('date');
		$this->load->helper('url');
	}

	public function index() {
		$slug = $this->uri->segment(1);
		$get_customer = $this->customer_model->customer_list();
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$listing_deliv = $this->delivery_model->listing_deliv();
		$listing_user = $this->user_model->list_user();
		$count_deliv = count($listing_deliv);
		$count_user = count($listing_user) - 1;
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}

		$firstYear = (int)date('Y') - 9;
		$lastYear = $firstYear + 9;
		$years = [];
		$count_customer_claim = count($get_customer_claim);
		for($i = $firstYear; $i <= $lastYear; $i++) {
			$years[] = $i;
		}
		
		$data = array(
			"year" => $years,
			"count_customer_claim" => $count_customer_claim,
			"slug" => $slug,
			"count_deliv" => $count_deliv,
			"customer" => $get_customer,
			"count_user" => $count_user
		);

		$this->load->view('index', $data);
	}

	public function filter_by_month() {
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$listing_deliv = $this->delivery_model->listing_deliv();
		$count_customer_claim = count($get_customer_claim);
		$count_deliv = count($listing_deliv);
		$dataMonth = array();
		$getYear = $_GET['year'];
		if($getYear != NULL) {
			$year = $getYear;
		} else {
			$year = date('Y');
		}
		// echo json_encode($year);
		$months = ["Jan-$year", "Feb-$year", "Mar-$year","Apr-$year", "May-$year", "Jun-$year", 
					"Jul-$year", "Aug-$year", "Sep-$year", "Oct-$year", "Nov-$year", "Dec-$year"];
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}

		$monthly_status_claim = $_GET['monthly_status_claim'];
		if($monthly_status_claim != null) {
			$status_claim = $monthly_status_claim;
		} else {
			$status_claim = null;
		}

		$monthly_customer = $_GET['monthly_customer'];
		if($monthly_customer != null) {
			$customer = $monthly_customer;
		} else {
			$customer = null;
		}

		$count_merge_field = count($merge_field_except);
		$ppm = [];
		for($i = 0; $i < count($months); $i++) {
			$month = date("m", strtotime($months[$i]));
			$rejection_per_year_month = $this->customerclaim_model->montly_rejection($year, $month, $status_claim, $customer);
			$get_deliv_montly = $this->delivery_model->monthly_ppm($year, $month);
			$count_chart_rejection_claim_month = count($rejection_per_year_month);
			$sumByMonth = 0;
			for($j = 0; $j < $count_merge_field; $j++) {
				$field = $merge_field_except[$j];
				for($k = 0; $k < $count_chart_rejection_claim_month; $k++) {
					if($rejection_per_year_month[$k]->$field > 0) {
						$sumByMonth += $rejection_per_year_month[$k]->$field;
					}			
				}
			}
			if($get_deliv_montly->total_qty != null) {
				$calculate_ppm = $get_deliv_montly->total_qty;
			} else {
				$calculate_ppm = 0;
			}
			$ppm[] = $calculate_ppm;
			$bulan = date("M", strtotime($months[$i]));
			$dataMonth[$bulan] = $sumByMonth;
		}
		
		$data = array(
			'dataMonthly' => $dataMonth,
			'count_customer_claim_monthly' => $count_customer_claim,
			'ppm' => $ppm,
			'count_deliv' => $count_deliv
		);

		echo json_encode($data);
	}

	public function filter_by_year() {
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$listing_deliv = $this->delivery_model->listing_deliv();
		$count_customer_claim = count($get_customer_claim);
		$count_deliv = count($listing_deliv);
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}

		$count_merge_field = count($merge_field_except);
		$annual_status_claim = $_GET['annual_status_claim'];
		$annual_customer = $_GET['annual_customer'];
		$get_year_from = $_GET['year_from'];
		$get_year_to = $_GET['year_to'];
		if($annual_status_claim != NULL) {
			$status_claim = $annual_status_claim;
		} else {
			$status_claim = null;
		}

		if($annual_customer != NULL) {
			$customer = $annual_customer;
		} else {
			$customer = null;
		}

		if($get_year_from != NULL && $get_year_to != NULL) {
			$year_from = $get_year_from;
			$year_to = $get_year_to;
		} else {
			$year_from = (int)date('Y') - 9;
			$year_to = $year_from + 9;;
		}

		$dataYear = array();
		$ppm = [];
		for($i = $year_from; $i <= $year_to; $i++) {
			$chart_rejection_claim = $this->customerclaim_model->rejection_per_year_month($i, $status_claim, $customer);
			$count_chart_rejection_claim = count($chart_rejection_claim);
			$get_deliv_annual = $this->delivery_model->annual_ppm($i);
			$sumByYear = 0;
			for($j = 0; $j < $count_merge_field; $j++) {
				$field = $merge_field_except[$j];
				for($k = 0; $k < $count_chart_rejection_claim; $k++) {
					if($chart_rejection_claim[$k]->$field > 0) {
						$sumByYear += $chart_rejection_claim[$k]->$field;
					}			
				}
			}
			if($get_deliv_annual->total_qty != null) {
				$calculate_ppm = $get_deliv_annual->total_qty;
			} else {
				$calculate_ppm = 0;
			}
			$ppm[] = $calculate_ppm;
			$dataYear[$i] = $sumByYear;
		}

		$data = array(
			'dataYears' => $dataYear,
			'count_customer_claim' => $count_customer_claim,
			'ppm' => $ppm,
			'count_deliv' => $count_deliv,
		);

		echo json_encode($data);
	}

	
}
