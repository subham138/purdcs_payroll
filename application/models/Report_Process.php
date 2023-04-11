<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_Process extends CI_Model
{

	public function f_get_particulars($table_name, $select = NULL, $where = NULL, $flag)
	{

		if (isset($select)) {

			$this->db->select($select);
		}

		if (isset($where)) {

			$this->db->where($where);
		}

		$result		=	$this->db->get($table_name);

		if ($flag == 1) {

			return $result->row();
		} else {

			return $result->result();
		}
	}


	public function f_get_particulars_in($table_name, $where_in = NULL, $where = NULL)
	{

		if (isset($where)) {

			$this->db->where($where);
		}

		if (isset($where_in)) {

			$this->db->where_in('emp_no', $where_in);
		}

		$result	=	$this->db->get($table_name);

		return $result->result();
	}
	public function f_edit($table_name, $data_array, $where)
	{

		$this->db->where($where);
		$this->db->update($table_name, $data_array);

		return;
	}

	//For inserting row
	public function f_insert($table_name, $data_array)
	{

		$this->db->insert($table_name, $data_array);

		return;
	}

	//For Deliting row
	public function f_delete($table_name, $where)
	{

		$this->db->delete($table_name, $where);

		return;
	}

	public function f_get_totaldeduction($from_date, $to_date)
	{
		$this->db->select('a.emp_code, SUM(a.pf) pf, SUM(a.loan_prin)loan_prin, SUM(a.loan_int)loan_int,
		 SUM(a.p_tax)p_tax, SUM(a.gici)gici, SUM(a.income_tax_tds)income_tax_tds, SUM(a.security) security, SUM(a.insurance) insurance, 
		  SUM(a.tot_diduction)tot_diduction, b.emp_name');
		$this->db->where(array(
			'a.emp_code=b.emp_code' => null,
			'a.sal_month BETWEEN ' . date('m', strtotime($from_date)) . ' AND ' . date('m', strtotime($to_date)) => null
		));
		$this->db->group_by('a.emp_code');
		$query = $this->db->get('td_pay_slip a, md_employee b');
		return $query->result();
	}

	public function f_get_totalearning($from_date, $to_date)
	{
		$this->db->select('a.emp_code, SUM(a.da) da, SUM(a.sa) sa, SUM(a.hra) hra, SUM(a.ta) ta, 
		SUM(a.da_on_sa) da_on_sa, SUM(a.da_on_ta) da_on_ta, SUM(a.ma) ma, SUM(a.cash_swa) cash_swa, b.emp_name, SUM(a.lwp) lwp, SUM(a.final_gross) final_gross');
		$this->db->where(array(
			'a.emp_code=b.emp_code' => null,
			'a.sal_month BETWEEN ' . date('m', strtotime($from_date)) . ' AND ' . date('m', strtotime($to_date)) => null
		));
		$this->db->group_by('a.emp_code');
		$query = $this->db->get('td_pay_slip a, md_employee b');
		return $query->result();
	}

	public function f_get_emp_dtls($empno, $sal_month, $sal_yr)
	{

		$result = $this->db->query("select a.trans_date, a.trans_no, a.sal_month, a.sal_year, a.emp_code, 
			a.catg_id, a.basic, a.da, a.sa, a.hra, a.ta, a.da_on_sa, a.da_on_ta, a.ma, a.cash_swa, a.lwp, a.final_gross, 
			a.pf, a.loan_prin, a.loan_int, a.p_tax, a.gici, a.income_tax_tds, 
			a.security, a.insurance, a.other_did, a.tot_diduction, a.net_sal, a.remarks, b.emp_name,c.name designation,b.phn_no,b.department,b.pan_no, b.grade, b.ret_dt, b.dob, b.bank_ac_no
			  from 
			  td_pay_slip a,md_employee b, md_designation c where a.emp_code=b.emp_code and b.designation=c.id AND a.emp_code = $empno
			  and a.sal_month=$sal_month and a.sal_year=$sal_yr ");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}


	public function f_count_emp($emp_code)
	{

		$result = $this->db->query("select count(*)count_emp from md_employee where emp_code = $emp_code");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}
}
