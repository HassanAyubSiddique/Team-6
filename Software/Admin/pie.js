document.addEventListener('DOMContentLoaded', function() {
    // Sample inventory data
    const inventoryData = [
      { label: 'Product A', quantity: 100 },
      { label: 'Product B', quantity: 200 },
      { label: 'Product C', quantity: 150 }
    ];
  
    // Extract labels and quantities
    const labels = inventoryData.map(item => item.label);
    const quantities = inventoryData.map(item => item.quantity);
  
    // Total quantity
    const totalQuantity = quantities.reduce((total, quantity) => total + quantity, 0);
  
    // Render pie chart
    const ctx = document.getElementById('inventory-pie-chart').getContext('2d');
    const inventoryPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          data: quantities,
          backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)'
          ],
          borderWidth: 3 // Change borderWidth to make it 3D
        }]
      },
      options: {
        plugins: {
          tooltip: {
            callbacks: {
              label: (context) => {
                const label = context.label || '';
                const value = context.raw || '';
                const percentage = (value / totalQuantity) * 100;
                return `${label}: ${value} ( ${percentage.toFixed(2)}% )`;
              }
            }
          }
        },
        onClick: (event, elements) => {
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
    });
  });