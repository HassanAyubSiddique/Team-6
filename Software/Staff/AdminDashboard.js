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
      window.location.href = "login.html";
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
  constructor(data, canvasId, chartType) {
    this.data = data;
    this.canvas = document.getElementById(canvasId);
    if (!this.canvas) {
      throw new Error("Canvas element not found");
    }
    this.chartType = chartType;
    this.renderChart();
  }

  renderChart() {
    const labels = this.data.map(item => item.label);
    const quantities = this.data.map(item => item.quantity);
    const totalQuantity = quantities.reduce((total, quantity) => total + quantity, 0);

    let chartOptions = {};

    switch (this.chartType) {
      case 'pie':
        chartOptions = {
          type: 'pie',
          data: {
            labels: labels,
            datasets: [{
              data: quantities,
              backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 0, 255, 0.7)',
                'rgba(0, 255, 0, 0.7)'
              ],
              borderWidth: 3
            }]
          }
        };
        break;
      case 'bar':
        chartOptions = {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Quantity',
              data: quantities,
              backgroundColor: 'rgba(54, 162, 235, 0.7)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          }
        };
        break;
      case 'line':
        const deliveryData = [
  // this is just a sample data but we need to add this to the database 
          [200, 90, 70, 45, 30, 50, 60], // Product A
          [40, 55, 65, 45, 85, 35, 100], // Product B
          [60, 70, 80, 90, 100, 110, 120], // Product C
          [45, 55, 65, 75, 85, 95, 105], // Product D
          [70, 80, 90, 100, 110, 120, 130], // Product E
          [55, 65, 75, 85, 95, 105], // Product F
          [65, 75, 85, 95, 105, 115, 125], // Product G
          [70, 80, 90, 100, 110, 120, 130] // Product H
        ];
        chartOptions = {
          type: 'line',
          data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'], // Sample weeks
            datasets: labels.map((label, index) => ({
              label: label,
              data: deliveryData[index],
              borderColor: `rgba(${Math.random() * 255},${Math.random() * 255},${Math.random() * 255},0.7)`,
              fill: false
            }))
          }
        };
        break;
      default:
        throw new Error("Invalid chart type");
    }

    try {
      new Chart(this.canvas.getContext('2d'), chartOptions);
    } catch (error) {
      console.error('Error rendering chart:', error.message);
      this.displayError();
    }
  }

  displayError() {
    this.canvas.parentElement.innerHTML = '<p>Unable to load chart</p>';
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // Sample inventory data we have to link this to the database 
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

  // Render pie chart if the canvas element exists
  const pieChart = new ChartRenderer(inventoryData, 'inventory-pie-chart', 'pie');

  // Render bar chart if the canvas element exists
  const barChart = new ChartRenderer(inventoryData, 'inventory-bar-chart', 'bar');

  // Render line chart if the canvas element exists
  const lineChart = new ChartRenderer(inventoryData, 'inventory-line-chart', 'line');


});



  // Initialize other classes 
  const sidebar = new Sidebar(".fas.fa-bars", ".sidebar");  // this is the icon for the menu
  const arrow = new Arrow(".arrow");    
  const deleteButton = new DeleteButton('.delete-btn');


  

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
  