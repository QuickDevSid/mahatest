
$(function () {

    var base_url = $('#base').val();
    var ur = base_url + "employee/fetch_user";

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "ajax":{  
            url:ur,  
            type:"POST"  
        } 
    });

});


