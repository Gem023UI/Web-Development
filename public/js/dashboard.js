$(document).ready(function () {
    $.ajax({
        method: "GET",
        url: "/api/dashboard/address-chart",
        dataType: "json",
        success: function (data) {
            console.log(data.labels, data.data);
            var ctx = $("#addressChart");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Number of Customers per town',
                        data: data.data,
                        backgroundColor: () => {
                            //generates random colours and puts them in string

                            var colors = [];
                            for (var i = 0; i < data.data.length; i++) {
                                var letters = '0123456789ABCDEF'.split('');
                                var color = '#';
                                for (var x = 0; x < 6; x++) {
                                    color += letters[Math.floor(Math.random() * 16)];
                                }
                                colors.push(color);
                            }
                            return colors;
                        },
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1,

                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    indexAxis: 'y',
                },
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
})