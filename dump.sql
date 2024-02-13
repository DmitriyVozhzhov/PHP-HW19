CREATE TABLE Authors
(
    id         INT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name  VARCHAR(50),
    country    VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
);

CREATE TABLE Books
(
    id        INT PRIMARY KEY,
    title     VARCHAR(100),
    genre     VARCHAR(50),
    year      INT,
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES Authors (id)
);

INSERT INTO Authors (id, first_name, last_name, country)
VALUES (1, 'Джордж', 'Оруелл', 'Великобританія'),
       (2, 'Марк', 'Твен', 'США'),
       (3, 'Харукі', 'Муракамі', 'Японія');

INSERT INTO Books (id, title, genre, year, author_id)
VALUES (1, '1984', 'Антиутопія', 1949, 1),
       (2, 'Пригоди Тома Сойєра', 'Пригодницький роман', 1876, 2),
       (3, 'Норвезький ліс', 'Роман', 1987, 3);

SELECT * FROM Books WHERE genre = 'Роман';
SELECT b.* FROM Books b JOIN Authors a ON b.author_id = a.id WHERE a.country = 'Японія';
SELECT * FROM Books WHERE year BETWEEN 1800 AND 1899;
UPDATE Books SET genre = 'Дистопія' WHERE title = '1984';
DELETE FROM Books WHERE title = 'Пригоди Тома Сойєра';