document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const sidebarLinks = document.querySelectorAll('.sidebar a');

    menuToggle.addEventListener('mouseover', function() {
        sidebar.style.transition = 'left 0.5s ease';
        sidebar.style.left = '0';
    });

    menuToggle.addEventListener('mouseout', function() {
        sidebar.style.transition = 'left 0.5s ease';
        sidebar.style.left = '-180px';
    });

    sidebarLinks.forEach(function(link) {
        link.addEventListener('mouseover', function() {
            if (!link.classList.contains('active')) {
                link.style.transition = 'background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease';
                link.style.backgroundColor = '#3498db';
                link.style.color = '#fff';
                link.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
            }
        });

        link.addEventListener('mouseout', function() {
            if (!link.classList.contains('active')) {
                link.style.transition = 'background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease';
                link.style.backgroundColor = '#f0f0f0';
                link.style.color = '#333';
                link.style.boxShadow = 'none';
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const inventoryData = {
        labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
        datasets: [{
            label: 'Inventory Distribution',
            data: [50, 30, 70, 40, 60],
            backgroundColor: ['#3498db', '#2ecc71', '#f1c40f', '#e74c3c', '#9b59b6']
        }]
    };

    const salesData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Sales Trends',
            data: [100, 150, 200, 250, 300, 350],
            backgroundColor: '#3498db'
        }]
    };

    const lowStockData = {
        labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
        datasets: [{
            label: 'Low Stock Alerts',
            data: [10, 20, 5, 15, 8],
            backgroundColor: '#e74c3c'
        }]
    };

    const inventoryChartCanvas = document.getElementById('inventoryChart');
    const salesChartCanvas = document.getElementById('salesChart');
    const lowStockChartCanvas = document.getElementById('lowStockChart');

    const inventoryChart = new Chart(inventoryChartCanvas, {
        type: 'bar',
        data: inventoryData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const salesChart = new Chart(salesChartCanvas, {
        type: 'line',
        data: salesData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const lowStockChart = new Chart(lowStockChartCanvas, {
        type: 'doughnut',
        data: lowStockData
    });
});

document.addEventListener('DOMContentLoaded', function() {
    function generatePDF(reportTitle, reportContent) {
        var doc = new jsPDF();
        doc.text(reportTitle, 10, 10);
        doc.text(reportContent, 10, 20);
        doc.save('report.pdf');
    }

    document.getElementById('product-sales-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var startDate = document.getElementById('start-date').value;
        var endDate = document.getElementById('end-date').value;
        var reportContent = "Product Sales Report from " + startDate + " to " + endDate;
        document.getElementById('product-sales-report').textContent = reportContent;
    });

    document.getElementById('inventory-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var reportContent = "This is the Inventory Report content.";
        document.getElementById('inventory-report').textContent = reportContent;
        generatePDF("Inventory Report", reportContent);
    });

    document.getElementById('purchase-orders-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var poStartDate = document.getElementById('po-start-date').value;
        var poEndDate = document.getElementById('po-end-date').value;
        var reportContent = "Purchase Orders Report from " + poStartDate + " to " + poEndDate;
        document.getElementById('purchase-orders-report').textContent = reportContent;
    });
});