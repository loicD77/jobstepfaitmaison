
CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE parcours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objet VARCHAR(255) NOT NULL,
    description TEXT,
    candidate_id INT,
    CONSTRAINT fk_parcours_user FOREIGN KEY (candidate_id) REFERENCES `user`(id)
);

CREATE TABLE etape (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descriptif TEXT NOT NULL,
    consignes TEXT,
    position INT NOT NULL,
    parcours_id INT,
    CONSTRAINT fk_etape_parcours FOREIGN KEY (parcours_id) REFERENCES parcours(id)
);

CREATE TABLE ressource (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intitule VARCHAR(255) NOT NULL,
    presentation TEXT,
    support VARCHAR(255) NOT NULL,
    nature VARCHAR(255) NOT NULL,
    url VARCHAR(255),
    etape_id INT,
    CONSTRAINT fk_ressource_etape FOREIGN KEY (etape_id) REFERENCES etape(id)
);

CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_heure DATETIME NOT NULL,
    sender_id INT,
    CONSTRAINT fk_message_user FOREIGN KEY (sender_id) REFERENCES `user`(id)
);

CREATE TABLE rendu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    date_heure DATETIME NOT NULL,
    user_id INT,
    etape_id INT,
    message_id INT,
    CONSTRAINT fk_rendu_user FOREIGN KEY (user_id) REFERENCES `user`(id),
    CONSTRAINT fk_rendu_etape FOREIGN KEY (etape_id) REFERENCES etape(id),
    CONSTRAINT fk_rendu_message FOREIGN KEY (message_id) REFERENCES message(id)
);
