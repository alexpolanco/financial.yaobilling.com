<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();

		$this->user_id = $this->session->userdata('userid');
		$this->company_id = $this->session->userdata('company_id');
    }

    public function check_rights()
    {
        $this->db->where('user_id',$this->session->userdata('userid'));
        $data = $this->db->get('rights')->result();

        $user_rights = array();

        foreach ($data as $value) {
            $user_rights[] = $value->rights;
        }

        return $user_rights;
    }

    /*  */
	public function getTotalEventsLoans()
	{
		$sql = "SELECT COUNT(o.customer_id) fixed FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE c.company_id = $this->company_id";
		$loansfixed = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) capital FROM loanscapital o JOIN customer c ON o.customer_id = c.customer_id WHERE c.company_id = $this->company_id";
		$loanscapital = $this->db->query($sql)->row_array();
		
		$sql = "SELECT COUNT(o.customer_id) inversion FROM loansinversion o JOIN customer c ON o.customer_id = c.customer_id WHERE c.company_id = $this->company_id";
		$loansinversion = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) christmas FROM loanschristmas o JOIN customer c ON o.customer_id = c.customer_id WHERE c.company_id = $this->company_id";
		$loanschristmas = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) quickbusiness FROM loansquickbusiness o JOIN customer c ON o.customer_id = c.customer_id WHERE c.company_id = $this->company_id";
		$loansquickbusiness= $this->db->query($sql)->row_array();

		$query = ($loansfixed['fixed'] + $loanscapital['capital'] + $loansinversion['inversion'] + $loanschristmas['christmas'] + $loansquickbusiness['quickbusiness']);
		//$query = ($loansfixed + $loanscapital + $loansinversion + $loanschristmas + $loansquickbusiness);

		return $query;
	}
	
	/* get all the events data by the given date */
	public function getTotalEventsLoansDue()
	{
		$sql = "SELECT COUNT(o.customer_id) fixed FROM loansfixed o LEFT OUTER JOIN loansfixed_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id";
		$loansfixed = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) capital FROM loanscapital o LEFT OUTER JOIN loanscapital_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id";
		$loanscapital = $this->db->query($sql)->row_array();
		
		$sql = "SELECT COUNT(o.customer_id) inversion FROM loansinversion o LEFT OUTER JOIN loansinversion_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id";
		$loansinversion = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) christmas FROM loanschristmas o LEFT OUTER JOIN loanschristmas_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id";
		$loanschristmas = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) quickbusiness FROM loansquickbusiness o LEFT OUTER JOIN loansquickbusiness_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id";
		$loansquickbusiness= $this->db->query($sql)->row_array();
					
		$query = ($loansfixed['fixed'] + $loanscapital['capital'] + $loansinversion['inversion'] + $loanschristmas['christmas'] + $loansquickbusiness['quickbusiness']);
		//$query = ($loansfixed + $loanscapital + $loansinversion + $loanschristmas + $loansquickbusiness);

		return $query;
	}
	
	/* get all the events data by the given date */
	public function getTotalEventsPayments()
	{
		$sql = "SELECT COUNT(o.customer_id) fixed FROM loansfixed o JOIN loansfixed_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id";
		$loansfixed = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) capital FROM loanscapital o JOIN loanscapital_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id";
		$loanscapital = $this->db->query($sql)->row_array();
		
		$sql = "SELECT COUNT(o.customer_id) inversion FROM loansinversion o JOIN loansinversion_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id";
		$loansinversion = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) christmas FROM loanschristmas o JOIN loanschristmas_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id";
		$loanschristmas = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(o.customer_id) quickbusiness FROM loansquickbusiness o JOIN loansquickbusiness_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id";
		$loansquickbusiness= $this->db->query($sql)->row_array();

		$query = ($loansfixed['fixed'] + $loanscapital['capital'] + $loansinversion['inversion'] + $loanschristmas['christmas'] + $loansquickbusiness['quickbusiness']);
		//$query = ($loansfixed + $loanscapital + $loansinversion + $loanschristmas + $loansquickbusiness);

		return $query;
	}

}


?>