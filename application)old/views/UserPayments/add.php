<?php
/**
 * Web Based Software Activation System
 * Developed By
 * Sagar Maher
 * Coding Visions Infotech Pvt. Ltd.
 * http://codingvisions.com/
 * 31/01/2019
 */
?>
<!-- Modal Dialogs ====================================================================================================================== -->
<!-- Default Size -->
<div class="modal fade" id="add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <form class="form-horizontal" id="submit" action="<?php echo base_url()?>UserPayments/add_data" enctype="multipart/form-data" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add User Payment </h4>
                </div>
                <div class="modal-body">
                    <!-- Masked Input -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <div class="body">
                                    <div class="demo-masked-input">
                                        <div class="row clearfix">

                                            <div class="col-md-4">
                                                <b>Student</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control" name="user_id" id="user_id" data-live-search="true">
                                                        <?php
                                                        $sql="SELECT * FROM `user_login` WHERE status='Active' ";
                                                        $exams=$this->common_model->executeArray($sql);
                                                        if (isset($exams)){
                                                            foreach ($exams as $key) {
                                                                ?>
                                                                <option value="<?php echo($key->login_id); ?>"><?php echo($key->email); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Exam Group</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">touch_app</i>
                                                    </span>
                                                    <select class="form-control" name="examid" id="examid" onchange="return get_select_value_add(this)">
                                                        <?php
                                                        $sql="SELECT * FROM `exams` WHERE status='Active'";
                                                        $fetch_data=$this->common_model->executeArray($sql);
                                                        if($fetch_data)
                                                        {
                                                            foreach ($fetch_data as $value)
                                                            {
                                                                echo '<option value="'.$value->exam_id.'">'.$value->exam_name.'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Test Series :</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <select class="form-control" id="a_test_series" name="a_test_series">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-md-4">
                                              <p>
                                                  <b>Payment Method</b>
                                              </p>
                                              <select class="form-control" name="payment_method" id="payment_method" >
                                                  <option value="Razor Pay">Razor Pay</option>
                                                  <option value="Cash">Cash</option>
                                                  <option value="UPI">UPI</option>
                                              </select>
                                          </div>

                                            <div class="col-md-4">
                                                <b>Payment Date</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="date" name="payment_date" id="payment_date"
                                                               class="form-control text" placeholder="Date" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <p>
                                                    <b>Payment Status</b>
                                                </p>
                                                <select class="form-control" name="payment_status" id="payment_status" >
                                                    <option value="success">Success</option>
                                                    <option value="failed">Failed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Amount</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="Amount" id="Amount"
                                                               class="form-control number" placeholder="Amount" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Payment ID</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="PaymentId" id="PaymentId"
                                                               class="form-control text" placeholder="Payment ID" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Order ID</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="OrderId" id="OrderId"
                                                               class="form-control text" placeholder="Order ID" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Currency</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="Currency" id="Currency"
                                                               class="form-control text" placeholder="Currency" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <b>Payment Charges</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="number" name="PaymentCharges" id="PaymentCharges"
                                                               class="form-control number" placeholder="Payment Charges" required>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-12">
                                                <b>
                                                    Description</b>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <textarea name="description" id="description" placeholder="Description" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Masked Input -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">SAVE DETAILS
                    </button>
                    <button type="button" class="btn btn-link waves-effect"
                            data-dismiss="modal">CLOSE
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    function get_select_value_add(val)
    {
        // $("#MasikeCategoryId").selectpicker('destroy');
        var id=val.value;
        if(id>0)
        {
            $.ajax({
                url: '<?php echo base_url()?>Test_series_exam/get_select',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#a_test_series").empty();
                    $("#a_test_series").append("<option value=''>Select Test Series </option>");
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#a_test_series").append("<option value='"+id+"'>"+name+"</option>");
                        $("#a_test_series").selectpicker('refresh');
                    }

                }
            });
            return 1;
        }
        else
        {
            $("#a_test_series").empty();
            $("#a_test_series").append("<option value=''>Select Test Series </option>");
        }

    }
</script>
