-- remove existing tables before we create new ones
DROP TABLE IF EXISTS users, contacts;

CREATE TABLE users
(
    id         INTEGER AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(255) NOT NULL UNIQUE,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP    NOT NULL
);

INSERT INTO users (username, email, password, created_at)
VALUES ('michaels', 'michaels@yourmeds.net', 'michael', CURRENT_TIMESTAMP),
       ('admin', 'admin@yourmeds.net', 'admin', CURRENT_TIMESTAMP),
       ('joe', 'joe@yourmeds.net', 'password', CURRENT_TIMESTAMP),
       ('testing', 'testing@yourmeds.net', 'testing', CURRENT_TIMESTAMP);

CREATE TABLE contacts
(
    id         INTEGER AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    message    LONGTEXT     NOT NULL,
    email      VARCHAR(255) NOT NULL,
    created_at VARCHAR(255) NOT NULL
);

INSERT INTO contacts (name, message, email, created_at)
VALUES ('Testing Jones', 'What is Lorem Ipsum?
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        'testing@example.com', CURRENT_TIMESTAMP),
       ('Michael Sievenpiper', 'Why do we use it?
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
        'msievenpiperdev@gmail.com', CURRENT_TIMESTAMP);