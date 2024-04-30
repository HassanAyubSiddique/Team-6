// this is for the Sidebar class for toggle functionality on click 
class Sidebar {
  constructor(toggleButtonSelector, sidebarSelector) {
    this.toggle = document.querySelector(toggleButtonSelector);
    this.sidebar = document.querySelector(sidebarSelector);
    if (!this.toggle || !this.sidebar) {
      throw new Error("Toggle button or sidebar element not found");
    }
    this.setupToggle();
  }

  setupToggle() {
    this.toggle.addEventListener("click", () => {
      this.sidebar.classList.toggle("close");
    });
  }
}


// Arrow class is for the  menu navigation
class Arrow {
  constructor(arrowSelector) {
    this.arrows = document.querySelectorAll(arrowSelector);
    this.setupArrows();
  }

  setupArrows() {
    this.arrows.forEach(arrow => {
      arrow.addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("show");
      });
    });
  }
}

// Signout class for handling signout confirmation 
class Signout {
  static confirmSignout() {
    var confirmSignout = confirm("Are you sure you want to sign out?");
    if (confirmSignout) {
      window.location.href = "Customer.php";
    }
  }
}

// Function to confirm signout
function confirmSignout() {
  Signout.confirmSignout();
}

// DeleteButton class for handling delete confirmation in the product , raw , staff and customer page 
class DeleteButton {
  constructor(buttonSelector) {
    this.buttons = document.querySelectorAll(buttonSelector);
    this.setupDeleteButtons();
  }

  setupDeleteButtons() {
    this.buttons.forEach(button => {
      button.addEventListener('click', function() {
        const isConfirmed = confirm('Are you sure you want to delete the item?');
        if (isConfirmed) {
          alert('Item deleted successfully');
        }
      });
    });
  }
}



// ChartRenderer class this is for rendering different types of charts in the admin dashboard 
class ChartRenderer {
  constructor(data, canvasId, chartType, options = {}) {
      this.data = data;
      this.canvas = document.getElementById(canvasId);
      if (!this.canvas) {
          console.error("Canvas element not found: " + canvasId);
          return;  // Exit constructor if canvas is not found to avoid further errors
      }
      this.ctx = this.canvas.getContext('2d');
      this.chartType = chartType;
      this.options = options;
      this.chart = this.initChart();
  }
 
 
  initChart() {
      const config = (this.chartType === 'line') ? this.getLineChartConfig() : this.getChartConfig();
      return new Chart(this.ctx, config);
  }
 
 
  getLineChartConfig() {
      const labels = this.options.labels || this.data.map(item => item.label);
      const datasets = this.getLineDatasets();
      let config = {
          type: 'line',
          data: {
              labels: labels,
              datasets: datasets
          },
          options: {
              responsive: true,
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              plugins: {
                  legend: {
                      position: 'top',
                  },
                  title: {
                      display: true,
                      text: 'Dynamic Chart Visualization'
                  }
              }
          }
      };
      return config;
  }
 
 
  getChartConfig() {
      const labels = this.data.map(item => item.label);
      const quantities = this.data.map(item => item.quantity);
      const backgroundColors = [
          'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)',
          'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)',
          'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)',
          'rgba(255, 0, 255, 0.7)', 'rgba(0, 255, 0, 0.7)'
      ];
 
 
      switch (this.chartType) {
          case 'pie':
              return {
                  type: 'pie',
                  data: {
                      labels: labels,
                      datasets: [{
                          data: quantities,
                          backgroundColor: backgroundColors,
                          borderWidth: 3
                      }]
                  }
              };
          case 'bar':
              return {
                  type: 'bar',
                  data: {
                      labels: labels,
                      datasets: [{
                          label: 'Quantity',
                          data: quantities,
                          backgroundColor: 'rgba(54, 162, 235, 0.7)',
                          borderColor: 'rgba(54, 162, 235, 1)',
                          borderWidth: 3
                      }]
                  }
              };
          default:
              throw new Error("Invalid chart type");
      }
  }
 
 
  getLineDatasets() {
      let backgroundColors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                              'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                              'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
                              'rgba(199, 199, 199, 0.2)', 'rgba(64, 159, 255, 0.2)'];
      return this.data.map((item, index) => ({
          label: item.label,
          data: item.quantity,
          backgroundColor: backgroundColors[index % backgroundColors.length],
          borderColor: backgroundColors[index % backgroundColors.length].replace('0.2', '1'),
          borderWidth: 1,
          fill: false
      }));
  }
 
 
  updateChart(data, labels, chartType = 'line') {
      this.chartType = chartType;
      this.chart.data.labels = labels;
      this.chart.data.datasets = this.getLineDatasets();
      this.chart.data.datasets.forEach((dataset, index) => {
          dataset.data = data[index].quantity;
      });
      this.chart.update();
  }
 }
 
 document.addEventListener('DOMContentLoaded', function() {
   // Your const inventoryData array goes here
   const inventoryData = [
     { label: 'Product A', quantity: 100 },
     { label: 'Product B', quantity: 200 },
     { label: 'Product C', quantity: 150 },
     { label: 'Product D', quantity: 120 },
     { label: 'Product E', quantity: 180 },
     { label: 'Product F', quantity: 220 },
     { label: 'Product G', quantity: 170 },
     { label: 'Product H', quantity: 130 }
   ];
 
   // Sample inventory data we have to link this to the database 
   const monthlyData = [
      { label: 'Product A', quantity: [150, 120, 180, 160, 170, 190, 210] },
      { label: 'Product B', quantity: [90, 110, 100, 120, 130, 140, 150] },
      { label: 'Product C', quantity: [120, 130, 140, 150, 160, 170, 180] },
      { label: 'Product D', quantity: [60, 70, 80, 90, 100, 110, 120] },
      { label: 'Product E', quantity: [180, 190, 200, 210, 220, 230, 240] },
      { label: 'Product F', quantity: [140, 150, 160, 170, 180, 190, 200] },
      { label: 'Product G', quantity: [110, 120, 130, 140, 150, 160, 170] },
      { label: 'Product H', quantity: [130, 140, 150, 160, 170, 180, 190] }
   ];
 
   const weeklyData = [
      { label: 'Product A', quantity: [75, 60, 90, 80, 85, 95, 105] },
      { label: 'Product B', quantity: [45, 55, 50, 60, 65, 70, 75] },
      { label: 'Product C', quantity: [60, 65, 70, 75, 80, 85, 90] },
      { label: 'Product D', quantity: [30, 35, 40, 45, 50, 55, 60] },
      { label: 'Product E', quantity: [90, 95, 100, 105, 110, 115, 120] },
      { label: 'Product F', quantity: [70, 75, 80, 85, 90, 95, 100] },
      { label: 'Product G', quantity: [55, 60, 65, 70, 75, 80, 85] },
      { label: 'Product H', quantity: [65, 70, 75, 80, 85, 90, 95] }
   ];
 
   const monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
   const weeklyLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'];
 
   // Initialize the chart instances
   const pieChart = new ChartRenderer(inventoryData, 'inventory-pie-chart', 'pie');
   const barChart = new ChartRenderer(inventoryData, 'inventory-bar-chart', 'bar');
   const lineChart = new ChartRenderer(monthlyData, 'inventory-line-chart', 'line', { labels: monthlyLabels });
 
   // Event listener for changing data frequency
   document.getElementById('data-frequency').addEventListener('change', function(event) {
     if (event.target.value === 'monthly') {
       lineChart.updateChart(monthlyData, monthlyLabels);
     } else {
       lineChart.updateChart(weeklyData, weeklyLabels);
     }
   });
 });
 




  // Initialize other classes 
  const sidebar = new Sidebar(".fas.fa-bars", ".sidebar");  // this is the icon for the menu
  const arrow = new Arrow(".arrow");    
  const deleteButton = new DeleteButton('.delete-btn');

// Function to confirm signout
function confirmSignout() {
  Signout.confirmSignout();
}

  

  // this is for the edit button 
  class ProductEditor {
    constructor() {
      this.editButtons = document.querySelectorAll(".edit-btn");
      this.modal = document.getElementById("editModal");
      this.closeBtn = this.modal.querySelector(".close");
      this.productTable = document.querySelector(".product-table-container");
  
      // Bind event listeners
      this.bindEvents();
    }
  
    bindEvents() {
      // Open modal when Edit button is clicked
      this.editButtons.forEach(button => {
        button.addEventListener("click", () => this.openModal());
      });
  
      // Close modal when close button is clicked
      this.closeBtn.addEventListener("click", () => this.closeModal());
  
      // Close modal when user clicks outside of it
      window.addEventListener("click", event => {
        if (event.target === this.modal) {
          this.closeModal();
        }
      });
  
      // Handle form submission
      const editForm = document.getElementById("editForm");
      editForm.addEventListener("submit", event => this.handleSubmit(event));
    }
  
    openModal() {
      // Hide product table and show edit form
      this.productTable.style.display = "none";
      this.modal.style.display = "block";
    }
  
    closeModal() {
      // Show product table and hide edit form
      this.productTable.style.display = "block";
      this.modal.style.display = "none";
    }
  
    handleSubmit(event) {
      event.preventDefault();
      // here we need to Perform form submission logic, such as sending data to the server (database )
      // After successful submission, we will close the modal and update the product details on the page as well 
      
      this.closeModal();
      
      
    }
    
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    new ProductEditor();
  });
  

  


// validation to the add to product page 

document.addEventListener('DOMContentLoaded', function() {
  var productForm = document.getElementById('productForm');
  if (productForm) {
      productForm.addEventListener('submit', function(event) {
          var inputs = this.querySelectorAll('input[type="text"], input[type="number"], textarea, input[type="file"]');
          var isValidForm = true;
          console.log('Form submission attempted.');

          inputs.forEach(function(input) {
              if (!input.value) {
                  isValidForm = false;
                  input.classList.add('error');
                  console.log(input.id + ' is empty.');
              } else {
                  input.classList.remove('error');
              }
          });

          if (!isValidForm) {
              event.preventDefault();
              console.log('Form submission prevented.');
          }
      });
  }

  document.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(function(input) {
      input.addEventListener('input', function() {
          if (this.value.trim() !== "") {
              this.classList.remove('error');
          }
      });
  });

  var imageInput = document.getElementById('image');
  if (imageInput) {
      imageInput.addEventListener('change', function() {
          if (this.files.length > 0) {
              this.classList.remove('error');
          }
      });
  }
});





























