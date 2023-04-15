-- we don't know how to generate root <with-no-name> (class Root) :(
create table doctrine_migration_versions
(
    version        VARCHAR(191) not null
        primary key,
    executed_at    DATETIME default NULL,
    execution_time INTEGER  default NULL
);

create table products
(
    id       INTEGER          not null
        primary key autoincrement,
    name     VARCHAR(255)     not null,
    prix     DOUBLE PRECISION not null,
    quantity INTEGER          not null
);

create table users
(
    id        INTEGER      not null
        primary key autoincrement,
    username  VARCHAR(180) not null,
    roles     CLOB         not null,
    password  VARCHAR(255) not null,
    birthdate DATE default NULL
);

create table carts
(
    id            INTEGER not null
        primary key autoincrement,
    id_user_id    INTEGER not null
        constraint FK_4E004AAC79F37AE5
            references users,
    id_product_id INTEGER not null
        constraint FK_4E004AACE00EE68D
            references products,
    quantity      INTEGER not null
);

create index IDX_4E004AAC79F37AE5
    on carts (id_user_id);

create index IDX_4E004AACE00EE68D
    on carts (id_product_id);

create unique index UNIQ_1483A5E9F85E0677
    on users (username);

INSERT INTO users (id, username, roles, password, birthdate) VALUES (3, 'rita', '["ROLE_CLIENT"]', '$2y$13$3eQzws.XkFsxBU89lqzMLOqmOpmoQfETcUaeSfjZmvDS2d.R./ijK', '2022-12-25');
INSERT INTO users (id, username, roles, password, birthdate) VALUES (4, 'sadmin', '["ROLE_SUPER_ADMIN"]', '$2y$13$mF/qygisSDg0pfZPwbuJKOzJ7PVA4px9rIdd47OUD0pCCoE.gHray', '2023-03-04');
INSERT INTO users (id, username, roles, password, birthdate) VALUES (5, 'gilles', '["ROLE_ADMIN"]', '$2y$13$dHChNV18DHdY5cNd8X.Co.gxtfn73Jla4.9RoTuPqKdVZrF7c8c/G', '2023-03-19');
INSERT INTO users (id, username, roles, password, birthdate) VALUES (6, 'client1', '["ROLE_CLIENT"]', '$2y$13$HayxtbsSAFfIbS17cKAJkOzOgR3LF/LwMNdZtw1JItluJ.aQSTf2K', '2023-04-25');
INSERT INTO users (id, username, roles, password, birthdate) VALUES (9, 'admin', '["ROLE_ADMIN"]', '$2y$13$m1vVzM4PjZMOV97wpHFhNe2EK.i7dC1BlGqyk3jH4S5sux4to.Asa', '2023-04-11');
INSERT INTO users (id, username, roles, password, birthdate) VALUES (10, 'client2', '["ROLE_CLIENT"]', '$2y$13$txmuKIDYJlS26GJjgf6XPunSYJ34v4O6lLP4Eg/4XsKIFZBcMBKKq', '2023-04-26');


INSERT INTO products (id, name, prix, quantity) VALUES (1, 'Eau bénite', 1000, 50);
INSERT INTO products (id, name, prix, quantity) VALUES (2, 'Eau de glacier', 650, 33);
INSERT INTO products (id, name, prix, quantity) VALUES (3, 'Eau de mer', 25, 500);
INSERT INTO products (id, name, prix, quantity) VALUES (4, 'Eau de source', 50, 125);
INSERT INTO products (id, name, prix, quantity) VALUES (5, 'Eau en poudre', 500, 69);
INSERT INTO products (id, name, prix, quantity) VALUES (6, 'Eau pétillante', 420, 240);
INSERT INTO products (id, name, prix, quantity) VALUES (7, 'Eau de piscine', 24.99, 150);
INSERT INTO products (id, name, prix, quantity) VALUES (8, 'Eau potable', 2, 999);
INSERT INTO products (id, name, prix, quantity) VALUES (9, 'Fraise à l''eau', 289.65, 845);
INSERT INTO products (id, name, prix, quantity) VALUES (10, 'Sac à d''eau', 5000, 5);


INSERT INTO carts (id, id_user_id, id_product_id, quantity) VALUES (1, 3, 4, 17);
INSERT INTO carts (id, id_user_id, id_product_id, quantity) VALUES (2, 3, 2, 1);
INSERT INTO carts (id, id_user_id, id_product_id, quantity) VALUES (3, 3, 3, 12);
INSERT INTO carts (id, id_user_id, id_product_id, quantity) VALUES (4, 5, 1, 8);
INSERT INTO carts (id, id_user_id, id_product_id, quantity) VALUES (5, 5, 2, 2);

