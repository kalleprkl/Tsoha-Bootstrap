CREATE TABLE Tutkija (
	tutkija_id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	kayttajatunnus text,
	salasana text
);

CREATE TABLE Vesisto (
	kohde_id SERIAL PRIMARY KEY,
	nimi TEXT,
	paikkakunta TEXT
);

CREATE TABLE Naytteenottopaikka (
	koordinaatit TEXT PRIMARY KEY,
	kohde INTEGER REFERENCES Vesisto(kohde_id) ON DELETE CASCADE,
	nimi TEXT,
	lahestymisohje	TEXT
);

CREATE TABLE Kenttatutkimusraportti (
	tutkimus_id SERIAL PRIMARY KEY,
	tutkija 	INTEGER REFERENCES Tutkija(tutkija_id) ON DELETE CASCADE,
	sijainti TEXT REFERENCES Naytteenottopaikka(koordinaatit) ON DELETE CASCADE,
	pvm DATE,
	vari TEXT,
	haju	TEXT,
	sameus TEXT,
	lampotila DECIMAL,
	pH DECIMAL, 
	muuta TEXT
);

CREATE TABLE Nayte (
	nayte_id SERIAL PRIMARY KEY,
	tutkimus INTEGER REFERENCES Kenttatutkimusraportti(tutkimus_id) ON DELETE CASCADE,
	tulokset TEXT
);




