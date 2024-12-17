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

<script type="text/javascript">

    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    $(function () {
        $('#app_users').addClass('active');
        getData();
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>Study_Material/fetch_user";
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
                type: "POST"
            }
        });
    }
    //Form data submition.js for add exam in sql.
   $("#addstudyform").submit(function (e) {
       e.preventDefault();
       var study_name = $("#study_name").val();
       var study_status = $("#study_status").val();
       var CreatedOn = $("#CreatedOn").val();
       //alert(study_name);

       $.ajax({
           type: "POST",
           url: "<?php echo base_url() ?>Study_Material_Api/addStudy",
           data: "study_name=" + study_name + "&study_status=" + study_status + "&CreatedOn=" + CreatedOn ,

           success: function (data) {


               $('#success_message').html(data);
               if (data === "Operation failed.") {
                   $("#error_message").html("All Fields are Required");
                   myFunctionEr();
               } else {
                   myFunctionSuc();

                   getData();
               }
           }
       });

   });
   //fetch exam detailes
   function getstudyDetails(getID) {
       var lid = getID.replace('details_', '');

       $.ajax({
           type: "GET",
           url: "<?php echo base_url() ?>Study_Material/StudyById/" + lid, // replace 'PHP-FILE.php with your php file
           dataType: "json",
           success: function (result) {
            // console.log(result);
               //alert(lid);
               $('#s_study_id').val(result[0]["study_material_id"]);
               $("#s_study_name").val(result[0]["study_material_title"]);
               $('#s_status').val(result[0]["status"]);
               $('#s_created_at').val(result[0]["created_at"]);

           },
           error: function () {
               alert('Some error occurred!');
           }
       });

   }
   function getStudyEdit(getID) {
        var lid = getID.replace('client_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Study_Material_Api/studyById", // replace 'PHP-FILE.php with your php file
            data: "id=" + lid,
            dataType: "json",
            success: function (result) {
                //console.log(result);
                $('#e_study_id').val(result[0]["study_material_id"]);
                $("#e_study_name").val(result[0]["study_material_title"]);
                var s =result[0]["status"];
                $('button[data-id="e_status"]').html('<span class="filter-option pull-left">'+s+'</span>');
                $('#e_created_at').val(result[0]["created_at"]);
                //console.log(result);
                },
            error: function () {
                alert('Some error occurred!');
            }
        });
    }
    $("#editstudyform").submit(function (e) {
    e.preventDefault();
    var u_exam_id = $("#e_study_id").val();
    var u_exam_name = $("#e_study_name").val();
    var u_status = $("#e_status").val();
    var u_created_at = $("#e_created_at").val();


    $.ajax({
        type: "PUT",
        url: "<?php echo base_url() ?>Study_Material_Api/update_studyById",

        data: "u_exam_id=" + u_exam_id + "&u_exam_name=" + u_exam_name + "&u_status=" + u_status + "&u_created_at=" + u_created_at ,

        success: function (data) {
            console.log(data);

            $('#success_message').html(data);
            if (data === "success") {
                myFunctionSuc();
                getData();
            } else {
                $("#error_message").html("All Fields are Required");
                myFunctionEr();
            }
        }
    });


});
//code for delete user
    function showConfirmMessage(getID) {
          var lid = getID;

          swal({
              title: "Are you sure?",
              text: "Study Material will be deleted with ID : " + lid + "!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
          }, function () {
              deleteStudyDetailsPerform(lid);
          });
      }

      function deleteStudyDetails(getID) {
          var lid = getID.replace('delete_', '');

          showConfirmMessage(lid);
      }

      function deleteStudyDetailsPerform(getID) {
          var lid = getID;
         // alert(lid);

          if (lid === "") {
              $("#error_message").html("All Fields are Required");
              myFunctionEr();
          } else {
              $.ajax({
                  type: "DELETE",
                  url: "<?php echo base_url() ?>Study_Material_Api/deleteStudy",
                  data: "id=" + lid,
                  success: function (data) {
                      $('#success_message').html(data);
                      console.log(data);
                      myFunctionSuc();
                      if (data === "Success") {
                          swal("Deleted!", "Your User details has been deleted.", "success");
                          getData();
                      } else {
                          $("#error_message").html(data);
                          myFunctionEr();
                      }
                  }
              });
          }
      }
      //this code for add study content
function addContentDetails(getID) {
    var lid = getID.replace('Add_', '');
      $('#content_id').val(lid);
      var ur = "<?php echo base_url() ?>Study_Material/fetch_qua_ans/" + lid;
      //Exportable table
    //  alert(lid);
      setTimeout(function() {
          //your datatable code
          $('#client_licenses').DataTable({
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
                  type: "POST"
              }
          });
      }, 1000);
  }
  function getData_one(lid) {
//Table data featching.
//alert(lid);
       var ur = "<?php echo base_url() ?>Study_Material/fetch_qua_ans/" + lid;
     //Exportable table
     $('#client_licenses').DataTable({
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
             type: "POST"
         }
     });
 }
  $('#add_study_content').submit(function(e){
            e.preventDefault();
                 $.ajax
                 ({
                     //url:'<?php echo base_url();?>index.php/upload/do_upload',
                     url: "<?php echo base_url() ?>Study_Material_Api/add_content",
                     type:"post",
                     data:new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false,
                      success: function(data)
                      {
                        $('#success_message').html(data);
                        if (data === "Operation failed.")
                         {
                            $("#error_message").html("All Fields are Required");
                            myFunctionEr();
                        } else
                         {
                            myFunctionSuc();

                            getData();
                        }
                    }
                 });
                 //Table data featching.

      });
      //delete quation
    function showConfirmMessage(getID,uid) {
          var lid = getID;

          swal({
              title: "Are you sure?",
              text: "Study Content will be deleted with ID : " + lid + "!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
          }, function () {
              deletcontentDetailsPerform(lid,uid);
          });
      }

      function deletcontentDetails(getID,uid) {
          var lid = getID.replace('delete_', '');

          showConfirmMessage(lid,uid);
      }

      function deletcontentDetailsPerform(getID,uid) {
          var lid = getID;
         // alert(lid);

          if (lid === "") {
              $("#error_message").html("All Fields are Required");
              myFunctionEr();
          } else {
              $.ajax({
                  type: "DELETE",
                  url: "<?php echo base_url() ?>Study_Material_Api/deletecontent",
                  data: "id=" + lid,
                  success: function (data) {
                      $('#success_message').html(data);
                      //console.log(data);
                      myFunctionSuc();
                      if (data === "Success") {
                          swal("Deleted!", "Study Content  details has been deleted.", "success");
                          getData_one(uid);
                          //alert(uid);
                      } else {
                          $("#error_message").html(data);
                          myFunctionEr();
                      }
                  }
              });
          }
      }

</script>
