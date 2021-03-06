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
		$this->load->model('aktivitas_model');
		$this->load->helper('date');
		$this->load->helper('url');
	}

	public function index() {

		if(!empty($this->session->userdata['role']) != "") {
			if($this->session->userdata['role'] == 'Admin') {
				$this->session->set_flashdata('error','YOU CANNOT ACCESS THE DASHBOARD PAGE!');
				redirect(base_url('claim/customerclaim'),'refresh');
			}
		}
		
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
		$customers = $this->customer_model->customer_list();
		// $get_customer = $this->customerclaim_model->get_customer();
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$get_customer_claim_distinct = $this->customerclaim_model->get_customer_claim_distinct();
		// $select_part_distinct = $this->customerclaim_model->select_part_distinct();
		$get_customer_claim_sort_by_date = $this->customerclaim_model->get_customer_claim_sort_by_date();
		$get_proses = $this->customerclaim_model->get_proses();
		$count_customer_claim = count($get_customer_claim);
		$get_data_aktivitas = $this->aktivitas_model->listing_aktivitas();
		$count_aktivitas = count($get_data_aktivitas);
		
		if(!empty($get_customer_claim_sort_by_date)) {
			$getStart = $get_customer_claim_sort_by_date[0]->tgl_input;
			$getEnd = $get_customer_claim_sort_by_date[count($get_customer_claim_sort_by_date) - 1]->tgl_input;
			$start = date('Y-m-d', strtotime($getStart));
			$end = date('Y-m-d', strtotime($getEnd));
		} else {
			$start = null;
			$end = null;
		}
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
			"count_user" => $count_user,
			'customers' => $customers,
			'customer_claim' => $get_customer_claim,
			'select_part_distinct' => $get_customer_claim_distinct,
			'count_customer_claim' => $count_customer_claim,
			'start' => $start,
			'end' => $end,
			'slug' => $slug,
			'proses' => $get_proses,
			'count_aktivitas' => $count_aktivitas
		);
		$this->load->view('index', $data);
	}

	public function filter_by_month() {
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$listing_deliv = $this->delivery_model->listing_deliv();
		$count_customer_claim = count($get_customer_claim);
		$count_deliv = count($listing_deliv);
		$dataMonth = array();
		$getYear = $_GET['year1'];

		if($getYear != NULL) {
			$year = $getYear;
		} else {
			$year = date('Y');
		}
		
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

		$monthly_proses = $_GET['monthly_proses'];
		if($monthly_proses != null) {
			$proses = $monthly_proses;
		} else {
			$proses = null;
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
			$rejection_per_year_month = $this->customerclaim_model->montly_rejection($year, $month, $status_claim, $customer, $proses);
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
		$annual_proses = $_GET['annual_proses'];
		$get_year_from = $_GET['year_from'];
		$get_year_to = $_GET['year_to'];
		if($annual_status_claim != NULL) {
			$status_claim = $annual_status_claim;
		} else {
			$status_claim = null;
		}

		if($annual_proses != NULL) {
			$proses = $annual_proses;
		} else {
			$proses = null;
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
			$year_to = $year_from + 9;
		}

		$dataYear = array();
		$ppm = [];
		for($i = $year_from; $i <= $year_to; $i++) {
			$chart_rejection_claim = $this->customerclaim_model->rejection_per_year_month($i, $status_claim, $customer, $proses);
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

	public function filter_by_daily() {
		$get_field_visual = $this->customerclaim_model->list_field_visual();
		$get_field_non_visual = $this->customerclaim_model->list_field_non_visual();
		$get_customer_claim = $this->customerclaim_model->get_customer_claim();
		$listing_deliv = $this->delivery_model->listing_deliv();
		$count_customer_claim = count($get_customer_claim);
		$count_deliv = count($listing_deliv);
		$key_visual = [];
		$key_non_visual = [];
		$value_visual = ['Kotor', 'Lecet', 'Tipis', 'Meler', 'Nyerep', 'O Peel', 'Buram', 'Over Cut',
					'Burry', 'Belang', 'Ngeflek', 'Minyak', 'Dustray', 'Cat Kelupas', 'Bintik Air', 
					'Finishing Ng', 'Serat', 'Demotograph', 'Lifting', 'Kusam', 'Flow Mark', 'Legok',
					'Salah Type', 'Getting', 'Part Campur', 'Sinmark', 'Gores', 'Gloss', 'Patah Depan',
					'Patah Belakang', 'Patah Kanan', 'Patah Kiri', 'Silver', 'Burn Mark', 'Weld Line',
					'Bubble', 'Black Dot', 'White Dot', 'Isi Tidak Set', 'Gompal', 'Salah label', 'Sobek terkena cutter',
					'Terbentur (Sobek handling)', 'Kereta (Sobek handling)', 'Terjatuh (Sobek handling)', 'Terkena Gun (Sobek handling)',
					'Sobek Handling', 'Sobek Staples', 'Staples Lepas', 'Keriput', 'Seaming Ng', 'Nonjol', 'Seal Lepas', 'Cover Ng',
					'Belum Finishing', 'Foam Ng'];
		$value_non_visual = ['Deformasi', 'Patah / Crack', 'Part Tidak Lengkap', 'Elector Mark', 'Short Shot', 'Material Asing',
					'Pecah', 'Stay Lepas', 'Salah Ulir', 'Visual T/A', 'Ulir Ng', 'Rubber TA', 'Hole Ng'];
		
		for($i = 1; $i < count($get_field_visual); $i++) {
			$key_visual[] = json_encode($get_field_visual[$i]);
		}
		$label_visual = array_combine($key_visual, $value_visual);
		for($i = 1; $i < count($get_field_non_visual); $i++) {
			$key_non_visual[] = json_encode($get_field_non_visual[$i]);
		}
		$label_non_visual = array_combine($key_non_visual, $value_non_visual);
		$mergeField = array_merge($get_field_visual, $get_field_non_visual);
		$merge_field_except = [];
		for($i = 0; $i < count($mergeField); $i++) {
			if($mergeField[$i] == "id_customer_claim") {
				continue;
			}
			$merge_field_except[] = $mergeField[$i];
		}
		$mergeLabel = array_merge($label_visual, $label_non_visual);
		$count_merge_field = count($merge_field_except);
		$status = $_GET['status_claim'];
		$customer = $_GET['ganti_customer'];
		$part = $_GET['ganti_part'];
		$proses = $_GET['proses'];
		$daily_year = $_GET['daily_year'];
		$daily_month = $_GET['daily_month'];
		if($status != null) {
			$status = $status;
		} else {
			$status = null;
		}

		if($proses != null) {
			$proses = $proses;
		} else {
			$proses = null;
		}

		if($customer != null) {
			$customer = $customer;
		} else {
			$customer = null;
		}

		if($part != null) {
			$part = $part;
		} else {
			$part = null;
		}

		if($daily_year != null) {
			$tahun = $daily_year;
		} else {
			$tahun = date('Y');
		}

		if($daily_month != null) {
			$current_month = intval(date('m', strtotime("$daily_month-$tahun")));
		} else {
			$curr_month = date('M-Y');
			$current_month = intval(date('m', strtotime("$curr_month")));
		}

		$previous_month = $current_month;
		$daily = [];
		$linked = [];
		$defects = [];
		$ppm = [];
		for($tgl = 0; $tgl <= 30; $tgl++) {
			if($previous_month != $current_month) {
				break;
			}
			$temp = [];
			$dailySum = 0;
			$year_month = strtotime("$tahun-$current_month");
			$fullDate = date("Y-m-d", strtotime("+$tgl day", $year_month));
			$day = date('d', strtotime($fullDate));
			$current_month = intval(date("m", strtotime("+$tgl day", $year_month)));
			if($current_month == $previous_month) {
				$daily_filter = $this->customerclaim_model->daily_filter($fullDate, $status, $customer, $proses, $part);
				$daily_delivery = $this->delivery_model->daily_ppm("$tahun-$current_month-$day");
				$count_daily_filter = count($daily_filter);
				for($i = 0; $i < $count_daily_filter; $i++) {
					if(!empty($daily_filter[$i])) {
						for($j = 0; $j < $count_merge_field; $j++) { 
							$field = $merge_field_except[$j];
							if($daily_filter[$i]->$field > 0) {
								$dailySum += $daily_filter[$i]->$field;
							}
						}
					}
				}

				for($i = 0; $i < $count_merge_field; $i++) {
					$defectSum = 0;
					for($j = 0; $j < $count_daily_filter; $j++) {
						if(!empty($daily_filter[$j])) {
							$field = $merge_field_except[$i];
							if($daily_filter[$j]->$field > 0) {
								$defectSum += $daily_filter[$j]->$field;
								$temp[$mergeLabel[json_encode($field)]] = $defectSum;
							}
						}
					}
					arsort($temp);
				}

				if($daily_delivery->total_qty != null && $daily_delivery->total_qty > 0) {
					$calculate_ppm = (int)$daily_delivery->total_qty;
				} else {
					$calculate_ppm = 0;
				}

				$ppm[] = $calculate_ppm;
				$daily[$day] = $dailySum;
				$linked[] = "$day";
				$defects[] = $temp;
			}
		}
		$data = array(
			"daily" => $daily,
			"tahun" => $tahun,
			"linked" => $linked,
			"defects" => $defects,
			"ppm" => $ppm,
			"bulan" => date("M"),
			"count_customer_claim" => $count_customer_claim,
			"count_deliv" => $count_deliv
		);
		echo json_encode($data);
	}
}