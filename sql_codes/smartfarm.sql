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

CREATE TABLE farm_types (
    farm_type_id INT AUTO_INCREMENT PRIMARY KEY,
    farm_type_name VARCHAR(100) NOT NULL
);

INSERT INTO farm_types (farm_type_name)
VALUES ('Vegetables'), ('Fresh Food'), ('Dairy Items'), ('Fish Items'), ('Meat Items'), ('Carb Items');

CREATE TABLE farmer_farm_types (
    farmer_id INT,
    farm_type_id INT,
    PRIMARY KEY (farmer_id, farm_type_id),
    FOREIGN KEY (farmer_id) REFERENCES farmers(farmer_id) ON DELETE CASCADE,
    FOREIGN KEY (farm_type_id) REFERENCES farm_types(farm_type_id) ON DELETE CASCADE
);
select *from farmers;
select *from farmer_farm_types;
