<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product and Raw Material Quantity Chart</title>
    <link rel="stylesheet" href="DATA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="DATAexport.php"></script> <!-- Include PHP file -->
</head>
<body>
<div class="container">
    <!-- HTML container for the main product chart with horizontal scrolling -->
    <div class="graph-container">
        <canvas id="chart1"></canvas>
        <!-- Export icon for product chart -->
        <i class="fas fa-file-download export-icon" onclick="exportChart('chart1', 'Product Chart')"></i>
        <!-- Icon to change chart type to pie chart --> 
        <i class="fas fa-chart-pie chart-type-icon" onclick="changeChartType('chart1', 'pie')"></i>
        <!-- Icon to change chart type to bar chart -->
        <i class="fas fa-chart-bar chart-type-icon" onclick="changeChartType('chart1', 'bar')"></i>
        <!-- Icon to change chart type to line graph -->
        <i class="fas fa-chart-line chart-type-icon" onclick="changeChartType('chart1', 'line')"></i>
    </div>

    <!-- HTML container for the raw material chart -->
    <div class="graph-container">
        <canvas id="chart2"></canvas>
        <!-- Export icon for raw material chart -->
        <i class="fas fa-file-download export-icon" onclick="exportChart('chart2', 'Raw Material Chart')"></i>
        <!-- Icon to change chart type to pie chart -->
        <i class="fas fa-chart-pie chart-type-icon" onclick="changeChartType('chart2', 'pie')"></i>
        <!-- Icon to change chart type to bar chart -->
        <i class="fas fa-chart-bar chart-type-icon" onclick="changeChartType('chart2', 'bar')"></i>
        <!-- Icon to change chart type to line graph -->
        <i class="fas fa-chart-line chart-type-icon" onclick="changeChartType('chart2', 'line')"></i>
    </div>

    <!-- HTML container for the additional orders chart -->
    <div class="graph-container">
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date">
            <button onclick="updateOrdersChart()">Generate Orders Chart</button>
        </div>
        <canvas id="chart3"></canvas>
        <!-- Export icon for orders chart -->
        <i class="fas fa-file-download export-icon" onclick="exportChart('chart3', 'Orders Chart')"></i>
        <!-- Icon to change chart type to pie chart -->
        <i class="fas fa-chart-pie chart-type-icon" onclick="changeChartType('chart3', 'pie')"></i>
        <!-- Icon to change chart type to bar chart -->
        <i class="fas fa-chart-bar chart-type-icon" onclick="changeChartType('chart3', 'bar')"></i>
        <!-- Icon to change chart type to line graph -->
        <i class="fas fa-chart-line chart-type-icon" onclick="changeChartType('chart3', 'line')"></i>
    </div>
    <!-- HTML container for the additional orders chart -->
    <div class="graph-container">
        <canvas id="chart4"></canvas>
        <!-- Export icon for client orders chart -->
        <i class="fas fa-file-download export-icon" onclick="exportChart('chart4', 'Client Orders Chart')"></i>
        <!-- Icon to change chart type to radar chart -->
        <i class="fas fa-chart-area chart-type-icon" onclick="changeChartType('chart4', 'radar')"></i>
    </div>
</div>
<script src="DATA.js"></script>
</body>
</html>
