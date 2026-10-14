-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: estetica_bv
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `estetica_bv`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `estetica_bv` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `estetica_bv`;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id_categoria` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(255) NOT NULL,
  `descripcion_categoria` varchar(500) DEFAULT NULL,
  `estado_categoria` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `nombre_categoria` (`nombre_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'SHAMPOO Y ACONDICIONADOR','',1),(2,'TRATAMIENTOS','',1),(3,'COLORACIÓN Y DECOLORACIÓN','',1),(4,'SPRAYS Y PROTECCIÓN','',1),(5,'REPARADORES DE PUNTAS','',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta`
--

DROP TABLE IF EXISTS `consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta` (
  `id_consulta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(500) NOT NULL,
  `fecha_consulta` date NOT NULL,
  `id_usuario` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_consulta`),
  KEY `consulta_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `consulta_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta`
--

LOCK TABLES `consulta` WRITE;
/*!40000 ALTER TABLE `consulta` DISABLE KEYS */;
/*!40000 ALTER TABLE `consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_venta`
--

DROP TABLE IF EXISTS `estado_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_venta` (
  `id_estado_venta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id_estado_venta`),
  UNIQUE KEY `nombre_estado` (`nombre_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_venta`
--

LOCK TABLES `estado_venta` WRITE;
/*!40000 ALTER TABLE `estado_venta` DISABLE KEYS */;
INSERT INTO `estado_venta` VALUES (2,'En Preparación'),(4,'Entregado'),(3,'Listo para retirar/enviar'),(1,'Pendiente');
/*!40000 ALTER TABLE `estado_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorito`
--

DROP TABLE IF EXISTS `favorito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorito` (
  `id_favorito` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) unsigned NOT NULL,
  `id_producto` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_favorito`),
  KEY `favorito_id_usuario_foreign` (`id_usuario`),
  KEY `favorito_id_producto_foreign` (`id_producto`),
  CONSTRAINT `favorito_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `favorito_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorito`
--

LOCK TABLES `favorito` WRITE;
/*!40000 ALTER TABLE `favorito` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodo_pago`
--

DROP TABLE IF EXISTS `metodo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metodo_pago` (
  `id_metodo_pago` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_metodo_pago` varchar(100) NOT NULL,
  PRIMARY KEY (`id_metodo_pago`),
  UNIQUE KEY `nombre_metodo_pago` (`nombre_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodo_pago`
--

LOCK TABLES `metodo_pago` WRITE;
/*!40000 ALTER TABLE `metodo_pago` DISABLE KEYS */;
INSERT INTO `metodo_pago` VALUES (1,'Efectivo'),(2,'Tarjeta de Crédito'),(3,'Tarjeta de Débito'),(4,'Transferencia');
/*!40000 ALTER TABLE `metodo_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (12,'2026-07-21-142141','App\\Database\\Migrations\\CrearTablaRol','default','App',1789607263,1),(13,'2026-07-21-142434','App\\Database\\Migrations\\CrearTablaEstadoVenta','default','App',1789607263,1),(14,'2026-07-21-142447','App\\Database\\Migrations\\CrearTablaMetodoPago','default','App',1789607263,1),(15,'2026-07-21-142455','App\\Database\\Migrations\\CrearTablaCategoria','default','App',1789607263,1),(16,'2026-07-22-203123','App\\Database\\Migrations\\CrearTablaUsuario','default','App',1789607263,1),(17,'2026-07-22-203150','App\\Database\\Migrations\\CrearTablaProducto','default','App',1789607263,1),(18,'2026-07-22-203204','App\\Database\\Migrations\\CrearTablaVenta','default','App',1789607263,1),(19,'2026-07-22-203217','App\\Database\\Migrations\\CrearTablaVentaDetalle','default','App',1789607263,1),(20,'2026-07-22-203230','App\\Database\\Migrations\\CrearTablaFavorito','default','App',1789607263,1),(21,'2026-07-22-203251','App\\Database\\Migrations\\CrearTablaConsulta','default','App',1789607263,1),(22,'2026-09-05-131500','App\\Database\\Migrations\\AgregarTipoEntregaAVenta','default','App',1789607263,1),(23,'2026-09-29-140000','App\\Database\\Migrations\\AgregarCodigoProductoAProducto','default','App',1791469825,2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id_producto` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_producto` varchar(50) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion_producto` varchar(500) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `estado_producto` tinyint(1) NOT NULL DEFAULT 1,
  `id_categoria` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `nombre_producto` (`nombre_producto`),
  UNIQUE KEY `uq_codigo_producto` (`codigo_producto`),
  KEY `producto_id_categoria_foreign` (`id_categoria`),
  CONSTRAINT `producto_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'PROD-0001','PRIMONT SHAMPOO SUPER ACIDO X 350ML ','PRIMONT SHAMPOO SUPER ACIDO\r\nEste shampoo es altamente recomendado para cabellos con coloración, decolorados y secos, ya que protege y revitaliza las fibras capilares, manteniendo el color y la hidratación por más tiempo. Gracias a su acción reguladora, ayuda a equilibrar el cuero cabelludo, previniendo la sequedad y la irritación.\r\nModo de uso: Aplicar sobre el cabello húmedo, masajear suavemente y enjuagar. Para mejores resultados, complementar con el acondicionador PRIMONT Super Ácido.',9500.00,10,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789682417/PRIMONT_SHAMPOO_SUPER_ACIDO_X_350ML_estcyc.webp',1,1),(2,'PROD-0002','primont color plex N°5','Color plex primont N°5\r\nMascarilla hidratante que reconstruye los enlaces al mismo tiempo que acondiciona profundamente.\r\nEvita el quiebre y elimina el frizz de la fibra capilar.\r\nSu fórmula con extracto de quínoa y aminoácidos revitaliza el cabello desde la raiz, reestructurando cabellos deteriorados y quebradizos. ',17800.00,20,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789682617/primont_color_plex_N_5_ll8b1o.webp',1,2),(3,'PROD-0003','LOREAL SERIE EXPERT METAL DETOX CREMA PARA PEINAR 100GR','Lavado tras lavado, las partículas metálicas, presentes en el agua, pueden penetrar en las fibras capilares. Esto crea un riesgo de rotura y cambio de color. Concentrada con un 1% de glicoamina, esta crema sin aclarado de alta protección elimina el metal* del cabello y lo protege del depósito de nuevas partículas, para detener la rotura y el cambio de color. Intensamente hidratado y fortalecido, el cabello está protegido contra los rayos UV, la oxidación, el cepillado y el calor hasta 230°C*.',86300.00,0,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789682885/LOREAL_SERIE_EXPERT_METAL_DETOX_CREMA_PARA_PEINAR_100GR_pg4zcl.webp',1,3),(4,'PROD-0004','PRIMONT STYLING SOSTENEDOR DE BUCLES','STYLING LIFE RULOS Y ONDAS Permite que los rulos y ondas del pelo natural o permanentado recuperen toda su elasticidad de forma instantánea. Otorga brillo y volumen de inmediato. No apelmaza el cabello ni deja rastros oleosos. Se utiliza sobre cabellos húmedos o secos.',18600.00,10,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789683129/PRIMONT_STYLING_SOSTENEDOR_DE_BUCLES_yeodjr.webp',1,4),(5,'PROD-0005','PRIMONT TOP FINISH SPRAY FIJADOR','El Spray Fijación Fuerte Reforzado es la solución ideal para quienes buscan mantener su peinado impecable durante todo el día. Con su formulación avanzada, este spray proporciona una fijación duradera sin dejar el cabello húmedo, asegurando un acabado natural y brillante.\r\nPara obtener los mejores resultados, agita bien el envase y rocía a una distancia de 20 cm sobre el cabello seco o húmedo. Peina como desees y disfruta de un look espectacular y bien definido.',22900.00,7,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789683168/PRIMONT_TOP_FINISH_SPRAY_FIJADOR_jb1r66.webp',1,4),(6,'PROD-0006','Primont Maroc-oil Serum 50ml','El Maroc-oil Serum PRIMONT 50ml es tu aliado perfecto para lograr un cabello radiante y saludable. Este serum, enriquecido con aceite de argán, ofrece una profunda hidratación y nutrición, transformando tu melena con un brillo excepcional. Su fórmula ligera se absorbe rápidamente, dejando el cabello suave y manejable sin sensación grasa.',13800.00,10,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789683276/Primont_Maroc-oil_Serum_50ml_dmmxfm.webp',1,5),(7,'PROD-0007','LOREAL SERIE EXPERT METAL DETOX SHAMPOO 300ML','La Mascarilla anti-deposito de Metal Detox protege la fibra de los depositos de particulas después de cualquier color, balayage o servicio de iluminaciones.\r\nEl metal dentro de las fibras crea riesgos de quiebre e impacta de manera negativa los resultados de tu servicio de coloración, balayage o iluminaciones.\r\nLa crema untuosa se vuelve una espuma concentrada que limpia gentilmente y remueve la acumulacion de particulas de metal del cabello.',78500.00,4,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789683391/LOREAL_SERIE_EXPERT_METAL_DETOX_SHAMPOO_300ML_ciwghe.webp',1,1),(8,'PROD-0008','PRIMONT TRATAMIENTO CELULAS MADRE 237GR','Revitaliza tu cabello con el Tratamiento de Células Madre Primont. Este innovador producto está diseñado para estimular el crecimiento de tus propias células, brindando una solución efectiva para combatir la alopecia y promover un cabello más saludable.',14700.00,10,'https://res.cloudinary.com/deza7gvrx/image/upload/v1789683468/PRIMONT_TRATAMIENTO_CELULAS_MADRE_237GR_igi4fu.webp',1,2);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `nombre_rol` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Administrador'),(2,'Cliente');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dni` int(11) NOT NULL,
  `apellido_nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `estado_usuario` tinyint(1) NOT NULL DEFAULT 1,
  `id_rol` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telefono` (`telefono`),
  KEY `usuario_id_rol_foreign` (`id_rol`),
  CONSTRAINT `usuario_id_rol_foreign` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,10000000,'Vera, Belén','admin@esteticabv.com','$2y$10$GjzILaNyg3lEriQf76cgvuDwxDjGNtab3W6od5cR5a7teTRDrpo2u','1122334455',1,1),(2,99999999,'Pérez, Juan','juan.perez@example.com','$2y$10$DTCILoXapB9zozx5omsDg.0m/ejcxzok.kdfcy7A4BUCi0P9HsmS6','1199887766',1,2),(5,42995260,'Vera Pablo','gabrielverahemi@gmail.com','$2y$10$hz1mHgtP8SlGVRT0medAIONOMoMskK3tZ.gyu1W5CiPHdNZFuUQ.G','3795054254',1,2),(6,40123123,'Vera Juliana','belenjv123@gmail.com','$2y$10$5lFo/rFf0CBo2K09pzl5pOpTdjVq4nDS/m0bSyxvbrT5V7nD9RLpu','3794878239',1,2);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta` (
  `id_venta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `fecha_venta` date NOT NULL,
  `tipo_entrega` varchar(50) DEFAULT 'Retiro en local',
  `id_estado_venta` int(11) unsigned NOT NULL,
  `id_metodo_pago` int(11) unsigned NOT NULL,
  `id_usuario` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `venta_id_estado_venta_foreign` (`id_estado_venta`),
  KEY `venta_id_metodo_pago_foreign` (`id_metodo_pago`),
  KEY `venta_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `venta_id_estado_venta_foreign` FOREIGN KEY (`id_estado_venta`) REFERENCES `estado_venta` (`id_estado_venta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_id_metodo_pago_foreign` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES (1,9500.00,'2026-09-18','Retiro en local',3,1,5),(2,86300.00,'2026-09-18','Envío a domicilio',3,4,6),(3,45800.00,'2026-09-18','Retiro en local',4,3,6),(4,22900.00,'2026-09-19','Retiro en local',1,4,2),(5,259000.00,'2026-09-28','Retiro en local',1,1,6);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta_detalle` (
  `id_venta_detalle` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `id_producto` int(11) unsigned NOT NULL,
  `id_venta` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_venta_detalle`),
  KEY `venta_detalle_id_producto_foreign` (`id_producto`),
  KEY `venta_detalle_id_venta_foreign` (`id_venta`),
  CONSTRAINT `venta_detalle_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venta_detalle_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_detalle`
--

LOCK TABLES `venta_detalle` WRITE;
/*!40000 ALTER TABLE `venta_detalle` DISABLE KEYS */;
INSERT INTO `venta_detalle` VALUES (1,1,9500.00,9500.00,1,1),(2,1,86300.00,86300.00,3,2),(3,2,22900.00,45800.00,5,3),(4,1,22900.00,22900.00,5,4),(5,19,9500.00,180500.00,1,5),(6,1,78500.00,78500.00,7,5);
/*!40000 ALTER TABLE `venta_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-13 13:59:30
