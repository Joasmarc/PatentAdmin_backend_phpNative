CREATE TABLE person (
    value_id VARCHAR(155) NOT NULL UNIQUE,
    type_id VARCHAR(2) NOT NULL,
    name VARCHAR(55) NOT NULL,
    last_name VARCHAR(55) NOT NULL,
    sex VARCHAR(2) NOT NULL,
    PRIMARY KEY(value_id),
    CONSTRAINT fk_typeid
    FOREIGN KEY(type_id)
	REFERENCES type_id(id),
    CONSTRAINT fk_sex
    FOREIGN KEY(sex)
	REFERENCES sex(id)
)

CREATE TABLE sex (
    id VARCHAR(2) NOT NULL,
    name VARCHAR(30) NOT NULL,
    PRIMARY KEY(id)
)

CREATE TABLE type_id (
    id VARCHAR(2) NOT NULL,
    name VARCHAR(40) NOT NULL,
    PRIMARY KEY(id)
)