CREATE TABLE recipients (
    id INT AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE special_offers (
    id INT AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    discount FLOAT(4,2) NOT NULL,
    expiration_date date NOT NULL, 
    created_at date NOT NULL, 
    updated_at date NOT NULL, 
    PRIMARY KEY (id)
);

CREATE TABLE voucher_codes (
    id INT AUTO_INCREMENT,
    special_offer_id INT NOT NULL,
    recipient_id INT NOT NULL,
    code VARCHAR(16) NOT NULL,
    used_at date NOT NULL, 
    created_at date NOT NULL, 
    updated_at date NOT NULL, 
    PRIMARY KEY (id)
);

--Foreign keys
--Indexes
