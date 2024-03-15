CREATE TABLE images (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title TEXT,
  `date` DATE,
  `description` TEXT,
  `image` TEXT,
  position TEXT
);

CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  `name` TEXT
);

CREATE TABLE imageCategories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  imageId INT,
  categoryId INT
);

INSERT INTO categories (`name`) VALUES
("Original Characters"), ("Fan Art"), ("Animals"), ("Landscape");

INSERT INTO images (title, `date`, `description`, `image`, position)  VALUES
("Aether Yanderer", "2022-10-10", "My boy being obsessive", "Aether0.jpg", "0 -10"),
("Aether in the ether", "2022-10-11", "My boy being ethereal", "Aether1.jpg", "0 -10"),
("Aether in Space", "2024-01-30", "My boy in space", "Aether2.jpg", "0 0");
