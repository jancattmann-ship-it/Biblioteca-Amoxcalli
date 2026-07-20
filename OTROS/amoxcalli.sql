-- Adminer 5.4.2 MariaDB 11.8.6-MariaDB-0+deb13u1 from Debian dump
SET
    FOREIGN_KEY_CHECKS = 0;

-- (todo el contenido exportado)
SET
    NAMES utf8;

SET
    time_zone = '+00:00';

SET
    foreign_key_checks = 0;

SET
    sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET
    NAMES utf8mb4;

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
    `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
    `slug` varchar(50) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `color` varchar(20) DEFAULT NULL,
    `orden` int(11) NOT NULL DEFAULT 0,
    `imagen` varchar(100) DEFAULT NULL,
    `descripcion` varchar(150) DEFAULT NULL,
    PRIMARY KEY (`id_categoria`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_uca1400_ai_ci;

INSERT INTO
    `categorias` (
        `id_categoria`,
        `slug`,
        `nombre`,
        `color`,
        `orden`,
        `imagen`,
        `descripcion`
    )
VALUES
    (
        1,
        'violeta',
        'Violeta',
        '#9C27B9',
        1,
        'la_piel.jpg',
        NULL
    ),
    (
        2,
        'cuentos_infantiles',
        'Cuentos Infantiles',
        NULL,
        2,
        NULL,
        NULL
    ),
    (
        3,
        'biblioteca_universal',
        'Biblioteca Universal',
        '#582619',
        3,
        'biblioteca_universal.webp',
        NULL
    ),
    (
        4,
        'nuevos',
        'Libros Nuevos',
        '#EAB847',
        4,
        'el_spirit.jpg',
        'Libros recientemente donados a la biblioteca'
    ),
    (5, 'terror', 'Terror', NULL, 5, NULL, NULL),
    (6, 'ciencias', 'Ciencias', NULL, 6, NULL, NULL),
    (
        7,
        'matematicas',
        'Matemáticas',
        NULL,
        7,
        NULL,
        NULL
    ),
    (8, 'medicina', 'Medicina', NULL, 8, NULL, NULL),
    (
        9,
        'autores_destacados',
        'Autores Destacados',
        NULL,
        9,
        NULL,
        NULL
    ),
    (
        10,
        'historia_general',
        'Historia General',
        NULL,
        12,
        NULL,
        NULL
    ),
    (
        11,
        'historia_mexico',
        'Historia de México',
        NULL,
        13,
        NULL,
        NULL
    ),
    (
        12,
        'revolucion_mexicana',
        'Revolución Mexicana',
        NULL,
        14,
        NULL,
        NULL
    ),
    (
        13,
        'cultura_general',
        'Cultura General',
        NULL,
        15,
        NULL,
        NULL
    ),
    (
        14,
        'cultura_mexico',
        'Cultura de México',
        NULL,
        16,
        NULL,
        NULL
    ),
    (15, 'religion', 'Religión', NULL, 17, NULL, NULL),
    (
        16,
        'diccionarios_enciclopedias',
        'Diccionarios y Enciclopedias',
        NULL,
        18,
        NULL,
        NULL
    ),
    (
        18,
        'fce',
        'Fondo de Cultura Económica',
        '#db2029',
        10,
        'fondo_logo.jpeg',
        NULL
    ),
    (
        19,
        'fedem',
        'Fondo Editorial del Estado de Morelos',
        '#3a4a3f',
        11,
        'FEDEM.jpg',
        NULL
    );

DROP TABLE IF EXISTS `libros`;

CREATE TABLE `libros` (
    `cod_libro` varchar(10) NOT NULL,
    `titulo` varchar(200) NOT NULL,
    `imagen` varchar(100) DEFAULT NULL,
    `id_categoria` int(11) DEFAULT NULL,
    `id_subcategoria` int(11) DEFAULT NULL,
    `id_tema` int(11) DEFAULT NULL,
    `autor` varchar(180) DEFAULT NULL,
    PRIMARY KEY (`cod_libro`),
    KEY `id_categoria` (`id_categoria`),
    KEY `id_subcategoria` (`id_subcategoria`),
    KEY `id_tema` (`id_tema`),
    CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE
    SET
        NULL,
        CONSTRAINT `libros_ibfk_2` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategorias` (`id_subcategoria`) ON DELETE
    SET
        NULL,
        CONSTRAINT `libros_ibfk_3` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id_tema`) ON DELETE
    SET
        NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

INSERT INTO
    `libros` (
        `cod_libro`,
        `titulo`,
        `imagen`,
        `id_categoria`,
        `id_subcategoria`,
        `id_tema`,
        `autor`
    )
VALUES
    (
        'ADM2N00005',
        'Administración de riesgos III',
        'Administracion_III.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'ADM3N00006',
        'Administración de riesgos IV',
        'administracion_riesgos_IV.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'ADMIN00004',
        'Administración de riesgos II',
        'Administracion_II.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'AGEND00007',
        'Agenda de la agonía. Agonique agenda',
        'agenda_agonia.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ALINE00008',
        'Aline Pettersson. Los territorios vastos',
        'territorios_vastos.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'AMANT00009',
        'Amante y el artefacto soviético, el',
        'amante_sovietico.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ANALI00010',
        'Análisis y controversias sobre las actuales políticas',
        'analisis_controversias.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'ANDAN00011',
        'Andanza y voces de los tres Ernestos, La',
        'nicaraguenses.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ANGEL00012',
        'Angelina Muñiz Huberman. Escritura en tierra',
        'escritura_tierra.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ANO2P00003',
        'A 100 años de la primera constitución política 2',
        '100años_2.jfif',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'ANOSP00002',
        'A 100 años de la primera constitución política 1',
        '100años.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'ANTOL00165',
        'Antología de poetas líricos castellanos',
        'antologia.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'ANTOL00213',
        'Antología de poesía mexicana del siglo XIX',
        'antologia_poesia.jpg',
        18,
        NULL,
        NULL,
        'Ezra Alcázar y Negrín Muñoz'
    ),
    (
        'APOCA00214',
        'Apocalipstick',
        'apocalipstick.jpg',
        18,
        NULL,
        NULL,
        'Carlos Monsiváis'
    ),
    (
        'APU2T00014',
        'Apuntes para una investigación evaluativa',
        'apuntes.png',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'APUNT00013',
        'Apuntes de un español sobre poetas de América',
        'apuntes_español.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ARTED00166',
        'Arte de la biografía',
        '',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'ARTET00015',
        'Arte, teoría y tecnología en el diseño',
        'arte_teoria.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'AVATA00016',
        'Avatares de la digitalización en la forma',
        'avatares.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'AVESA00198',
        'Aves acuáticas de Morelos (vol. I)',
        'aves_morelos_vol1.webp',
        6,
        6,
        6,
        'Fernando Urbina Torres'
    ),
    (
        'AVESA00199',
        'Aves acuáticas de Morelos (vol. II)',
        'aves_morelos_vol2.webp',
        6,
        6,
        6,
        'Fernando Urbina Torres'
    ),
    (
        'AVESR00200',
        'Aves rapaces de México',
        'aves_rapaces.jpg',
        6,
        6,
        6,
        'Fernando Urbina Torres y Guillermo Morales González'
    ),
    (
        'AZTEC00294',
        'Azteca (portada españoles)',
        NULL,
        11,
        NULL,
        NULL,
        'Gary Jennings'
    ),
    (
        'AZTEC00303',
        'Azteca (portada indígenas)',
        NULL,
        11,
        NULL,
        NULL,
        'Gary Jennings'
    ),
    (
        'BALUN00157',
        'Balún Canán',
        'balun_canan.jpg',
        18,
        NULL,
        NULL,
        'Rosario Castellanos'
    ),
    (
        'BARBA00017',
        'Bárbaros contra cristianos',
        'barbaros_vs_cristianos.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'BATAL00291',
        'Batalla de Churubusco el 20 de agosto de 1847',
        NULL,
        11,
        NULL,
        NULL,
        'Departamento del Distrito Federal'
    ),
    (
        'BESOL00018',
        'Besolario',
        'besolario.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'BILOP00019',
        'Bilopayoo funk',
        'bilopayoo.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'BIOTE00020',
        'Biotecnología y sociedad',
        'biotecnologia_sociedad.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'BOLIV00021',
        'Bolívar Echeverría. Modernidad y resistencia',
        'bolivar_echeverria.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'BRAZO00022',
        'Brazos del tiempo',
        'brazos_tiempo.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'BREVE00215',
        'Breve historia de la guerra con los Estados Unidos',
        'breve_historia.jpg',
        18,
        NULL,
        NULL,
        'José C. Valadés'
    ),
    (
        'CACOF00023',
        'Cacofónicos y disléxicos',
        'cacofonicos.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'CAMBI00024',
        'Cambios y procesos emergentes en el desarrollo',
        'cambios_procesos.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'CANEK00216',
        'Canek',
        'canek.jpg',
        18,
        NULL,
        NULL,
        'Ermilo Abreu Gómez'
    ),
    (
        'CANTO00025',
        'Canto del guerrero',
        'canto_guerrero.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'CAPIT00026',
        'Capital, salario y crisis',
        'capital.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'CASAS00027',
        'Casas son como los cuerpos, las',
        'casas_cuerpos.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'CICUT00028',
        'Cicuta del tiempo',
        'cicuta.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'CINCU00029',
        'Cincuenta años de Shinzaburo Takeda en México',
        'cincuenta_años.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'CIUDA00030',
        'Ciudad como cultura, la',
        'ciudad_cultura.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'COM2E00034',
        'Competitividad de la industria petroquímica',
        'la_competitividad.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'COMED00167',
        'Comedias',
        'comedias.webp',
        3,
        NULL,
        NULL,
        'Shakespeare'
    ),
    (
        'COMON00031',
        'Cómo nace una editora',
        'nace_escritora.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'COMOP00032',
        'Como un pez rojo',
        'pex_rojo.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'COMPE00033',
        'Compendio argumentado de hermenéutica',
        'compendio.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'COMUN00035',
        'Comunidades y contextos en las teorías',
        'comunidades.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'CONTR00036',
        'Contribuciones para una historia',
        'contribuciones_para_una.jfif',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'CORRE00290',
        'Corresponsales mexicanos en la II Guerra Mundial',
        NULL,
        11,
        NULL,
        NULL,
        'Carlos J. Sierra Brabatta y Berenice Locroix Macosay'
    ),
    (
        'CREAR00037',
        'Crear crearse. Engendrar y dar vida',
        'crearse.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'CRISO00038',
        'Crisol del pensamiento colectivo',
        'crisol.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'CRONI00217',
        'Crónicas de amor, de historia y de guerra',
        'cronicas_amor.jpg',
        18,
        NULL,
        NULL,
        'Guillermo Prieto'
    ),
    (
        'CRONI00293',
        'Crónica morelense - memoria de ponencias',
        NULL,
        11,
        NULL,
        NULL,
        NULL
    ),
    (
        'CUART00039',
        'Cuarto paradigma',
        'cuarto_paradigma.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'CUERP00040',
        'Cuerpos inciertos',
        'cuerpos.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'CULTU00041',
        'Cultura laboral y productividad en Telmex',
        'Telmex.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'DEBAT00043',
        'Debates y estudios de la movilidad laboral',
        'debates.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'DELOS00168',
        'De los héroes, hombres representativos',
        'de_los_hombres.webp',
        3,
        NULL,
        NULL,
        'Carlyle y Emerson'
    ),
    (
        'DERIV00045',
        'Derivas críticas del museo en América Latina',
        'derivas.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'DES2E00048',
        'Desde la escucha',
        'la_escucha.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'DESAF00046',
        'Desafíos para la calidad de la democracia',
        'desafios.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'DESDE00047',
        'Desde el norte. Narrativa canadiense',
        'desde_norte.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'DESNU00049',
        'Desnudo y arte',
        'desnudo.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'DESPU00050',
        'Después de la revolución, los caciques y',
        'despues_de_revolucion.jfif',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'DIABL00051',
        'Diablo en el cuerpo',
        'diavlo.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'DIALO00169',
        'Diálogos socráticos',
        'dialogos_socraticos.webp',
        3,
        NULL,
        NULL,
        'Platón'
    ),
    (
        'DICCI00242',
        'Diccionario enciclopédico UTEHA tomo (I)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00243',
        'Diccionario enciclopédico UTEHA tomo (II)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00244',
        'Diccionario enciclopédico UTEHA tomo (III)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00245',
        'Diccionario enciclopédico UTEHA tomo (IV)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00246',
        'Diccionario enciclopédico UTEHA tomo (V)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00247',
        'Diccionario enciclopédico UTEHA tomo (VI)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00248',
        'Diccionario enciclopédico UTEHA tomo (VII)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00249',
        'Diccionario enciclopédico UTEHA tomo (VIII)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00250',
        'Diccionario enciclopédico UTEHA tomo (IX)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00251',
        'Diccionario enciclopédico UTEHA tomo (X)',
        'uteha.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00252',
        'Diccionario léxico hispano (I)',
        'lexico_espanol.webp',
        16,
        NULL,
        NULL,
        'W. M. Jackson, Inc., editores'
    ),
    (
        'DICCI00253',
        'Diccionario léxico hispano (II)',
        'lexico_espanol.webp',
        16,
        NULL,
        NULL,
        'W. M. Jackson, Inc., editores'
    ),
    (
        'DICCI00255',
        'Diccionario enciclopédico Hachette Castell (I)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00256',
        'Diccionario enciclopédico Hachette Castell (II)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00257',
        'Diccionario enciclopédico Hachette Castell (III)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00258',
        'Diccionario enciclopédico Hachette Castell (V)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00259',
        'Diccionario enciclopédico Hachette Castell (VI)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00260',
        'Diccionario enciclopédico Hachette Castell (VII)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00261',
        'Diccionario enciclopédico Hachette Castell (VIII)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00262',
        'Diccionario enciclopédico Hachette Castell (IX)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00263',
        'Diccionario enciclopédico Hachette Castell (X)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00264',
        'Diccionario enciclopédico Hachette Castell (XI)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00265',
        'Diccionario enciclopédico Hachette Castell (XII)',
        'athos.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'DICCI00266',
        'Diccionario enciclopédico de México (A-B)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00267',
        'Diccionario enciclopédico de México (C-D)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00268',
        'Diccionario enciclopédico de México (E-G)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00269',
        'Diccionario enciclopédico de México (H-L)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00270',
        'Diccionario enciclopédico de México (M-N)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00271',
        'Diccionario enciclopédico de México (O-Q)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00272',
        'Diccionario enciclopédico de México (R-S)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DICCI00273',
        'Diccionario enciclopédico de México (T-Z)',
        'diccionario_mexico.webp',
        16,
        NULL,
        NULL,
        'Humberto Musacchio'
    ),
    (
        'DOCEN00052',
        'Docente y la mediación de los nuevos capítulos',
        'docente.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'DOLOR00053',
        'Dolores Castro. A la sombra de las palabras',
        'dolores.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ELEME00054',
        'Elementos básicos de estadística y probabilidad',
        'elementos.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'ELHOM00277',
        'Historia del hombre - Prehistoria (I): El hombre prehistórico',
        NULL,
        10,
        NULL,
        NULL,
        NULL
    ),
    (
        'ELING00170',
        'El ingenioso hidalgo Don Quijote de la Mancha (I)',
        'don_quijote.webp',
        3,
        NULL,
        NULL,
        'Cervantes'
    ),
    (
        'ELLIB00158',
        'El libro que canta',
        'el_libro_que_canta.jpg',
        1,
        NULL,
        NULL,
        'Yolanda Reyes y Cristina López'
    ),
    (
        'ELLIB00218',
        'El libro rojo de la independencia',
        'libro_rojo.jpg',
        18,
        NULL,
        NULL,
        'Vicente Riva Palacio, Manuel Payno'
    ),
    (
        'ELLIB00219',
        'El libro vacío',
        'libro_vacio.jpg',
        18,
        NULL,
        NULL,
        'Josefina Vicens'
    ),
    (
        'ELSUE00159',
        'El sueño correcto',
        'sueno_correcto.jpg',
        1,
        NULL,
        NULL,
        'Aline Davidoff'
    ),
    (
        'ENC2E00057',
        'Encuentros. Arte y nuevos medios',
        'encuentros.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ENCEN00055',
        'Encender el mundo',
        'encender.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ENCUE00056',
        'Encuentro de dos empeños: la educación superior',
        'empeños.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'ENRIQ00058',
        'Enrique Segarra, grabador de luz',
        'segarra.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ENSAY00171',
        'Ensayistas ingleses',
        'ensayistas_ingleses.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'ENSAY00172',
        'Ensayos',
        'ensayos.webp',
        3,
        NULL,
        NULL,
        'Montaigne'
    ),
    (
        'ESCRI00173',
        'Escritores místicos españoles',
        'escritores_misticos.webp',
        3,
        NULL,
        NULL,
        'Fray Luis de Granada, Santa Teresa de Jesús, Fray Luis de León'
    ),
    (
        'ESCRI00174',
        'Escritos escogidos',
        'escritos_escogidos.webp',
        3,
        NULL,
        NULL,
        'Pascal, Bossuet'
    ),
    (
        'ESPAN00059',
        'Espantosa y maravillosa vida de Roberto',
        'roberto.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ESPRI00060',
        'Esprit Gaillard que ríe, el',
        'el_spirit.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'EST2D00065',
        'Estudios y argumentaciones hermenéuticas (II)',
        'argumentaciones_2.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'EST3D00066',
        'Estudios y argumentaciones hermenéuticas (III)',
        'argumentaciones_3.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'EST4D00067',
        'Estudios y argumentaciones hermenéuticas (IV)',
        'argumentaciones_4.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'EST5D00068',
        'Estudios y argumentaciones hermenéuticas (V)',
        'argumentaciones_5.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'EST6D00069',
        'Estudios y argumentaciones hermenéuticas (VI)',
        'argumentaciones_6.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'ESTAD00061',
        'Estado de derecho y la calidad de la democracia',
        'estado_derecho.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'ESTHE00062',
        'Esther Seligson. Fugacidad y permanencia',
        'fugacidad.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'ESTRA00063',
        'Estrategias territoriales, recampesinización',
        'estrategias_territoriales.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'ESTUD00064',
        'Estudio de los procesos de reforma económica',
        'estudio_procesos.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'EXPRE00070',
        'Expresiones territoriales latinoamericanas',
        'expresiones_territoriales.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'FAUST00175',
        'Fausto',
        'fausto.webp',
        3,
        NULL,
        NULL,
        'Goethe'
    ),
    (
        'FLAMA00071',
        'Flama del tiempo, la',
        'flama_tiempo.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'FORMA00072',
        'Formación ciudadana en estudiantes universitarios',
        'formacion_ciudadana.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'FUTUR00073',
        'Futuro de la movilidad urbana y los vehículos',
        'futuro_movilidad.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'GALER00074',
        'Galería de las ciencias',
        'galeria_ciencias.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'GASNA00075',
        'Gas natural y su geografía industrial en México',
        'gas_natural.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'GENTE00076',
        'Gente con nombre de calle',
        'nombre_calle.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'GLOBA00077',
        'Globalización versus desarrollo',
        'globalizacion_vs.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'GRAND00176',
        'Grandes cuentistas',
        'cuentistaa.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'GRAND00177',
        'Grandes escritores rusos',
        'grandes_rursos.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'GUIAD00201',
        'Guía de aves',
        'guia_aves.png',
        6,
        6,
        6,
        'Gianfranco Bologna'
    ),
    (
        'GUIAD00202',
        'Guía de aves (Corredor Biológico Chichinautzin)',
        'guia_aves_corredor.webp',
        6,
        6,
        6,
        'CONANP / SEMARNAT / Gobierno Federal'
    ),
    (
        'HABIT00078',
        'Habitar la casa: historia, actualidad y',
        'habitar_casa.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'HACIA00079',
        'Hacia una mejora de políticas para la ecoinnovación',
        'innovacion.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'HETER00080',
        'Heterodoxia. Ensayos de teoría económica',
        'heterodoxia.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'HISTO00178',
        'Historiadores de Indias',
        'indias.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'HISTO00289',
        'Historia general de la revolución mexicana (V)',
        NULL,
        11,
        NULL,
        NULL,
        'José C. Valadés'
    ),
    (
        'HISTO00301',
        'Historia de la cultura',
        NULL,
        13,
        NULL,
        NULL,
        'José Manuel Lozano Fuentes'
    ),
    (
        'HUELL00081',
        'Huella posible, la',
        'huella.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'INDIC00082',
        'Indicadores de satisfacción de la infraestructura',
        'satisfaccion.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'INDIS00001',
        '(In)disciplinar la investigación',
        'indisciplinar.jfif',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'INNOV00083',
        'Innovación. Instituciones, redes y aprendizaje',
        'innovacion.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'INSER00084',
        'Inserción de México en el siglo XXI, la',
        'inserccion.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'INSTI00085',
        'Instituciones y desarrollo',
        'instituciones.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'INTER00086',
        'Interpelaciones del arte, el diseño y la',
        'interpelaciones.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'INTRO00087',
        'Introducción al color',
        'introduccion.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'JOS2F00091',
        'Josefina Vicens: un clásico por descubrir',
        'un_clasico.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'JOSEF00090',
        'Josefina Vicens. Una vida contracorriente',
        'una_vida.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'JOSER00089',
        'José Revueltas un rebelde melancólico',
        'melancolico.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'LABER00092',
        'Laberintos de la racionalidad crisis científica',
        'laberintos.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'LACTA00093',
        'Lactancia humana y equidad de género',
        'lactancia.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'LADIV00179',
        'La divina comedia',
        'divina_comedia.webp',
        3,
        NULL,
        NULL,
        'Dante'
    ),
    (
        'LAHER00203',
        'La herbolaria en México',
        'herbolaria_mexico.jpg',
        6,
        6,
        8,
        'Xavier Lozoya'
    ),
    (
        'LAILI00180',
        'La Ilíada',
        'homero.webp',
        3,
        NULL,
        NULL,
        'Homero'
    ),
    (
        'LAINF00234',
        'La infancia es la certeza de las cosas sucias, rotas y muertas',
        'la_infancia.webp',
        19,
        9,
        NULL,
        'Denisse Buendía Castañeda'
    ),
    (
        'LANOC00292',
        'La noche de Tlatelolco',
        NULL,
        11,
        NULL,
        NULL,
        'Elena Poniatowska'
    ),
    (
        'LAPIE00160',
        'La piel del cielo',
        'la_piel.jpg',
        1,
        NULL,
        NULL,
        'Elena Poniatowska'
    ),
    (
        'LARAT00204',
        'La rata',
        'adrian.jpeg',
        6,
        6,
        5,
        'Patricio Whitehouse'
    ),
    (
        'LAROU00236',
        'Larousse universal ilustrado (I)',
        'larousse_ilustrado.webp',
        16,
        NULL,
        NULL,
        'Dirigido por Claude y Paul Augé'
    ),
    (
        'LAROU00237',
        'Larousse universal ilustrado (II)',
        'larousse_ilustrado.webp',
        16,
        NULL,
        NULL,
        'Dirigido por Claude y Paul Augé'
    ),
    (
        'LAROU00238',
        'Larousse universal ilustrado (III)',
        'larousse_ilustrado.webp',
        16,
        NULL,
        NULL,
        'Dirigido por Claude y Paul Augé'
    ),
    (
        'LAROU00239',
        'Larousse universal ilustrado (IV)',
        'larousse_ilustrado.webp',
        16,
        NULL,
        NULL,
        'Dirigido por Claude y Paul Augé'
    ),
    (
        'LAROU00240',
        'Larousse universal ilustrado (V)',
        'larousse_ilustrado.webp',
        16,
        NULL,
        NULL,
        'Dirigido por Claude y Paul Augé'
    ),
    (
        'LAROU00241',
        'Larousse universal ilustrado (VI)',
        'larousse_ilustrado.webp',
        16,
        NULL,
        NULL,
        'Dirigido por Claude y Paul Augé'
    ),
    (
        'LAROU00254',
        'Larousse illustrated international dictionary',
        'larousse_ingles.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'LAROU00274',
        'Larousse \"La gran\" portátil (tomo I) — El mundo, ciencias y tecnología',
        'larousse_portatil.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'LAROU00275',
        'Larousse \"La gran\" portátil (tomo II) — Ciencias de la vida, las artes',
        'larousse_portatil.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'LAROU00276',
        'Larousse \"La gran\" portátil (tomo III) — Historia universal, la sociedad',
        'larousse_portatil.webp',
        16,
        NULL,
        NULL,
        NULL
    ),
    (
        'LASAM00161',
        'Las amistades peligrosas',
        'amistades_peligrosas.jpg',
        1,
        NULL,
        NULL,
        'Choderlos de Laclos'
    ),
    (
        'LASCO00181',
        'Las confesiones',
        'confesiones.webp',
        3,
        NULL,
        NULL,
        'Rousseau'
    ),
    (
        'LASOM00220',
        'La sombra del caudillo',
        'sombra_caudillo.jpg',
        18,
        NULL,
        NULL,
        'Martín Luis Guzmán'
    ),
    (
        'LASSE00205',
        'Las serpientes',
        'las_serpientes.webp',
        6,
        6,
        7,
        'Dr. David Kirshner y Kim Graham'
    ),
    (
        'LATIN00094',
        'Latinoamérica en breve',
        'latinoamerica.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'LECHU00155',
        'Y la lechuza sale a cazar',
        'lechuza.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'LEXIC00095',
        'Léxico tipográfico e histórico',
        'lexico_mexico.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'LEYTE00099',
        'Ley televisa y la lucha por el poder en México',
        'ley_televisa.jfif',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'LIBRO00100',
        'Libro oliva de las hadas, el',
        'libro_oliva.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'LITER00182',
        'Literatura epistolar',
        'epistolar.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'LOSDE00221',
        'Los de abajo',
        'los_de_abajo.jpg',
        18,
        NULL,
        NULL,
        'Mariano Azuela'
    ),
    (
        'LOSIN00206',
        'Los insectos',
        'los_insectos.jpg',
        6,
        6,
        4,
        'Maryellen Gregoire'
    ),
    (
        'LOSRE00207',
        'Los reptiles',
        'los_reptiles.webp',
        6,
        6,
        9,
        'No especificado'
    ),
    (
        'LOSSU00162',
        'Los sueños',
        'los_suenos.webp',
        1,
        NULL,
        NULL,
        'Elsa Cross'
    ),
    (
        'LUG2R00149',
        'Un lugar para los libros',
        'un_lugar.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'LUGAR00101',
        'Lugar de enunciación',
        'enunciacion.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'LUNAT00163',
        'Lunática',
        'lunatica.jpg',
        1,
        NULL,
        NULL,
        'Martha Riva Palacio y Merche López'
    ),
    (
        'MALNE00102',
        'Mal necesario, el',
        'mal_necesario.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'MANUA00208',
        'Manual de la Selva Lacandona',
        'manual_selva_lacandona.webp',
        6,
        6,
        8,
        'Varios'
    ),
    (
        'MARIA00103',
        'María Luisa Puga y el espacio de la reconstrucción',
        'espacio.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'MARIP00209',
        'Mariposa monarca en México',
        'mariposa_monarca.webp',
        6,
        6,
        4,
        'No especificado (gobierno)'
    ),
    (
        'MATEM00300',
        'Matemáticas simplificadas',
        NULL,
        7,
        NULL,
        NULL,
        NULL
    ),
    (
        'MEMOR00104',
        'Memorias de guerra de una pequeña Francia',
        'memorias.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'MISCE00105',
        'Miscelánea. Curato de Iztacalco',
        'miscelanea.jfif',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'MODAL00106',
        'Modalidades alternas para la innovación',
        'modalidades.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'MONAR00107',
        'Monarca, el ciudadano y el excluido, el',
        'monarca.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'MONED00108',
        'Moneda y la banca durante la revolución',
        'moneda.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'MORAL00183',
        'Moralistas castellanos',
        'moralistas.webp',
        3,
        NULL,
        NULL,
        'Guevara, Valdés, Vives, Saavedra Fajardo, Gracián'
    ),
    (
        'NECRO00231',
        'Necroescritura de los días muy vivos',
        'necroescritura.jpeg',
        19,
        8,
        NULL,
        'Alma Karla Sandoval'
    ),
    (
        'NEURO00109',
        'Neuroética: relaciones entre mente/cerebro',
        'neuroetica.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'NINAS00164',
        'Niñas',
        'ninas.jpeg',
        1,
        NULL,
        NULL,
        'Marta Vicente'
    ),
    (
        'NOTEO00230',
        'No te olvides de mí, Berlín',
        'berlin.webp',
        19,
        8,
        NULL,
        'María Teresa Meneses'
    ),
    (
        'NOTIC00222',
        'Noticias biográficas de insurgentes apodados',
        'noticias_biograficas.jpg',
        18,
        NULL,
        NULL,
        'Elías Amador'
    ),
    (
        'NOVEL00184',
        'Novelas y cuentos',
        'novellas_cuentos.webp',
        3,
        NULL,
        NULL,
        'Dostoievski y Tolstói'
    ),
    (
        'NUEST00110',
        'Nuestro cónsul en Lima',
        'consul.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'OBRAS00185',
        'Obras escogidas (Quevedo)',
        'quevedo.webp',
        3,
        NULL,
        NULL,
        'Quevedo'
    ),
    (
        'OBRAS00186',
        'Obras escogidas (Voltaire, Diderot)',
        'obras_escogidas.webp',
        3,
        NULL,
        NULL,
        'Voltaire, Diderot'
    ),
    (
        'OBRAS00187',
        'Obras filosóficas',
        'obras_filosoficas.webp',
        3,
        NULL,
        NULL,
        'Aristóteles'
    ),
    (
        'OBRAS00188',
        'Obras poéticas',
        'obras_poeticas.webp',
        3,
        NULL,
        NULL,
        'Virgilio, Horacio'
    ),
    (
        'OFICI00111',
        'Oficios y menesteres',
        'oficios.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'OTRAM00112',
        'Otra mirada a las universidades públicas',
        'otra_mirada.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'OTROM00299',
        'Otro mundo posible',
        NULL,
        19,
        9,
        NULL,
        'Miriam Ponce Ruiz'
    ),
    (
        'PAJAR00210',
        'Pájaros',
        'pajaros.webp',
        6,
        6,
        6,
        'Susan Canizares y Pamela Chanko'
    ),
    (
        'PARAC00113',
        'Para contender con la pobreza',
        'contender.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'PARTE00114',
        'Partes de maltrato',
        'maltrato.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'PASAD00044',
        'Del pasado al futuro',
        'del_pasado_al_futuro.jfif',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'PASEO00223',
        'Paseo de la Reforma',
        'paseo_reforma.jpg',
        18,
        NULL,
        NULL,
        'Elena Poniatowska'
    ),
    (
        'PEDAG00115',
        'Pedagogía del diseño en el sistema modular',
        'pedagogia.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'PENSA00116',
        'Pensar la UAM en la pandemia: reflexiones',
        'uam.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'PERIF00117',
        'Periferia, poemas',
        'poemas.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'PLANT00211',
        'Plantas sin flor',
        'plantas_flor.webp',
        6,
        6,
        8,
        'Varios / no especificado'
    ),
    (
        'POETA00189',
        'Poetas dramáticos españoles I',
        'poetas_dramas.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'POETA00190',
        'Poetas dramáticos españoles II',
        'poetas_dramas_2.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'POETA00191',
        'Poetas dramáticos griegos',
        'poetas_dramas_griegos.webp',
        3,
        NULL,
        NULL,
        'Esquilo, Sófocles, Eurípides, Aristófanes'
    ),
    (
        'POETA00192',
        'Poetas líricos en lengua inglesa',
        'liricos.webp',
        3,
        NULL,
        NULL,
        'Varios autores'
    ),
    (
        'POETI00233',
        'Poética de la plegaria',
        'poetica.jpg',
        19,
        9,
        NULL,
        'Xochiquétzal Salazar García'
    ),
    (
        'PRENS00118',
        'Prensa transnacional, la',
        'prensa.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'PRESO00119',
        'Presocialidad en la educación universitaria',
        'educacion_universitaria.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'PROGR00157',
        'Programación lineal: El modelado, las aplicaciones',
        'Programacion_lineal.jpg',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'PROSO00120',
        'Prosocialidad, cinco miradas Latinoamérica',
        'cinco_miradas.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'PUEBL00224',
        'Pueblo en vilo',
        'pueblo_vielo.jpg',
        18,
        NULL,
        NULL,
        'Luis González y González'
    ),
    (
        'PUERT00121',
        'Puertas del paraíso, las',
        'puertas.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'PUNTA00122',
        'Puntas de luz',
        'puntas.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'RAYOD00235',
        'Rayo de luz',
        'luz_aldama.jpg',
        19,
        11,
        NULL,
        'Luis Aldama'
    ),
    (
        'REFLE00123',
        'Reflexiones filosóficas y literarias',
        'reflexiones.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'REPEN00124',
        'Repensar El Periodismo',
        'repensar.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'RESIS00125',
        'Resistir la pesadilla. La izquierda en México',
        'resistir.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'RIOSU00225',
        'Río subterráneo',
        'rio_subterraneo.jpg',
        18,
        NULL,
        NULL,
        'Inés Arredondo'
    ),
    (
        'RUINA00042',
        'De ruinas y horizontes. La modernidad y',
        'ruinas.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'SABAC00126',
        'Sabacio',
        'sabacio.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SALIR00127',
        'Salir del laberinto / Empédocles',
        'salir_laberinto.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SAMUE00128',
        'Samuel Beckett electrónico',
        'electronico.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SEGUN00129',
        'Segunda modernidad urbano arquitectónica',
        'segunda_modernidad.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'SEISI00278',
        '6 siglos de historia gráfica de México 1325-1976 (I)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00279',
        '6 siglos de historia gráfica de México 1325-1976 (II)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00280',
        '6 siglos de historia gráfica de México 1325-1976 (III)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00281',
        '6 siglos de historia gráfica de México 1325-1976 (IV)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00282',
        '6 siglos de historia gráfica de México 1325-1976 (V)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00283',
        '6 siglos de historia gráfica de México 1325-1976 (VI)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00284',
        '6 siglos de historia gráfica de México 1325-1976 (VII)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00285',
        '6 siglos de historia gráfica de México 1325-1976 (VIII)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00286',
        '6 siglos de historia gráfica de México 1325-1976 (IX)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00287',
        '6 siglos de historia gráfica de México 1325-1976 (X)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISI00288',
        '6 siglos de historia gráfica de México 1325-1976 (XI)',
        NULL,
        11,
        NULL,
        NULL,
        'Gustavo Casasola'
    ),
    (
        'SEISN00130',
        'Seis niñas ahogadas en una gota de agua',
        'seis_niñas.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SEM2R00132',
        'Sembrando futuro en la región de los volcanes',
        'volcanes.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'SEMBR00131',
        'Sembrando el corazón de nuestra palabra',
        'sembrando.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SENDA00133',
        'Sendas extraviadas. Ensayos para vivir',
        'sendas.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SERVI00134',
        'Servidumbre del amo. Paradojas del administrador',
        'la_servidumbre.jfif',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'SILEN00136',
        'Silencio de los muelles / umbría nube',
        'silencio.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SINFO00137',
        'Sinfonía. De mi sangre nacerán pájaros',
        'sinfonia.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SIS2E00139',
        'Sistemas regionales de innovación',
        'sistema_nacional_espacio_para_pymes.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'SISTE00138',
        'Sistema nacional de innovación mexicano',
        'sistema_nacional.jfif',
        4,
        4,
        NULL,
        NULL
    ),
    (
        'SITED00135',
        'Si te dicen que he llorado por ti',
        'si_te_dicen_que_he_llorado_por_ti.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SOCRA00193',
        'Socráticas: economía, Ciropedia',
        'socraticas.webp',
        3,
        NULL,
        NULL,
        'Jenofonte'
    ),
    (
        'SONAR00096',
        'Sonar. Navegación-localización. Del sonido',
        'sonar.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'SUE2O00098',
        'Sueños que da pánico escribir. Pacheco y',
        'sueños_panico.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'SUENO00097',
        'Sueño del ángel, el',
        'sueño_angel.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'TEATR00194',
        'Teatro (Calderón)',
        '',
        3,
        NULL,
        NULL,
        'Calderón de la Barca'
    ),
    (
        'TEATR00195',
        'Teatro (Lope de Vega)',
        '',
        3,
        NULL,
        NULL,
        'Lope de Vega'
    ),
    (
        'TEOTI00296',
        'Teotihuacán: la metrópolis de los dioses',
        NULL,
        14,
        NULL,
        NULL,
        'Eduardo Matos Moctezuma'
    ),
    (
        'TESOR00297',
        'Tesoros vivos de Morelos',
        NULL,
        14,
        NULL,
        NULL,
        NULL
    ),
    (
        'TESOR00298',
        'Tesoros del Museo Nacional de Bellas Artes',
        NULL,
        14,
        NULL,
        NULL,
        'Julio Moyano'
    ),
    (
        'TETRA00140',
        'Tetraedro/caleidoscopio (1977-2015)',
        'caleidoscopio.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'TEXTO00141',
        'Texto',
        'texto.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'THENA00212',
        'The National Audubon Society Baby Elephant Folio: \"Audubon\'s Birds of America\"',
        'society.jpg',
        6,
        6,
        6,
        'Roger Tory Peterson'
    ),
    (
        'TIE2P00143',
        'Tiempo de zafra',
        'zafra.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'TIEMP00142',
        'Tiempo de ballenas',
        'tiempo_de_ballenas.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'TIEMP00226',
        'Tiempo de ladrones: la historia de Chucho el Roto',
        'tiempo_ladrones.jpg',
        18,
        NULL,
        NULL,
        'Emilio Carballido'
    ),
    (
        'TIENE00227',
        'Tiene la noche un árbol',
        'tiene_la_noche.jpg',
        18,
        NULL,
        NULL,
        'Guadalupe Dueñas'
    ),
    (
        'TIPOS00144',
        'Tipos de capital social, sus interacciones',
        'capital_tipos.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'TOCAR00145',
        'Tocar tu argolla en llamas',
        'tocar_argolla.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'TOLTE00295',
        'Toltecayotl: aspectos de la cultura náhuatl',
        NULL,
        14,
        NULL,
        NULL,
        'Miguel León-Portilla'
    ),
    (
        'TOMOC00228',
        'Tomóchic',
        'tomochic.jpg',
        18,
        NULL,
        NULL,
        'Heriberto Frías'
    ),
    (
        'TRACT00146',
        'Tractatus politicus mínimum',
        'tractatus.jpg',
        4,
        1,
        NULL,
        NULL
    ),
    (
        'TRAGE00196',
        'Tragedias',
        'tragedias.webp',
        3,
        NULL,
        NULL,
        'Shakespeare'
    ),
    (
        'TRATA00197',
        'Tratados morales',
        'tratados.webp',
        3,
        NULL,
        NULL,
        'Cicerón y Séneca'
    ),
    (
        'TRILC00147',
        'Trilce a la luz de la hermenéutica simbólica',
        'trilce_luz.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'UAMVI00148',
        'UAM: una visión a 45 años, la. 3 tomos',
        'uam_45.jfif',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'UNIVE00150',
        'Universidad de cara a la constitución de',
        'universidad_cara.jpg',
        4,
        3,
        NULL,
        NULL
    ),
    (
        'URBAN00151',
        'Urbanismo e historia',
        'urbanismo_historia.jfif',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'VERED00152',
        'Veredas para un centauro',
        'vereda_centauro.jfif',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'VIAJE00153',
        'Viajeros en los andenes',
        'viejeros.jpg',
        4,
        2,
        NULL,
        NULL
    ),
    (
        'XICOT00154',
        'Xicotepec. Años roble',
        'xicotepec.jpg',
        4,
        5,
        NULL,
        NULL
    ),
    (
        'YMATA00229',
        'Y Matarazo no llamó...',
        'y_matarazo.jpg',
        18,
        NULL,
        NULL,
        'Elena Garro'
    ),
    (
        'ZAFRA00232',
        'Zafras de tiempo y memoria',
        'zafras_tiempo_azul.webp',
        19,
        10,
        NULL,
        'Carmen Gamiño'
    ),
    (
        'ZONAS00156',
        'Zonas metropolitanas de México, las',
        'las_zonas_metropolitanas.jfif',
        4,
        5,
        NULL,
        NULL
    );

DROP TABLE IF EXISTS `registros`;

CREATE TABLE `registros` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(150) DEFAULT NULL,
    `nombre` varchar(100) DEFAULT NULL,
    `cod_libro` varchar(20) DEFAULT NULL,
    `titulo_libro` varchar(200) DEFAULT NULL,
    `fecha_pedido` date DEFAULT NULL,
    `fecha_devuelto` date DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

INSERT INTO
    `registros` (
        `id`,
        `email`,
        `nombre`,
        `cod_libro`,
        `titulo_libro`,
        `fecha_pedido`,
        `fecha_devuelto`
    )
VALUES
    (
        1,
        'Bodoque@gmail.com',
        'Juan Carlos Bodoque',
        'CACOF00023',
        'Cacofónicos y disléxicos',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        2,
        'Bodoque@gmail.com',
        'Juan Carlos Bodoque',
        'CAPIT00026',
        'Capital, salario y crisis',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        3,
        'Romeo.Marino@gmail.com',
        'Angel Romeo Marino Gonzalez',
        'DOCEN00052',
        'Docente y la mediación de los nuevos capítulos',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        4,
        'amoxcallip.viejo@gmail.com',
        'Administrador',
        'PROGR00157',
        'Programación lineal: El modelado, las aplicaciones',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        5,
        'jan.carlos.antunez.ocampo@gmail.com',
        'Jan Carlos Antunez Ocampo',
        'SALIR00127',
        'Salir del laberinto / Empédocles',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        6,
        'jan.carlos.antunez.ocampo@gmail.com',
        'Jan Carlos Antunez Ocampo',
        'COMOP00032',
        'Como un pez rojo',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        7,
        'jan.carlos.antunez.ocampo@gmail.com',
        'Jan Carlos Antunez Ocampo',
        'BARBA00017',
        'Bárbaros contra cristianos',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        8,
        'jan.carlos.antunez.ocampo@gmail.com',
        'Jan Carlos Antunez Ocampo',
        'MONAR00107',
        'Monarca, el ciudadano y el excluido, el',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        9,
        'amoxcallip.viejo@gmail.com',
        'Administrador',
        'CUART00039',
        'Cuarto paradigma',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        10,
        'brandon.beristain@gmail.com',
        'Brandon Boris Beristain Aguilar',
        'RESIS00125',
        'Resistir la pesadilla. La izquierda en México',
        '2026-06-15',
        '2026-06-15'
    ),
    (
        11,
        'jeslib.jr@gmail.com',
        'Jesus Reyna Jr',
        'TRACT00146',
        'Tractatus politicus mínimum',
        '2026-06-15',
        '2026-06-15'
    ),
    (
        12,
        'jan.carlos.antunez.ocampo@gmail.com',
        'Jan Carlos Antunez Ocampo',
        'VIAJE00153',
        'Viajeros en los andenes',
        '2026-06-15',
        '2026-06-15'
    ),
    (
        13,
        'elquecanta@gmail.com',
        'Juan Gabriel',
        'ANGEL00012',
        'Angelina Muñiz Huberman. Escritura en tierra',
        '2026-07-12',
        '2026-07-12'
    );

DROP TABLE IF EXISTS `saca`;

CREATE TABLE `saca` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(150) NOT NULL,
    `cod_libro` varchar(10) NOT NULL,
    `fecha_pedido` date NOT NULL,
    `fecha_devuelto` date DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_saca_usuario` (`email`),
    KEY `fk_saca_libro` (`cod_libro`),
    CONSTRAINT `fk_saca_libro` FOREIGN KEY (`cod_libro`) REFERENCES `libros` (`cod_libro`) ON UPDATE CASCADE,
    CONSTRAINT `fk_saca_usuario` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

INSERT INTO
    `saca` (
        `id`,
        `email`,
        `cod_libro`,
        `fecha_pedido`,
        `fecha_devuelto`
    )
VALUES
    (
        3,
        'Romeo.Marino@gmail.com',
        'DOCEN00052',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        4,
        'amoxcallip.viejo@gmail.com',
        'PROGR00157',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        5,
        'jan.carlos.antunez.ocampo@gmail.com',
        'SALIR00127',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        6,
        'jan.carlos.antunez.ocampo@gmail.com',
        'COMOP00032',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        7,
        'jan.carlos.antunez.ocampo@gmail.com',
        'BARBA00017',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        8,
        'jan.carlos.antunez.ocampo@gmail.com',
        'MONAR00107',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        9,
        'amoxcallip.viejo@gmail.com',
        'CUART00039',
        '2026-06-14',
        '2026-06-14'
    ),
    (
        10,
        'brandon.beristain@gmail.com',
        'RESIS00125',
        '2026-06-15',
        '2026-06-15'
    ),
    (
        12,
        'jan.carlos.antunez.ocampo@gmail.com',
        'VIAJE00153',
        '2026-06-15',
        '2026-06-15'
    ),
    (
        13,
        'elquecanta@gmail.com',
        'ANGEL00012',
        '2026-07-12',
        '2026-07-12'
    );

DROP TABLE IF EXISTS `subcategorias`;

CREATE TABLE `subcategorias` (
    `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT,
    `id_categoria` int(11) NOT NULL,
    `slug` varchar(50) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `color` varchar(20) DEFAULT NULL,
    `orden` int(11) NOT NULL DEFAULT 0,
    `imagen` varchar(150) DEFAULT NULL,
    PRIMARY KEY (`id_subcategoria`),
    UNIQUE KEY `uniq_slug_por_categoria` (`id_categoria`, `slug`),
    CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_uca1400_ai_ci;

INSERT INTO
    `subcategorias` (
        `id_subcategoria`,
        `id_categoria`,
        `slug`,
        `nombre`,
        `color`,
        `orden`,
        `imagen`
    )
VALUES
    (
        1,
        4,
        'politica',
        'Política y Sociedad',
        '#c62828',
        1,
        NULL
    ),
    (
        2,
        4,
        'literatura',
        'Literatura y Arte',
        '#6a1e8a',
        2,
        NULL
    ),
    (
        3,
        4,
        'educacion',
        'Educación y Ciencia',
        '#1565c0',
        3,
        NULL
    ),
    (
        4,
        4,
        'economia',
        'Economía y Desarrollo',
        '#2e7d32',
        4,
        NULL
    ),
    (
        5,
        4,
        'historia',
        'Historia y Cultura',
        '#e65100',
        5,
        NULL
    ),
    (
        6,
        6,
        'biologia',
        'Biología',
        '#2eaf9c',
        1,
        'aves_rapaces.jpg'
    ),
    (7, 6, 'fisica', 'Física', NULL, 2, NULL),
    (8, 19, 'ensayo', 'Ensayo', '#234e94', 1, NULL),
    (9, 19, 'poesia', 'Poesía', '#ae3b32', 2, NULL),
    (
        10,
        19,
        'narrativa',
        'Narrativa',
        '#438c88',
        3,
        NULL
    ),
    (
        11,
        19,
        'dramaturgia',
        'Dramaturgia',
        '#4f2d68',
        4,
        NULL
    );

DROP TABLE IF EXISTS `temas`;

CREATE TABLE `temas` (
    `id_tema` int(11) NOT NULL AUTO_INCREMENT,
    `id_subcategoria` int(11) DEFAULT NULL,
    `slug` varchar(50) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `color` varchar(7) DEFAULT NULL,
    `orden` int(11) DEFAULT 0,
    PRIMARY KEY (`id_tema`),
    KEY `id_subcategoria` (`id_subcategoria`),
    CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategorias` (`id_subcategoria`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO
    `temas` (
        `id_tema`,
        `id_subcategoria`,
        `slug`,
        `nombre`,
        `color`,
        `orden`
    )
VALUES
    (4, 6, 'insectos', 'Insectos', '#8BC34A', 1),
    (5, 6, 'mamiferos', 'Mamíferos', '#795548', 2),
    (6, 6, 'aves', 'Aves', '#03A9F4', 3),
    (7, 6, 'serpientes', 'Serpientes', '#4CAF50', 4),
    (8, 6, 'plantas', 'Plantas', '#009688', 5),
    (9, 6, 'reptiles', 'Reptiles', '#FF7043', 6);

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
    `email` varchar(150) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `telefono` varchar(20) DEFAULT NULL,
    `genero` enum('Masculino', 'Femenino') DEFAULT NULL,
    `tipo` enum('visitante', 'administrador') NOT NULL DEFAULT 'visitante',
    `contrasena` varchar(255) NOT NULL,
    PRIMARY KEY (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

INSERT INTO
    `usuarios` (
        `email`,
        `nombre`,
        `telefono`,
        `genero`,
        `tipo`,
        `contrasena`
    )
VALUES
    (
        'Adrian.de.Jesus.Abarca.Mariano@gmail.com',
        'Adrian de Jesus Abarca Mariano',
        '7774629992',
        'Masculino',
        'visitante',
        'contrasenaadrian'
    ),
    (
        'amoxcallip.viejo@gmail.com',
        'Administrador',
        '5541049360',
        'Masculino',
        'administrador',
        'Admin009'
    ),
    (
        'brandon.beristain@gmail.com',
        'Brandon Boris Beristain Aguilar',
        '7772605150',
        'Masculino',
        'visitante',
        'bonais77'
    ),
    (
        'elquecanta@gmail.com',
        'Juan Gabriel',
        '5573123719',
        'Masculino',
        'visitante',
        'querida1233'
    ),
    (
        'jan.carlos.antunez.ocampo@gmail.com',
        'Jan Carlos Antunez Ocampo',
        '7777889767',
        'Masculino',
        'visitante',
        'Contrasena007'
    ),
    (
        'Romeo.Marino@gmail.com',
        'Angel Romeo Marino Gonzalez',
        '7775544060',
        'Masculino',
        'visitante',
        'romeoyjulieta'
    );

-- 2026-07-19 04:52:53 UTC
SET
    FOREIGN_KEY_CHECKS = 1;