<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('CronRunner');
	}

	public function index()
	{
		if ($this->input->is_cli_request())
		{
			show_error('Direct access is not allowed');
			return;
		}
	}

	public function run() 
	{
		//$cron = new CronRunner();
		$this->cronrunner->run();
	}

	public function company() 
	{
		//$this->db->where('id',1);
		$this->db->update('cron', array('last_run_at' => 'now()', 'notes' => 'Nota del '+date('d-m-Y')));
	}

}