<?php
ini_set("allow_url_fopen", 1);
defined('BASEPATH') or exit('No direct script access allowed');
require_once('application/controllers/Main_controller.php');

/************************************************************
 * ! Comments by Phanuwat
 *  ? สามารถนำ Keywords ไปค้นหาข้อมูลที่ต้องการได้นะครับ
 *  TODO: 
 *  TODO: 
 ************************************************************/
class C_stock_location extends Main_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("M_stock_location", "msl");
    }
    public function index() //หน้าแสดงผล
    {
        $data['type_location'] = $this->msl->get_stock_location_type();
        $this->output('stock_location/v_stock_location', $data);
    }

    public function insert_stock_location()
    {
        $code_id = $this->input->post('code_id');
        $sl_area = $this->input->post('sl_area');
        $sl_location = $this->input->post('sl_location');
        $sl_distribution = $this->input->post('sl_distribution');
        $sl_amount = $this->input->post('sl_amount');
        $empcode = $this->session->userdata('UsEmpCode');
        $data_cid = $this->msl->get_data_express($code_id);
        $cid = $data_cid[0]['CID'];

        $error = 0;
        $error_area = [];
        $error_locations = []; // เก็บชั้นจัดเก็บที่ที่ซ้ำ

        if (empty($sl_distribution)) {
            $sl_distribution = array_fill(0, count($sl_location), '1'); // ตั้งค่าเริ่มต้นให้กับ `sl_distribution`
        }
        foreach ($sl_location as $i => $location) {
            foreach ($sl_area as $i => $area) {
                $check_duplicate = $this->msl->get_duplicate($area, $location, $cid);

                if (empty($check_duplicate)) {
                    $data = array(
                        'sl_cid' => $cid,
                        'sl_code_id' => $code_id,
                        'sl_area' => $area,
                        'sl_location' => $location,
                        'sl_amount' => $sl_amount[$i],
                        'sl_distribution' => $sl_distribution[$i],
                        'sl_status' => '1',
                        'sl_cr_empcode' => $empcode,
                        'sl_cr_datetime' => date("Y-m-d H:i:s")
                    );

                    $this->msl->insert_stock_location($data);
                } else {
                    $error++;
                    $error_area[] = $area;
                    $error_locations[] = $location;
                }
            }
            if ($error == 0) {
                echo json_encode(array("success" => true, "message" => "บันทึกข้อมูลเรียบร้อย"));
            } else {
                echo json_encode(array("success" => false, "message" => "มีข้อมูลซ้ำ : " . implode(', ', $error_locations)));
            }
        }
    }
    public function get_data_location()
    {
        $codeID = $this->input->post('code_id');
        $get_data = $this->msl->get_data_stock_location($codeID);
        echo '<table class="table table-bordered">
            <tr style="text-align :center;">
            <th>ลำดับ</th>
            <th>สถานที่</th>
            <th>ชั้นจัดเก็บ</th>
            <th>จำนวนสูงสุด (ต่อการจัดเก็บ)</th>
            <th>จุดจ่ายสินค้า</th>
            <th>เครื่องมือ</th>
            </tr>';
        foreach ($get_data as $key => $data) {
            $isChecked = $data['sl_distribution'] == '2' ? 'checked' : '';
            echo '

            <tr class="detail">
            <td> <span name="" data-toggle="tooltip" autocomplete="off" >' . ($key + 1) . '</span></td>
            <td> <span name="" data-toggle="tooltip" autocomplete="off" >' . $data['sly_name'] . ' </span></td>
            <td> <span name="" data-toggle="tooltip" autocomplete="off" >' . $data['sl_location'] . ' </span></td>
            <td> <span name="" data-toggle="tooltip" autocomplete="off" >' . $data['sl_amount'] . ' </span></td>
            <td> 
            <input type="checkbox" class="form-control" id="" name="" value="' . $data['sl_distribution'] . '" ' . $isChecked . ' disabled>
            </td> 
            <td>
                <button style="text-align :center;" id="btedit" class="btn btn-warning edit-btn" type="button" data-location-id="' . $data['sl_id'] . '"data-sl-area="' . $data['sl_area'] . '" data-sl-distribution="' . $data['sl_distribution'] . '" data-sl-location="' . $data['sl_location'] . '" data-sl-amount="' . $data['sl_amount'] . '"><i class="fas fa-pencil-alt"></i></button>
                <button style="text-align :center;" id="btdelete" class="btn btn-danger delete-data" data-location-id="' . $data['sl_id'] . '" type="button"><i class="fa fa-trash"></i></button>
            </td>
            </tr> ';
        }
    }
    public function delete_stock_location()
    {
        $code_id = $this->input->post('code_id');
        $empcode = $this->session->userdata('UsEmpCode');

        $data = array(
            'sl_status' => 0, //สถานะ 0 ไม่ใช้งาน แต่ไม่ได้ลบข้อมูล
            'sl_log_empcode' => $empcode,
            'sl_log_datetime' => date("Y-m-d H:i:s")
        );
        $this->msl->update_stock_location($code_id, $data);
        echo json_encode(array("success" => true));
    }

    //------------------------------------------------------------------
    public function update_stock_location()
    {
        $sl_id = $this->input->post('code_id');
        $sl_area = $this->input->post('sl_area');
        $sl_location = $this->input->post('sl_location');
        $sl_distribution = $this->input->post('sl_distribution');
        $sl_amount = $this->input->post('sl_amount');
        $empcode = $this->session->userdata('UsEmpCode');

        $check_duplicate = $this->msl->check_duplicate_on_update($sl_area, $sl_location, $sl_id);
        if (!$sl_distribution) {
            $sl_distribution = '1';
        }
        // echo $sl_area;

        if (empty($check_duplicate)) {
            $data = array(
                'sl_area' => $sl_area,
                'sl_location' => $sl_location,
                'sl_amount' => $sl_amount,
                'sl_distribution' => $sl_distribution,
                'sl_log_empcode' => $empcode,
                'sl_log_datetime' => date("Y-m-d H:i:s")
            );
            // var_dump($code_id, $sl_area, $sl_location);
            $this->msl->update_stock_location($sl_id, $data);
            echo json_encode(array("success" => true));
        } else {

            echo json_encode(array("success" => false, "message" => "มีข้อมูลซ้ำ"));
        }
    }

    // public function create()
    // {
    //     $data['location_types'] = $this->msl->get_stock_location_types();
    //     $this->output('v_stock_location', $data);
    // }
}
