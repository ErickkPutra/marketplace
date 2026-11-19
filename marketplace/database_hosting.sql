CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(12,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  image_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;
CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address TEXT NOT NULL
) ENGINE=InnoDB;
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_code VARCHAR(20) NOT NULL UNIQUE,
  customer_id INT NOT NULL,
  total DECIMAL(12,2) NOT NULL,
  status ENUM('pending','paid','shipped','done','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id)
) ENGINE=InnoDB;
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;

INSERT INTO categories (name) VALUES ('Fashion'),('Elektronik'),('Rumah Tangga');
INSERT INTO products (category_id,name,description,price,stock,image_url) VALUES
(1,'Kemeja Batik Pria','Kemeja batik katun motif parang, nyaman dipakai harian.',185000,20,'https://picsum.photos/seed/batik/600/400'),
(1,'Tas Anyaman Rotan','Tas tangan anyaman rotan buatan pengrajin lokal.',220000,12,'https://picsum.photos/seed/rotan/600/400'),
(2,'Earphone Bluetooth','Earphone nirkabel dengan baterai tahan 20 jam.',275000,30,'https://picsum.photos/seed/earphone/600/400'),
(2,'Power Bank 10.000 mAh','Power bank ringkas dengan dua port USB.',160000,25,'https://picsum.photos/seed/powerbank/600/400'),
(3,'Set Cangkir Keramik','Satu set 4 cangkir keramik glasir.',130000,15,'https://picsum.photos/seed/cangkir/600/400');
