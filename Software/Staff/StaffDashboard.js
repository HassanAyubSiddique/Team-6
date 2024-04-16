

let toggle = document.querySelector(".fas.fa-bars");
let sidebar = document.querySelector(".sidebar");

toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

let arrows = document.querySelectorAll(".arrow");
for (var i = 0; i < arrows.length; i++) {
  arrows[i].addEventListener("click", (e) => {
    let arrowParent = e.target.parentElement.parentElement;

    arrowParent.classList.toggle("show");
  });
}


function confirmSignout() {
  // Display a confirmation dialog
  var confirmSignout = confirm("Are you sure you want to sign out?");
  
  // If the user confirms, redirect to the signout page
  if (confirmSignout) {
    window.location.href = "registeration.html"; 
  }
}



// Check if the element with ID 'createButton' exists before adding the event listener
var createButton = document.getElementById('createButton');
if (createButton) {
    createButton.addEventListener('click', function() {
        var quantityInput = document.getElementById('quantity');
        // Check if quantityInput is not null before accessing its value
        if (quantityInput && parseInt(quantityInput.value) < 0) {
            quantityInput.value = 0;
        }
    });
}







// this is the script for the pie chart 

document.addEventListener('DOMContentLoaded', function() {
  // Sample inventory data
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

  // Extract labels and quantities
  const labels = inventoryData.map(item => item.label);
  const quantities = inventoryData.map(item => item.quantity);

  // Total quantity
  const totalQuantity = quantities.reduce((total, quantity) => total + quantity, 0);

  // Render pie chart
  const ctxPie = document.getElementById('inventory-pie-chart').getContext('2d');
  const inventoryPieChart = new Chart(ctxPie, {
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
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Inventory Level', // Title text for the pie chart 
          font: {
            size: 18 // Title font size
          }
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              const label = context.label || '';
              const value = context.raw || '';
              const percentage = (value / totalQuantity) * 100;
              return `${label}: ${value} ( ${percentage.toFixed(2)}% )`;
            }
          }
        },
       
        onClick:
        (event, elements) => {
            if (elements.length > 0) {
              const clickedIndex = elements[0].index;
              const meta = inventoryPieChart.getDatasetMeta(0);
              const clickedSegment = meta.data[clickedIndex];
              const model = clickedSegment._model;
              if (!model.offset) {
                model.offset = 10;
              } else {
                model.offset = 0;
              }
              inventoryPieChart.update();
            }
          }
        }
      }
    });
  
  // Render bar chart
  const ctxBar = document.getElementById('inventory-bar-chart').getContext('2d');
  const inventoryBarChart = new Chart(ctxBar, {
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
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Inventory Level', // Title text for the bar chart 
          font: { 
            size: 18 // Title font size (we can change it )
          }
        },
        tooltip: {
          callbacks: {
            label: (context) => {
              const label = context.label || '';
              const value = context.raw || '';
              return `${label}: ${value}`;
            }
          }
        }
      }
    }
  });

   // Sample delivery data (weekly)
   const deliveryData = [
    [200, 90, 70, 45, 30, 50, 60], // Product A
    [40, 55, 65, 45, 85, 35, 100], // Product B
    [60, 70, 80, 90, 100, 110, 120], // Product C
    [45, 55, 65, 75, 85, 95, 105], // Product D
    [70, 80, 90, 100, 110, 120, 130], // Product E
    [55,   65, 75, 85, 95, 105], // Product F
    [65, 75, 85, 95, 105, 115, 125], // Product G
    [70, 80, 90, 100, 110, 120, 130] // Product H
  ];

  // Render line chart
  const ctxLine = document.getElementById('inventory-line-chart').getContext('2d');
  const inventoryLineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'], // Sample weeks
      datasets: labels.map((label, index) => ({
        label: label,
        data: deliveryData[index],
        borderColor: `rgba(${Math.random() * 255},${Math.random() * 255},${Math.random() * 255},0.7)`,
        fill: false
      }))
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Delivery per Week', // Title text
          font: {
            size: 18 // Title font size
          }
        }
      }
    }
  });

  
});