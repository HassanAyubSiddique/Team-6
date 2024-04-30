import numpy as np
import matplotlib.pyplot as plt

# Render the product chart
def render_product_chart(product_names, product_quantities):
    plt.figure(figsize=(10, 6))
    plt.bar(product_names, product_quantities, color='skyblue')
    plt.xlabel('Product Names')
    plt.ylabel('Product Quantity')
    plt.title('Product Quantity Chart')
    plt.xticks(rotation=45, ha='right')
    plt.tight_layout()
    plt.show()

# Render the raw material chart
def render_raw_material_chart(raw_material_names, raw_material_quantities):
    plt.figure(figsize=(10, 6))
    plt.bar(raw_material_names, raw_material_quantities, color='lightcoral')
    plt.xlabel('Raw Material Names')
    plt.ylabel('Raw Material Quantity')
    plt.title('Raw Material Quantity Chart')
    plt.xticks(rotation=45, ha='right')
    plt.tight_layout()
    plt.show()

# Render the orders chart
def render_orders_chart(order_labels, order_data):
    plt.figure(figsize=(10, 6))
    plt.bar(order_labels, order_data, color='lightgreen')
    plt.xlabel('Order Dates')
    plt.ylabel('Number of Orders')
    plt.title('Orders Chart')
    plt.xticks(rotation=45, ha='right')
    plt.tight_layout()
    plt.show()

# Render the clients vs. number of orders chart
def render_clients_orders_chart(client_names, client_order_counts):
    plt.figure(figsize=(10, 6))
    plt.bar(client_names, client_order_counts, color='lightsalmon')
    plt.xlabel('Client Names')
    plt.ylabel('Number of Orders')
    plt.title('Clients Orders Chart')
    plt.xticks(rotation=45, ha='right')
    plt.tight_layout()
    plt.show()

# Call the functions to render the charts
render_product_chart(['l','oo','k','k'], [9,8,88,5,5])
render_raw_material_chart(rawMaterialNames, rawMaterialQuantities)
render_orders_chart(orderLabels, orderData)

# Generate random data for the graph
categories = ['Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5']
values = np.random.randint(1, 100, size=len(categories))

# Create the bar chart
plt.figure(figsize=(10, 6))
plt.bar(categories, values, color='skyblue')
plt.xlabel('Categories')
plt.ylabel('Values')
plt.title('Random Data Bar Chart')
plt.xticks(rotation=45, ha='right')
plt.tight_layout()

# Save the plot as an image file
plt.savefig('python_graph.png')

# Show the plot
plt.show()
