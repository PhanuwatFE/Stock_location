<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<title>สินค้า</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css" rel="stylesheet" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
if (!empty($get_code_data)) {
    $codeData   =   $get_code_data->row();
}
$arr_aut    =   array('4260', '4200', '4250');
?>

<head>
    <style>
        .active {
            color: #263d1f;
        }

        fieldset {
            font-size: 1em;
            padding: 0.5em;
            background-color: #d9edff;
            border-radius: 10px 10px 10px 10px;
            border: 2px solid #1F1717;
        }

        legend {
            padding: 0.25em 1em;
            background-color: #25a8bc;
            border-radius: 1em;
            width: auto;
            margin-bottom: 5px;
            text-align: left;
            font-size: 14pt;
        }

        #fullcolor {
            background: linear-gradient(to right, #198ae3, #57c7d4);
            color: white;
        }

        #btadd {
            background: linear-gradient(to right, #3BDA00, #00CA26);
        }

        #btedit {
            background: linear-gradient(to right, #FFC300, #F6E700);
        }

        #btdelete {
            background: linear-gradient(to right, #BF0000, #FF5733);
        }

        #submit {
            background: linear-gradient(to right, #00930A, #2BB434);
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td,
        th,
        table {
            margin: 20px;
            /* padding: 10em 10em; */
        }

        .second-table {
            width: 100%;
        }

        .second-table th,
        .second-table td {
            text-align: center;
        }
    </style>
</head>
<div id="existing_data_table">
    <!-- ข้อมูลที่ดึงมาจากฐานข้อมูลจะถูกแสดงที่นี่ -->
</div>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow" style="min-height: 850px;">
            <div class="card-header bg-gradient-info pt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 style='font-family: "K2D" !important;'>
                            <b>ที่จัดเก็บสินค้า</b>
                        </h5>
                    </div>
                </div>
            </div>

            <body>
                <div class="container" style="width: 100%;">
                    <form id="insertForm" action="<?php echo site_url(); ?>/C_stock_location/insert_stock_location" method="POST"> <!-- เรียกใช้การส่งข้อมูล -->
                        <div class="row">

                            <table class="table table-bordered">
                                <tr>
                                    <th id="fullcolor" class="CID" style="text-align :center;">
                                        <h3>รหัสสินค้า</h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <select name="code_id" id="code_id" class="select2_codeID" required>
                                            <option value="">กรุณาเลือก</option>
                                        </select>

                                    </th>
                                </tr>
                                <table class="table table-bordered second-table" id="data_detail">
                                    <!-- ข้อมูลที่ดึงค่ามาจากรหัสสินค้า code_id -->
                                </table>
                                <table class="table table-bordered second-table " id="specificSecondTable">
                                    <thead>
                                        <tr>
                                            <th id="fullcolor" colspan="6">
                                                <h3>เพิ่มข้อมูล</h3>
                                            </th>
                                        </tr>
                                        <tr style="text-align :center;">
                                            <th>ลำดับ</th>
                                            <th>สถานที่</th>
                                            <th>ชั้นจัดเก็บ</th>
                                            <th>จำนวนสูงสุด (ต่อการจัดเก็บ)</th>
                                            <th>จุดจ่ายสินค้า</th>
                                            <th>เครื่องมือ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="index">1</span></td>
                                            <td>
                                                <!-- <input type="text" class="form-control " placeholder="สถานที่จัดเก็บ" name="sl_area[]" required> -->
                                                <select name="sl_area[]" id="" class="form-control">
                                                    <option value="">----กรุณาเลือกที่จัดเก็บ----</option>
                                                    <?php
                                                    foreach ($type_location->result() as $type_1) {
                                                        echo "<option value='" . $type_1->sly_id . "'>" . $type_1->sly_name . "";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <!-- <td>
                                                <select class="form-control" name="sl_type" id="sl_type">
                                                    <option value="">กรุณาเลือกสถานที่</option>
                                                    <php foreach ($location_types as $type) : ?>
                                                        <option value="?= $type['sly_id'] ?>">?= $type['sly_name'] ?></option>
                                                    ?php endforeach; ?>
                                                </select>
                                            </td> -->
                                            <td><input type="text" class="form-control " placeholder="ชั้นจัดเก็บ" name="sl_location[]" required></td>
                                            <td><input type="text" class="form-control amount-input" placeholder="จำนวนที่จัดเก็บ" name="sl_amount[]" pattern="[0-9,]*" inputmode="numeric" maxlength="9" required></td>
                                            <td><input type="checkbox" class="form-control" name="sl_distribution[]"></td>

                                            <td><button class="btn btn-info add-btn" id="btadd" type="button" name="addcolum"><i class='fas fa-plus'></i></button>
                                                <!-- <button class="btn btn-danger delete-btn" type="button" name="deletecolum"><i class="fa fa-trash"></i></button> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                        <div class="grid text-center">
                            <div class="g-col-4 g-start-6"> <button class="btn btn-success" id="savedata" style="width:100%;text-align:center;" type="submit"><i class='far fa-check-circle'></i> บันทึกข้อมูล</button></div>
                        </div>
                        </table>
                </div>
        </div>
        </form>
        <div id="deleteConfirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">ยืนยันการลบข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ต้องการลบข้อมูลนี้ใช่หรือไม่?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">ลบข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit_location_modal" tabindex="-1" role="dialog" aria-labelledby="edit_location_modal_title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit_location_modal_title">แก้ไขข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" action="<?php echo site_url('C_stock_location/update_stock_location'); ?>" method="POST">
                            <input type="hidden" name="code_id" id="code_id_edit">
                            <div class="form-group">
                                <label for="sl_area">สถานที่:</label>
                                <!-- <input type="text" class="form-control" id="sl_area" name="sl_area" required> -->
                                <select name="sl_area" id="sl_area" class="form-control">
                                    <option value="">----กรุณาเลือกที่จัดเก็บ----</option>
                                    <?php
                                    foreach ($type_location->result() as $type_1) {
                                        echo "<option value='" . $type_1->sly_id . "'>" . $type_1->sly_name . "";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sl_location">ชั้นจัดเก็บ:</label>
                                <input type="text" class="form-control" id="sl_location" name="sl_location" required>
                            </div>
                            <div class="form-group">
                                <label for="sl_amount">จำนวน (ชิ้น):</label>
                                <input type="text" class="form-control" id="sl_amount" name="sl_amount" required>
                            </div>
                            <div class="form-group">
                                <label for="sl_distribution">จุดจ่ายสินค้า:</label>
                                <input type="checkbox" class="form-control" id="sl_distribution" name="sl_distribution" value="2">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-warning">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
<script>
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap 4 JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Fancybox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<!-- Custom JavaScript -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
<script>
    // JavaScript สำหรับเพิ่มแถวและลบแถว
    $(document).ready(function() {
        var rowCount = $("#specificSecondTable tbody tr").length + 1;
        // console.log(rowCount);
        $(document).on("click", ".add-btn", function() {
            var newRow = $("<tr></tr>");
            var rowCount = $("#specificSecondTable tbody tr").length + 1;
            // console.log(rowCount);
            newRow.append("<td><span class='index'>" + rowCount + "</span></td>");
            newRow.append(`<td>
            <select name="sl_area[]" id="sl_area" class="form-control">
                <option value="">----กรุณาเลือกที่จัดเก็บ----</option>
                <?php
                foreach ($type_location->result() as $type_1) {
                    echo "<option value='" . $type_1->sly_id . "'>" . $type_1->sly_name . "";
                }
                ?>
            </select>
            </td>`);
            newRow.append("<td><input type='text' class='form-control' placeholder='ชั้นจัดเก็บ' name='sl_location[]' required/></td>");
            newRow.append("<td><input type='text' class='form-control amount-input' placeholder='จำนวนที่จัดเก็บ' name='sl_amount[]' pattern='[0-9,]*' inputmode='numeric' maxlength='9' required></td>");
            newRow.append("<td><input type='checkbox' class='form-control' placeholder='จุดจ่ายสินค้า' name='sl_distribution[]' /></td>");
            newRow.append("<td><button type='button' id='btadd' class='btn btn-info add-btn'><i class='fas fa-plus'></i></button>  <button id='btdelete' class='btn btn-danger delete-btn'><i class='fa fa-trash'></i></button></td>");
            $(".second-table#specificSecondTable ").append(newRow);
        });

        $(".second-table").on("click", ".delete-btn", function() {
            $(this).closest("tr").remove(); // ลบแถวที่คลิกปุ่มลบ
        });
    });

    //--------------------------------------------------------------------------------------------------
    // $(document).ready(function() {
    //     $('.select2_codeID').on('change', function() {
    //         var code_id = $(this).val();
    //         $.ajax({
    //             url: '?php echo base_url(); ?>index.php/C_stock_location/get_existing_data',
    //             type: 'post',
    //             data: {
    //                 code_id: code_id
    //             },
    //             success: function(response) {
    //                 $('#existing_data_table').html(response);
    //             }
    //         });
    //     });
    // });

    $(document).ready(function() {
        $('.select2_codeID').on('change', function() {
            var code_id = $(this).val();
            $.ajax({
                url: '<?php echo site_url("C_stock_location/get_data_location"); ?>',
                type: 'post',
                data: {
                    code_id: code_id
                },
                success: function(response) {
                    $('#data_detail').html(response);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.select2_codeID').select2({
            language: {
                searching: function() {
                    return "กำลังค้นหาข้อมูล....";
                },
                noResults: function() {
                    return "ไม่พบรายการที่ค้นหา"
                },
                inputTooShort: function() {
                    return "กรุณากรอกข้อมูล";
                },
                errorLoading: function() {
                    return "";
                }
            },
            ajax: {
                url: '<?php echo base_url() ?>index.php/C_goods/search_codeID',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: $.map(response, function(obj) {
                            return {
                                id: obj.id,
                                text: obj.text
                            };
                        })
                    };
                },
                cache: true
            },
            placeholder: {
                id: "-1",
                text: "กรุณาเลือก หรือ กรอก",
            },
            tags: "true",
            allowClear: true,
            width: '100%',
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    value: true // add additional parameters
                }
            }
        });
    });

    $(document).ready(function() {
        $(document).on("click", ".delete-data", function() {
            var code_id = $(this).data('location-id');
            // console.log(code_id);
            $("#deleteConfirmationModal").modal('show');

            $("#confirmDelete").off("click").on("click", function() { //ให้ใช้ .off() เพื่อป้องกันการทำงานซ้ำซ้อน โดยการลบไว้ก่อนทำการเชื่อมต่ออีกครั้ง
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('C_stock_location/delete_stock_location'); ?>",
                    data: {
                        code_id: code_id
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            $("#deleteConfirmationModal").modal('hide');
                            updateTable();
                        } else {
                            updateTable();
                            alert("เกิดข้อผิดพลาดในการลบข้อมูล");
                        }
                    }
                });
                // console.log(code_id);
            });
        });
    });

    function updateTable() {
        $.ajax({
            url: '<?php echo site_url("C_stock_location/get_data_location"); ?>',
            type: 'post',
            data: {
                code_id: $("#code_id").val()
            },
            success: function(response) {
                $('#data_detail').html(response);
            }
        });
    }

    $(document).ready(function() {
        $(document).on("click", ".edit-btn", function() {

            var code_id = $(this).data('location-id');
            console.log("code_id:", code_id);
            console.log($(this).data());
            var sl_area = $(this).data('slArea');
            var sl_location = $(this).data('sl-location');
            var sl_amount = $(this).data('sl-amount');
            var sl_distribution = $(this).data('sl-distribution');
            // console.log(sl_distribution);
            $("#code_id_edit").val(code_id);
            $("#sl_area").val(sl_area);
            $("#sl_location").val(sl_location);
            $("#sl_amount").val(sl_amount);
            // $("#sl_distribution").val(sl_distribution);

            if (sl_distribution == '2') {
                $("#sl_distribution").prop('checked', true);
            } else {
                $("#sl_distribution").prop('checked', false);
            }
            $("#edit_location_modal").modal('show');
            console.log(code_id, sl_area, sl_location, sl_distribution);
            // console.log("Checkbox checked:", $("#sl_distribution").prop('checked'));
            // console.log(sl_distribution);
            // console.log($("#sl_distribution").prop("checked"));
        });
        // Submit edit form
        $("#editForm").submit(function(e) {
            e.preventDefault();
            var code_id = $("#code_id").val();
            var form = $(this);
            var url = form.attr('action');
            console.log("รหัสสินค้า:", code_id);
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('C_stock_location/update_stock_location'); ?>",
                data: form.serialize(),
                // success: function(data) {
                success: function(response) {
                    // console.log(form.serialize());
                    // console.log(response);
                    // console.log(data);
                    // try {
                    //     let jsonData = JSON.parse(response);
                    // } catch (e) {
                    //     console.error("Not valid JSON:", e);
                    // }
                    var result = JSON.parse(response);
                    console.log(result);
                    if (result.success) {
                        $("#edit_location_modal").modal('hide');
                        alert("บันทึกการแก้ไขข้อมูล");
                        updateTable();
                        console.log(result);

                    } else {
                        // แจ้งเตือนกรณีผิดพลาด
                        alert(result.message);
                        updateTable();

                    }
                    // console.log(response);
                }
            });
        });
    });

    $(document).ready(function() {
        $('#insertForm').submit(function(e) {
            e.preventDefault();
            $('input[name="sl_distribution[]"]').each(function() {
                if ($(this).is(':checked')) {
                    $(this).val('2');
                } else {
                    $(this).val('1');
                }
                console.log($(this).val());

            });
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("C_stock_location/insert_stock_location"); ?>',
                data: $(this).serialize(),
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#data_detail').html(data.message);
                        alert("------- บันทึกข้อมูลเรียบร้อยแล้ว ------");
                        updateTable();
                    } else {
                        alert(data.message);
                        updateTable();
                    }
                },
                error: function() {
                    alert("เกิดข้อผิดพลาดในการส่งคำขอ");
                    console.log("ไม่เข้าเงื่อนไขเพิ่มข้อมูล");
                }
            });
        });

        function updateTable() {
            $.ajax({
                url: '<?php echo site_url("C_stock_location/get_data_location"); ?>',
                type: 'post',
                data: {
                    code_id: $("#code_id").val()
                },
                success: function(response) {
                    $('#data_detail').html(response);
                }
            });
        }
    });

    //---------------------------------------------------------------------------
</script>
</body>