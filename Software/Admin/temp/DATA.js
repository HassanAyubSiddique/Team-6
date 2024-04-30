// Declare the ordersChart variable globally
var ordersChart;

// Function to export the chart as a PNG image
function exportChart(chartId, chartName) {
    // Get the canvas element
    var canvas = document.getElementById(chartId);

    // Create an image from the canvas
    var imgData = canvas.toDataURL('image/png');

    // Create a new anchor element
    var anchor = document.createElement('a');

    // Set the href attribute to the image data
    anchor.href = imgData;

    // Set the download attribute to specify the file name
    anchor.download = chartName + '.png';

    // Programmatically click the anchor to trigger the download
    anchor.click();
}

// JavaScript code to render the product chart
document.addEventListener('DOMContentLoaded', function() {
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var productChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Product Quantity',
                data: productQuantities,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

// JavaScript code to render the raw material chart
document.addEventListener('DOMContentLoaded', function() {
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var rawMaterialChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: rawMaterialNames,
            datasets: [{
                label: 'Raw Material Quantity',
                data: rawMaterialQuantities,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

// JavaScript code to render the orders chart
document.addEventListener('DOMContentLoaded', function() {
    var ctx3 = document.getElementById('chart3').getContext('2d');
    ordersChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: orderLabels, // Replace with your order labels
            datasets: [{
                label: 'Number of Orders',
                data: orderData, // Replace with your order data
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

// Function to update the orders chart based on the selected timestamp
function updateOrdersChart() {
    var selectedTimestamp = document.getElementById('timestamp').value;

    // Perform an AJAX request to retrieve updated data based on the selected timestamp
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'update_orders_data.php?timestamp=' + selectedTimestamp, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response
            var data = JSON.parse(xhr.responseText);

            // Update the labels and data of the orders chart
            ordersChart.data.labels = data.labels;
            ordersChart.data.datasets[0].data = data.data;

            // Update the chart
            ordersChart.update();
        } else {
            console.error('Request failed with status:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
}

// // JavaScript code to render the clients vs. number of orders chart
// document.addEventListener('DOMContentLoaded', function() {
//     var ctx4 = document.getElementById('chart4').getContext('2d');
//     var clientsOrdersChart = new Chart(ctx4, {
//         type: 'bar',
//         data: {
//             labels: clientNames,
//             datasets: [{
//                 label: 'Number of Orders',
//                 data: clientOrderCounts,
//                 backgroundColor: 'rgba(75, 192, 192, 0.7)',
//                 borderColor: 'rgba(75, 192, 192, 1)',
//                 borderWidth: 1
//             }]
//         },
//         options: {
//             scales: {
//                 y: {
//                     beginAtZero: true
//                 }
//             }
//         }
//     });
// });

// Function to change the type of chart (pie, bar, line)
function changeChartType(chartId, type) {
    var chart = Chart.getChart(chartId);
    chart.config.type = type;
    chart.update();
}

// Function to export the orders chart as a PNG image
function exportOrdersChart() {
    // Get the canvas element
    var canvas = document.getElementById('chart3');

    // Create an image from the canvas
    var imgData = canvas.toDataURL('image/png');

    // Create a new anchor element
    var anchor = document.createElement('a');

    // Set the href attribute to the image data
    anchor.href = imgData;

    // Set the download attribute to specify the file name
    anchor.download = 'Orders Chart.png';

    // Programmatically click the anchor to trigger the download
    anchor.click();
}
