<script>
    function removeBomMaterial(rowId) {
        const rows = document.querySelectorAll(`.${rowId}`);
        rows.forEach(function(row) {
            row.remove();
        });
    }

    $('#matrial_master').on('click', '.remove-btn', function() {
        const rowId = $(this).data('row-id');
        $('#quotation option:selected').prop('disabled', false);
        removeBomMaterial(rowId);
    });
</script>
<script>
    $(".alert").fadeTo(5000, 500).slideUp(500, function() {
        $(".alert").slideUp(500);
    });
    $(document).ready(function() {
        $('#test_submit').validate({
            rules: {
                consignee: {
                    required: true,
                },
            },
            messages: {
                consignee: {
                    required: "Please enter consignee name",
                },
            },
            submitHandler: function(form) {
                // if ($('#service_data tr').length > 0) {
                    form.submit();
                // } else {
                //     alert("Please add at least one pallet before submitting the form.");
                // }
            }
        });

        let rowCounter = 0; // Initialize counter for unique IDs

        $("#add_more_button").on('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            console.log("Add More button clicked!");

            $('#show_material_table').css('display', 'block'); // Ensure the table is visible

            rowCounter++; // Increment counter to ensure unique IDs
            const escapedId = `${rowCounter}`; // Generate unique ID

            // HTML content to append
            let appendData = `
                    <div class="row bom_material_${escapedId}" style="margin-bottom: 15px; border: 1px solid #ddd; padding: 10px;">
                        <!-- Row 1: Title and Short Description -->
                        <input type="hidden" name="selected_plot_id[]" class="form-control" value="${escapedId}">
                        <div class="row">
                            <!-- Title Field -->
                            <div class="col-md-6 form-group">
                                <b>Title*</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">title</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="text" name="title_${escapedId}" id="title_${escapedId}" class="form-control text" placeholder="Enter Title">
                                        <b><span id="title_error_${escapedId}" style="color:red; display:none;"></span></b>
                                    </div>
                                </div>
                            </div>

                            <!-- Short Description Field -->
                            <div class="col-md-6 form-group">
                                <b>Short Description*</b>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">description</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="text" name="description_${escapedId}" id="description_${escapedId}" class="form-control text" placeholder="Enter Description">
                                        <b><span id="description_error_${escapedId}" style="color:red; display:none;"></span></b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: PDF, Image, and Remove Button -->
                        <div class="row">
                            <!-- PDF Upload -->
                            <div class="col-md-4 form-group">
                                <b>PDF*</b>
                                <div class="uploadOuter form-group">
                                    <span class="dragBox">
                                        <i class="fa-solid fa-file-pdf" style="font-size: 30px; color: #d9534f;"></i>
                                        <input type="file" name="pdf[]" id="pdf_${escapedId}" class="form-control" accept="application/pdf">

                                        <input type="hidden" name="current_pdf_${escapedId}" value="">
                                    </span>
                                    <div id="pdf_error_${escapedId}" class="error" style="color: red;"></div>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <b>Image*</b>
                                <div class="uploadOuter form-group">
                                    <span class="dragBox">
                                        <i class="fa-solid fa-images" style="font-size: 30px;"></i>
                                        
                                        <input type="file" name="icon[]" id="icon_${escapedId}" class="form-control" accept="image/*">
                                        <input type="hidden" name="current_icon_${escapedId}" value="">
                                    </span>
                                    <div id="icon_error_${escapedId}" class="error" style="color: red;"></div>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <div class="col-md-4">
                                <b>Actions</b><br>
                                <i onclick="removeBomMaterial('${escapedId}')" title="Remove" class="fa fa-times" aria-hidden="true" style="color:red; cursor:pointer;"></i>
                            </div>
                        </div>
                    </div>`;

            // Append the new section to the container
            $('#matrial_master').append(appendData);
        });

        // let rowCounter = 0;
        // $("#add_more_button").on('click', function() {
        //     event.preventDefault();
        //     console.log("Add More button clicked!");

        //     $('#show_material_table').css('display', 'block');
        //     $(this).rules('remove');
        //     $.ajax({
        //         url: "<?php echo base_url() ?>Ajax_controller/previous_exam_pdf_details_to_ajx/",
        //         type: "post",
        //         data: {
        //             // new_plot_id: new_plot_id
        //         },
        //         success: function(response) {
        //             // console.log(response);
        //             var data = JSON.parse(response);
        //             if (data && data.products) {
        //                 const plotData = data.products[0];
        //                 // console.log(plotData);
        //                 // exit;
        //                 const plot_id = plotData.id;
        //                 // console.log(plot_id);
        //                 // exit;
        //                 rowCounter++;
        //                 const new_plot_id = rowCounter;
        //                 const escapedId = `row_${new_plot_id}`;

        //                 let appendData = `
        //                             <div class="row bom_material_${escapedId}" style="margin-bottom: 15px; border: 1px solid #ddd; padding: 10px;">
        //                                 <!-- Title Field -->
        //                                 <div class="col-md-4 form-group">
        //                                     <b>Title*</b>
        //                                     <div class="input-group">
        //                                         <span class="input-group-addon">
        //                                             <i class="material-icons">title</i>
        //                                         </span>
        //                                         <div class="form-line">
        //                                             <input type="text" name="title[]" id="title_${escapedId}" class="form-control text" placeholder="Enter Title">
        //                                             <b><span id="title_error_${escapedId}" style="color:red; display:none;"></span></b>
        //                                         </div>
        //                                     </div>
        //                                 </div>

        //                                 <!-- Short Description Field -->
        //                                 <div class="col-md-4 form-group">
        //                                     <b>Short Description*</b>
        //                                     <div class="input-group">
        //                                         <span class="input-group-addon">
        //                                             <i class="material-icons">description</i>
        //                                         </span>
        //                                         <div class="form-line">
        //                                             <input type="text" name="description[]" id="description_${escapedId}" class="form-control text" placeholder="Enter Description">
        //                                             <b><span id="description_error_${escapedId}" style="color:red; display:none;"></span></b>
        //                                         </div>
        //                                     </div>
        //                                 </div>

        //                                 <!-- PDF Upload -->
        //                                 <div class="col-md-4 form-group">
        //                                     <b>PDF*</b>
        //                                     <div class="uploadOuter form-group">
        //                                         <span class="dragBox">
        //                                             <i class="fa-solid fa-file-pdf" style="font-size: 30px; color: #d9534f;"></i>
        //                                             <input type="file" name="pdf[]" id="pdf_${escapedId}" class="form-control" accept="application/pdf">
        //                                         </span>
        //                                         <div id="pdf_error_${escapedId}" class="error" style="color: red;"></div>
        //                                     </div>
        //                                 </div>

        //                                 <!-- Image Upload -->
        //                                 <div class="col-md-4 form-group">
        //                                     <b>Image*</b>
        //                                     <div class="uploadOuter form-group">
        //                                         <span class="dragBox">
        //                                             <i class="fa-solid fa-images" style="font-size: 30px;"></i>
        //                                             <input type="file" name="icon[]" id="icon_${escapedId}" class="form-control" accept="image/*">
        //                                         </span>
        //                                         <div id="icon_error_${escapedId}" class="error" style="color: red;"></div>
        //                                     </div>
        //                                 </div>

        //                                 <!-- Remove Button -->
        //                                 <div class="col-md-4">
        //                                     <b>Actions</b><br>
        //                                     <i onclick="removeBomMaterial('${escapedId}')" title="Remove" class="fa fa-times" aria-hidden="true" style="color:red; cursor:pointer;"></i>
        //                                 </div>
        //                             </div>`;
        //                 // $('#service_data').append(appendData);
        //                 $('#matrial_master').append(appendData);
        //                 // initializeValidationForFields();
        //             } else {
        //                 console.error("Data or its properties (products, categories, etc.) are undefined.");
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Error:', error);
        //         }
        //     });
        // });

        // function initializeValidationForFields() {
        //     $(".product, .product_category, .unit, .capacity, .size, .boxes, .colour, .container, .sequence").rules("remove");

        //     $(".product, .product_category, .unit, .capacity, .size, .boxes, .colour, .container, .sequence").each(function() {
        //         $(this).rules("add", {
        //             required: true,
        //             messages: {
        //                 required: "This field is required",
        //             },
        //         });
        //     });
        // }
    });
</script>
<script>
    function removeBomMaterial(id) {
        const rowToRemove = document.querySelector(`.bom_material_${id}`);
        if (rowToRemove) {
            rowToRemove.remove(); // Remove the row from the DOM
        }
    }
</script>