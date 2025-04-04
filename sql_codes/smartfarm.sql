SET SQL_SAFE_UPDATES = 0;
SET SQL_SAFE_UPDATES = 1;
CREATE DATABASE smartfarm;
USE smartfarm;
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

-- DELETE FROM farmer_farm_types;

CREATE TABLE farm_types (
    farm_type_id INT AUTO_INCREMENT PRIMARY KEY,
    farm_type_name VARCHAR(100) NOT NULL
);

INSERT INTO farm_types (farm_type_name)
VALUES ('Vegetables'), ('Fresh Fruits'), ('Dairy Items'), ('Fish Items'), ('Meat Items'), ('Carb Items');

CREATE TABLE farmer_farm_types (
    farmer_id INT,
    farm_type_id INT,
    PRIMARY KEY (farmer_id, farm_type_id),
    FOREIGN KEY (farmer_id) REFERENCES farmers(farmer_id) ON DELETE CASCADE,
    FOREIGN KEY (farm_type_id) REFERENCES farm_types(farm_type_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    weight_kg INT NOT NULL CHECK (weight_kg >= 0),
    price_tk INT NOT NULL CHECK (price_tk >= 0),
    farmer_id INT NOT NULL,
    farm_type_id INT NOT NULL,
    description TEXT NOT NULL,
    entry_date DATE NOT NULL,
    FOREIGN KEY (farmer_id) REFERENCES farmers(farmer_id) ON DELETE CASCADE,
    FOREIGN KEY (farm_type_id) REFERENCES farm_types(farm_type_id) ON DELETE RESTRICT
);

ALTER TABLE products
ADD COLUMN product_image VARCHAR(255) NOT NULL;

SHOW TABLES;
select *from farmers;
select *from farmer_farm_types;
select *from farm_types;
select *from products;
DELETE FROM products;
