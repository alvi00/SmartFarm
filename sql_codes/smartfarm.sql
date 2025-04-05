SET SQL_SAFE_UPDATES = 0;
SET SQL_SAFE_UPDATES = 1;
CREATE DATABASE IF NOT EXISTS smartfarm;
USE smartfarm;

-- Farmers table
CREATE TABLE farmers (
    farmer_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    registration_date DATE NOT NULL,
    face_image VARCHAR(255) NOT NULL
);

-- Farm types table
CREATE TABLE farm_types (
    farm_type_id INT AUTO_INCREMENT PRIMARY KEY,
    farm_type_name VARCHAR(100) NOT NULL
);

INSERT INTO farm_types (farm_type_name)
VALUES ('Vegetables'), ('Fresh Fruits'), ('Dairy Items'), ('Fish Items'), ('Meat Items'), ('Carb Items');

-- Farmer-farm types junction table
CREATE TABLE farmer_farm_types (
    farmer_id INT,
    farm_type_id INT,
    PRIMARY KEY (farmer_id, farm_type_id),
    FOREIGN KEY (farmer_id) REFERENCES farmers(farmer_id) ON DELETE CASCADE,
    FOREIGN KEY (farm_type_id) REFERENCES farm_types(farm_type_id) ON DELETE CASCADE
);

-- Product types table for predefined products
CREATE TABLE product_types (
    product_type_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL UNIQUE,
    product_image VARCHAR(255) NOT NULL
);

INSERT INTO product_types (product_name, product_image) VALUES
('Apple', 'apple.jpg'), ('Potato', 'potato.jpg'), ('Carrot', 'carrot.jpg'), ('Tomato', 'tomato.jpg'),
('Banana', 'banana.jpg'), ('Orange', 'orange.jpg'), ('Milk', 'milk.jpg'), ('Cheese', 'cheese.jpg'),
('Yogurt', 'yogurt.jpg'), ('Salmon', 'salmon.jpg'), ('Tuna', 'tuna.jpg'), ('Cod', 'cod.jpg'),
('Beef', 'beef.jpg'), ('Chicken', 'chicken.jpg'), ('Pork', 'pork.jpg'), ('Rice', 'rice.jpg'),
('Wheat', 'wheat.jpg'), ('Corn', 'corn.jpg'), ('Onion', 'onion.jpg'), ('Garlic', 'garlic.jpg'),
('Broccoli', 'broccoli.jpg'), ('Spinach', 'spinach.jpg'), ('Egg', 'egg.jpg');

-- Products table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    weight_kg INT NOT NULL CHECK (weight_kg >= 0),
    price_tk INT NOT NULL CHECK (price_tk >= 0),
    product_type_id INT NOT NULL,
    farmer_id INT NOT NULL,
    farm_type_id INT NOT NULL,
    description TEXT NOT NULL,
    entry_date DATE NOT NULL,
    FOREIGN KEY (farmer_id) REFERENCES farmers(farmer_id) ON DELETE CASCADE,
    FOREIGN KEY (farm_type_id) REFERENCES farm_types(farm_type_id) ON DELETE RESTRICT,
    FOREIGN KEY (product_type_id) REFERENCES product_types(product_type_id) ON DELETE RESTRICT
);

-- cart section
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    product_type_id INT NOT NULL,
    quantity_kg INT NOT NULL CHECK (quantity_kg > 0),
    unit_price_tk DECIMAL(10,2) NOT NULL CHECK (unit_price_tk >= 0),
    total_price_tk DECIMAL(10,2) NOT NULL CHECK (total_price_tk >= 0),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_type_id) REFERENCES product_types(product_type_id) ON DELETE CASCADE
);

-- Verify setup
SHOW TABLES;
SELECT * FROM farmers;
SELECT * FROM farmer_farm_types;
SELECT * FROM farm_types;
SELECT * FROM products;
SELECT * FROM product_types;
SELECT * FROM cart;