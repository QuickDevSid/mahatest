<script type="text/javascript">
    //Tooltip

    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {

        $('#docs_and_videos').addClass('active');
        $('#docs_and_videos .menu-toggle').addClass('toggled');
        $('#docs_and_videos .ml-menu').css('display','block');

        $('#'+id).addClass('active');
        getData();
        $('#video_source,#edit_video_source').change(function (){
            if($(this).val()==='Hosted'){
                alert('hosted')
                $('#url-section,#edit_url-section').hide();
                $('#video-section,#edit_video-section').show();
            }else{
                $('#video-section,#edit_video-section').hide();
                $('#url-section,#edit_url-section').show();
            }
        });
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>get_doc_video_details?type="+type;
        console.log('ur',ur)
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
            url: "<?php echo base_url() ?>get_single_video_doc/" + lid+"?type="+type, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                var img = result["image_url"];
                let newsrc = '';
                newsrc = '<?=base_url()?>' + img;
                let source_type=result.video_source;
                let link=result.video_url;

                console.log('img',newsrc)
                $("#s_img").attr("src", newsrc);
                $('#s_title').val(result["title"]);
                $('#s_status option[value="'+result["status"]+'"]').attr("selected", "selected");
                $('#s_status').selectpicker('refresh');
                $('#s_can_download option[value="'+result["can_download"]+'"]').attr("selected", "selected");
                $('#s_can_download').selectpicker('refresh');
                $('#s_description').val(result["description"]);
                if(source_type!='Youtube'){
                    url = '';
                    if(source_type=='Hosted'){
                        link = '<video width="100%" height="200" controls class="w-100"><source src="<?= base_url()?>'+link+'"></video>';
                    }else{
                        var url = link;
                        var id = url.split("vimeo.com/")[1]; //sGbxmsDFVnE
                        link = `
						<iframe width="100%" height="200" src="https://player.vimeo.com/video/${id}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
							`;
                        // link = '<video width="320" height="240" controls><source type="video/mp4" src="'+link+'"></video>';
                    }
                }else{
                    var url = link;
                    var id = url.split("?v=")[1]; //sGbxmsDFVnE

                    var embedlink = "http://www.youtube.com/embed/" + id;
                    link='<div class="ratio ratio-16x9"><iframe width="100%" height="400" src="'+embedlink+'?autohide=0&showinfo=0&controls=0"></iframe></div>';
                }
                $('#video').html(link)
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
            url: "<?php echo base_url() ?>get_single_video_doc/" + lid+"?type="+type, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
                $('#edit_title').val(result["title"]);
                $('#edit_status').val(result["status"]);
                $('#edit_status option[value="'+result["status"]+'"]').attr("selected", "selected");
                $('#edit_status').selectpicker('refresh');
                $('#edit_can_download option[value="'+result["can_download"]+'"]').attr("selected", "selected");
                $('#edit_can_download').selectpicker('refresh');
                if(result['video_source'] !=''){
                    // alert()
                    $('#edit_video_source option[value="'+result["video_source"]+'"]').attr("selected", "selected");
                    $('#edit_video_source').change();
                    $('#edit_video_source').selectpicker('refresh');
                    $('input[type="url"]').val(result['video_url'])

                }
                $('#edit_description').val(result["description"]);
                $('#edit_id').val(result["id"]);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }

    $('#submit_examsection').submit(function (e) {
        e.preventDefault();
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
                url: "<?php echo base_url() ?>Doc_Videos/delete_doc_video_data/"+lid,
                
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

</script>