SET SQL_SAFE_UPDATES = 0;
SET SQL_SAFE_UPDATES = 1;
SET FOREIGN_KEY_CHECKS = 0;
SET FOREIGN_KEY_CHECKS = 1;
CREATE DATABASE IF NOT EXISTS smartfarm;
USE smartfarm;

-- Farmers table (unchanged)
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

-- Farm types table (unchanged)
CREATE TABLE farm_types (
    farm_type_id INT AUTO_INCREMENT PRIMARY KEY,
    farm_type_name VARCHAR(100) NOT NULL
);

INSERT INTO farm_types (farm_type_name)
VALUES ('Vegetables'), ('Fresh Fruits'), ('Dairy Items'), ('Fish Items'), ('Meat Items'), ('Carb Items');

-- Farmer-farm types junction table (unchanged)
CREATE TABLE farmer_farm_types (
    farmer_id INT,
    farm_type_id INT,
    PRIMARY KEY (farmer_id, farm_type_id),
    FOREIGN KEY (farmer_id) REFERENCES farmers(farmer_id) ON DELETE CASCADE,
    FOREIGN KEY (farm_type_id) REFERENCES farm_types(farm_type_id) ON DELETE CASCADE
);




-- Product types table (unchanged)
CREATE TABLE product_types (
    product_type_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL UNIQUE,
    product_image VARCHAR(255) NOT NULL
);

INSERT INTO product_types (product_name, product_image) VALUES
('Fulkopi', 'fulkopi.jpg'), ('Potato', 'potato.jpg'), ('Carrot', 'carrot.jpg'), ('Tomato', 'tomato.jpg'),('Begun', 'begun.jpg'),('Borboti', 'borboti.jpg'),
('Apple', 'apple.jpg'),('Banana', 'banana.jpg'), ('Orange', 'orange.jpg'), ('Milk', 'milk.jpg'), ('Cheese', 'cheese.jpg'),('Chalkumra', 'chalkumra.jpg'),
('Yogurt', 'yogurt.jpg'), ('Salmon', 'salmon.jpg'), ('Tuna', 'tuna.jpg'), ('Cod', 'cod.jpg'),('Corn_powder', 'corn_powder.jpg'),('Ginger', 'ginger.jpg'),
('Beef', 'beef.jpg'), ('Chicken', 'chicken.jpg'), ('Pork', 'pork.jpg'), ('Rice', 'rice.jpg'),('Green_capsicum', 'green_capsicum.jpg'),('Red_capsicum', 'red_capsicum.jpg'),
('Wheat', 'wheat.jpg'), ('Corn', 'corn.jpg'), ('Onion', 'onion.jpg'), ('Garlic', 'garlic.jpg'),('Kacha_morich', 'kacha_morich.jpg'),('Mutton', 'mutton.jpg'),('Pepe', 'pepe.jpg'),('Shim', 'shim.jpg'),
('Broccoli', 'broccoli.jpg'), ('Spinach', 'spinach.jpg'), ('Egg', 'egg.jpg'),('Shosha', 'Shosha.jpg'),('Badhakopi', 'Badhakopi.jpg'),
('Sweet_pumkin', 'sweet_pumkin.jpg'),('Motorshoti', 'motorshoti.jpg'),('LouBadhakopi', 'lou.jpg');


-- Products table (unchanged)
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

-- Cart table (unchanged, matches add_to_cart.php)
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    product_type_id INT NOT NULL,
    quantity_kg INT NOT NULL CHECK (quantity_kg > 0),
    unit_price_tk DECIMAL(10,2) NOT NULL CHECK (unit_price_tk >= 0),
    total_price_tk DECIMAL(10,2) NOT NULL CHECK (total_price_tk >= 0),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_type_id) REFERENCES product_types(product_type_id) ON DELETE CASCADE
);


-- New Orders table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    delivery_address TEXT NOT NULL,
    additional_notes TEXT,
    payment_method VARCHAR(50) NOT NULL, -- e.g., "MasterCard", "Visa", "COD", "bKash"
    subtotal DECIMAL(10,2) NOT NULL,
    shipping DECIMAL(10,2) NOT NULL DEFAULT 100.00,
    tax DECIMAL(10,2) NOT NULL DEFAULT 20.00,
    total DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- New Order Items table (to link orders with cart items)
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_type_id INT NOT NULL,
    quantity_kg INT NOT NULL,
    unit_price_tk DECIMAL(10,2) NOT NULL,
    total_price_tk DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_type_id) REFERENCES product_types(product_type_id) ON DELETE RESTRICT
);

-- Employees table (unchanged)
CREATE TABLE employees (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    blood_group VARCHAR(10) NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    permanent_address TEXT NOT NULL,
    present_address TEXT NOT NULL,
    joining_date DATE NOT NULL,
    marital_status VARCHAR(20) NOT NULL,
    profile_image VARCHAR(255) NOT NULL
);

alter table employees
add column password VARCHAR(255) NOT NULL;

-- Users table for login/signup
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Stores hashed password
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Verify setup
SHOW TABLES;
SELECT * FROM farmers;
SELECT * FROM farmer_farm_types;
SELECT * FROM farm_types;
SELECT * FROM products;
SELECT * FROM product_types;
SELECT * FROM cart;
SELECT * FROM employees;
SELECT * FROM orders;
SELECT * FROM order_items;
SELECT * FROM users;

DESCRIBE orders;
DESCRIBE order_items;