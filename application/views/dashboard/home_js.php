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

    $(function () {
        $('#dashboard').addClass('active');

        getData();
        initDonutChart();
        getStatistic()
    });

    function getData() {
//Table data featching.
        var ur = "<?php echo base_url() ?>Dashboard/fetch_user";

        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            destroy: true,
            responsive: true,
            scrollX: true,
            scrollY: true,
            pageLength : 11,
            order: [[ 3, "desc" ]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "ajax": {
                url: ur,
                type: "POST"
            }
        });
    }

    $(function () {
        //Widgets count
        $('.count-to').countTo();
        //Sales count to
        $('.sales-count-to').countTo({
            formatter: function (value, options) {
                return '$' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, ' ').replace('.', ',');
            }
        });

    });


    function initDonutChart() {
        var ur = "<?php echo base_url() ?>Dashboard/chart_data";
        $.ajax({
            url: ur,
        }).done(function (data) {
            Morris.Donut({
                element: 'donut_chart',
                data: JSON.parse(data),
                colors: ['rgb(139, 195, 74)', 'rgb(233, 30, 99)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)'],
                formatter: function (y) {
                    return y
                }
            });

        }).fail(function () {
            alert("Error.");
        });
    }

    function getStatistic() {
        var ur = "<?php echo base_url() ?>Dashboard/statistic_data";
        $.ajax({
            url: ur,
        }).done(function (data) {

            var data = JSON.parse(data);
            var v1 = data["Users"];
            var v2 = data["Exams"];
            var v3 = data["Videos"];
            var v4 = data["Jobs"];

            $('#Users').countTo({from: 0, to: v1, speed: 1000, interval: 20});
            $('#Exams').countTo({from: 0, to: v2, speed: 1000, interval: 20});
            $('#Videos').countTo({from: 0, to: v3, speed: 1000, interval: 20});
            $('#Jobs').countTo({from: 0, to: v4, speed: 1000, interval: 20});
        }).fail(function () {
            alert("Error.");
        });
    }
</script>
