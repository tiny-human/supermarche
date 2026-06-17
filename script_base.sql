CREATE TABLE utilisateur (
    id       INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
);

CREATE TABLE caisse (
    id     INTEGER PRIMARY KEY AUTOINCREMENT,
    numero TEXT NOT NULL
);

CREATE TABLE produit (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    designation    TEXT NOT NULL,
    prix           REAL NOT NULL,
    quantite_stock INTEGER NOT NULL
);

CREATE TABLE achat (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    caisse_id  INTEGER NOT NULL,
    date_achat TEXT DEFAULT (datetime('now')),
    statut     TEXT DEFAULT 'en_cours',
    FOREIGN KEY (caisse_id) REFERENCES caisse(id)
);

CREATE TABLE ligne_achat (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    achat_id   INTEGER NOT NULL,
    produit_id INTEGER NOT NULL,
    quantite   INTEGER NOT NULL,
    montant    REAL NOT NULL,
    FOREIGN KEY (achat_id)   REFERENCES achat(id),
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);

-- 2 caisses
INSERT INTO caisse (numero) VALUES ('C01'), ('C02');

-- 5 produits
INSERT INTO produit (designation, prix, quantite_stock) VALUES
    ('Biscuit', 1000, 50),
    ('Pain',     400, 30),
    ('Lait 1L',  800, 40),
    ('Riz 1kg', 1200, 60),
    ('Savon',    500, 25);

-- 1 utilisateur
INSERT INTO utilisateur (username, password) VALUES ('admin', 'admin123');