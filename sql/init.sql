CREATE TABLE IF NOT EXISTS moneda (
    id_moneda SERIAL PRIMARY KEY,
    nombre_moneda VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS material (
    id_material SERIAL PRIMARY KEY,
    nombre_material VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS bodega (
    id_bodega SERIAL PRIMARY KEY,
    nombre_bodega VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS sucursal (
    id_sucursal SERIAL PRIMARY KEY,
    nombre_sucursal VARCHAR(100),
    id_bodega INT REFERENCES bodega(id_bodega)
);

CREATE TABLE IF NOT EXISTS producto (
    codigo VARCHAR PRIMARY KEY,
    nombre VARCHAR(100),
    id_sucursal INT REFERENCES sucursal(id_sucursal),
    precio DECIMAL(10,2),
    id_moneda INT REFERENCES moneda(id_moneda),
    descripcion VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS material_producto (
    id_material INT REFERENCES material(id_material),
    codigo_producto VARCHAR REFERENCES producto(codigo),
    PRIMARY KEY (id_material, codigo_producto)
);

INSERT INTO material(id_material, nombre_material) VALUES (1, 'vidrio'), (2, 'plástico'), (3, 'textil'), (4, 'madera'), (5, 'metal');
INSERT INTO bodega(id_bodega, nombre_bodega) VALUES (1, 'AKIKB'), (2, 'Enea'), (3, 'El Cortijo'), (4, 'Hotel Marriot'), (5, 'Mall Plaza Los Domínicos');
INSERT INTO sucursal(id_sucursal, id_bodega, nombre_sucursal) VALUES (101, 1, 'Colina'), (102, 1, 'San Bernardo'), (201, 2, 'Quilicura'), (202, 2, 'Cerrillos'), (301, 3, 'Buin'), (302, 3, 'San José de Maipo'), (401, 4, 'Maipú'), (501, 5, 'Melipilla');
INSERT INTO moneda(id_moneda, nombre_moneda) VALUES (1, 'Dólar americano'), (2, 'Peso chileno'), (3, 'Peso colombiano'), (4, 'Peso mexicano'), (5, 'Sol');
INSERT INTO producto VALUES ('A1234', 'Sillón', 101, 250000, 2, 'Un sillón de última costura');
INSERT INTO material_producto(id_material, codigo_producto) VALUES (3, 'A1234'), (4, 'A1234');