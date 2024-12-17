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

    // $(function() {
    //     $('#app_users').addClass('active');
    //     getData();
    // });

    $(function() {
        $('#app_user_management').addClass('active');
        $('#app_user_management .menu-toggle').addClass('toggled');
        $('#app_user_management .ml-menu').css('display', 'block');

        $('#app_users').addClass('active');
        getData();
    });

    function getData() {
        var is_member = '<?php if(isset($_GET['is_member'])){ echo $_GET['is_member']; }?>';
//Table data featching.
        var ur = "<?php echo base_url() ?>App_Users/fetch_user?is_member=" + is_member;
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

    function getUserDetails(getID) {
        var lid = getID.replace('details_', '');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>App_Users/userById/" + lid, // replace 'PHP-FILE.php with your php file
            dataType: "json",
            success: function (result) {
              //console.log(result);
                //alert(lid);
                $('#d_id').val(result[0]["id"]);
                $("#d_Name").val(result[0]["full_name"]);
                $('#d_Email_ID').val(result[0]["email"]);
                $('#d_password').val(result[0]["password"]);
                $('#d_gender').val(result[0]["gender"]);
                $('#d_selected_exams').val(result[0]["selected_exams"]);
               // $('#Profile_Pic').val(result[0]["Profile_Pic"]);
                $('#d_login_type').val(result[0]["login_type"]);
                $('#d_status').val(result[0]["status"]);
                $('#d_created_at').val(result[0]["created_at"]);

                var img = result[0]["banner_image"];
                newsrc = "AppAPI/banner-images/" + img;
                $("#s_img").attr("src", newsrc);
            },
            error: function () {
                alert('Some error occurred!');
            }
        });

    }
    
    //code for delete user
    function showConfirmMessage(getID) {
          var lid = getID;

          swal({
              title: "Are you sure?",
              text: "Current Affair's will be deleted with ID : " + lid + "!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
          }, function () {
              deleteUserDetailsPerform(lid);
          });
      }

      function deleteUserDetails(getID) {
          var lid = getID.replace('delete_', '');

          showConfirmMessage(lid);
      }

      function deleteUserDetailsPerform(getID) {
          var lid = getID;
         // alert(lid);

          if (lid === "") {
              $("#error_message").html("All Fields are Required");
              myFunctionEr();
          } else {
              $.ajax({
                  type: "DELETE",
                  url: "<?php echo base_url() ?>App_user_API/deleteUser",
                  data: "id=" + lid,
                  success: function (data) {
                      $('#success_message').html(data);
                      console.log('response: ',data);
                      myFunctionSuc();
                      if (data === "Success") {
                          swal("Deleted!", "Your User details has been deleted.", "success");
                          getData();
                      } else {
                          $("#error_message").html(data);
                          myFunctionEr();
                      }
                      location.reload();
                  }
              });
          }
      }
    
</script>
