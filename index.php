<?php
declare(strict_types=1);

const USERNAME = 'root';
const PASSWORD = 'root';
const DATABASE = 'hillel';

//function generatorFetch(PDOStatement $stmt): Generator
//{
//    while ($entity = $stmt->fetch(PDO::FETCH_OBJ)){
//        yield $entity;
//    }
//}

try {
    $dsn = "mysql:host=mysql;port=3306;dbname=" . DATABASE . ";charset=utf8mb4";
    $database = new PDO($dsn, USERNAME, PASSWORD);

    $sql = "CREATE TABLE IF NOT EXISTS Authors (
        id  INT UNSIGNED PRIMARY KEY,
        first_name VARCHAR(50),
        last_name  VARCHAR(50),
        country    VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP DEFAULT NULL
    )";
    $database->exec($sql);
    echo "<pre>";
    echo "Table 'Authors' created successfully" . PHP_EOL;
    echo "</pre>";

    $sql = "CREATE TABLE IF NOT EXISTS Books (
        id  INT UNSIGNED PRIMARY KEY,
        title     VARCHAR(100),
        genre     VARCHAR(50),
        year      INT,
        author_id INT UNSIGNED,
        FOREIGN KEY (author_id) REFERENCES Authors (id)
)
";
    $database->exec($sql);
    echo "<pre>";
    echo "Table 'Books' created successfully" . PHP_EOL;
    echo "</pre>";

    $sql = "INSERT INTO Authors (id, first_name, last_name, country)
            VALUES (1, 'Джордж', 'Оруелл', 'Великобританія'),
                   (2, 'Марк', 'Твен', 'США'),
                   (3, 'Харукі', 'Муракамі', 'Японія')";
    $database->exec($sql);
    echo "<pre>";
    echo "Data INSERT iNTO table 'Authors'" . PHP_EOL;
    echo "</pre>";

    $sql = "INSERT INTO Books (id, title, genre, year, author_id)
            VALUES (1, '1984', 'Антиутопія', 1949, 1),
                    (2, 'Пригоди Тома Сойєра', 'Пригодницький роман', 1876, 2),
                    (3, 'Норвезький ліс', 'Роман', 1987, 3)";
    $database->exec($sql);
    echo "<pre>";
    echo "Data INSERT iNTO table 'Books'" . PHP_EOL;
    echo "</pre>";

    $sql = "SELECT * FROM Books WHERE genre = 'Роман'";
    $stmt = $database->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Books with genre 'Роман':\n";
    foreach ($result as $book) {
        print_r($book);
    }

    $sql = "SELECT b.* FROM Books b JOIN Authors a ON b.author_id = a.id WHERE a.country = 'Японія'";
    $stmt = $database->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\nBooks written by authors from 'Японія':\n";
    foreach ($result as $book) {
        print_r($book);
    }

    $sql = "SELECT * FROM Books WHERE year BETWEEN 1800 AND 1899";
    $stmt = $database->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\nBooks published between 1800 and 1899:\n";
    foreach ($result as $book) {
        print_r($book);
    }

    $sql = "UPDATE Books SET genre = 'Дистопія' WHERE title = '1984'";
    $database->exec($sql);
    echo "\nGenre of the book '1984' updated to 'Дистопія'\n";

    $sql = "DELETE FROM Books WHERE title = 'Пригоди Тома Сойєра'";
    $database->exec($sql);
    echo "\nBook 'Пригоди Тома Сойєра' deleted from the database\n";

} catch (PDOException $exception){
    echo $exception->getMessage();
}