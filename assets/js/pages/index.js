$(function () {
    //Widgets count
    $('.count-to').countTo();

    //Sales count to
    $('.sales-count-to').countTo({
        formatter: function (value, options) {
            return '$' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, ' ').replace('.', ',');
        }
    });

    initDonutChart();
});


function initDonutChart() {
    Morris.Donut({
        element: 'donut_chart',
        data: [{
            label: 'Active',
            value: 72
        }, {
            label: 'Expire',
            value: 8
        }, {
            label: 'Suspended',
            value: 2
        }, {
            label: 'Pending',
            value: 18
        }],
        colors: ['rgb(139, 195, 74)', 'rgb(233, 30, 99)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)'],
        formatter: function (y) {
            return y + '%'
        }
    });
}
