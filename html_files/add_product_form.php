<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product Form</title>
    <!-- Bootstrap & FontAwesome -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css_file/add_product_form.css" />
  </head>
  <body>
    <div class="product-form-container">
      <div class="product-form-card">
        <!-- Logo -->
        <div class="logo">
          <img src="../IMG/LOGO DESIGN-01.png" alt="Company Logo" />
        </div>

        <!-- Form Title -->
        <h2>Add Product Form</h2>

        <!-- Product Form -->
        <form class="product-form">
          <!-- Product Name -->
          <div class="form-group">
            <label>Product Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter product name"
              required
            />
          </div>

          <!-- Weight -->
          <div class="form-group">
            <label>Weight (kg)</label>
            <input
              type="number"
              class="form-control"
              placeholder="Enter product weight"
              step="0.1"
              min="0"
              required
            />
          </div>

          <!-- Price -->
          <div class="form-group">
            <label>Price (TK)</label>
            <input
              type="number"
              class="form-control"
              placeholder="Enter product price"
              step="1"
              min="0"
              required
            />
          </div>

          <!-- Farmer Name -->
          <div class="form-group">
            <label>Farmer Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter farmer's name"
              required
            />
          </div>

          <!-- Product Entry Date -->
          <div class="form-group">
            <label>Product Entry Date</label>
            <input type="date" class="form-control" required />
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-submit">
            Add Product
          </button>
        </form>
      </div>
    </div>
  </body>
</html>