    CREATE TABLE user (
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(255) UNIQUE NOT NULL,
        password varchar(18) NOT NULL,
        height float NOT NULL,
        weight float NOT NULL,
        age int NOT NULL,
        gender varchar(13) NOT NULL,
        activity_level varchar(255) NOT NULL,
        previous_weight float NOT NULL,
        target_weight float NOT NULL,
        role varchar(20) NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE admin (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(255) UNIQUE NOT NULL,
        password varchar(18) NOT NULL,
        role varchar(20) NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE entry(
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        admin_id int NOT NULL,
        foods_id bigint NOT NULL,
        drinks_id bigint NOT NULL,
        quantities int NOT NULL,
        total int NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE foods(
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id bigint NOT NULL,
        foods_name varchar(255) UNIQUE NOT NULL,
        calories float NOT NULL,
        carbohydrates float NOT NULL,
        fats float NOT NULL,
        energy float NOT NULL,
        servings int NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE drinks(
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id bigint NOT NULL,
        drinks_name varchar(255) UNIQUE NOT NULL,
        calories float NOT NULL,
        carbohydrates float NOT NULL,
        fats float NOT NULL,
        energy float NOT NULL,
        servings int NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE calculation(
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id bigint NOT NULL,
        BMR float NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE recommendations(
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id bigint NOT NULL,
        foods_id bigint NOT NULL,
        drinks_id bigint NOT NULL,
        calculation_id bigint NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    CREATE TABLE basket(
        id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id bigint NOT NULL,
        foods_id bigint NOT NULL,
        drinks_id bigint NOT NULL,
        recommendations_id bigint NOT NULL,
        quantities int NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );

    ALTER TABLE foods ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES user(id) CASCADE;
    ALTER TABLE drinks ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES user(id) CASCADE;
    ALTER TABLE entry ADD CONSTRAINT admin_id FOREIGN KEY (admin_id) REFERENCES admin(id) CASCADE;
    ALTER TABLE entry ADD CONSTRAINT foods_id FOREIGN KEY (foods_id) REFERENCES foods(id) CASCADE;
    ALTER TABLE entry ADD CONSTRAINT drinks_id KEY (drinks_id) REFERENCES drinks(id) CASCADE;
    ALTER TABLE calculation ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES user(id) CASCADE;
    ALTER TABLE recommendations ADD CONSTRAINT foods_id FOREIGN KEY (foods_id) REFERENCES foods(id) CASCADE;
    ALTER TABLE recommendations ADD CONSTRAINT drinks_id FOREIGN KEY (drinks_id) REFERENCES drinks(id) CASCADE;
    ALTER TABLE recommendations ADD CONSTRAINT calculation_id FOREIGN KEY (calculation_id) REFERENCES calculation(id) CASCADE;
    ALTER TABLE basket ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES user(id) CASCADE;
    ALTER TABLE basket ADD CONSTRAINT foods_id FOREIGN KEY (foods_id) REFERENCES foods(id) CASCADE;
    ALTER TABLE basket ADD CONSTRAINT drinks_id FOREIGN KEY (drinks_id) REFERENCES drinks(id) CASCADE;
    ALTER TABLE basket ADD CONSTRAINT recommendations_id FOREIGN KEY (recommendations_id) REFERENCES recommendations(id) CASCADE;