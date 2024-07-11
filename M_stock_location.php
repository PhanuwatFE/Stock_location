<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stock_location extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->engineer_utah = $this->load->database("engineer_utah", TRUE);
		$this->express = $this->load->database("express", TRUE); //ดึงฐานตารางข้อมูล
		$this->engineer_utah_db = $this->config->item('engineer_utah_db');
	}

	public function insert_stock_location($data)
	{
		$this->db->insert('stock_location', $data);
	}

	public function get_data_express($code_id)
	{
		$this->express->select('*');
		$this->express->from('code');
		$this->express->where('codeID LIKE', $code_id);
		$this->express->order_by('CID', 'DESC');

		// Execute the query
		$query = $this->express->get();

		// Get the result
		$results = $query->result_array();
		return $results;
	}
	//ลบข้อมูลตาราง
	public function get_delete_data($code_id)
	{
		$this->db->select('*');
		$this->db->from('code');
		$this->db->where('codeID LIKE', $code_id);
		$this->db->where('CID', 'DESC');
		// Execute the query
		$query = $this->express->get();

		// Get the result
		$results = $query->result_array();
		return $results;
	}
	//เช็คค่าซ้ำ
	public function get_duplicate($sl_area, $sl_location, $cid)
	{
		$this->db->select('*');
		$this->db->from('stock_location');
		$this->db->where('sl_CID', $cid);
		$this->db->where('sl_area', $sl_area);
		// $this->db->where('sl_distribution', 1);	
		$this->db->where('sl_location', $sl_location);
		$this->db->where('sl_status', 1);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	//ดึงข้อมูล
	public function get_data_stock_location($code_id)
	{  //ดึงข้อมูลจาก databased_stock_location
		$this->db->select('*');
		$this->db->from('stock_location');
		$this->db->join('stock_location_type','sl_area = sly_id' ,'left');
		$this->db->where('sl_code_id', $code_id);
		$this->db->where('sl_status', 1);
		$query = $this->db->get()->result_array();
		return $query;
	}
	//แก้ไขข้อมูล
	public function update_stock_location($code_id, $data)
	{
		$this->db->where('sl_id', $code_id);
		$this->db->update('stock_location', $data);
	}
	//ลบข้อมูล
	public function delete_stock_location($code_id)
	{
		$this->db->where('sl_id', $code_id);
		$this->db->delete('stock_location');
	}
	//----------------------------------------------------------------
	//เช็คขอมูลซ้ำใน modal edit
	// public function check_duplicate_on_update($sl_area, $sl_location, $code_id)
	// {
	// 	$this->db->where('sl_area', $sl_area);
	// 	$this->db->where('sl_location', $sl_location);
	// 	$this->db->where('sl_id !=', $code_id);
	// 	$query = $this->db->get('stock_location');
	// 	return $query->row();
	// }

	public function check_duplicate_on_update($sl_area, $sl_location, $sl_id)
	{
		// ตรวจสอบว่ามีข้อมูลอื่นที่มีพื้นที่และชั้นจัดเก็บเดียวกัน แต่ ID ไม่เหมือนกับที่กำลังอัปเดต
		$this->db->select('*'); // เลือกทุกฟิลด์
		$this->db->from('stock_location'); // จากตาราง `stock_location`
		$this->db->where('sl_area', $sl_area); // เงื่อนไขพื้นที่
		$this->db->where('sl_location', $sl_location); // เงื่อนไขชั้นจัดเก็บ
		$this->db->where('sl_status', 1); // เงื่อนไขเฉพาะสถานะที่ใช้งานอยู่
		$this->db->where('sl_id !=', $sl_id); // ไม่เลือก ID ของรายการที่กำลังอัปเดต

		$query = $this->db->get(); // รันคำสั่ง
		return $query->row(); // ส่งแถวแรกที่ตรงกับเงื่อนไข (หากมี) หรือ `null` หากไม่พบ
	}
	// public function get_stock_location_types()
	// {
	// 	$this->db->select('sly_id, sly_name');
	// 	$this->db->from('stock_location_type');
	// 	$query = $this->db->get();
	// 	return $query->result_array();
	// }

	public function get_stock_location_type()
	{
		$this->db->select('*');
		$this->db->from('stock_location_type');
		$this->db->where('sly_usage', '1');
		$query = $this->db->get();
		return $query;
	}
}
