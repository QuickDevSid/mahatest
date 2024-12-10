<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
       
        $('#membership_plans').addClass('active');

        CKEDITOR.config.height = 300;
        //CKEditor
        CKEDITOR.replace('description',{
            extraPlugins: 'filebrowser',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });
        CKEDITOR.replace('edit_description',{
            extraPlugins: 'filebrowser',
            filebrowserUploadMethod: "form",
            filebrowserUploadUrl: '<?php echo base_url()?>Uploader/upload',
        });



        // $('#Exam_section').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>get_membership_section_details";
        //Exportable table
        $('#user_data').DataTable({
            dom: 'Bfrtip',
            destroy: true,
            responsive: true,
            scrollX: true,
            scrollY: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "ajax": {
                url: ur,
                type: "GET"
            }
        });
    }

    $('#submit').submit(function (e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax
        ({
            url: $(this).attr('action'),
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                // if()
                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    $('#submit').trigger("reset");
                    myFunctionSuc();
                    getData();
                    $('#add').modal('hide');
                }
            }
        });
    });

    function getExamSectionDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>get_single_membership/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result["icon"];
                newsrc = "AppAPI/exam-section-icon/" + img;
                
                
                $("#s_title").val(result["title"]);
                $('#s_sub_heading').val(result["sub_heading"]);
                $('#s_price').val(result["price"]);
                $('#s_actual_price').val(result["actual_price"]);
                $('#s_discount_per').val(result["discount_per"]);
                $('#s_no_of_months').val(result["no_of_months"]);
                $('#s_usage_count').val(result["usage_count"]);
                $('#s_description').val(result["description"]);
                $('#s_status').selectpicker('val', result["status"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    function getExamSectionDetailsEdit(getID) {
        var lid = getID.replace('edit_', '');


        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>get_single_membership/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                $('#edit_title').val(result["title"]);
                $('#edit_sub_heading').val(result["sub_heading"]);
                $('#edit_price').val(result["price"]);
                $('#edit_actual_price').val(result["actual_price"]);
                $('#edit_discount_per').val(result["discount_per"]);
                $('#edit_no_of_months').val(result["no_of_months"]);
              //  $('#edit_description').val(result["description"]);
                $('#edit_id').val(result["id"]);
                $('#edit_status').selectpicker('val', result["status"]);
                CKEDITOR.instances['edit_description'].setData(result["description"]);

            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    $('#submit_examsection').submit(function (e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax
        ({
            //url:'<?php echo base_url();?>index.php/upload/do_upload',
            url: $(this).attr('action'),
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {

                $('#success_message').html(data);
                if (data === "Operation failed.") {
                    $("#error_message").html("All Fields are Required");
                    myFunctionEr();
                } else {
                    myFunctionSuc();

                    getData();
                    $('#edit').modal('hide');
                }
            }
        });
    });

    //code for delete user
    function showConfirmMessage(getID) {
        var lid = getID;

        swal({
            title: "Are you sure?",
            text: "Details will be deleted with ID : " + lid + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            deleteExamSectionDetailsFunc(lid);
        });
    }

    function deleteExamSectionDetails(getID) {
        var lid = getID.replace('delete_', '');

        showConfirmMessage(lid);
    }

    function deleteExamSectionDetailsFunc(getID) {
        var lid = getID;
        // alert(lid);

        if (lid === "") {
            $("#error_message").html("All Fields are Required");
            myFunctionEr();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>Membership_Plans/delete_member_data/"+lid,
                
                success: function (data) {
                    
                    $('#success_message').html(data);
                    myFunctionSuc(); 
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);                    
                    
                }
            });
        }
    }


    $(document).ready(function(){
        // Function to calculate discounted price
        function calculateDiscount() {
            var originalPrice = parseFloat($("#price").val());
            var discountPercentage = parseFloat($("#discount_per").val());

            if(isNaN(originalPrice) || isNaN(discountPercentage)){
                alert("Please enter valid numbers for original price and discount percentage.");
                return;
            }

            if(discountPercentage < 0 || discountPercentage > 100){
                alert("Discount percentage must be between 0 and 100.");
                return;
            }

            var discountedPrice = originalPrice - (originalPrice * discountPercentage / 100);
            $("#actual_price").val(discountedPrice.toFixed(0));

        }

        function calculateDiscountEdit() {
            var originalPrice = parseFloat($("#edit_price").val());
            var discountPercentage = parseFloat($("#edit_discount_per").val());

            if(isNaN(originalPrice) || isNaN(discountPercentage)){
                alert("Please enter valid numbers for original price and discount percentage.");
                return;
            }

            if(discountPercentage < 0 || discountPercentage > 100){
                alert("Discount percentage must be between 0 and 100.");
                return;
            }

            var discountedPrice = originalPrice - (originalPrice * discountPercentage / 100);
            $("#edit_actual_price").val(discountedPrice.toFixed(0));

        }

        // Calculate discount when discount percentage changes
        $("#discount_per").on("input", function() {
            calculateDiscount();
        });

        $("#edit_discount_per").on("input", function() {
            calculateDiscountEdit();
        });
    });
</script>