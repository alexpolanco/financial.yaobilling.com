<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Company_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->get('company')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('company_id',$id);
		return $this->db->get('company')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('customer_is_active'=>$mode);
		$this->db->where('company_id',$id);
		$this->db->update('company',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

			'company_name' => $this->input->post('txt_company_name'),
			'company_rnc' => $this->input->post('txt_company_rnc'),
			'company_city' => $this->input->post('txt_company_city'),
			'company_address' => $this->input->post('txt_company_address'),
			'company_email' => $this->input->post('txt_company_email'),
			'company_url' => $this->input->post('txt_company_url'),
			'company_slogan' => $this->input->post('txt_company_slogan'),

			'LegalName' => $this->input->post('txtLegalName'),
			'LegalName_PersonalId' => $this->input->post('txtLegalName_PersonalId'),
			'LegalName_Occupation' => $this->input->post('txtLegalName_Occupation'),
			'LegalName_Sex' => $this->input->post('txtLegalName_Sex'),
			'LegalName_CivilStatus' => $this->input->post('txtLegalName_CivilStatus'),
			'LegalName_Nationality' => $this->input->post('txtLegalName_Nationality'),
			'LegalName_Address' => $this->input->post('txtLegalName_Address'),

			'WitnessName1' => $this->input->post('txtWitness1'),
			'Witness1_PersonalId' => $this->input->post('txtWitness1_PersonalId'),
			'Witness1_Occupation' => $this->input->post('txtWitness1_Occupation'),
			'Witness1_Sex' => $this->input->post('txtWitness1_Sex'),
			'Witness1_CivilStatus' => $this->input->post('txtWitness1_CivilStatus'),
			'Witness1_Nationality' => $this->input->post('txtWitness1_Nationality'),
			'Witness1_Address' => $this->input->post('txtWitness1_Address'),

			'WitnessName2' => $this->input->post('txtWitness2'),
			'Witness2_PersonalId' => $this->input->post('txtWitness2_PersonalId'),
			'Witness2_Occupation' => $this->input->post('txtWitness2_Occupation'),
			'Witness2_Sex' => $this->input->post('txtWitness2_Sex'),
			'Witness2_CivilStatus' => $this->input->post('txtWitness2_CivilStatus'),
			'Witness2_Nationality' => $this->input->post('txtWitness2_Nationality'),
			'Witness2_Address' => $this->input->post('txtWitness2_Address'),

			'company_image' => $this->input->post('txt_company_image'),
			'company_vat_no' => $this->input->post('txt_company_vat_no'),
			'company_cst_no' => $this->input->post('txt_company_cst_no'),
			'company_gst_no' => $this->input->post('txt_company_gst_no'),
			'recipe_print' => $this->input->post('txt_recipe_print'),
			'currency' => $this->input->post('txt_currency'),
			'currency_symbol' => $this->input->post('txt_currency_symbol'),
			'sales_tax1' => $this->input->post('txt_sales_tax1'),
			'sales_tax2' => $this->input->post('txt_sales_tax2'),
			'sales_tax3' => $this->input->post('txt_sales_tax3'),
			'total_table' => $this->input->post('txt_total_table'),
			'total_parcel' => $this->input->post('txt_total_parcel'),
			'sms' => $this->input->post('txt_sms'),
			'sms_api' => $this->input->post('txt_sms_api'),

			'Lawyer_Name' => $this->input->post('txtLawyer_Name'),
			'Lawyer_PersonalId' => $this->input->post('txtLawyer_PersonalId'),
			'Lawyer_CivilStatus' => $this->input->post('txtLawyer_CivilStatus'),
			'Lawyer_City' => $this->input->post('txtLawyer_City'),
			'Lawyer_Nationality' => $this->input->post('txtLawyer_Nationality'),
			'Lawyer_Address' => $this->input->post('txtLawyer_Address'),
			'Lawyer_Matricula' => $this->input->post('txtLawyer_Matricula'),
			'Lawyer_NotaryNumber' => $this->input->post('txtLawyer_NotaryNumber'),

			'company_terms' => $this->input->post('txt_company_terms'),
			'backup_time' => $this->input->post('txt_backup_time'),
			'company_is_active' => $this->input->post('txt_company_is_active'),
			'create_date' => $this->input->post('txt_create_date'),
			'company_phone' => $this->input->post('txt_company_phone'),

        );
        
        if ($id == 0) {
            return $this->db->insert('company', $data);
        } else {
            $this->db->where('company_id', $id);
            return $this->db->update('company', $data);
        }
	}
		
	public function update($id)
	{
		if($this->input->post('chkdelete_logo') == 'yes')
		{
			$data=array('company_image'=>'');
			$this->db->where('company_id',$id);
			$this->db->update('company',$data);
		}
		

		$data = array(

			'company_name' => $this->input->post('txtfirst_name'),
			'company_rnc' => $this->input->post('txtRNC'),
			'company_city' => $this->input->post('txtcity'),
			'company_address' => $this->input->post('txtaddress'),
			'company_email' => $this->input->post('txt_company_email'),
			'company_url' => $this->input->post('txt_company_url'),
			'company_slogan' => $this->input->post('txt_company_slogan'),
		
			'LegalName' => $this->input->post('txtLegalName'),
			'LegalName_PersonalId' => $this->input->post('txtLegalName_PersonalId'),
			'LegalName_Occupation' => $this->input->post('txtLegalName_Occupation'),
			'LegalName_Sex' => $this->input->post('txtLegalName_Sex'),
			'LegalName_CivilStatus' => $this->input->post('txtLegalName_CivilStatus'),
			'LegalName_Nationality' => $this->input->post('txtLegalName_Nationality'),
			'LegalName_Address' => $this->input->post('txtLegalName_Address'),
			
			'WitnessName1' => $this->input->post('txtWitnessName1'),
			'Witness1_PersonalId' => $this->input->post('txtWitness1_PersonalId'),
			'Witness1_Occupation' => $this->input->post('txtWitness1_Occupation'),
			'Witness1_Sex' => $this->input->post('txtWitness1_Sex'),
			'Witness1_CivilStatus' => $this->input->post('txtWitness1_CivilStatus'),
			'Witness1_Nationality' => $this->input->post('txtWitness1_Nationality'),
			'Witness1_Address' => $this->input->post('txtWitness1_Address'),

			'WitnessName2' => $this->input->post('txtWitnessName2'),
			'Witness2_PersonalId' => $this->input->post('txtWitness2_PersonalId'),
			'Witness2_Occupation' => $this->input->post('txtWitness2_Occupation'),
			'Witness2_Sex' => $this->input->post('txtWitness2_Sex'),
			'Witness2_CivilStatus' => $this->input->post('txtWitness2_CivilStatus'),
			'Witness2_Nationality' => $this->input->post('txtWitness2_Nationality'),
			'Witness2_Address' => $this->input->post('txtWitness2_Address'),

			'company_vat_no' => $this->input->post('txtvat_no'),
			'company_cst_no' => $this->input->post('txtcst_no'),
			'company_gst_no' => $this->input->post('txtgst_no'),
			'recipe_print' => $this->input->post('chkprint_logo'),
			'currency' => $this->input->post('cur'),
			'currency_symbol' => $this->input->post('cur_symbol'),
			'sales_tax1' => $this->input->post('txtsales_tax1'),
			'sales_tax2' => $this->input->post('txtsales_tax2'),
			'sales_tax3' => $this->input->post('txtsales_tax3'),
			'total_table' => $this->input->post('txttable'),
			'total_parcel' => $this->input->post('txtparcel'),
			'sms' => $this->input->post('chksms'),
			'sms_api' => $this->input->post('txtsmsapi'),
			
			'Lawyer_Name' => $this->input->post('txtLawyer_Name'),
			'Lawyer_PersonalId' => $this->input->post('txtLawyer_PersonalId'),
			'Lawyer_CivilStatus' => $this->input->post('txtLawyer_CivilStatus'),
			'Lawyer_City' => $this->input->post('txtLawyer_City'),
			'Lawyer_Nationality' => $this->input->post('txtLawyer_Nationality'),
			'Lawyer_Address' => $this->input->post('txtLawyer_Address'),
			'Lawyer_Matricula' => $this->input->post('txtLawyer_Matricula'),
			'Lawyer_NotaryNumber' => $this->input->post('txtLawyer_NotaryNumber'),

			'company_terms' => $this->input->post('txtterms'),
			'company_phone' => $this->input->post('txt_company_phone')

        );
        
        
            $this->db->where('company_id', $id);
            return $this->db->update('company', $data);
        
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('company_image'=>$file_name);
		$this->db->where('company_id',$id);
		$this->db->update('company',$data);
	}

	public function remove($ids)
	{
		$this->db->where('company_id',$ids);
		$this->db->delete('company');
	}
 } 
 

?>