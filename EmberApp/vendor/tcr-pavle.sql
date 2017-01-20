-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 20, 2017 at 11:34 AM
-- Server version: 5.5.54-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcr-pavle`
--

-- --------------------------------------------------------

--
-- Table structure for table `al_db_session`
--

CREATE TABLE `al_db_session` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `lifetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `al_db_session`
--

INSERT INTO `al_db_session` (`id`, `value`, `time`, `lifetime`) VALUES
('02rui39ji4neccmr1rme2v56c2', '_sf2_attributes|a:1:{s:18:"_csrf/authenticate";s:43:"V6MnyR6p6B9yJWUmyy91WmmZWOOrZNxZLeH3qNxSkDY";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484131287;s:1:"c";i:1484130161;s:1:"l";s:5:"86400";}', 1484131287, 1800),
('2i8pi04g6kq6ifvao6g2vl3a80', '_sf2_attributes|a:1:{s:18:"_csrf/authenticate";s:43:"vG_7frgNiAbUjEots5-Eo_MavYUNv0UeKu-tD8bzlc8";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483009148;s:1:"c";i:1483009147;s:1:"l";s:5:"86400";}', 1483009148, 1800),
('3jett9mcsmrhnkhob32ctsekl2', '_sf2_attributes|a:3:{s:26:"_security.main.target_path";s:53:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard";s:18:"_csrf/authenticate";s:43:"RvsvohJf7fyGC0xrQhoE15A5XBLmYLxxZJgiRlw1IRk";s:14:"_security_main";s:920:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":832:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:792:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":447:{a:18:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:488.58064516128002;i:16;s:7:"Andorra";i:17;s:69:"https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484826894;s:1:"c";i:1484826857;s:1:"l";s:5:"86400";}', 1484826894, 1800),
('3nfp25l2hba0dpuoup9e1umj55', '_sf2_attributes|a:2:{s:26:"_security.main.target_path";s:53:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard";s:18:"_csrf/authenticate";s:43:"HpP3wURsLJisUHcArE81EDBdra7F1rmrXd8lfefYCwE";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483954083;s:1:"c";i:1483954081;s:1:"l";s:5:"86400";}', 1483954083, 1800),
('7ilpbf4v6e3p89djooql10i6p0', '_sf2_attributes|a:3:{s:26:"_security.main.target_path";s:64:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/all-agents";s:18:"_csrf/authenticate";s:43:"0K0kIZs-7tBTYPkR9zoT7_D55MWvUpCcodREA67u5vU";s:14:"_security_main";s:920:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":832:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:792:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":447:{a:18:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:488.58064516128002;i:16;s:7:"Andorra";i:17;s:69:"https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484655208;s:1:"c";i:1484653365;s:1:"l";s:5:"86400";}', 1484655209, 1800),
('a5popi5ekhocrprk7nde3vqao5', '_sf2_attributes|a:2:{s:26:"_security.main.target_path";s:82:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/orders-list-completed";s:18:"_csrf/authenticate";s:43:"pGf6WYVD7nPYlY26gnjSUotaEKb8lUi0y6eJRN2IQ_Q";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484896011;s:1:"c";i:1484896009;s:1:"l";s:5:"86400";}', 1484896011, 1800),
('dag84j9url0m9m1rpt5el2eea2', '_sf2_attributes|a:2:{s:26:"_security.main.target_path";s:53:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard";s:18:"_csrf/authenticate";s:43:"VIvNjgxXb5BFlsaVMvhwVp61-o3Doc74nZ0CoszCAYc";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483021358;s:1:"c";i:1483021340;s:1:"l";s:5:"86400";}', 1483021358, 1800),
('hl5p8pgjm1o01nt8rvogus9op3', '_sf2_attributes|a:2:{s:18:"_csrf/authenticate";s:43:"g6X_q81YCqmEt8QWZyoyQIPbwx3plZ1P2O6t9dEn920";s:14:"_security_main";s:920:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":832:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:792:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":447:{a:18:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:488.58064516128002;i:16;s:7:"Andorra";i:17;s:69:"https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484511544;s:1:"c";i:1484511343;s:1:"l";s:5:"86400";}', 1484511545, 1800),
('ij2eb34be2il40ddh7q9ddet12', '_sf2_attributes|a:6:{s:18:"_csrf/authenticate";s:43:"LMcfDty-li5N-SJxKFPkVP6C4f6YN7Q1Ha5So4U7mvo";s:14:"_security_main";s:824:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":736:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:696:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":351:{a:17:{i:0;i:4;i:1;s:60:"$2y$13$q5mld7xg5eswggw8cs4cwO.5sJ3xgo.MkpIcDbeWfEvVS7qSINkxK";i:2;s:31:"q5mld7xg5eswggw8cs4cwcwsw0okgcw";i:3;s:17:"tester.chf@fsd.rs";i:4;s:17:"tester.chf@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:4;i:10;N;i:11;N;i:12;s:17:"tester.chf@fsd.rs";i:13;s:17:"tester.chf@fsd.rs";i:14;s:2:"en";i:15;d:500;i:16;s:11:"Switzerland";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";s:21:"_csrf/change_password";s:43:"ygJ8h8Y3ajk30kZ9HvUSijK8dXtuiC0XekoIoF-bEME";s:17:"checkout_order_id";s:3:"105";s:21:"sofort_transaction_id";s:27:"103382-297316-58639C22-25E4";s:25:"sofort_transaction_amount";d:100;}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1482923336;s:1:"c";i:1482921529;s:1:"l";s:5:"86400";}', 1482923336, 1800),
('k43ajdk512hhipv7b5mu47idk7', '_sf2_attributes|a:2:{s:26:"_security.main.target_path";s:86:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/36";s:18:"_csrf/authenticate";s:43:"bZe9Rz7yWmk2L3Y40HwNlN3ySd-XCOQDWwPyRS58X1A";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483009629;s:1:"c";i:1483009627;s:1:"l";s:5:"86400";}', 1483009629, 1800),
('k93tnli7t4s9rpliicvsvnrq42', '_sf2_attributes|a:2:{s:18:"_csrf/authenticate";s:43:"XbrTSyGMVqWW-2hdd0MSNulLlNqw2vCwsm5HdxhB7gU";s:14:"_security_main";s:920:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":832:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:792:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":447:{a:18:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:488.58064516128002;i:16;s:7:"Andorra";i:17;s:69:"https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484836775;s:1:"c";i:1484836589;s:1:"l";s:5:"86400";}', 1484836776, 1800),
('kh87rb94i9o5drgo1g4gldouc0', '_sf2_attributes|a:3:{s:26:"_security.main.target_path";s:72:"https://tcr-media.fsd.rs:105/app_dev.php/en/profile/orders/order-print/9";s:18:"_csrf/authenticate";s:43:"aBZDjcVN7wF_bl_bBYjS77N67NMpOPsmzc4Wbk8VFJQ";s:14:"_security_main";s:835:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":747:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:707:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":362:{a:17:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:498.64516129032;i:16;s:7:"Andorra";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483966350;s:1:"c";i:1483965646;s:1:"l";s:5:"86400";}', 1483966351, 1800),
('lok8qu1j9ej0u0f4lf8p0kuap3', '_sf2_attributes|a:2:{s:26:"_security.main.target_path";s:53:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard";s:18:"_csrf/authenticate";s:43:"5pz3YErjcfWVyVy3VTjf__z0ONcZGlVF0W0FTDrU0Ew";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484752120;s:1:"c";i:1484748398;s:1:"l";s:5:"86400";}', 1484752248, 1800),
('n9tv1e8ll6r2l2mpkq6p83fts3', '_sf2_attributes|a:1:{s:18:"_csrf/authenticate";s:43:"_XNfSGrlqfQMqn8G2ohYL1D99oFLS-rM1IMl34i-uyA";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484140175;s:1:"c";i:1484138723;s:1:"l";s:5:"86400";}', 1484140175, 1800),
('nqt8pn9fq7q9vf1kepo6crbfm4', '_sf2_attributes|a:3:{s:26:"_security.main.target_path";s:53:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard";s:18:"_csrf/authenticate";s:43:"9xItN0Mk4Rth1alth86Lg6to1z-uqxWHFAw4l4RTcCM";s:14:"_security_main";s:835:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":747:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:707:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":362:{a:17:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:498.64516129032;i:16;s:7:"Andorra";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483961766;s:1:"c";i:1483956363;s:1:"l";s:5:"86400";}', 1483961766, 1800),
('sd4anp64pmbcijtlsit0uvmuo0', '_sf2_attributes|a:2:{s:18:"_csrf/authenticate";s:43:"RcRw6dtL9CvSdUgx2Tavzb2fe8H3F9rwwZ44lfMXOmQ";s:23:"_security.last_username";s:5:"admin";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1483946942;s:1:"c";i:1483946471;s:1:"l";s:5:"86400";}', 1483946943, 1800),
('virec8l4rnna09mkdevh815rc6', '_sf2_attributes|a:2:{s:18:"_csrf/authenticate";s:43:"ov7fJhMmEKEPgMe0sGdROVbhyR9AXs34Pj20-vx_I2o";s:14:"_security_main";s:920:"C:74:"Symfony\\Component\\Security\\Core\\Authentication\\Token\\UsernamePasswordToken":832:{a:3:{i:0;N;i:1;s:4:"main";i:2;s:792:"a:4:{i:0;C:29:"TCR\\UserBundle\\Entity\\TCRUser":447:{a:18:{i:0;i:1;i:1;s:60:"$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q";i:2;s:31:"38ouepkxvlogswwogsww404gcsso0w0";i:3;s:18:"pavle.losic@fsd.rs";i:4;s:18:"pavle.losic@fsd.rs";i:5;b:0;i:6;b:0;i:7;b:0;i:8;b:1;i:9;i:1;i:10;N;i:11;N;i:12;s:18:"pavle.losic@fsd.rs";i:13;s:18:"pavle.losic@fsd.rs";i:14;s:2:"en";i:15;d:488.58064516128002;i:16;s:7:"Andorra";i:17;s:69:"https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg";}}i:1;b:1;i:2;a:2:{i:0;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:16:"ROLE_SUPER_ADMIN";}i:1;O:41:"Symfony\\Component\\Security\\Core\\Role\\Role":1:{s:47:"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role";s:9:"ROLE_USER";}}i:3;a:0:{}}";}}";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484130960;s:1:"c";i:1484129293;s:1:"l";s:5:"86400";}', 1484130960, 1800),
('vp3rr7h2jied9qqm4hm92gfin1', '_sf2_attributes|a:2:{s:26:"_security.main.target_path";s:62:"https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/agent/60";s:18:"_csrf/authenticate";s:43:"3YthHO1gkBZtzhOZC6ht-m-RdcfSQIlILAa8nV1pu0M";}_sf2_flashes|a:0:{}_sf2_meta|a:3:{s:1:"u";i:1484129259;s:1:"c";i:1484129257;s:1:"l";s:5:"86400";}', 1484129260, 1800);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_agent`
--

CREATE TABLE `tcr_agent` (
  `id` int(11) NOT NULL,
  `agent_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_agent`
--

INSERT INTO `tcr_agent` (`id`, `agent_id`, `first_name`, `last_name`, `email`, `phone_number`, `country`, `agent_type`, `comment`, `company`, `createdAt`) VALUES
(1, 'agent47', 'admin', 'admin', 'admin@fsd-test.rs', '+381113480804', 'Serbia', 'AMBASSADOR', 'agent47', '', '2016-07-15 15:01:59'),
(2, 'asdas', 'asdasda', 'sdasdasda', 'asdasda@asdadsas.com', '+381113480804', 'Serbia', 'ACTIVE', 'asdas', '', '2016-11-25 14:27:05'),
(3, 'asdasd', 'asdas', 'dasdad', 'sasdads@asdadsadsasd.com', '+381113480804', 'Serbia', 'REFEREE', 'asdasd', '', '2016-11-25 14:27:33'),
(4, 'dasasd', 'asdas', 'dasd', 'asdasdasdQ2sda@asdadsadsc.com', '+381113480804', 'Croatia', 'MASTER', 'dasasd', '', '2016-11-25 14:48:56'),
(5, 'adsadsads', 'adsadsads', 'asadsads', 'adsadsads@adsadsads.com', '+381113480804', 'Serbia', 'REFEREE', 'adsadsads', '', '2016-11-25 14:56:01'),
(7, 'CHA-85', 'Prvi', 'Child', 'nikola@fsd.rs', '+381113480804', 'Serbia', 'MASTER', 'CHA-85', '', '2016-11-28 12:51:37'),
(8, 'ADSSDAsa', 'dasdadsa', 'dasdadsa', 'branko@fsd.rs', '+381113480804', 'Serbia', 'ACTIVE', 'ADSSDAsa', '', '0000-00-00 00:00:00'),
(11, 'asdasda', 'sdasdasd', 'asdasdasd', 'aa@a', '+381113480804', 'Serbia', 'ACTIVE', 'asdasda', '', '2016-11-29 14:10:23'),
(13, 'assadasd', 'adsdsaasd', 'asdasdadsads', '123456@123', '+381113480804', 'Serbia', 'REFEREE', 'assadasd', '', '2016-11-30 08:59:27'),
(15, '9999', 'testerpera@testerpera.testerpe', 'testerpera@testerpera.testerpe', 'testerpera@testerpera.testerpera', '+381113480804', 'Serbia', 'ACTIVE', '9999', '', '2016-12-05 11:28:57'),
(29, 'dsaads', 'dasadsadsads', 'asdasdasd', 'asdadsads@adsadsads.com', '+381113480804', 'Serbia', 'REFEREE', 'dsaads', '', '2016-11-28 15:17:12'),
(42, 'adsadsdsa', 'Admin', 'Admin', 'admin', '+381113480804', 'Serbia', 'ACTIVE', 'adsadsdsa', '', '0000-00-00 00:00:00'),
(49, 'adsas', 'dasdas', 'dasdasads', 'asdadsads@adsadsads.comccc', '+381113480804', 'Serbia', 'ACTIVE', 'adsas', '', '2016-11-29 09:38:59'),
(51, 'CHA01', 'Agent', 'Agentovic', 'agent@agent.agent', '+381113480804', 'Serbia', 'MASTER', 'CHA01', '', '2016-12-01 09:06:48'),
(62, 'id', 'name', 'surname', 'testiranje@testing.cm', '+381642512651', 'Austria', 'ADMIN', '', '', '2016-12-22 13:42:50'),
(92, 'bonus10', 'Sync', 'TestStync', 'testiranje@testing.cm', '+381642512650', 'Andorra', 'Master Agent', '', '', '2016-12-27 10:06:00'),
(98, 'novi@test', 'novi@test', 'novi@test', 'novi@test', '+381113480804', 'Serbia', 'ACTIVE', 'novi@test', '', '2016-12-27 10:57:27'),
(101, 'agent@test', 'agent@test', 'agent@test', 'agent@test', '+381113480804', 'Serbia', 'REFEREE', 'agent@test', '', '2016-12-27 14:16:59'),
(102, 'final@AgentId', 'final@name', 'final@last', 'final@email', '+381113480804', 'Serbia', 'REFEREE', 'final@AgentId', '', '2016-12-27 14:21:18'),
(103, 'agentTest@ee', 'agentTest@ee', 'agentTest@ee', 'agentTest@ee', '+381113480804', 'Serbia', 'ACTIVE', 'agentTest@ee', '', '2016-12-27 14:25:28'),
(108, 'drugiAgent@agent', 'klijent@kl', 'klijent@kl', 'klijent@kl', '+381113480804', 'Serbia', 'REFEREE', 'klijent@kl', '', '2016-12-27 14:39:35'),
(120, 'agent_1_code', 'Pera', 'Peric', 'agent1@agent1.com', '+381113480804', 'Serbia', 'ACTIVE', 'agent_1_code', '', '2016-12-27 17:57:50'),
(121, 'agent2@agent2.com', 'agent2@agent2.com', 'agent2@agent2.com', 'agent2@agent2.com', '+381113480804', 'Serbia', 'ACTIVE', 'agent2@agent2.com', '', '2016-12-27 18:02:20'),
(122, 'agent3@agent3.com', 'agent3@agent3.com', 'agent3@agent3.com', 'agent3@agent3.com', '+381113480804', 'Serbia', 'MASTER', 'agent3@agent3.com', '', '2016-12-27 18:04:06'),
(125, 'tester', 'tester', 'tester', 'tester@tester', '+381113480804', 'Serbia', 'ACTIVE', 'tester', '', '2017-01-13 15:02:26'),
(129, 'ASDADADADSSA', 'ASDADADADSSA', 'ASDADADADSSA', 'ljubica.keso@fsd.rs', '+381653480804', 'Serbia', 'ACTIVE', '+381653480804', '', '2017-01-20 09:53:13'),
(132, 'QQEQEQEQRQRQ', 'ASDADADADSSA', 'ASDADADADSSA', 'dassd.leso@fsd.rs', '+381653480804', 'Serbia', 'ACTIVE', '+381653480804', '', '2017-01-20 09:55:31'),
(134, 'QEQDQFQRWREEQXAQ', 'ASDADADADSSA', 'ASDADADADSSA', 'dassd.leso.los@fsd.rs', '+381653480804', 'Serbia', 'ACTIVE', '+381653480804', '', '2017-01-20 09:56:03'),
(135, 'PAVLE_986e112', 'ASDADADADSSA', 'ASDADADADSSA', 'pavlevolikesovudjoku@gmail.com', '+381653480804', 'Serbia', 'ACTIVE', '110000', '', '2017-01-20 10:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_channel`
--

CREATE TABLE `tcr_channel` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf_id` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_channel`
--

INSERT INTO `tcr_channel` (`id`, `title`, `description`, `deleted`, `createdAt`, `updatedAt`, `icon`, `pdf_id`, `comment`) VALUES
(2, 'Latino channel', 'asd', 0, '2016-04-07 12:15:44', '2016-07-05 14:55:39', 'fa-align-justify', NULL, ''),
(3, 'SportChannel', 'asdas', 0, '2016-04-07 12:15:59', '2016-07-05 09:48:26', 'fa-align-justify', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_connect_fee`
--

CREATE TABLE `tcr_connect_fee` (
  `id` int(11) NOT NULL,
  `settings_id` int(11) DEFAULT NULL,
  `pricePerMonth` double NOT NULL,
  `pricePerThreeMonths` double NOT NULL,
  `pricePerSixMonths` double NOT NULL,
  `pricePerTwelveMonths` double NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_connect_fee`
--

INSERT INTO `tcr_connect_fee` (`id`, `settings_id`, `pricePerMonth`, `pricePerThreeMonths`, `pricePerSixMonths`, `pricePerTwelveMonths`, `country`) VALUES
(1, 1, 1, 1, 1, 1, 'Switzerland'),
(2, 1, 1, 1, 1, 1, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_exception_table`
--

CREATE TABLE `tcr_exception_table` (
  `id` int(11) NOT NULL,
  `trace` longtext COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tcr_free_packages`
--

CREATE TABLE `tcr_free_packages` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_free_packages`
--

INSERT INTO `tcr_free_packages` (`id`, `package_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_image`
--

CREATE TABLE `tcr_image` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_image`
--

INSERT INTO `tcr_image` (`id`, `name`) VALUES
(1, '56c446d095179.png'),
(2, '56c447f669bf9.png'),
(3, '56c450f7014cb.png'),
(4, '56c589997732b.png'),
(8, '56c447f669bf9.png'),
(9, '56c589997732b.png'),
(10, '57062ffec63bc.png'),
(11, '570632d685399.png'),
(12, '5718ae6421495.png'),
(13, '570632d685399.png'),
(14, '5730313c1f09c.gif'),
(15, '5730345abda4f.png'),
(16, '5732fe777af35.png'),
(18, '570632d685399.png'),
(19, '570632d685399.png'),
(20, '57555bc9e6087.png'),
(21, '57555dcdf27c1.png'),
(22, '57555bc9e6087.png'),
(23, '57555bc9e6087.png'),
(24, '57555bc9e6087.png'),
(25, '5756aa2f06446.png'),
(26, '570632d685399.png'),
(27, '56d5f8f66e03d.png'),
(28, '5761377cb8f4b.png'),
(29, '56d5f8f66e03d.png'),
(30, '576149094f547.png'),
(31, '5761492a7774d.png'),
(32, '5761377cb8f4b.png'),
(33, '5761377cb8f4b.png'),
(34, '56d5f8f66e03d.png'),
(35, '5761377cb8f4b.png'),
(36, '56d5f8f66e03d.png'),
(37, '56d5f8f66e03d.png'),
(38, '56d5f8f66e03d.png'),
(39, '5761377cb8f4b.png'),
(40, '5761377cb8f4b.png'),
(41, '5761377cb8f4b.png'),
(42, '56d5f8f66e03d.png'),
(43, '56d5f8f66e03d.png'),
(44, '56d5f8f66e03d.png'),
(45, '56d5f8f66e03d.png'),
(46, '56d5f8f66e03d.png'),
(47, '56d5f8f66e03d.png'),
(48, '56d5f8f66e03d.png'),
(49, '56d5f8f66e03d.png'),
(50, '56d5f8f66e03d.png'),
(51, '5761377cb8f4b.png'),
(52, '56d5f8f66e03d.png'),
(53, '56d5f8f66e03d.png'),
(54, '5761377cb8f4b.png'),
(55, '5761377cb8f4b.png'),
(56, '5761377cb8f4b.png'),
(57, '56d5f8f66e03d.png'),
(58, '5761377cb8f4b.png'),
(59, '56d5f8f66e03d.png'),
(60, '5761377cb8f4b.png'),
(61, 'hanPijesak.jpg'),
(62, 'hanPijesak.jpg'),
(63, 'hanPijesak.jpg'),
(64, '56d56bf9902fa.jpg'),
(65, '56d56bf9902fa.jpg'),
(66, '56d56bf9902fa.jpg'),
(67, '56d56bf9902fa.jpg'),
(68, '56d56bf9902fa.jpg'),
(69, 'tcr-logo.png'),
(70, 'marker-01-128.png'),
(71, '582c5bb4c12d0.png'),
(72, '582c5bb4c12d0.png'),
(73, '582c5bb4c12d0.png'),
(74, '582c5bb4c12d0.png'),
(75, '582c5bb4c12d0.png'),
(76, '582c5bb4c12d0.png'),
(77, '582c5bb4c12d0.png'),
(78, '582c5bb4c12d0.png'),
(79, NULL),
(80, 'hanPijesak.jpg'),
(81, NULL),
(82, '582dc3e785d47.jpeg'),
(83, NULL),
(84, '582dc419a701a.png'),
(85, NULL),
(86, '582dc4c3637f9.jpeg'),
(87, '582eb623f2096.png'),
(88, '582eb63e311dd.png'),
(89, '582ebeed9a1e4.png'),
(90, '582ebeed9a1e4.png'),
(91, '582eed962a968.png'),
(92, '582eedb422f2f.png'),
(93, '582eedc757895.png'),
(94, '582eedd479783.png'),
(95, '582eeddd01f0b.png'),
(96, '582eede5a9d3c.png'),
(97, '582eede9684ea.png'),
(98, '582eedf4c412b.png'),
(99, '582eedff1443c.png'),
(100, '582eee14c377e.png'),
(101, '56d56bf9902fa.jpg'),
(102, 'iphone-hero-holiday-gifts-201611.png'),
(103, '584011ccca12b.png'),
(104, NULL),
(105, NULL),
(106, NULL),
(107, NULL),
(108, NULL),
(113, NULL),
(115, NULL),
(116, 'iphone-hero-holiday-gifts-201611.png'),
(117, 'iphone-hero-holiday-gifts-201611.png'),
(118, 'iphone-hero-holiday-gifts-201611.png'),
(119, 'iphone-hero-holiday-gifts-201611.png'),
(120, 'iphone-hero-holiday-gifts-201611.png'),
(121, 'iphone-hero-holiday-gifts-201611.png'),
(122, 'iphone-hero-holiday-gifts-201611.png'),
(123, '5840353a448b4.jpeg'),
(124, '5841358d5914c.png'),
(125, '58416542caa56.jpeg'),
(126, '13490633_1062923870411606_4325778330827701882_o.jpg'),
(127, '5841724ea7963.jpeg'),
(128, '5841726e9649b.jpeg'),
(129, '5841727a48746.jpeg'),
(130, '58417289a091d.jpeg'),
(131, '584172a4d5136.jpeg'),
(132, '584172d2c0204.jpeg'),
(133, '584172ed9572c.jpeg'),
(134, '58417314884de.jpeg'),
(135, '5841731f6951f.jpeg'),
(136, '5841733056384.jpeg'),
(137, '5841733056384.jpeg'),
(138, '584173bf01e61.jpeg'),
(139, '584177296dcaf.png'),
(140, '584177296dcaf.png'),
(141, '584177296dcaf.png'),
(142, '584177296dcaf.png'),
(143, '58417de2802e1.png'),
(144, '58417de2802e1.png'),
(145, '58417de2802e1.png'),
(146, '58417de2802e1.png'),
(147, '58417de2802e1.png'),
(148, '58417de2802e1.png'),
(149, '58417de2802e1.png'),
(150, '58417de2802e1.png'),
(151, '5841854255c7f.png'),
(152, '5841854255c7f.png'),
(153, '5841854255c7f.png'),
(154, '5841854255c7f.png'),
(155, '5841854255c7f.png'),
(156, '5841854255c7f.png'),
(157, '5841854255c7f.png'),
(158, '5841854255c7f.png'),
(159, '5841854255c7f.png'),
(160, '5841854255c7f.png'),
(161, '5841854255c7f.png'),
(162, '5841854255c7f.png'),
(163, '5841854255c7f.png'),
(164, '5841854255c7f.png'),
(165, '5841854255c7f.png'),
(166, '5841854255c7f.png'),
(167, '5841854255c7f.png'),
(168, '5841854255c7f.png'),
(169, '5841854255c7f.png'),
(170, '582dc4c3637f9.jpeg'),
(171, '582dc4c3637f9.jpeg'),
(172, 'backdrop.jpg'),
(173, '584698018181a.jpeg'),
(174, '58469e31220d2.jpeg'),
(175, '58469ec51a81a.jpeg'),
(176, '5846a1e386d20.jpeg'),
(177, '5846a1e386d20.jpeg'),
(178, '5846a1e386d20.jpeg'),
(179, 'backdrop.jpg'),
(180, 'backdrop.jpg'),
(181, 'backdrop.jpg'),
(182, 'backdrop.jpg'),
(183, 'backdrop.jpg'),
(184, 'backdrop.jpg'),
(185, '5846b47679416.jpeg'),
(186, '5846b47679416.jpeg'),
(187, '5846b47679416.jpeg'),
(188, '5846a1e386d20.jpeg'),
(189, '5846d3f702a47.jpeg'),
(190, '5846d41d2df77.jpeg'),
(191, '5846d41d2df77.jpeg'),
(192, '5846d4e60fb90.jpeg'),
(193, '5847eef201599.jpeg'),
(194, '5847ef47608cc.jpeg'),
(195, '5847f8564a49e.jpeg'),
(196, '5847f8f6b405e.jpeg'),
(197, '5847fab21d818.jpeg'),
(198, '5847fb0f4ff58.jpeg'),
(199, '5848122dd1274.jpeg'),
(200, '584812d919f8d.jpeg'),
(201, NULL),
(202, '584818d28d12c.jpeg'),
(203, '584818d28d12c.jpeg'),
(204, '584818d28d12c.jpeg'),
(205, '584818d28d12c.jpeg'),
(206, '582ebeed9a1e4.png'),
(207, '584818d28d12c.jpeg'),
(208, '584818d28d12c.jpeg'),
(209, 'backdrop.jpg'),
(210, '58481d7b18759.jpeg'),
(211, '58481effaedd8.jpeg'),
(212, '58481effaedd8.jpeg'),
(213, '586236ed827b0.jpeg'),
(214, 'xiaomimi4i-624x351.jpg'),
(215, '5874c043a978a.png'),
(216, '5874c0807e204.png'),
(217, '5874c0807e204.png'),
(218, '5874c0807e204.png'),
(219, '5874c0807e204.png'),
(220, '5874c1690e101.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_join_package_category`
--

CREATE TABLE `tcr_join_package_category` (
  `package_id` int(11) NOT NULL,
  `package_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_join_package_category`
--

INSERT INTO `tcr_join_package_category` (`package_id`, `package_category_id`) VALUES
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_join_package_channel`
--

CREATE TABLE `tcr_join_package_channel` (
  `package_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_join_package_channel`
--

INSERT INTO `tcr_join_package_channel` (`package_id`, `channel_id`) VALUES
(1, 2),
(1, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_join_package_price`
--

CREATE TABLE `tcr_join_package_price` (
  `package_id` int(11) NOT NULL,
  `package_country_price_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_join_package_price`
--

INSERT INTO `tcr_join_package_price` (`package_id`, `package_country_price_id`) VALUES
(1, 7),
(1, 8),
(2, 9),
(2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_notification`
--

CREATE TABLE `tcr_notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_notification`
--

INSERT INTO `tcr_notification` (`id`, `user_id`, `created_at`, `link`, `message`, `seen`) VALUES
(1, 1, '2016-07-15 14:41:30', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(2, 1, '2016-07-27 08:53:16', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/2', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(3, 1, '2016-08-11 11:04:27', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/3', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(4, 1, '2016-08-11 11:06:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/4', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(5, 1, '2016-08-11 15:03:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/6', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(6, 1, '2016-08-11 15:06:53', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/7', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(7, 1, '2016-08-12 08:34:50', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/9', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(8, 1, '2016-08-12 14:37:58', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'losicpavle@yahoo.com ', 0),
(9, 2, '2016-08-12 14:37:59', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(10, 1, '2016-08-15 09:04:37', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/12', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(11, 1, '2016-09-05 15:44:36', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'test@fsd.rs ', 0),
(12, 3, '2016-09-05 15:44:37', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 1),
(13, 1, '2016-09-19 16:00:27', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'tester.chf@fsd.rs ', 0),
(14, 4, '2016-09-19 16:00:27', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'tester.chf@fsd.rs ', 0),
(15, 4, '2016-09-19 16:00:27', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(16, 1, '2016-11-18 10:22:17', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'tester.tester@fsd.tcr.es.de ', 0),
(17, 2, '2016-11-18 10:22:17', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'tester.tester@fsd.tcr.es.de ', 0),
(18, 4, '2016-11-18 10:22:17', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'tester.tester@fsd.tcr.es.de ', 0),
(19, 5, '2016-11-18 10:22:18', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(20, 1, '2016-11-28 13:35:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/13', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(21, 2, '2016-11-28 13:35:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/13', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(22, 4, '2016-11-28 13:35:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/13', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(23, 1, '2016-11-29 13:04:01', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/18', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(24, 2, '2016-11-29 13:04:01', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/18', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(25, 4, '2016-11-29 13:04:01', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/18', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(26, 1, '2016-11-29 13:54:34', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/23', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(27, 2, '2016-11-29 13:54:34', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/23', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(28, 4, '2016-11-29 13:54:34', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/23', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(29, 1, '2016-12-01 09:17:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@emailemail.com ', 0),
(30, 2, '2016-12-01 09:17:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@emailemail.com ', 0),
(31, 4, '2016-12-01 09:17:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@emailemail.com ', 0),
(33, 1, '2016-12-01 10:48:43', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Testttttttt@reasd123.com ', 0),
(34, 2, '2016-12-01 10:48:43', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Testttttttt@reasd123.com ', 0),
(35, 4, '2016-12-01 10:48:43', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Testttttttt@reasd123.com ', 0),
(37, 1, '2016-12-01 10:51:48', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'adsasdadsads@asddasads.com ', 0),
(38, 2, '2016-12-01 10:51:48', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'adsasdadsads@asddasads.com ', 0),
(39, 4, '2016-12-01 10:51:48', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'adsasdadsads@asddasads.com ', 0),
(42, 1, '2016-12-01 11:33:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asadsads@dadsadsas.com ', 0),
(43, 2, '2016-12-01 11:33:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asadsads@dadsadsas.com ', 0),
(44, 4, '2016-12-01 11:33:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asadsads@dadsadsas.com ', 0),
(47, 1, '2016-12-01 13:04:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ovajmailsigurnonema@nema.com ', 0),
(48, 2, '2016-12-01 13:04:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ovajmailsigurnonema@nema.com ', 0),
(49, 4, '2016-12-01 13:04:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ovajmailsigurnonema@nema.com ', 0),
(52, 1, '2016-12-01 13:06:13', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '231231654654@dsaadsads ', 0),
(53, 2, '2016-12-01 13:06:13', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '231231654654@dsaadsads ', 0),
(54, 4, '2016-12-01 13:06:13', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '231231654654@dsaadsads ', 0),
(57, 1, '2016-12-01 13:18:22', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'aaaaaaaaa@ASdadsad ', 0),
(58, 2, '2016-12-01 13:18:22', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'aaaaaaaaa@ASdadsad ', 0),
(59, 4, '2016-12-01 13:18:22', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'aaaaaaaaa@ASdadsad ', 0),
(62, 1, '2016-12-01 14:01:57', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ddddd@ddddd.com ', 0),
(63, 2, '2016-12-01 14:01:57', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ddddd@ddddd.com ', 0),
(64, 4, '2016-12-01 14:01:57', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ddddd@ddddd.com ', 0),
(67, 1, '2016-12-01 14:03:47', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ddddda@ddddd.com ', 0),
(68, 2, '2016-12-01 14:03:47', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ddddda@ddddd.com ', 0),
(69, 4, '2016-12-01 14:03:47', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'ddddda@ddddd.com ', 0),
(72, 1, '2016-12-01 14:04:14', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dddddas@ddddd.com ', 0),
(73, 2, '2016-12-01 14:04:14', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dddddas@ddddd.com ', 0),
(74, 4, '2016-12-01 14:04:14', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dddddas@ddddd.com ', 0),
(77, 1, '2016-12-01 14:16:07', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dddddasa@ddddd.com ', 0),
(78, 2, '2016-12-01 14:16:07', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dddddasa@ddddd.com ', 0),
(79, 4, '2016-12-01 14:16:07', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dddddasa@ddddd.com ', 0),
(82, 1, '2016-12-01 14:28:11', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '1231321321@asdasdads.commm ', 0),
(83, 2, '2016-12-01 14:28:11', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '1231321321@asdasdads.commm ', 0),
(84, 4, '2016-12-01 14:28:11', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '1231321321@asdasdads.commm ', 0),
(87, 1, '2016-12-02 13:12:50', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiram@tcr-fsd.rs ', 0),
(88, 2, '2016-12-02 13:12:50', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiram@tcr-fsd.rs ', 0),
(89, 4, '2016-12-02 13:12:50', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiram@tcr-fsd.rs ', 0),
(93, 1, '2016-12-05 13:43:16', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'nkm790021@gmail.com ', 0),
(94, 2, '2016-12-05 13:43:16', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'nkm790021@gmail.com ', 0),
(95, 4, '2016-12-05 13:43:16', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'nkm790021@gmail.com ', 0),
(96, 24, '2016-12-05 13:43:17', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(97, 1, '2016-12-05 13:50:03', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/36', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(98, 2, '2016-12-05 13:50:03', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/36', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(99, 4, '2016-12-05 13:50:03', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/36', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(100, 1, '2016-12-05 14:01:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/41', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(101, 2, '2016-12-05 14:01:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/41', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(102, 4, '2016-12-05 14:01:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/41', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(103, 1, '2016-12-05 14:24:40', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/42', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(104, 2, '2016-12-05 14:24:40', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/42', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(105, 4, '2016-12-05 14:24:40', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/42', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(106, 1, '2016-12-05 14:30:32', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/43', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(107, 2, '2016-12-05 14:30:32', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/43', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(108, 4, '2016-12-05 14:30:32', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/43', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(109, 1, '2016-12-05 14:31:53', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/44', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(110, 2, '2016-12-05 14:31:53', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/44', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(111, 4, '2016-12-05 14:31:53', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/44', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(112, 1, '2016-12-05 14:35:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/45', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(113, 2, '2016-12-05 14:35:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/45', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(114, 4, '2016-12-05 14:35:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/45', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(115, 1, '2016-12-05 15:20:20', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/15', 'New order has been confirmed by test@fsd.rs', 0),
(116, 2, '2016-12-05 15:20:20', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/15', 'New order has been confirmed by test@fsd.rs', 0),
(117, 4, '2016-12-05 15:20:20', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/15', 'New order has been confirmed by test@fsd.rs', 0),
(118, 1, '2016-12-05 15:22:13', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/46', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(119, 2, '2016-12-05 15:22:13', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/46', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(120, 4, '2016-12-05 15:22:13', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/46', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(121, 1, '2016-12-06 10:03:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '9999@999 ', 0),
(122, 2, '2016-12-06 10:03:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '9999@999 ', 0),
(123, 4, '2016-12-06 10:03:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '9999@999 ', 0),
(124, 25, '2016-12-06 10:04:03', '/app_dev.php/fr/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(125, 1, '2016-12-06 10:07:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '9999@99922.com ', 0),
(126, 2, '2016-12-06 10:07:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '9999@99922.com ', 0),
(127, 4, '2016-12-06 10:07:21', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '9999@99922.com ', 0),
(128, 27, '2016-12-06 10:07:21', '/app_dev.php/fr/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(129, 1, '2016-12-06 10:11:14', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '29999@99922.com ', 0),
(130, 2, '2016-12-06 10:11:15', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '29999@99922.com ', 0),
(131, 4, '2016-12-06 10:11:15', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '29999@99922.com ', 0),
(132, 28, '2016-12-06 10:11:15', '/app_dev.php/fr/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(133, 1, '2016-12-06 10:21:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@mail ', 0),
(134, 2, '2016-12-06 10:21:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@mail ', 0),
(135, 4, '2016-12-06 10:21:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@mail ', 0),
(136, 29, '2016-12-06 10:21:35', '/app_dev.php/fr/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(137, 1, '2016-12-06 11:13:43', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'last@user ', 0),
(138, 2, '2016-12-06 11:13:43', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'last@user ', 0),
(139, 4, '2016-12-06 11:13:43', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'last@user ', 0),
(140, 30, '2016-12-06 11:13:44', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(141, 1, '2016-12-06 11:23:26', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asdasd ', 0),
(142, 2, '2016-12-06 11:23:26', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asdasd ', 0),
(143, 4, '2016-12-06 11:23:26', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asdasd ', 0),
(144, 31, '2016-12-06 11:23:27', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(145, 1, '2016-12-06 11:26:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asdasdasdasd ', 0),
(146, 2, '2016-12-06 11:26:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asdasdasdasd ', 0),
(147, 4, '2016-12-06 11:26:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asdasdasdasd ', 0),
(148, 32, '2016-12-06 11:26:04', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(149, 1, '2016-12-06 12:17:05', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poiuytr@poiuytr ', 0),
(150, 2, '2016-12-06 12:17:05', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poiuytr@poiuytr ', 0),
(151, 4, '2016-12-06 12:17:05', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poiuytr@poiuytr ', 0),
(152, 33, '2016-12-06 12:17:05', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(153, 1, '2016-12-06 12:19:33', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poiuytr@poiuytrtr ', 0),
(154, 2, '2016-12-06 12:19:33', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poiuytr@poiuytrtr ', 0),
(155, 4, '2016-12-06 12:19:33', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poiuytr@poiuytrtr ', 0),
(156, 34, '2016-12-06 12:19:33', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(157, 1, '2016-12-06 12:57:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghji ', 0),
(158, 2, '2016-12-06 12:57:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghji ', 0),
(159, 4, '2016-12-06 12:57:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghji ', 0),
(160, 35, '2016-12-06 12:57:31', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(161, 1, '2016-12-06 12:59:49', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjias ', 0),
(162, 2, '2016-12-06 12:59:49', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjias ', 0),
(163, 4, '2016-12-06 12:59:49', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjias ', 0),
(164, 38, '2016-12-06 12:59:49', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(165, 1, '2016-12-06 13:00:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasdd ', 0),
(166, 2, '2016-12-06 13:00:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasdd ', 0),
(167, 4, '2016-12-06 13:00:59', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasdd ', 0),
(168, 39, '2016-12-06 13:00:59', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(169, 1, '2016-12-06 13:03:22', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrr ', 0),
(170, 2, '2016-12-06 13:03:22', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrr ', 0),
(171, 4, '2016-12-06 13:03:22', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrr ', 0),
(172, 40, '2016-12-06 13:03:22', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(173, 1, '2016-12-06 13:05:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrrff ', 0),
(174, 2, '2016-12-06 13:05:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrrff ', 0),
(175, 4, '2016-12-06 13:05:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrrff ', 0),
(176, 41, '2016-12-06 13:05:04', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(177, 1, '2016-12-06 13:06:10', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrrffrr ', 0),
(178, 2, '2016-12-06 13:06:10', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrrffrr ', 0),
(179, 4, '2016-12-06 13:06:10', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'dfjkghji@dfjkghjiasddrrffrr ', 0),
(180, 42, '2016-12-06 13:06:10', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(181, 1, '2016-12-06 13:13:17', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'customers@customers ', 0),
(182, 2, '2016-12-06 13:13:17', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'customers@customers ', 0),
(183, 4, '2016-12-06 13:13:17', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'customers@customers ', 0),
(184, 43, '2016-12-06 13:13:18', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(185, 1, '2016-12-06 13:17:25', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Ember2@Ember2 ', 0),
(186, 2, '2016-12-06 13:17:25', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Ember2@Ember2 ', 0),
(187, 4, '2016-12-06 13:17:25', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Ember2@Ember2 ', 0),
(188, 44, '2016-12-06 13:17:25', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(189, 1, '2016-12-06 13:52:06', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'symfony@mail.com ', 0),
(190, 2, '2016-12-06 13:52:06', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'symfony@mail.com ', 0),
(191, 4, '2016-12-06 13:52:06', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'symfony@mail.com ', 0),
(192, 45, '2016-12-06 13:52:06', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(193, 1, '2016-12-06 16:06:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '666@6 ', 0),
(194, 2, '2016-12-06 16:06:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '666@6 ', 0),
(195, 4, '2016-12-06 16:06:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '666@6 ', 0),
(196, 46, '2016-12-06 16:06:31', '/app_dev.php/es/profile/orders/my-services-list', 'Los paquetes libres son asignadas a usted. Compruebe sus órdenes libres.', 0),
(197, 1, '2016-12-06 16:10:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '5555@2 ', 0),
(198, 2, '2016-12-06 16:10:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '5555@2 ', 0),
(199, 4, '2016-12-06 16:10:30', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '5555@2 ', 0),
(200, 47, '2016-12-06 16:10:30', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(201, 1, '2016-12-07 12:13:54', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdddddddddd@fsdddd.ddddd ', 0),
(202, 2, '2016-12-07 12:13:54', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdddddddddd@fsdddd.ddddd ', 0),
(203, 4, '2016-12-07 12:13:54', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdddddddddd@fsdddd.ddddd ', 0),
(204, 48, '2016-12-07 12:13:54', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(205, 1, '2016-12-07 12:15:19', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'avatar@avatar ', 0),
(206, 2, '2016-12-07 12:15:19', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'avatar@avatar ', 0),
(207, 4, '2016-12-07 12:15:19', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'avatar@avatar ', 0),
(208, 49, '2016-12-07 12:15:19', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(209, 1, '2016-12-07 13:05:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'filePath@filePath ', 0),
(210, 2, '2016-12-07 13:05:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'filePath@filePath ', 0),
(211, 4, '2016-12-07 13:05:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'filePath@filePath ', 0),
(212, 50, '2016-12-07 13:05:35', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(213, 1, '2016-12-07 14:32:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asd ', 0),
(214, 2, '2016-12-07 14:32:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asd ', 0),
(215, 4, '2016-12-07 14:32:35', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdasd@asd ', 0),
(216, 76, '2016-12-07 14:32:35', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(217, 1, '2016-12-07 15:38:55', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@mai ', 0),
(218, 2, '2016-12-07 15:38:55', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@mai ', 0),
(219, 4, '2016-12-07 15:38:55', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@mai ', 0),
(220, 80, '2016-12-07 15:38:56', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(221, 1, '2016-12-07 16:06:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@maila ', 0),
(222, 2, '2016-12-07 16:06:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@maila ', 0),
(223, 4, '2016-12-07 16:06:28', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'email@maila ', 0),
(224, 82, '2016-12-07 16:06:28', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(225, 1, '2016-12-20 09:33:07', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/87', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(226, 2, '2016-12-20 09:33:07', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/87', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(227, 4, '2016-12-20 09:33:07', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/87', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(228, 1, '2016-12-22 12:12:26', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '12345@12345.12345 ', 0),
(229, 2, '2016-12-22 12:12:26', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '12345@12345.12345 ', 0),
(230, 4, '2016-12-22 12:12:26', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', '12345@12345.12345 ', 0),
(231, 83, '2016-12-22 12:12:27', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(232, 1, '2016-12-22 12:14:02', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiram@tcr-fsd.rs ', 0),
(233, 2, '2016-12-22 12:14:02', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiram@tcr-fsd.rs ', 0),
(234, 4, '2016-12-22 12:14:02', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiram@tcr-fsd.rs ', 0),
(235, 1, '2016-12-26 12:04:25', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'test@test ', 0),
(236, 2, '2016-12-26 12:04:25', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'test@test ', 0),
(237, 4, '2016-12-26 12:04:25', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'test@test ', 0),
(238, 85, '2016-12-26 12:04:27', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(239, 1, '2016-12-26 12:08:12', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiranjeeeeee@testiranjeeeeee.com ', 0),
(240, 2, '2016-12-26 12:08:12', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiranjeeeeee@testiranjeeeeee.com ', 0),
(241, 4, '2016-12-26 12:08:12', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testiranjeeeeee@testiranjeeeeee.com ', 0),
(242, 86, '2016-12-26 12:08:13', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(243, 1, '2016-12-26 12:09:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testing@testing ', 0),
(244, 2, '2016-12-26 12:09:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testing@testing ', 0),
(245, 4, '2016-12-26 12:09:04', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testing@testing ', 0),
(246, 87, '2016-12-26 12:09:05', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(247, 1, '2016-12-26 12:10:01', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poewrl@pole.com ', 0),
(248, 2, '2016-12-26 12:10:01', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poewrl@pole.com ', 0),
(249, 4, '2016-12-26 12:10:01', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'poewrl@pole.com ', 0),
(250, 88, '2016-12-26 12:10:01', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(251, 1, '2016-12-26 12:20:11', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testAgent@testAgent ', 0),
(252, 2, '2016-12-26 12:20:11', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testAgent@testAgent ', 0),
(253, 4, '2016-12-26 12:20:11', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'testAgent@testAgent ', 0),
(254, 89, '2016-12-26 12:20:12', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(255, 1, '2016-12-26 12:22:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'af@asdjf ', 0),
(256, 2, '2016-12-26 12:22:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'af@asdjf ', 0),
(257, 4, '2016-12-26 12:22:31', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'af@asdjf ', 0),
(258, 90, '2016-12-26 12:22:31', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(259, 1, '2016-12-26 12:24:06', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdh@asd ', 0),
(260, 2, '2016-12-26 12:24:06', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdh@asd ', 0),
(261, 4, '2016-12-26 12:24:06', 'http://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'asdh@asd ', 0),
(262, 91, '2016-12-26 12:24:06', '/app_dev.php/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(263, 1, '2016-12-27 10:39:57', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Tester@mail ', 0),
(264, 2, '2016-12-27 10:39:57', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Tester@mail ', 0),
(265, 4, '2016-12-27 10:39:57', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/users-all', 'Tester@mail ', 0),
(266, 92, '2016-12-27 10:40:03', '/app_dev.php/de/profile/orders/my-services-list', 'Gratis Pakete sind Dir zugeordnet. Überprüfe Deine Email.', 0),
(267, 1, '2016-12-28 11:36:23', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/101', 'New order has been confirmed by test@fsd.rs', 0),
(268, 2, '2016-12-28 11:36:23', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/101', 'New order has been confirmed by test@fsd.rs', 0),
(269, 4, '2016-12-28 11:36:23', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/101', 'New order has been confirmed by test@fsd.rs', 0),
(270, 1, '2016-12-28 11:54:09', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/103', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(271, 2, '2016-12-28 11:54:09', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/103', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(272, 4, '2016-12-28 11:54:09', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/103', 'New order has been confirmed by tester.chf@fsd.rs', 0),
(273, 1, '2017-01-10 12:05:53', 'https://tcr-media.fsd.rs:105/en/dashboard/users-all', 'nikola@fsd.rs ', 0),
(274, 2, '2017-01-10 12:05:53', 'https://tcr-media.fsd.rs:105/en/dashboard/users-all', 'nikola@fsd.rs ', 0),
(275, 4, '2017-01-10 12:05:53', 'https://tcr-media.fsd.rs:105/en/dashboard/users-all', 'nikola@fsd.rs ', 0),
(276, 93, '2017-01-10 12:05:53', '/en/profile/orders/my-services-list', 'Free packages assigned to you. Check your email.', 0),
(277, 1, '2017-01-10 14:41:21', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/106', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(278, 2, '2017-01-10 14:41:21', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/106', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(279, 4, '2017-01-10 14:41:21', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/106', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(280, 1, '2017-01-10 14:48:01', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/109', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(281, 2, '2017-01-10 14:48:01', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/109', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(282, 4, '2017-01-10 14:48:01', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/109', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(283, 1, '2017-01-10 14:49:33', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/110', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(284, 2, '2017-01-10 14:49:33', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/110', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(285, 4, '2017-01-10 14:49:33', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/110', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(286, 1, '2017-01-10 14:52:08', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/111', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(287, 2, '2017-01-10 14:52:08', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/111', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(288, 4, '2017-01-10 14:52:08', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/111', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(289, 1, '2017-01-10 14:53:58', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/112', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(290, 2, '2017-01-10 14:53:58', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/112', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(291, 4, '2017-01-10 14:53:58', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/112', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(292, 1, '2017-01-10 14:55:03', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/113', 'New order has been confirmed by pavle.losic@fsd.rs', 1),
(293, 2, '2017-01-10 14:55:03', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/113', 'New order has been confirmed by pavle.losic@fsd.rs', 0),
(294, 4, '2017-01-10 14:55:03', 'https://tcr-media.fsd.rs:105/app_dev.php/en/dashboard/orders/order-preview-complete/113', 'New order has been confirmed by pavle.losic@fsd.rs', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_one_time_setup_fee`
--

CREATE TABLE `tcr_one_time_setup_fee` (
  `id` int(11) NOT NULL,
  `settings_id` int(11) DEFAULT NULL,
  `pricePerMonth` double NOT NULL,
  `pricePerThreeMonths` double NOT NULL,
  `pricePerSixMonths` double NOT NULL,
  `pricePerTwelveMonths` double NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_one_time_setup_fee`
--

INSERT INTO `tcr_one_time_setup_fee` (`id`, `settings_id`, `pricePerMonth`, `pricePerThreeMonths`, `pricePerSixMonths`, `pricePerTwelveMonths`, `country`) VALUES
(1, 1, 1, 1, 1, 1, 'Switzerland'),
(2, 1, 1, 1, 1, 1, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_order`
--

CREATE TABLE `tcr_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `created_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `items_total` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `num_of_remaining_days` int(11) DEFAULT NULL,
  `price_per_remaining_day` double DEFAULT NULL,
  `largest_period` int(11) DEFAULT NULL,
  `connect_price` double DEFAULT NULL,
  `num_of_streams` int(11) DEFAULT NULL,
  `streams_length` int(11) DEFAULT NULL,
  `stream_price` double DEFAULT NULL,
  `stream_date_to` datetime DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_price` double DEFAULT NULL,
  `connect_price_per_month` double DEFAULT NULL,
  `stream_price_per_month` double DEFAULT NULL,
  `agent_commissions_paid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_order`
--

INSERT INTO `tcr_order` (`id`, `user_id`, `description`, `created_at`, `completed_at`, `items_total`, `total`, `num_of_remaining_days`, `price_per_remaining_day`, `largest_period`, `connect_price`, `num_of_streams`, `streams_length`, `stream_price`, `stream_date_to`, `state`, `fee_price`, `connect_price_per_month`, `stream_price_per_month`, `agent_commissions_paid`) VALUES
(9, 1, 'Latino Simple', '2016-08-12 08:34:46', '2016-08-12 08:34:50', 38.18, 66.846451612903, 19, 0.45612903225806, 3, 0, 0, 0, 0, '2016-12-01 00:00:00', 'complete', 20, 0, 0, 1),
(10, 2, NULL, '2016-08-12 14:37:59', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(11, 2, 'Latino Simple', '2016-12-02 08:32:06', NULL, 1, 8.8709677419355, 29, 0.064516129032258, 1, 1, 0, 0, 0, '2017-02-01 00:00:00', 'add_to_cart', 5, 1, 0, 1),
(12, 1, 'Latino Simple', '2016-08-15 09:04:33', '2016-08-15 09:04:37', 14.14, 21.438064516129, 16, 0.45612903225806, 1, 0, 0, 0, 0, '2016-10-01 00:00:00', 'complete', 0, 0, 0, 1),
(13, 1, 'Latino Simple', '2016-11-28 12:58:38', '2016-11-28 13:35:21', 67.87, 93.012666666667, 2, 0.57133333333333, 6, 6, 1, 6, 18, '2017-06-01 00:00:00', 'complete', 0, 0, 3, 1),
(14, 3, NULL, '2016-09-05 15:44:37', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(15, 3, 'Latino Simple', '2016-12-05 15:20:16', '2016-12-05 15:20:20', 1, 4.6774193548387, 26, 0.064516129032258, 1, 1, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 1, 1, 0, 1),
(16, 4, NULL, '2016-09-19 16:00:27', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(17, 5, NULL, '2016-11-18 10:22:17', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(18, 1, 'Latino Simple', '2016-11-29 13:01:19', '2016-11-29 13:04:01', 1, 1.0333333333333, 1, 0.033333333333333, 1, 0, 0, 0, 0, '2017-01-01 00:00:00', 'complete', 0, 0, 0, 1),
(19, 1, 'Latino Simple', '2016-11-29 13:46:03', NULL, 1, 5, 1, 0, 1, 1, 1, 1, 3, '2017-07-01 00:00:00', 'extend', 0, 0, 3, 1),
(20, 1, NULL, '2016-11-29 13:22:43', NULL, 0, 3.1, 1, 0.1, 0, 0, 1, 1, 3, '2017-01-01 00:00:00', 'stream', 0, 0, 3, 1),
(21, 1, 'Latino Simple', '2016-12-05 11:56:45', NULL, 1, 1.8387096774194, 26, 0.032258064516129, 3, 0, 0, 0, 0, '2017-04-01 00:00:00', 'abandoned_cart', 0, 0, 0, 1),
(22, 1, NULL, '2016-11-29 13:46:39', NULL, 0, 3.1, 1, 0.1, 0, 0, 1, 1, 3, '2017-01-01 00:00:00', 'stream', 0, 0, 3, 1),
(23, 1, NULL, '2016-11-29 13:53:10', '2016-11-29 13:54:34', 0, 3.1, 1, 0.1, 0, 0, 1, 1, 3, '2017-01-01 00:00:00', 'complete', 0, 0, 3, 1),
(36, 4, 'Latino Simple', '2016-12-05 13:48:21', '2016-12-05 13:50:03', 1, 4.6774193548387, 26, 0.064516129032258, 1, 1, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 1, 1, 0, 1),
(37, 1, 'Latino Simple', NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'extend', 0, 0, 0, 1),
(39, 24, NULL, '2016-12-05 13:43:17', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(40, 4, NULL, '2016-12-05 13:51:19', NULL, 0, 1.8387096774194, 26, 0.032258064516129, 0, 0, 1, 1, 1, '2017-02-01 00:00:00', 'stream', 0, 0, 1, 1),
(41, 4, NULL, '2016-12-05 13:57:58', '2016-12-05 14:01:28', 0, 1.8387096774194, 26, 0.032258064516129, 0, 0, 1, 1, 1, '2017-02-01 00:00:00', 'complete', 0, 0, 1, 1),
(42, 4, 'Latino Simple', '2016-12-05 14:23:47', '2016-12-05 14:24:40', 1, 1.8387096774194, 26, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 0, 0, 0, 1),
(43, 4, 'Latino Simple', '2016-12-05 14:29:03', '2016-12-05 14:30:32', 1, 1.8387096774194, 26, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 0, 0, 0, 1),
(44, 4, 'Latino Simple', '2016-12-05 14:31:24', '2016-12-05 14:31:53', 1, 1.8387096774194, 26, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 0, 0, 0, 1),
(45, 4, 'Latino Simple', '2016-12-05 14:35:11', '2016-12-05 14:35:30', 1, 1.8387096774194, 26, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 0, 0, 0, 1),
(46, 4, 'Latino Simple', '2016-12-05 15:21:33', '2016-12-05 15:22:13', 1, 1.8387096774194, 26, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'complete', 0, 0, 0, 1),
(47, 25, NULL, '2016-12-06 10:04:03', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(48, 27, NULL, '2016-12-06 10:07:21', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(49, 28, NULL, '2016-12-06 10:11:15', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(50, 29, NULL, '2016-12-06 10:21:35', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(51, 30, NULL, '2016-12-06 11:13:44', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(52, 31, NULL, '2016-12-06 11:23:27', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(53, 32, NULL, '2016-12-06 11:26:04', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(54, 33, NULL, '2016-12-06 12:17:05', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(55, 34, NULL, '2016-12-06 12:19:33', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(56, 35, NULL, '2016-12-06 12:57:31', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(57, 38, NULL, '2016-12-06 12:59:49', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(58, 39, NULL, '2016-12-06 13:00:59', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(59, 40, NULL, '2016-12-06 13:03:22', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(60, 41, NULL, '2016-12-06 13:05:04', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(61, 42, NULL, '2016-12-06 13:06:10', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(62, 43, NULL, '2016-12-06 13:13:18', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(63, 44, NULL, '2016-12-06 13:17:25', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(64, 45, NULL, '2016-12-06 13:52:06', '2017-01-11 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'complete', 0, 0, 0, 1),
(65, 46, NULL, '2016-12-06 16:06:31', '2017-01-09 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'complete', 0, 0, 0, 1),
(66, 47, NULL, '2016-12-06 16:10:30', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(67, 48, NULL, '2016-12-07 12:13:54', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(68, 49, NULL, '2016-12-07 12:15:19', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(69, 50, NULL, '2016-12-07 13:05:35', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(70, 76, NULL, '2016-12-07 14:32:35', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(71, 80, NULL, '2016-12-07 15:38:56', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(72, 82, NULL, '2016-12-07 16:06:28', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(73, 4, 'Latino Simple', '2016-12-12 12:37:05', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(74, 4, 'Latino Simple', '2016-12-12 12:38:03', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(75, 1, 'Latino Simple', '2016-12-12 12:48:04', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(76, 1, 'Latino Simple', '2016-12-12 12:48:14', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(77, 1, 'Latino Simple', '2016-12-12 12:49:31', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(78, 1, 'Latino Simple', '2016-12-12 12:49:43', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(79, 1, 'Latino Simple', '2016-12-12 12:49:50', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(80, 1, 'Latino Simple', '2016-12-12 12:49:56', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(81, 1, 'Latino Simple', '2016-12-12 12:50:07', NULL, 1, 1.6129032258065, 19, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'abandoned_cart', 0, 0, 0, 1),
(82, 1, 'Latino Simple', '2016-12-12 12:50:14', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(83, 4, 'Latino Simple', '2016-12-12 12:53:45', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(84, 1, 'Latino Simple', '2016-12-12 12:56:34', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(85, 1, 'Latino Simple', '2016-12-12 12:57:00', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(86, 1, 'Latino Simple', '2016-12-12 12:57:06', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(87, 1, 'Latino Simple', '2016-12-20 09:33:02', '2016-12-20 09:33:07', 1, 1.3548387096774, 11, 0.032258064516129, 3, 0, 0, 0, 0, '2017-04-01 00:00:00', 'complete', 0, 0, 0, 1),
(88, 4, 'Latino Simple', '2016-12-12 13:33:54', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(89, 4, 'Latino Simple', '2016-12-12 13:59:00', NULL, 1, 1.6129032258065, 19, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'add_to_cart', 0, 0, 0, 1),
(90, 3, 'Latino Simple', '2016-12-12 17:43:56', NULL, 1, 1.6129032258065, 19, 0.032258064516129, 1, 0, 0, 0, 0, '2017-02-01 00:00:00', 'abandoned_cart', 0, 0, 0, 1),
(91, 3, 'Latino Simple', '2016-12-12 17:44:17', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'add_to_cart', 0, 0, 0, 1),
(92, 83, NULL, '2016-12-22 12:12:27', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(93, 85, NULL, '2016-12-26 12:04:27', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(94, 86, NULL, '2016-12-26 12:08:13', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(95, 87, NULL, '2016-12-26 12:09:05', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(96, 88, NULL, '2016-12-26 12:10:01', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(97, 89, NULL, '2016-12-26 12:20:12', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(98, 90, NULL, '2016-12-26 12:22:31', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(99, 91, NULL, '2016-12-26 12:24:06', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(100, 92, NULL, '2016-12-27 10:40:03', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(101, 3, NULL, '2016-12-28 11:36:08', '2016-12-28 11:36:23', 0, 1.0967741935484, 3, 0.032258064516129, 0, 0, 1, 1, 1, '2017-02-01 00:00:00', 'complete', 0, 0, 1, 1),
(102, 4, NULL, '2016-12-28 11:43:07', NULL, 0, 1.0967741935484, 3, 0.032258064516129, 0, 0, 1, 1, 1, '2017-02-01 00:00:00', 'stream', 0, 0, 1, 1),
(103, 4, NULL, '2016-12-28 11:52:40', '2016-12-28 11:54:09', 0, 1.0967741935484, 3, 0.032258064516129, 0, 0, 1, 1, 1, '2017-02-01 00:00:00', 'complete', 0, 0, 1, 1),
(104, 4, 'Latino Simple', '2016-12-28 11:58:18', NULL, 1, 2, 3, 0, 1, 1, 0, 0, 0, '2017-03-01 00:00:00', 'extend', 0, 0, 0, 1),
(105, 4, 'Latino Simple', '2016-12-28 12:00:14', NULL, 1, 2, 3, 0, 1, 1, 0, 0, 0, '2017-03-01 00:00:00', 'extend', 0, 0, 0, 1),
(106, 1, 'Latino Simple', '2017-01-10 14:41:17', '2017-01-10 14:41:21', 1, 1.6774193548387, 21, 0.032258064516129, 1, 0, 0, 0, 0, '2017-03-01 00:00:00', 'complete', 0, 0, 0, 1),
(107, 93, NULL, '2017-01-10 12:05:53', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'free_complete', 0, 0, 0, 1),
(108, 1, 'Latino Simple', '2017-01-10 14:45:53', NULL, 1, 1, 0, 0, 0, 0, 0, 1, 0, NULL, 'abandoned_cart', 0, 0, 0, 1),
(109, 1, 'Latino Simple', '2017-01-10 14:47:56', '2017-01-10 14:48:01', 1, 1.6774193548387, 21, 0.032258064516129, 1, 0, 0, 0, 0, '2017-03-01 00:00:00', 'complete', 0, 0, 0, 1),
(110, 1, 'Latino Simple', '2017-01-10 14:49:29', '2017-01-10 14:49:33', 1, 1.6774193548387, 21, 0.032258064516129, 1, 0, 0, 0, 0, '2017-03-01 00:00:00', 'complete', 0, 0, 0, 1),
(111, 1, 'Latino Simple', '2017-01-10 14:52:04', '2017-01-10 14:52:08', 1, 1.6774193548387, 21, 0.032258064516129, 1, 0, 0, 0, 0, '2017-03-01 00:00:00', 'complete', 0, 0, 0, 1),
(112, 1, 'Latino Simple', '2017-01-10 14:53:53', '2017-01-10 14:53:58', 1, 1.6774193548387, 21, 0.032258064516129, 1, 0, 0, 0, 0, '2017-03-01 00:00:00', 'complete', 0, 0, 0, 1),
(113, 1, 'Latino Simple', '2017-01-10 14:54:59', '2017-01-10 14:55:03', 1, 1.6774193548387, 21, 0.032258064516129, 1, 0, 0, 0, 0, '2017-03-01 00:00:00', 'complete', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_order_item`
--

CREATE TABLE `tcr_order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `extended_item_id` int(11) DEFAULT NULL,
  `activated_item_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `number_of_months` int(11) DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `price_per_remaining_day` double DEFAULT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `is_extended` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_order_item`
--

INSERT INTO `tcr_order_item` (`id`, `order_id`, `product_id`, `extended_item_id`, `activated_item_id`, `created_at`, `date_from`, `date_to`, `number_of_months`, `unit_price`, `price_per_remaining_day`, `is_activated`, `is_extended`) VALUES
(9, 9, 1, NULL, NULL, '2016-08-12 08:34:22', '2016-08-12 08:19:59', '2016-07-01 00:00:00', 3, 38.18, 0.45612903225806, 0, 0),
(10, 10, 2, NULL, NULL, '2016-08-12 14:37:59', NULL, NULL, 1, 0, 0, 0, 0),
(11, 11, 1, NULL, NULL, '2016-08-12 14:38:06', '2016-12-02 08:31:05', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(12, 12, 1, NULL, NULL, '2016-08-15 08:41:42', '2016-08-15 08:49:40', '2016-08-01 00:00:00', 1, 14.14, 0.45612903225806, 0, 0),
(13, 13, 1, NULL, NULL, '2016-08-15 09:10:04', '2016-11-28 12:57:44', '2017-06-01 00:00:00', 6, 67.87, 0.47133333333333, 0, 0),
(14, 14, 2, NULL, NULL, '2016-09-05 15:44:37', NULL, NULL, 1, 0, 0, 0, 0),
(15, 15, 1, NULL, NULL, '2016-09-09 10:07:02', '2016-12-05 15:19:08', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(16, 16, 2, NULL, NULL, '2016-09-19 16:00:27', NULL, NULL, 1, 0, 0, 0, 0),
(17, 17, 2, NULL, NULL, '2016-11-18 10:22:17', NULL, NULL, 1, 0, 0, 0, 0),
(18, 18, 1, NULL, NULL, '2016-11-28 13:50:31', '2016-11-29 13:00:23', '2017-01-01 00:00:00', 1, 1, 0.033333333333333, 0, 0),
(19, 19, 1, 13, NULL, '2016-11-29 13:10:00', '2017-06-01 00:00:00', '2017-07-01 00:00:00', 1, 1, 0, 0, 0),
(20, 21, 1, NULL, NULL, '2016-11-29 13:42:24', '2016-12-05 11:55:38', '2017-04-01 00:00:00', 3, 1, 0.032258064516129, 0, 0),
(33, 36, 1, NULL, NULL, '2016-12-02 08:34:03', '2016-12-05 13:47:13', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(34, 37, 1, 18, NULL, '2016-12-02 09:09:59', '2017-01-01 00:00:00', NULL, 1, 1, 0, 0, 0),
(36, 39, 2, NULL, NULL, '2016-12-05 13:43:17', NULL, NULL, 1, 0, 0, 0, 0),
(37, 42, 1, NULL, NULL, '2016-12-05 14:08:10', '2016-12-05 14:22:38', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(38, 43, 1, NULL, NULL, '2016-12-05 14:28:58', '2016-12-05 14:27:55', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(39, 44, 1, NULL, NULL, '2016-12-05 14:31:07', '2016-12-05 14:30:16', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(40, 45, 1, NULL, NULL, '2016-12-05 14:35:07', '2016-12-05 14:34:03', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(41, 46, 1, NULL, NULL, '2016-12-05 15:21:29', '2016-12-05 15:20:25', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(42, 47, 2, NULL, NULL, '2016-12-06 10:04:03', NULL, NULL, 1, 0, 0, 0, 0),
(43, 48, 2, NULL, NULL, '2016-12-06 10:07:21', NULL, NULL, 1, 0, 0, 0, 0),
(44, 49, 2, NULL, NULL, '2016-12-06 10:11:15', NULL, NULL, 1, 0, 0, 0, 0),
(45, 50, 2, NULL, NULL, '2016-12-06 10:21:35', NULL, NULL, 1, 0, 0, 0, 0),
(46, 51, 2, NULL, NULL, '2016-12-06 11:13:44', NULL, NULL, 1, 0, 0, 0, 0),
(47, 52, 2, NULL, NULL, '2016-12-06 11:23:27', NULL, NULL, 1, 0, 0, 0, 0),
(48, 53, 2, NULL, NULL, '2016-12-06 11:26:04', NULL, NULL, 1, 0, 0, 0, 0),
(49, 54, 2, NULL, NULL, '2016-12-06 12:17:05', NULL, NULL, 1, 0, 0, 0, 0),
(50, 55, 2, NULL, NULL, '2016-12-06 12:19:33', NULL, NULL, 1, 0, 0, 0, 0),
(51, 56, 2, NULL, NULL, '2016-12-06 12:57:31', NULL, NULL, 1, 0, 0, 0, 0),
(52, 57, 2, NULL, NULL, '2016-12-06 12:59:49', NULL, NULL, 1, 0, 0, 0, 0),
(53, 58, 2, NULL, NULL, '2016-12-06 13:00:59', NULL, NULL, 1, 0, 0, 0, 0),
(54, 59, 2, NULL, NULL, '2016-12-06 13:03:22', NULL, NULL, 1, 0, 0, 0, 0),
(55, 60, 2, NULL, NULL, '2016-12-06 13:05:04', NULL, NULL, 1, 0, 0, 0, 0),
(56, 61, 2, NULL, NULL, '2016-12-06 13:06:10', NULL, NULL, 1, 0, 0, 0, 0),
(57, 62, 2, NULL, NULL, '2016-12-06 13:13:18', NULL, NULL, 1, 0, 0, 0, 0),
(58, 63, 2, NULL, NULL, '2016-12-06 13:17:25', NULL, NULL, 1, 0, 0, 0, 0),
(59, 64, 2, NULL, NULL, '2016-12-06 13:52:06', NULL, NULL, 1, 0, 0, 0, 0),
(60, 65, 2, NULL, NULL, '2016-12-06 16:06:31', NULL, NULL, 1, 0, 0, 0, 0),
(61, 66, 2, NULL, NULL, '2016-12-06 16:10:30', NULL, NULL, 1, 0, 0, 0, 0),
(62, 67, 2, NULL, NULL, '2016-12-07 12:13:54', NULL, NULL, 1, 0, 0, 0, 0),
(63, 68, 2, NULL, NULL, '2016-12-07 12:15:19', NULL, NULL, 1, 0, 0, 0, 0),
(64, 69, 2, NULL, NULL, '2016-12-07 13:05:35', NULL, NULL, 1, 0, 0, 0, 0),
(65, 70, 2, NULL, NULL, '2016-12-07 14:32:35', NULL, NULL, 1, 0, 0, 0, 0),
(66, 71, 2, NULL, NULL, '2016-12-07 15:38:56', NULL, NULL, 1, 0, 0, 0, 0),
(67, 72, 2, NULL, NULL, '2016-12-07 16:06:28', NULL, NULL, 1, 0, 0, 0, 0),
(68, 73, 1, NULL, NULL, '2016-12-12 12:37:05', NULL, NULL, 1, 1, 0, 0, 0),
(69, 74, 1, NULL, NULL, '2016-12-12 12:38:03', NULL, NULL, 1, 1, 0, 0, 0),
(70, 75, 1, NULL, NULL, '2016-12-12 12:48:04', NULL, NULL, 1, 1, 0, 0, 0),
(71, 76, 1, NULL, NULL, '2016-12-12 12:48:14', NULL, NULL, 1, 1, 0, 0, 0),
(72, 77, 1, NULL, NULL, '2016-12-12 12:49:31', NULL, NULL, 1, 1, 0, 0, 0),
(73, 78, 1, NULL, NULL, '2016-12-12 12:49:43', NULL, NULL, 1, 1, 0, 0, 0),
(74, 79, 1, NULL, NULL, '2016-12-12 12:49:50', NULL, NULL, 1, 1, 0, 0, 0),
(75, 80, 1, NULL, NULL, '2016-12-12 12:49:56', NULL, NULL, 1, 1, 0, 0, 0),
(76, 81, 1, NULL, NULL, '2016-12-12 12:50:02', '2016-12-12 12:48:46', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(77, 82, 1, NULL, NULL, '2016-12-12 12:50:14', NULL, NULL, 1, 1, 0, 0, 0),
(78, 83, 1, NULL, NULL, '2016-12-12 12:53:45', NULL, NULL, 1, 1, 0, 0, 0),
(79, 84, 1, NULL, NULL, '2016-12-12 12:56:34', NULL, NULL, 1, 1, 0, 0, 0),
(80, 85, 1, NULL, NULL, '2016-12-12 12:57:00', NULL, NULL, 1, 1, 0, 0, 0),
(81, 86, 1, NULL, NULL, '2016-12-12 12:57:06', NULL, NULL, 1, 1, 0, 0, 0),
(82, 87, 1, NULL, NULL, '2016-12-12 12:57:14', '2016-12-20 09:31:26', '2017-04-01 00:00:00', 3, 1, 0.032258064516129, 0, 0),
(83, 88, 1, NULL, NULL, '2016-12-12 13:33:54', NULL, NULL, 1, 1, 0, 0, 0),
(84, 89, 1, NULL, NULL, '2016-12-12 13:34:31', '2016-12-12 13:57:40', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(85, 90, 1, NULL, NULL, '2016-12-12 17:43:48', '2016-12-12 17:42:36', '2017-02-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(86, 91, 1, NULL, NULL, '2016-12-12 17:44:17', NULL, NULL, 1, 1, 0, 0, 0),
(87, 92, 2, NULL, NULL, '2016-12-22 12:12:27', NULL, NULL, 1, 0, 0, 0, 0),
(88, 93, 2, NULL, NULL, '2016-12-26 12:04:27', NULL, NULL, 1, 0, 0, 0, 0),
(89, 94, 2, NULL, NULL, '2016-12-26 12:08:13', NULL, NULL, 1, 0, 0, 0, 0),
(90, 95, 2, NULL, NULL, '2016-12-26 12:09:05', NULL, NULL, 1, 0, 0, 0, 0),
(91, 96, 2, NULL, NULL, '2016-12-26 12:10:01', NULL, NULL, 1, 0, 0, 0, 0),
(92, 97, 2, NULL, NULL, '2016-12-26 12:20:12', NULL, NULL, 1, 0, 0, 0, 0),
(93, 98, 2, NULL, NULL, '2016-12-26 12:22:31', NULL, NULL, 1, 0, 0, 0, 0),
(94, 99, 2, NULL, NULL, '2016-12-26 12:24:06', NULL, NULL, 1, 0, 0, 0, 0),
(95, 100, 2, NULL, NULL, '2016-12-27 10:40:03', NULL, NULL, 1, 0, 0, 0, 0),
(96, 104, 1, 41, NULL, '2016-12-28 11:56:42', '2017-02-01 00:00:00', '2017-03-01 00:00:00', 1, 1, 0, 0, 0),
(97, 105, 1, 40, NULL, '2016-12-28 11:59:35', '2017-02-01 00:00:00', '2017-03-01 00:00:00', 1, 1, 0, 0, 0),
(98, 106, 1, NULL, NULL, '2016-12-28 12:22:04', '2017-01-10 14:38:59', '2017-03-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(99, 107, 2, NULL, NULL, '2017-01-10 12:05:53', NULL, NULL, 1, 0, 0, 0, 0),
(100, 108, 1, NULL, NULL, '2017-01-10 14:45:53', NULL, NULL, 1, 1, 0, 0, 0),
(101, 109, 1, NULL, NULL, '2017-01-10 14:45:58', '2017-01-10 14:45:38', '2017-03-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(102, 110, 1, NULL, NULL, '2017-01-10 14:49:25', '2017-01-10 14:47:11', '2017-03-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(103, 111, 1, NULL, NULL, '2017-01-10 14:51:45', '2017-01-10 14:49:45', '2017-03-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(104, 112, 1, NULL, NULL, '2017-01-10 14:53:49', '2017-01-10 14:51:34', '2017-03-01 00:00:00', 1, 1, 0.032258064516129, 0, 0),
(105, 113, 1, NULL, NULL, '2017-01-10 14:54:56', '2017-01-10 14:52:41', '2017-03-01 00:00:00', 1, 1, 0.032258064516129, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_package`
--

CREATE TABLE `tcr_package` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shortDescription` longtext COLLATE utf8_unicode_ci,
  `detailedDescription` longtext COLLATE utf8_unicode_ci,
  `tags` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `categoryNames` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `availableFrom` datetime DEFAULT NULL,
  `availableTo` datetime DEFAULT NULL,
  `a_la_carte` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_package`
--

INSERT INTO `tcr_package` (`id`, `image_id`, `name`, `shortDescription`, `detailedDescription`, `tags`, `categoryNames`, `createdAt`, `updatedAt`, `deleted`, `status`, `availableFrom`, `availableTo`, `a_la_carte`) VALUES
(1, 101, 'Latino Simple', 'simple latino', '', 'latino,simple,a,aa,aaa,s,ss,sss,d,dd,ddd,f,ff,fff,g,gg,ggg,wertyuiopsdxcfvgbhnjkxcfgvbhjnkm,xctvbynuim,xrctvbynuimxcvbhynu,crvbnum,ctvbyhjnukm,cvbnu,cvbn,cvbhyn', 'Latino', '2016-04-07 12:01:34', '2016-11-28 14:28:28', 0, 1, '2015-01-01 00:00:00', '3008-10-03 00:00:00', 0),
(2, 60, 'Sport package', 'Sport and more....', '', 'sportPaket', 'Sport', '2016-04-07 12:13:42', '2016-07-05 11:59:27', 0, 1, '2016-04-07 02:00:00', '3000-12-31 01:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_package_category`
--

CREATE TABLE `tcr_package_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_package_category`
--

INSERT INTO `tcr_package_category` (`id`, `name`, `description`, `createdAt`, `updatedAt`, `deleted`) VALUES
(2, 'Latino', 'Latino category', '2016-04-07 11:15:32', NULL, 0),
(3, 'Sport', 'Sport category', '2016-04-07 11:15:58', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_package_country_price`
--

CREATE TABLE `tcr_package_country_price` (
  `id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_per_month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_per_three_months` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_per_six_months` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_per_twelve_months` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_package_country_price`
--

INSERT INTO `tcr_package_country_price` (`id`, `country`, `price_per_month`, `price_per_three_months`, `price_per_six_months`, `price_per_twelve_months`) VALUES
(7, 'Switzerland', '1', '1', '1', '1'),
(8, 'Other', '1', '1', '1', '1'),
(9, 'Switzerland', '0', '0', '0', '0'),
(10, 'Other', '0', '0', '0', '0'),
(11, 'Switzerland', '0', '0', '0', '0'),
(12, 'Other', '0', '0', '0', '0'),
(13, 'Switzerland', '5', '5', '5', '5'),
(14, 'Other', '5', '5', '5', '5'),
(15, 'Switzerland', '2', '2', '2', '2'),
(16, 'Other', '3', '3', '3', '3'),
(17, 'Switzerland', '0', '0', '0', '0'),
(18, 'Other', '0', '0', '0', '0'),
(19, 'Switzerland', '10', '9', '8', '7'),
(20, 'Other', '10', '9', '8', '7'),
(21, 'Switzerland', '5', '5', '5', '5'),
(22, 'Other', '5', '5', '5', '5'),
(23, 'Switzerland', '5', '5', '5', '5'),
(24, 'Other', '5', '5', '5', '5'),
(25, 'Switzerland', '1', '1', '1', '1'),
(26, 'Other', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_payment_account`
--

CREATE TABLE `tcr_payment_account` (
  `id` int(11) NOT NULL,
  `business_account` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `APIPassword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `APISignature` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `strip_public` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `strip_private` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tcr_payment_security_token`
--

CREATE TABLE `tcr_payment_security_token` (
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:object)',
  `after_url` longtext COLLATE utf8_unicode_ci,
  `target_url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gateway_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_payment_security_token`
--

INSERT INTO `tcr_payment_security_token` (`hash`, `details`, `after_url`, `target_url`, `gateway_name`) VALUES
('_2LYrgczxaG91XsuCv3qmfxIF4rmnohctKz7WUg7isQ', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:7;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=_2LYrgczxaG91XsuCv3qmfxIF4rmnohctKz7WUg7isQ', 'paypal_tcr'),
('12YjsIpkomRxVeLOlQ7reCh5RUJUGVVSzWRTwcffkok', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:9;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/en/profile/pay-Redirect?payum_token=12YjsIpkomRxVeLOlQ7reCh5RUJUGVVSzWRTwcffkok', 'paypal_tcr'),
('4wYkJeHiCxMEue6Qn-DStAvYHt-w_iYHVKnjO_dHqh0', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:11;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/payment/notify/4wYkJeHiCxMEue6Qn-DStAvYHt-w_iYHVKnjO_dHqh0', 'paypal_tcr'),
('936m2XCbNGbMVBbsGBTmVbMoNEFj_uksK17ZVgd1tDE', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:11;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=VwFkSP2uJVhT4kWwTIxQeIZJUD1foBxEYw6zt6WcSG8', 'http://tcr-media.fsd.rs:105/app_dev.php/payment/capture/936m2XCbNGbMVBbsGBTmVbMoNEFj_uksK17ZVgd1tDE', 'paypal_tcr'),
('dCbRQr_ZoD_5NjDTWyrPZeEIWdtfmi7haizmTM-3nNc', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:5;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/payment/notify/dCbRQr_ZoD_5NjDTWyrPZeEIWdtfmi7haizmTM-3nNc', 'paypal_tcr'),
('DDvDi6ecJeSZSXmZkDx6BZWYTtI39_q5Uae8EEKlEBY', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:7;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/payment/notify/DDvDi6ecJeSZSXmZkDx6BZWYTtI39_q5Uae8EEKlEBY', 'paypal_tcr'),
('eLeGeHULOfy5COWrsGGxMMwoICTWsbg7uDNfBxFn3DE', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:6;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/payment/notify/eLeGeHULOfy5COWrsGGxMMwoICTWsbg7uDNfBxFn3DE', 'paypal_tcr'),
('FBcLFf_uYSCHGg6Rw0IMEsv5OkfmnuJzTS68-TdCU84', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:7;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=_2LYrgczxaG91XsuCv3qmfxIF4rmnohctKz7WUg7isQ', 'http://tcr-media.fsd.rs:105/app_dev.php/payment/capture/FBcLFf_uYSCHGg6Rw0IMEsv5OkfmnuJzTS68-TdCU84', 'paypal_tcr'),
('G-cUezjyKs-Mr4hF7U2X46qoLVCkwoupdXjc6LMvWdQ', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:8;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=G-cUezjyKs-Mr4hF7U2X46qoLVCkwoupdXjc6LMvWdQ', 'paypal_tcr'),
('gp32X2N3NGgyIsQtS6CU5XRE0f3Oj2vmI0JGPIcaERA', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:6;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=rcN4uwRdD__sRToCd1vvTaDByia35tPvaIQ-SQ3Jmlc', 'http://tcr-media.fsd.rs:105/app_dev.php/payment/capture/gp32X2N3NGgyIsQtS6CU5XRE0f3Oj2vmI0JGPIcaERA', 'paypal_tcr'),
('hhYzDosYyZAw_ypOCnHpWZmKMjRxib4vl0Ziqs_LI7Y', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:8;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/payment/notify/hhYzDosYyZAw_ypOCnHpWZmKMjRxib4vl0Ziqs_LI7Y', 'paypal_tcr'),
('MhGaNe09lJtfTBP5DPzAr7O6b8bA41hsXG6ZsiJ2jGM', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:8;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=G-cUezjyKs-Mr4hF7U2X46qoLVCkwoupdXjc6LMvWdQ', 'http://tcr-media.fsd.rs:105/app_dev.php/payment/capture/MhGaNe09lJtfTBP5DPzAr7O6b8bA41hsXG6ZsiJ2jGM', 'paypal_tcr'),
('NFKW72W2A7o7Zm21Nl_Zx8eIOsAwRUR9hExLvM88KMw', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:10;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/en/profile/pay-Redirect?payum_token=suKWag1GtJnZmVXHDJdUaEIB73IUI2DnJ1uImSDpdr4', 'http://tcr-media.fsd.rs:105/payment/capture/NFKW72W2A7o7Zm21Nl_Zx8eIOsAwRUR9hExLvM88KMw', 'paypal_tcr'),
('NP1yVK7RMjl8NW5mY9sJvNsOIlD7uIh8q35rOFb6T2E', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:12;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'https://tcr-media.fsd.rs:105/app_dev.php/de/profile/pay-Redirect?payum_token=QNejXXPE083ehcHQNG8lRT2l8nbSm74Y-QMreJO88FM', 'https://tcr-media.fsd.rs:105/app_dev.php/payment/capture/NP1yVK7RMjl8NW5mY9sJvNsOIlD7uIh8q35rOFb6T2E', 'paypal_tcr'),
('QNejXXPE083ehcHQNG8lRT2l8nbSm74Y-QMreJO88FM', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:12;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'https://tcr-media.fsd.rs:105/app_dev.php/de/profile/pay-Redirect?payum_token=QNejXXPE083ehcHQNG8lRT2l8nbSm74Y-QMreJO88FM', 'paypal_tcr'),
('rcN4uwRdD__sRToCd1vvTaDByia35tPvaIQ-SQ3Jmlc', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:6;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=rcN4uwRdD__sRToCd1vvTaDByia35tPvaIQ-SQ3Jmlc', 'paypal_tcr'),
('RVAiqPUvnN9eZ9wbLXE9CKaE_GwXaRInlWUK3IMT1Kg', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:12;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'https://tcr-media.fsd.rs:105/app_dev.php/payment/notify/RVAiqPUvnN9eZ9wbLXE9CKaE_GwXaRInlWUK3IMT1Kg', 'paypal_tcr'),
('suKWag1GtJnZmVXHDJdUaEIB73IUI2DnJ1uImSDpdr4', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:10;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/en/profile/pay-Redirect?payum_token=suKWag1GtJnZmVXHDJdUaEIB73IUI2DnJ1uImSDpdr4', 'paypal_tcr'),
('tmkaSCF7cDYU4KDHj2xMJlmlZcA0YqBBtLEsuumWzHo', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:5;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/de/profile/pay-Redirect?payum_token=XifIqxK7LNWd9389bIqay6N97Wi8DrHeOXANk3pLQAI', 'http://tcr-media.fsd.rs:105/payment/capture/tmkaSCF7cDYU4KDHj2xMJlmlZcA0YqBBtLEsuumWzHo', 'paypal_tcr'),
('VwFkSP2uJVhT4kWwTIxQeIZJUD1foBxEYw6zt6WcSG8', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:11;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/app_dev.php/en/profile/pay-Redirect?payum_token=VwFkSP2uJVhT4kWwTIxQeIZJUD1foBxEYw6zt6WcSG8', 'paypal_tcr'),
('Wct7km7G2bMtHJ1w4p_CriiY6XD5EO23Yl52H32HuMQ', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:9;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', 'http://tcr-media.fsd.rs:105/en/profile/pay-Redirect?payum_token=12YjsIpkomRxVeLOlQ7reCh5RUJUGVVSzWRTwcffkok', 'http://tcr-media.fsd.rs:105/payment/capture/Wct7km7G2bMtHJ1w4p_CriiY6XD5EO23Yl52H32HuMQ', 'paypal_tcr'),
('XifIqxK7LNWd9389bIqay6N97Wi8DrHeOXANk3pLQAI', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:5;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/de/profile/pay-Redirect?payum_token=XifIqxK7LNWd9389bIqay6N97Wi8DrHeOXANk3pLQAI', 'paypal_tcr'),
('xurpb5urEjbvYG4NQXaYsntXIsIhpO8lvzX8lG7R80Y', 'C:25:"Payum\\Core\\Model\\Identity":63:{a:2:{i:0;i:9;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/payment/notify/xurpb5urEjbvYG4NQXaYsntXIsIhpO8lvzX8lG7R80Y', 'paypal_tcr'),
('z4RpE4CX7or1pTorm69pVJhF9quKUpiUrOzj0dIKm0U', 'C:25:"Payum\\Core\\Model\\Identity":64:{a:2:{i:0;i:10;i:1;s:37:"TCR\\OrderBundle\\Entity\\PaymentDetails";}}', NULL, 'http://tcr-media.fsd.rs:105/payment/notify/z4RpE4CX7or1pTorm69pVJhF9quKUpiUrOzj0dIKm0U', 'paypal_tcr');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_pay_pal_payment_details`
--

CREATE TABLE `tcr_pay_pal_payment_details` (
  `id` int(11) NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_pay_pal_payment_details`
--

INSERT INTO `tcr_pay_pal_payment_details` (`id`, `details`) VALUES
(5, '{"PAYMENTREQUEST_0_CURRENCYCODE":"CHF","PAYMENTREQUEST_0_AMT":"1000.00","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/capture\\/tmkaSCF7cDYU4KDHj2xMJlmlZcA0YqBBtLEsuumWzHo","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/capture\\/tmkaSCF7cDYU4KDHj2xMJlmlZcA0YqBBtLEsuumWzHo?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/notify\\/dCbRQr_ZoD_5NjDTWyrPZeEIWdtfmi7haizmTM-3nNc","TOKEN":"EC-019408413M484301F","TIMESTAMP":"2016-07-06T15:57:31Z","CORRELATIONID":"a2470e409d0f2","ACK":"Success","VERSION":"65.1","BUILD":"23255924","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"CHF","AMT":"1000.00","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/notify\\/dCbRQr_ZoD_5NjDTWyrPZeEIWdtfmi7haizmTM-3nNc","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(6, '{"PAYMENTREQUEST_0_CURRENCYCODE":"EUR","PAYMENTREQUEST_0_AMT":"6.00","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/gp32X2N3NGgyIsQtS6CU5XRE0f3Oj2vmI0JGPIcaERA","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/gp32X2N3NGgyIsQtS6CU5XRE0f3Oj2vmI0JGPIcaERA?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/eLeGeHULOfy5COWrsGGxMMwoICTWsbg7uDNfBxFn3DE","TOKEN":"EC-39S17518X35921723","TIMESTAMP":"2016-08-11T07:44:47Z","CORRELATIONID":"40c23bba70c1","ACK":"Success","VERSION":"65.1","BUILD":"24362847","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"EUR","AMT":"6.00","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/eLeGeHULOfy5COWrsGGxMMwoICTWsbg7uDNfBxFn3DE","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(7, '{"PAYMENTREQUEST_0_CURRENCYCODE":"EUR","PAYMENTREQUEST_0_AMT":"0.81","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/FBcLFf_uYSCHGg6Rw0IMEsv5OkfmnuJzTS68-TdCU84","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/FBcLFf_uYSCHGg6Rw0IMEsv5OkfmnuJzTS68-TdCU84?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/DDvDi6ecJeSZSXmZkDx6BZWYTtI39_q5Uae8EEKlEBY","TOKEN":"EC-12P07688G3187030J","TIMESTAMP":"2016-09-05T12:28:37Z","CORRELATIONID":"f46e58c4c1d93","ACK":"Success","VERSION":"65.1","BUILD":"24765677","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"EUR","AMT":"0.81","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/DDvDi6ecJeSZSXmZkDx6BZWYTtI39_q5Uae8EEKlEBY","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(8, '{"PAYMENTREQUEST_0_CURRENCYCODE":"EUR","PAYMENTREQUEST_0_AMT":"1.00","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/MhGaNe09lJtfTBP5DPzAr7O6b8bA41hsXG6ZsiJ2jGM","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/MhGaNe09lJtfTBP5DPzAr7O6b8bA41hsXG6ZsiJ2jGM?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/hhYzDosYyZAw_ypOCnHpWZmKMjRxib4vl0Ziqs_LI7Y","TOKEN":"EC-8AP749437A668312R","TIMESTAMP":"2016-09-08T06:30:29Z","CORRELATIONID":"676d1c03d5478","ACK":"Success","VERSION":"65.1","BUILD":"24765677","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"EUR","AMT":"1.00","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/hhYzDosYyZAw_ypOCnHpWZmKMjRxib4vl0Ziqs_LI7Y","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(9, '{"PAYMENTREQUEST_0_CURRENCYCODE":"EUR","PAYMENTREQUEST_0_AMT":"0.10","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/capture\\/Wct7km7G2bMtHJ1w4p_CriiY6XD5EO23Yl52H32HuMQ","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/capture\\/Wct7km7G2bMtHJ1w4p_CriiY6XD5EO23Yl52H32HuMQ?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/notify\\/xurpb5urEjbvYG4NQXaYsntXIsIhpO8lvzX8lG7R80Y","TOKEN":"EC-387338457X452871E","TIMESTAMP":"2016-09-09T08:12:53Z","CORRELATIONID":"ceb5a5aaa7c44","ACK":"Success","VERSION":"65.1","BUILD":"24765677","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"EUR","AMT":"0.10","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/notify\\/xurpb5urEjbvYG4NQXaYsntXIsIhpO8lvzX8lG7R80Y","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(10, '{"PAYMENTREQUEST_0_CURRENCYCODE":"EUR","PAYMENTREQUEST_0_AMT":"0.10","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/capture\\/NFKW72W2A7o7Zm21Nl_Zx8eIOsAwRUR9hExLvM88KMw","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/capture\\/NFKW72W2A7o7Zm21Nl_Zx8eIOsAwRUR9hExLvM88KMw?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/notify\\/z4RpE4CX7or1pTorm69pVJhF9quKUpiUrOzj0dIKm0U","TOKEN":"EC-4U092831A5510734B","TIMESTAMP":"2016-09-09T08:26:38Z","CORRELATIONID":"87d06e9fadec","ACK":"Success","VERSION":"65.1","BUILD":"24765677","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"EUR","AMT":"0.10","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/payment\\/notify\\/z4RpE4CX7or1pTorm69pVJhF9quKUpiUrOzj0dIKm0U","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(11, '{"PAYMENTREQUEST_0_CURRENCYCODE":"EUR","PAYMENTREQUEST_0_AMT":"1.00","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/936m2XCbNGbMVBbsGBTmVbMoNEFj_uksK17ZVgd1tDE","CANCELURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/936m2XCbNGbMVBbsGBTmVbMoNEFj_uksK17ZVgd1tDE?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/4wYkJeHiCxMEue6Qn-DStAvYHt-w_iYHVKnjO_dHqh0","TOKEN":"EC-89K46433BP904181M","TIMESTAMP":"2016-09-19T13:09:22Z","CORRELATIONID":"c489ebdf276a9","ACK":"Success","VERSION":"65.1","BUILD":"25037053","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"EUR","AMT":"1.00","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"http:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/4wYkJeHiCxMEue6Qn-DStAvYHt-w_iYHVKnjO_dHqh0","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}'),
(12, '{"PAYMENTREQUEST_0_CURRENCYCODE":"CHF","PAYMENTREQUEST_0_AMT":"10.00","PAYMENTREQUEST_0_PAYMENTACTION":"Sale","AUTHORIZE_TOKEN_USERACTION":"commit","RETURNURL":"https:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/NP1yVK7RMjl8NW5mY9sJvNsOIlD7uIh8q35rOFb6T2E","CANCELURL":"https:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/capture\\/NP1yVK7RMjl8NW5mY9sJvNsOIlD7uIh8q35rOFb6T2E?cancelled=1","PAYMENTREQUEST_0_NOTIFYURL":"https:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/RVAiqPUvnN9eZ9wbLXE9CKaE_GwXaRInlWUK3IMT1Kg","TOKEN":"EC-95G727546R991844G","TIMESTAMP":"2016-12-28T11:06:46Z","CORRELATIONID":"9382d7203499d","ACK":"Success","VERSION":"65.1","BUILD":"28258785","BILLINGAGREEMENTACCEPTEDSTATUS":"0","CHECKOUTSTATUS":"PaymentActionNotInitiated","CURRENCYCODE":"CHF","AMT":"10.00","SHIPPINGAMT":"0.00","HANDLINGAMT":"0.00","TAXAMT":"0.00","NOTIFYURL":"https:\\/\\/tcr-media.fsd.rs:105\\/app_dev.php\\/payment\\/notify\\/RVAiqPUvnN9eZ9wbLXE9CKaE_GwXaRInlWUK3IMT1Kg","INSURANCEAMT":"0.00","SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_SHIPPINGAMT":"0.00","PAYMENTREQUEST_0_HANDLINGAMT":"0.00","PAYMENTREQUEST_0_TAXAMT":"0.00","PAYMENTREQUEST_0_INSURANCEAMT":"0.00","PAYMENTREQUEST_0_SHIPDISCAMT":"0.00","PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED":"false","PAYMENTREQUESTINFO_0_ERRORCODE":"0"}');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_pdf`
--

CREATE TABLE `tcr_pdf` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_pdf`
--

INSERT INTO `tcr_pdf` (`id`, `name`) VALUES
(1, '20160226_AGB_CR_(Schweiz)_V_1.3.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_settings`
--

CREATE TABLE `tcr_settings` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `confirmationEmail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `easycall` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eur_to_chf_conversion_rate` double NOT NULL,
  `chf_to_eur_conversion_rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_settings`
--

INSERT INTO `tcr_settings` (`id`, `image_id`, `confirmationEmail`, `language`, `paypal`, `easycall`, `facebook`, `twitter`, `googleplus`, `eur_to_chf_conversion_rate`, `chf_to_eur_conversion_rate`) VALUES
(1, 70, 'test@fsd.rs', 'en', '1', '1', '1', '1', '1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcr_stream_fee`
--

CREATE TABLE `tcr_stream_fee` (
  `id` int(11) NOT NULL,
  `settings_id` int(11) DEFAULT NULL,
  `pricePerMonth` double NOT NULL,
  `pricePerThreeMonths` double NOT NULL,
  `pricePerSixMonths` double NOT NULL,
  `pricePerTwelveMonths` double NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_stream_fee`
--

INSERT INTO `tcr_stream_fee` (`id`, `settings_id`, `pricePerMonth`, `pricePerThreeMonths`, `pricePerSixMonths`, `pricePerTwelveMonths`, `country`) VALUES
(1, 1, 1, 1, 1, 1, 'Switzerland'),
(2, 1, 1, 1, 1, 1, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_transaction`
--

CREATE TABLE `tcr_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_transaction`
--

INSERT INTO `tcr_transaction` (`id`, `user_id`, `payment_method`, `created_at`, `currency`, `balance`, `status`, `description`, `transaction_id`) VALUES
(1, 1, 'CRPREPAID', '2016-08-16 10:03:06', 'EUR', 0.1, '', '', ''),
(2, 1, 'CRPREPAID', '2016-08-16 10:11:24', 'EUR', 0.1, '', '', ''),
(3, 1, 'CRPREPAID', '2016-08-16 10:56:14', 'EUR', 0.9203, '', '', ''),
(4, 1, 'CRPREPAID', '2016-08-16 11:16:25', 'EUR', 1, '', '', ''),
(5, 1, 'SOFORT', '2016-08-17 14:07:11', 'EUR', 1, '', '', ''),
(6, 1, 'SOFORT', '2016-08-17 14:07:12', 'EUR', 1, '', '', ''),
(7, 1, 'SOFORT', '2016-08-17 14:08:23', 'EUR', 5.88, '', '', ''),
(8, 1, 'SOFORT', '2016-08-17 14:08:23', 'EUR', 5.88, '', '', ''),
(9, 1, 'SOFORT', '2016-08-17 14:29:57', 'EUR', 2, '', '', ''),
(10, 1, 'SOFORT', '2016-08-17 14:31:26', 'EUR', 0.12, '', '', ''),
(11, 1, 'SOFORT', '2016-08-17 15:36:00', 'EUR', 2, '', '', ''),
(12, 1, 'SWISSCOM EASYPAY', '2016-09-01 14:13:03', 'EUR', 0.18216, '', '', ''),
(13, 1, 'SWISSCOM EASYPAY', '2016-09-01 14:13:09', 'EUR', 0.18216, '', '', ''),
(14, 1, 'SWISSCOM EASYPAY', '2016-09-01 14:13:29', 'EUR', 0.1822, '', '', ''),
(15, 1, 'SWISSCOM EASYPAY', '2016-09-01 14:14:43', 'EUR', 0.18218, '', '', ''),
(16, 1, 'SWISSCOM EASYPAY', '2016-09-01 14:38:35', 'EUR', 0.18214, '', '', ''),
(17, 1, 'SWISSCOM EASYPAY', '2016-09-01 15:16:55', 'EUR', 0.1822, '', '', ''),
(18, 1, 'SOFORT', '2016-09-05 14:13:48', 'EUR', 1, '', '', ''),
(19, 1, 'CRPREPAID', '2016-09-05 14:28:59', 'EUR', 0.81, '', '', ''),
(20, 1, 'CRPREPAID', '2016-09-05 14:29:19', 'EUR', 0.9146, '', '', ''),
(21, 1, 'SWISSCOM EASYPAY', '2016-09-05 14:34:43', 'EUR', 0.9146, '', '', ''),
(22, 3, 'SOFORT', '2016-09-05 15:46:52', 'EUR', 1, '', '', ''),
(23, 1, 'SOFORT', '2016-09-08 08:31:15', 'EUR', 1, '', '', ''),
(24, 1, 'CRPREPAID', '2016-09-08 08:32:30', 'EUR', 0.917, '', '', ''),
(25, 1, 'CRPREPAID', '2016-09-08 08:32:51', 'EUR', 1, '', '', ''),
(26, 3, 'SWISSCOM EASYPAY', '2016-09-09 14:03:52', 'EUR', 0.09118, '', '', ''),
(27, 1, 'CRPREPAID', '2016-09-09 17:07:28', 'EUR', 0.09129, '', '', ''),
(28, 1, 'CRPREPAID', '2016-09-09 17:11:18', 'EUR', 0.0913, '', '', ''),
(29, 3, 'CRPREPAID', '2016-09-09 17:12:39', 'EUR', 0.1, '', '', ''),
(30, 3, 'CRPREPAID', '2016-09-09 17:14:22', 'EUR', 0.1826, '', '', ''),
(31, 3, 'SOFORT', '2016-09-14 15:28:29', 'EUR', 1, '', '', ''),
(32, 3, 'SOFORT', '2016-09-14 15:29:40', 'EUR', 1, '', '', ''),
(33, 1, 'CRPREPAID', '2016-09-19 14:14:23', 'EUR', 20, 'error', 'this pin 25362127344 has not enougth credit', 'n/a'),
(34, 1, 'SOFORT', '2016-09-19 15:22:27', 'EUR', 1, 'success', '', 'n/a'),
(36, 1, 'SOFORT', '2016-09-20 09:43:23', 'EUR', 1, 'success', '', 'n/a'),
(37, 1, 'SOFORT', '2016-09-20 09:43:58', 'EUR', 1, 'error', 'cancel', '103382-297316-57E0E87C-AC3C'),
(38, 4, 'SOFORT', '2016-10-10 08:23:41', 'CHF', 1, 'success', '', 'n/a'),
(39, 4, 'CRPREPAID', '2016-10-10 08:32:13', 'CHF', 0.1, 'success', '', 'n/a'),
(40, 4, 'CRPREPAID', '2016-10-10 08:32:28', 'CHF', 40, 'error', 'this pin 25362127344 has not enougth credit', 'n/a'),
(41, 4, 'EASYCALL', '2016-10-10 08:35:33', 'CHF', 0.1, 'error', '99', 'n/a'),
(42, 1, 'EASYCALL', '2016-11-01 10:02:25', 'EUR', 1, 'error', '2', 'n/a'),
(43, 1, 'EASYCALL', '2016-11-01 10:26:58', 'EUR', 1, 'error', '2', 'n/a'),
(44, 1, 'CRPREPAID', '2016-11-01 10:27:11', 'EUR', 1, 'error', 'this pin 123 is not valid', 'n/a'),
(45, 5, 'PROMOCODE', '2016-11-18 10:22:16', 'EUR', 5, 'success', '', 'n/a'),
(46, 1, 'SOFORT', '2016-11-24 13:51:22', 'EUR', 1, 'error', 'cancel', '103382-297316-5836E1FC-8A78'),
(47, 1, 'SOFORT', '2016-11-24 13:52:17', 'EUR', 1, 'error', 'cancel', '103382-297316-5836E220-D631'),
(48, 1, 'SOFORT', '2016-11-24 14:06:47', 'EUR', 1, 'success', '', 'n/a'),
(49, 1, 'SOFORT', '2016-11-24 14:49:33', 'EUR', 1, 'error', 'cancel', '103382-297316-5836EF94-4171'),
(50, 86, 'PROMOCODE', '2016-12-26 12:08:12', 'EUR', 5, 'success', '', 'n/a'),
(51, 91, 'PROMOCODE', '2016-12-26 12:24:05', 'EUR', 5, 'success', '', 'n/a'),
(52, 92, 'PROMOCODE', '2016-12-27 10:39:57', 'EUR', 5, 'success', '', 'n/a'),
(53, 4, 'EASYCALL', '2016-12-28 12:08:11', 'CHF', 10, 'error', '2', 'n/a'),
(54, 4, 'CRPREPAID', '2016-12-28 12:08:23', 'CHF', 10, 'error', 'this pin 1232312 is not valid', 'n/a'),
(55, 2, 'ADMIN', '2017-01-17 11:44:31', 'EUR', 9, 'success', '', 'n/a');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_user`
--

CREATE TABLE `tcr_user` (
  `id` int(11) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthDate` datetime DEFAULT NULL,
  `text_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_balance` double NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `connectDateTo` datetime DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `base_image_url` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_user`
--

INSERT INTO `tcr_user` (`id`, `avatar_id`, `agent_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `name`, `surname`, `birthDate`, `text_password`, `language`, `address`, `phoneNumber`, `country`, `account_balance`, `title`, `zip`, `comment`, `connectDateTo`, `createdAt`, `company`, `base_image_url`) VALUES
(1, 171, 108, 'pavle.losic@fsd.rs', 'pavle.losic@fsd.rs', 'pavle.losic@fsd.rs', 'pavle.losic@fsd.rs', 1, '38ouepkxvlogswwogsww404gcsso0w0', '$2y$13$38ouepkxvlogswwogsww4uYyTKr6L/NdRzypbpDh42pWdlN0jrr/q', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'Pavle', 'Losic', '1994-06-14 00:00:00', '', 'en', 'Belgrade, Lipar 20', '+381 64 251 26 50', 'Andorra', 488.58064516128, 'MR', '11001', 'test komentar', '2017-06-01 00:00:00', '2016-07-15 14:41:29', 'FSD', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(2, 206, 51, 'losicpavle@yahoo.com', 'losicpavle@yahoo.com', 'losicpavle@yahoo.com', 'losicpavle@yahoo.com', 1, 'no6ojmgaauos808scggk0cggc800cko', '$2y$13$no6ojmgaauos808scggk0OonrHZhPH88x3rpWDmQPlNoBj.gtP5YC', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'Pavle', 'Losic', '1994-06-14 00:00:00', '', 'en', 'Belgrade, Lipar 20', '+381 64 251 2650', 'Serbia', 509, 'MR', '11030', 'koment', NULL, '2016-08-12 14:37:58', 'FSD', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(3, NULL, NULL, 'test@fsd.rs', 'test@fsd.rs', 'test@fsd.rs', 'test@fsd.rs', 1, 'k9c5eaye728ws48g0sgs0co8s0sko0k', '$2y$13$k9c5eaye728ws48g0sgs0OkRKkbeljXUcRojEoyVNMyytM1GIlB9.', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'test@fsd.rs', 'test@fsd.rs', '1990-02-06 00:00:00', '', 'en', 'Belgrade, Lipar 20', '', 'Andorra', 494.22580645161, 'MR', '', NULL, '2017-02-01 00:00:00', '2016-09-05 15:44:36', '', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(4, NULL, 1, 'tester.chf@fsd.rs', 'tester.chf@fsd.rs', 'tester.chf@fsd.rs', 'tester.chf@fsd.rs', 1, 'q5mld7xg5eswggw8cs4cwcwsw0okgcw', '$2y$13$q5mld7xg5eswggw8cs4cwO.5sJ3xgo.MkpIcDbeWfEvVS7qSINkxK', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, 'tester.chf', 'tester.chf', '1994-06-01 00:00:00', '', 'en', 'Belgrade, Lipar 20', '', 'Switzerland', 500, 'MR', '', '', '2017-02-01 00:00:00', '2016-09-19 16:00:27', '', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(5, NULL, 1, 'tester.tester@fsd.tcr.es.de', 'tester.tester@fsd.tcr.es.de', 'tester.tester@fsd.tcr.es.de', 'tester.tester@fsd.tcr.es.de', 1, 't5zwmnquoiogo80k4g48owsckw0o4g0', '$2y$13$t5zwmnquoiogo80k4g48ou1n2VxyfxzSkscCIgMulMfJTcW6EUWJq', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'tester.tester@fsd.tcr.es.de', 'tester.tester@fsd.tcr.es.de', '1994-06-14 00:00:00', '', 'en', 'Belgrade, Lipar 20', '123', 'Bulgaria', 500, 'MR', '123', '1', NULL, '2016-11-18 10:22:17', '123', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(24, NULL, NULL, 'nkm790021@gmail.com', 'nkm790021@gmail.com', 'nkm790021@gmail.com', 'nkm790021@gmail.com', 1, 'erbas3z5j8080g8wwc4cwo0okwccsgg', '$2y$13$erbas3z5j8080g8wwc4cweLgEm8NYedAL4G6j6nburYzniVfGqp0G', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Nensi', 'Markovici', '1991-05-05 00:00:00', '', 'en', 'Belgrade, 12', '+381643679905', 'Serbia', 500, 'MR', '31210', 'dfdsf', NULL, '2016-12-05 13:43:16', 'FSD', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(25, NULL, NULL, '9999@999', '9999@999', '9999@999', '9999@999', 1, 'td6n1m4rcessswgogkcsg844wkg8w0g', '$2y$13$td6n1m4rcessswgogkcsguBJXiYRnS1.6bakI7CZj5rZxLWOs1Bga', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Devet', 'Devet', '1996-12-04 00:00:00', '', 'en', 'DevetGrad, Ulica 99', '+381 61 542 3999', 'Belgium', 0, 'MR', '8888', NULL, NULL, '2016-12-06 10:03:59', 'Devet Company 9999999', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(27, NULL, NULL, '9999@99922.com', '9999@99922.com', '9999@99922.com', '9999@99922.com', 1, 'kefkb0gkmzkk408kkk0s008cg4gokkc', '$2y$13$kefkb0gkmzkk408kkk0s0unF3jFex7GFocA/sIyyfvda77o5EZJaG', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Name99922', 'FaName22', '1996-12-06 00:00:00', '', 'fr', 'City99, 99999', '+381 61 542 4447', 'Belgium', 0, 'MR', '99999', 'Comment 9999', NULL, '2016-12-06 10:07:21', 'Company 9999999', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(28, NULL, NULL, '29999@99922.com', '29999@99922.com', '29999@99922.com', '29999@99922.com', 1, 'ep5ll7i9h7w4wkccc4skscggs44osks', '$2y$13$ep5ll7i9h7w4wkccc4sksOLgIaUzXQatdN4sI65jGDkutu78f2OU2', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Name99922', 'FaName22', '1996-12-06 00:00:00', '', 'fr', 'City99, 99999', '+381 61 542 4447', 'Belgium', 0, 'MR', '99999', 'Comment 9999', NULL, '2016-12-06 10:11:14', 'Company 9999999', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(29, NULL, NULL, 'email@mail', 'email@mail', 'email@mail', 'email@mail', 1, 'sjucpifyboggw4ccw0ss48ogcc0s8o4', '$2y$13$sjucpifyboggw4ccw0ss4uCmKS0RLOk4dkKyT9LPBNx1vxzcA8JdW', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Name333', 'FaName333', '1996-12-01 00:00:00', '', 'fr', 'TriTri, Ulica 333', '+381 25 555 5555', 'Austria', 0, 'MRS', '11300', NULL, NULL, '2016-12-06 10:21:34', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(30, NULL, NULL, 'last@user', 'last@user', 'last@user', 'last@user', 1, 'au5lbepa5egcw8oogk88g4wo8wcc4g4', '$2y$13$au5lbepa5egcw8oogk88guViQ492z5KXoHFmhjqKsO7sZliOr1euO', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Last', 'User', '1997-12-04 00:00:00', '', 'en', ', ', '+381 65 555 55 55', 'Andorra', 0, 'MR', '', '', NULL, '2016-12-06 11:13:43', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(31, NULL, NULL, 'asdasd@asdasd', 'asdasd@asdasd', 'asdasd@asdasd', 'asdasd@asdasd', 1, 'amz5h1hsow000sks0gkkwosggwggkgs', '$2y$13$amz5h1hsow000sks0gkkweHhsEqH4p3EJIG/s7z1IUS/8s/5LZrNO', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'asdasd', 'asdasd', '1997-12-12 00:00:00', '', 'en', 'null, null', '+381555555555', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 11:23:26', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(32, NULL, NULL, 'asdasd@asdasdasdasd', 'asdasd@asdasdasdasd', 'asdasd@asdasdasdasd', 'asdasd@asdasdasdasd', 1, '9uaj8al2csg0k8osc44kc8kggww8ggw', '$2y$13$9uaj8al2csg0k8osc44kcuy85vCTW0xsaihEKtscv8APDokkhLtVi', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'asdasdasdasdasdasd', 'asdasdasdasdasdas', '1996-12-19 00:00:00', '', 'de', 'null, null', '+366666666666', 'Austria', 0, 'MRS', NULL, NULL, NULL, '2016-12-06 11:26:04', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(33, 208, NULL, 'poiuytr@poiuytr', 'poiuytr@poiuytr', 'poiuytr@poiuytr', 'poiuytr@poiuytr', 1, 'exm45niwhb4ko0go8g4cckosc0wsk40', '$2y$13$exm45niwhb4ko0go8g4cceLFlKf.5SXyy9ZSpY9een4doBHEhJ3Xi', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'poiuytr', 'poiuytr', '1996-12-13 00:00:00', '', 'de', 'null, null', '+33333333333333', 'Austria', 0, 'MRS', NULL, NULL, NULL, '2016-12-06 12:17:05', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(34, 175, NULL, 'poiuytr@poiuytrtr', 'poiuytr@poiuytrtr', 'poiuytr@poiuytrtr', 'poiuytr@poiuytrtr', 1, 'kh8fqdhn1u88oc8w0k08kk48wwwwswo', '$2y$13$kh8fqdhn1u88oc8w0k08ke3kTRx9PtuR67fVyj9JfLHMlWbNR0Lwi', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'poiuytrtr', 'poiuytrtr', '1996-12-13 00:00:00', '', 'de', 'null, null', '+33333333333333', 'Austria', 0, 'MRS', NULL, NULL, NULL, '2016-12-06 12:19:33', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(35, NULL, NULL, 'dfjkghji@dfjkghji', 'dfjkghji@dfjkghji', 'dfjkghji@dfjkghji', 'dfjkghji@dfjkghji', 1, '8d2aeoh4bbc4wo8s00kck84kkogwwog', '$2y$13$8d2aeoh4bbc4wo8s00kckuKP3HPFImd35epfPTyt66tC.pCwFfjgG', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'dfjkghji', 'dfjkghji', '1996-12-13 00:00:00', '', 'en', 'null, null', '+65655666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 12:57:31', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(38, NULL, NULL, 'dfjkghji@dfjkghjias', 'dfjkghji@dfjkghjias', 'dfjkghji@dfjkghjias', 'dfjkghji@dfjkghjias', 1, 'cq4fx6yxwpsgoswwwsk0s48w4okgks8', '$2y$13$cq4fx6yxwpsgoswwwsk0suhkMvEBICtUJWRLoik3vBDjsWX.yzoRK', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'dfjkghjias', 'dfjkghjias', '1996-12-13 00:00:00', '', 'en', 'null, null', '+65655666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 12:59:49', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(39, NULL, NULL, 'dfjkghji@dfjkghjiasdd', 'dfjkghji@dfjkghjiasdd', 'dfjkghji@dfjkghjiasdd', 'dfjkghji@dfjkghjiasdd', 1, '4kwntod1xqucgcwkcg8w4skwg4cc4wk', '$2y$13$4kwntod1xqucgcwkcg8w4e7nMxKY9msjz9txIPbBatNRotuVuqqzK', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'dfjkghjiasdd', 'dfjkghjiasdd', '1996-12-13 00:00:00', '', 'en', 'null, null', '+65655666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 13:00:59', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(40, NULL, NULL, 'dfjkghji@dfjkghjiasddrr', 'dfjkghji@dfjkghjiasddrr', 'dfjkghji@dfjkghjiasddrr', 'dfjkghji@dfjkghjiasddrr', 1, '8auvuqalh2g4800gkc0oggwwcggw4kc', '$2y$13$8auvuqalh2g4800gkc0ogeWN/ygGaWePhF1ry5dpsJjszGbWkbqbu', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'dfjkghjiasddrr', 'dfjkghjiasddrr', '1996-12-13 00:00:00', '', 'en', 'null, null', '+65655666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 13:03:22', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(41, NULL, NULL, 'dfjkghji@dfjkghjiasddrrff', 'dfjkghji@dfjkghjiasddrrff', 'dfjkghji@dfjkghjiasddrrff', 'dfjkghji@dfjkghjiasddrrff', 1, '9n83xmhky7ksosw8w4k4sogkkoo0ssk', '$2y$13$9n83xmhky7ksosw8w4k4seujCpwtqD1JweFcbDeS.M6BZX8rRupQW', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'dfjkghjiasddrrff', 'dfjkghjiasddrrff', '1996-12-13 00:00:00', '', 'en', 'null, null', '+65655666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 13:05:04', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(42, NULL, 108, 'dfjkghji@dfjkghjiasddrrffrr', 'dfjkghji@dfjkghjiasddrrffrr', 'dfjkghji@dfjkghjiasddrrffrr', 'dfjkghji@dfjkghjiasddrrffrr', 0, '7b1xnmmiaoowckos0owsw84oo88kwgg', '$2y$13$7b1xnmmiaoowckos0owswuSQubm6ou5Qlmvg7R9dpNGwXnrhfR4fW', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'dfjkghjiasddrrffrr', 'dfjkghjiasddrrffrr', '1996-12-13 00:00:00', '', 'en', 'null, null', '+65655666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 13:06:10', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(43, NULL, NULL, 'customers@customers', 'customers@customers', 'customers@customers', 'customers@customers', 1, 'b8q7btiznvcckw0og8gcc4cc4gckowo', '$2y$13$b8q7btiznvcckw0og8gccuYejpj.8hgDT9xC6KGgreWwVPBIhrli2', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'customers', 'customers', '1996-12-13 00:00:00', '', 'de', 'null, null', '+666666666666666666', 'Austria', 0, 'MRS', NULL, '', NULL, '2016-12-06 13:13:17', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(44, NULL, NULL, 'Ember2@Ember2', 'ember2@ember2', 'Ember2@Ember2', 'ember2@ember2', 1, '62sodf9387wgk80c4ksc0c0sokk4wc4', '$2y$13$62sodf9387wgk80c4ksc0OoDWKZ/U2RPvMvQzNnOQINEXwHz9JbzW', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Ember2', 'Ember2', '1996-12-13 00:00:00', '', 'de', 'null, null', '+366666666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-06 13:17:25', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(45, 187, 49, 'symfony@mail.com', 'symfony@mail.com', 'symfony@mail.com', 'symfony@mail.com', 1, '6rsnrx9abukgc88ckgk8kgg8o0wg48w', '$2y$13$6rsnrx9abukgc88ckgk8kezIXAyXzFBeH7lGypcE0EgssEVsIT5zG', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Symfony2.0', 'Symfony', '1986-12-11 00:00:00', '', 'en', 'Belgrade, 2.9', '+381 64 555 5555', 'Serbia', 0, 'MR', '11000', NULL, NULL, '2016-12-06 13:52:06', 'SymfonyEnterprise', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(46, 191, 49, '666@6', '666@6', '666@6', '666@6', 1, 'ega2vf00ydk4kggw8o00cg0gwwogg8g', '$2y$13$ega2vf00ydk4kggw8o00ceX1EdT2YV8okk7kInTRQQ.vh.wC.7BtS', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, '6', '6', '1987-12-04 00:00:00', '', 'fr', '33, 3333', '+65333333333', 'Belgium', 0, 'MR', '3333', NULL, NULL, '2016-12-06 16:06:31', '333', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(47, 192, 29, '5555@2', '5555@2', '5555@2', '5555@2', 1, '7osjvnsgvf8cgsw0gcs4kks8o4sggsc', '$2y$13$7osjvnsgvf8cgsw0gcs4keMmWbBEiiV0NsyyradaWmtU2Qc01tpSK', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, '5', '5', '1996-12-07 00:00:00', '', 'en', 'null, null', '+65655666666', 'Andorra', 0, 'MR', NULL, NULL, NULL, '2016-12-06 16:10:30', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(48, 193, NULL, 'asdddddddddd@fsdddd.ddddd', 'asdddddddddd@fsdddd.ddddd', 'asdddddddddd@fsdddd.ddddd', 'asdddddddddd@fsdddd.ddddd', 1, '4nmjffjcaa04k08kso0okcw4wkks0ww', '$2y$13$4nmjffjcaa04k08kso0okOW6HenjrWftmIIdjS7FAzC5fRaNpVEGC', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'asdddddddddd@fsdddd.ddddd', 'asdddddddddd@fsdddd.ddddd', '1990-07-04 00:00:00', '', 'en', 'Belgrad,s 213', '', 'Greece', 0, 'MR', 'a1312', '', NULL, '2016-12-07 12:13:53', '', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(49, 194, NULL, 'avatar@avatar', 'avatar@avatar', 'avatar@avatar', 'avatar@avatar', 1, 'hucp64qwr280sooosgowkkk4sgw8ssw', '$2y$13$hucp64qwr280sooosgowkejFXcRUC26zhqIMDmlqUy9kC0bzUPNS.', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'avatar', 'avatar', '1997-12-04 00:00:00', '', 'en', 'null, null', '+366666666666', 'Andorra', 0, 'MR', NULL, NULL, NULL, '2016-12-07 12:15:19', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(50, NULL, NULL, 'filePath@filePath', 'filepath@filepath', 'filePath@filePath', 'filepath@filepath', 1, 'bpl02e3i9vs4gw04wkco0k040oco0gw', '$2y$13$bpl02e3i9vs4gw04wkco0ett8DGY5/VVvc0LbEh8sqdutyElf.edK', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'filePath', 'filePath', '1996-12-13 00:00:00', '', 'de', 'null, null', '+381 61 542 3999', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-07 13:05:35', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(76, NULL, NULL, 'asdasd@asd', 'asdasd@asd', 'asdasd@asd', 'asdasd@asd', 1, 'argrzoju8ygc4844g4o8k8sg4scw4wc', '$2y$13$argrzoju8ygc4844g4o8kubvesvjW4mpjetZFv4dJwowpGqespY8.', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Name99922', 'Name99922', '1996-12-13 00:00:00', '', 'en', 'null, null', '+381 61 542 3999', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-07 14:32:35', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(80, 212, NULL, 'email@mai', 'email@mai', 'email@mai', 'email@mai', 1, '6pb2p9hhcug448o44w8g8wc444gc4kg', '$2y$13$6pb2p9hhcug448o44w8g8ucOttsqs90tBxux2Q5jXDYvhJakbaQ5S', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'email@maill', 'email@maillllll', '1996-12-06 00:00:00', '', 'de', 'null, null', '+366666666666', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-07 15:38:55', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(82, NULL, NULL, 'email@maila', 'email@maila', 'email@maila', 'email@maila', 1, '467cmb6130isw0wcc8sckk08kwsc404', '$2y$13$467cmb6130isw0wcc8sckemBWGwW0anhwAWw1L9wCB1hG/h8E9EC2', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'email@mail', 'email@mail', '1996-12-06 00:00:00', '', 'en', 'null, null', '+381 61 542 3993', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-07 16:06:28', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(83, NULL, NULL, '12345@12345.12345', '12345@12345.12345', '12345@12345.12345', '12345@12345.12345', 1, 'se9cam4ton40k0gssowwcg4o0kg8w88', '$2y$13$se9cam4ton40k0gssowwceRzWaPmghFDdSXyaHPo7Q4pa.i6z7ahi', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, '123', '123', '1996-12-12 00:00:00', '', 'en', 'null, null', '+381 261265088', 'Belgium', 0, 'MR', NULL, '', NULL, '2016-12-22 12:12:26', '123', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(84, NULL, NULL, 'testiram@tcr-fsd.rs', 'testiram@tcr-fsd.rs', 'testiram@tcr-fsd.rs', 'testiram@tcr-fsd.rs', 1, '9msu6jpjp98g4gcgkcwc080s04o0wg0', '$2y$13$9msu6jpjp98g4gcgkcwc0uXgjYP.kwdXjc47tcgWl7xxcYkE8PPSy', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'testiram@tcr-fsd.rs', 'testiram@tcr-fsd.rs', '1991-12-06 00:00:00', 'testiram@tcr-fsd.rs', 'en', 'testiram@tcr-fsd.rs, null', '+381 261265088', 'Andorra', 0, 'MR', NULL, '', NULL, '2016-12-22 12:14:02', '21323', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(85, NULL, NULL, 'test@test', 'test@test', 'test@test', 'test@test', 1, 'gm9pbtnu4740gw8gs0804oc88oo40cc', '$2y$13$gm9pbtnu4740gw8gs0804e1OnhP0PCL.X1nL0ipMm9Yr798Lw3KBa', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'test2', 'test2', '1996-12-06 00:00:00', '', 'en', 'null, null', '+381 64 555 5555', 'Andorra', 0, 'MR', NULL, NULL, NULL, '2016-12-26 12:04:25', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(86, NULL, 1, 'testiranjeeeeee@testiranjeeeeee.com', 'testiranjeeeeee@testiranjeeeeee.com', 'testiranjeeeeee@testiranjeeeeee.com', 'testiranjeeeeee@testiranjeeeeee.com', 1, 'py2kvsuiodwc4g080skwogs4g4ccg08', '$2y$13$py2kvsuiodwc4g080skwoe47lXgbN8jjAOb86NJXmzTWmxy9B6r1G', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'testiranjeeeeee@testiranjeeeeee.com', 'testiranjeeeeee@testiranjeeeeee.com', '1991-02-04 00:00:00', '', 'en', 'Bgd,10', '+387642512650', 'Germany', 5, 'MR', '11100', '', NULL, '2015-08-12 12:08:12', '', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(87, NULL, NULL, 'testing@testing', 'testing@testing', 'testing@testing', 'testing@testing', 1, 't54slgctnnk084kok0o04o0gssoowkw', '$2y$13$t54slgctnnk084kok0o04eRqijx7XvJinb.iixezMrZHXOcEmrEF.', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'testing', 'testing', '1996-12-06 00:00:00', '', 'en', 'null, null', '+2222222222222', 'Andorra', 0, 'MR', NULL, NULL, NULL, '2016-12-26 12:09:04', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(88, NULL, NULL, 'poewrl@pole.com', 'poewrl@pole.com', 'poewrl@pole.com', 'poewrl@pole.com', 1, 'cgem9e7hwpc8c0ck8wggsc0c44gcksc', '$2y$13$cgem9e7hwpc8c0ck8wggsOLH3qETWS.q45OdMXQNJfiQ/nM2KjLWW', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'poewrl@pole.com', 'poewrl@pole.com', '1997-12-12 00:00:00', '', 'en', 'null, ', '+381 61 542 3999', 'Andorra', 0, 'MR', NULL, NULL, NULL, '2016-12-26 12:10:01', '', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(89, NULL, 51, 'testAgent@testAgent', 'testagent@testagent', 'testAgent@testAgent', 'testagent@testagent', 1, '3x8zaindwk8w8cg40k480400occwcg4', '$2y$13$3x8zaindwk8w8cg40k480u9QMFAqrqG5scDsDa4fFVvXSeRdHQe42', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'testAgent@testAgent', 'testAgent@testAgent', '1997-12-12 00:00:00', '', 'en', ', null', '+381 61 542 3999', 'Austria', 0, 'MR', NULL, NULL, NULL, '2016-12-26 12:20:11', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(90, NULL, 1, 'af@asdjf', 'af@asdjf', 'af@asdjf', 'af@asdjf', 1, 'nxfrxyfi9u8c0cog8c8o4goow8c84kw', '$2y$13$nxfrxyfi9u8c0cog8c8o4eaMoT46.mxyirKW6kI5LvwU.DHgOneo6', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'af@asdjf', 'af@asdjf', '1996-12-06 00:00:00', '', 'en', 'null, null', '+65655666666', 'Andorra', 0, 'MR', NULL, NULL, NULL, '2016-12-26 12:22:30', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(91, NULL, NULL, 'asdh@asd', 'asdh@asd', 'asdh@asd', 'asdh@asd', 1, 'p05x893wto0ook4k0o840c0k0sowo8s', '$2y$13$p05x893wto0ook4k0o840OVJNBAO699EhIrmpAQkOdP031XDQj1Om', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'asdh@asd', 'asdh@asd', '1996-12-06 00:00:00', '', 'en', 'null, null', '+366666666666', 'Austria', 5, 'MRS', NULL, NULL, NULL, '2016-12-26 12:24:06', NULL, 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(92, 213, 1, 'Tester@mail', 'tester@mail', 'Tester@mail', 'tester@mail', 1, 'id16atgyr8gkc0kcws0gc88wwgs40o4', '$2y$13$id16atgyr8gkc0kcws0gcuBR2lHU1QkVYpuqrGC66F8TazeV7864m', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Tester name', 'Tester lastname', '1996-12-01 00:00:00', '', 'de', 'Tester City, Tester Numebr', '+6666666666666', 'Bulgaria', 5, 'MRS', 'Tester PostCode', 'Tester Comment', NULL, '2016-12-27 10:39:57', 'Tester Company', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg'),
(93, 220, NULL, 'nikola@fsd.rs', 'nikola@fsd.rs', 'nikola@fsd.rs', 'nikola@fsd.rs', 1, 'c9g5zsimirk04swg0g0sgc044o0k800', '$2y$13$c9g5zsimirk04swg0g0sgOXS2EKL4HvZzcEGT9yQLWW678fa2vyEW', NULL, 0, 0, NULL, NULL, NULL, 'N;', 0, NULL, 'Nikola', 'Testira', '1992-12-08 00:00:00', '', 'en', 'Vukasoviceva,Belgrade', '+381637339728', 'Greece', 0, 'MR', '11000', NULL, NULL, '2017-01-10 12:05:53', 'FSD', 'https://tcr-media.fsd.rs:105/uploads/documents/tcr/5874c1690e101.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tcr_user_log`
--

CREATE TABLE `tcr_user_log` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `registration_date` datetime NOT NULL,
  `inserted_in_database_date` datetime DEFAULT NULL,
  `confirmation_date` datetime DEFAULT NULL,
  `confirmed_by_admin` tinyint(1) DEFAULT NULL,
  `reason` varchar(252) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcr_user_log`
--

INSERT INTO `tcr_user_log` (`id`, `user_name`, `registration_date`, `inserted_in_database_date`, `confirmation_date`, `confirmed_by_admin`, `reason`) VALUES
(1, 'pavle.losic@fsd.rs', '2016-07-15 14:41:29', '2016-07-15 14:41:29', NULL, NULL, NULL),
(2, 'losicpavle@yahoo.com', '2016-08-12 14:37:57', '2016-08-12 14:37:58', NULL, NULL, NULL),
(3, 'test@fsd.rs', '2016-09-05 15:44:35', '2016-09-05 15:44:36', NULL, NULL, NULL),
(4, 'tester.chf@fsd.rs', '2016-09-19 16:00:26', '2016-09-19 16:00:27', NULL, NULL, NULL),
(5, 'tester.chf@fsd.rs', '2016-10-17 21:52:59', NULL, NULL, NULL, 'Duplicate username or email address!'),
(6, 'tester.chf@fsd.rs', '2016-10-17 22:00:47', NULL, NULL, NULL, 'Duplicate username or email address!'),
(7, 'tester.chf@fsd.rs', '2016-10-17 22:07:59', NULL, NULL, NULL, 'Duplicate username or email address!'),
(8, 'tester.chf@fsd.rs', '2016-10-17 22:09:11', NULL, NULL, NULL, 'Duplicate username or email address!'),
(9, 'tester.chf@fsd.rs', '2016-10-17 22:11:25', NULL, NULL, NULL, 'Duplicate username or email address!'),
(10, 'tester.tester@fsd.tcr.es.de', '2016-11-18 10:22:16', '2016-11-18 10:22:17', NULL, NULL, NULL),
(11, 'email@emailemail.com', '2016-12-01 09:17:20', '2016-12-01 09:17:21', NULL, NULL, NULL),
(12, 'Testttttttt@reasd123.com', '2016-12-01 10:48:43', '2016-12-01 10:48:43', NULL, NULL, NULL),
(13, 'adsasdadsads@asddasads.com', '2016-12-01 10:51:47', '2016-12-01 10:51:48', NULL, NULL, NULL),
(14, 'asadsads@dadsadsas.com', '2016-12-01 11:33:34', '2016-12-01 11:33:35', NULL, NULL, NULL),
(15, 'ovajmailsigurnonema@nema.com', '2016-12-01 13:04:28', '2016-12-01 13:04:28', NULL, NULL, NULL),
(16, '231231654654@dsaadsads', '2016-12-01 13:06:13', '2016-12-01 13:06:13', NULL, NULL, NULL),
(17, 'aaaaaaaaa@ASdadsad', '2016-12-01 13:18:21', '2016-12-01 13:18:22', NULL, NULL, NULL),
(18, 'ddddd@ddddd.com', '2016-12-01 14:01:56', '2016-12-01 14:01:57', NULL, NULL, NULL),
(19, 'ddddda@ddddd.com', '2016-12-01 14:03:47', '2016-12-01 14:03:48', NULL, NULL, NULL),
(20, 'dddddas@ddddd.com', '2016-12-01 14:04:13', '2016-12-01 14:04:14', NULL, NULL, NULL),
(21, 'dddddas@ddddd.com', '2016-12-01 14:13:12', NULL, NULL, NULL, 'Duplicate username or email address!'),
(22, 'dddddas@ddddd.com', '2016-12-01 14:14:46', NULL, NULL, NULL, 'Duplicate username or email address!'),
(23, 'dddddas@ddddd.com', '2016-12-01 14:15:05', NULL, NULL, NULL, 'Duplicate username or email address!'),
(24, 'dddddas@ddddd.com', '2016-12-01 14:15:33', NULL, NULL, NULL, 'Duplicate username or email address!'),
(25, 'dddddasa@ddddd.com', '2016-12-01 14:16:07', '2016-12-01 14:16:07', NULL, NULL, NULL),
(26, 'dddddasa@ddddd.com', '2016-12-01 14:27:00', NULL, NULL, NULL, 'Duplicate username or email address!'),
(27, '1231321321@asdasdads.commm', '2016-12-01 14:28:10', '2016-12-01 14:28:11', NULL, NULL, NULL),
(28, 'testiram@tcr-fsd.rs', '2016-12-02 13:12:50', '2016-12-02 13:12:50', NULL, NULL, NULL),
(29, 'nkm790021@gmail.com', '2016-12-05 13:43:16', '2016-12-05 13:43:16', NULL, NULL, NULL),
(30, '9999@999', '2016-12-06 10:03:58', '2016-12-06 10:03:59', NULL, NULL, NULL),
(31, '9999@999', '2016-12-06 10:05:27', NULL, NULL, NULL, 'Duplicate username or email address!'),
(32, '9999@99922.com', '2016-12-06 10:07:21', '2016-12-06 10:07:21', NULL, NULL, NULL),
(33, '29999@99922.com', '2016-12-06 10:11:14', '2016-12-06 10:11:15', NULL, NULL, NULL),
(34, 'email@mail', '2016-12-06 10:21:34', '2016-12-06 10:21:35', NULL, NULL, NULL),
(35, 'last@user', '2016-12-06 11:13:43', '2016-12-06 11:13:43', NULL, NULL, NULL),
(36, 'asdasd@asdasd', '2016-12-06 11:23:26', '2016-12-06 11:23:26', NULL, NULL, NULL),
(37, 'asdasd@asdasdasdasd', '2016-12-06 11:26:03', '2016-12-06 11:26:04', NULL, NULL, NULL),
(38, 'poiuytr@poiuytr', '2016-12-06 12:17:04', '2016-12-06 12:17:05', NULL, NULL, NULL),
(39, 'poiuytr@poiuytrtr', '2016-12-06 12:19:32', '2016-12-06 12:19:33', NULL, NULL, NULL),
(40, 'dfjkghji@dfjkghji', '2016-12-06 12:57:30', '2016-12-06 12:57:31', NULL, NULL, NULL),
(41, 'dfjkghji@dfjkghji', '2016-12-06 12:57:44', NULL, NULL, NULL, 'Duplicate username or email address!'),
(42, 'dfjkghji@dfjkghji', '2016-12-06 12:58:42', NULL, NULL, NULL, 'Duplicate username or email address!'),
(43, 'dfjkghji@dfjkghjias', '2016-12-06 12:59:48', '2016-12-06 12:59:49', NULL, NULL, NULL),
(44, 'dfjkghji@dfjkghjiasdd', '2016-12-06 13:00:58', '2016-12-06 13:00:59', NULL, NULL, NULL),
(45, 'dfjkghji@dfjkghjiasddrr', '2016-12-06 13:03:21', '2016-12-06 13:03:22', NULL, NULL, NULL),
(46, 'dfjkghji@dfjkghjiasddrrff', '2016-12-06 13:05:03', '2016-12-06 13:05:04', NULL, NULL, NULL),
(47, 'dfjkghji@dfjkghjiasddrrffrr', '2016-12-06 13:06:10', '2016-12-06 13:06:10', NULL, NULL, NULL),
(48, 'customers@customers', '2016-12-06 13:13:17', '2016-12-06 13:13:17', NULL, NULL, NULL),
(49, 'Ember2@Ember2', '2016-12-06 13:17:24', '2016-12-06 13:17:25', NULL, NULL, NULL),
(50, 'symfony@mail.com', '2016-12-06 13:52:05', '2016-12-06 13:52:06', NULL, NULL, NULL),
(51, '666@6', '2016-12-06 16:06:30', '2016-12-06 16:06:31', NULL, NULL, NULL),
(52, '5555@2', '2016-12-06 16:10:29', '2016-12-06 16:10:30', NULL, NULL, NULL),
(53, 'asdddddddddd@fsdddd.ddddd', '2016-12-07 12:13:53', '2016-12-07 12:13:54', NULL, NULL, NULL),
(54, 'avatar@avatar', '2016-12-07 12:15:18', '2016-12-07 12:15:19', NULL, NULL, NULL),
(55, 'filePath@filePath', '2016-12-07 13:05:34', '2016-12-07 13:05:35', NULL, NULL, NULL),
(56, '9999@999', '2016-12-07 13:54:32', NULL, NULL, NULL, 'Duplicate username or email address!'),
(57, '9999@999', '2016-12-07 13:55:33', NULL, NULL, NULL, 'Duplicate username or email address!'),
(58, '9999@999', '2016-12-07 13:55:55', NULL, NULL, NULL, 'Duplicate username or email address!'),
(59, '9999@999', '2016-12-07 13:57:08', NULL, NULL, NULL, 'Duplicate username or email address!'),
(60, '9999@999', '2016-12-07 13:57:22', NULL, NULL, NULL, 'Duplicate username or email address!'),
(61, '9999@999', '2016-12-07 13:59:16', NULL, NULL, NULL, 'Duplicate username or email address!'),
(62, '9999@999', '2016-12-07 14:00:16', NULL, NULL, NULL, 'Duplicate username or email address!'),
(63, '9999@999', '2016-12-07 14:00:38', NULL, NULL, NULL, 'Duplicate username or email address!'),
(64, '9999@999', '2016-12-07 14:01:13', NULL, NULL, NULL, 'Duplicate username or email address!'),
(65, '9999@999', '2016-12-07 14:03:20', NULL, NULL, NULL, 'Duplicate username or email address!'),
(66, '9999@999', '2016-12-07 14:04:15', NULL, NULL, NULL, 'Duplicate username or email address!'),
(67, '9999@999', '2016-12-07 14:08:31', NULL, NULL, NULL, 'Duplicate username or email address!'),
(68, '9999@999', '2016-12-07 14:09:46', NULL, NULL, NULL, 'Duplicate username or email address!'),
(69, '9999@999', '2016-12-07 14:14:31', NULL, NULL, NULL, 'Duplicate username or email address!'),
(70, '9999@999', '2016-12-07 14:18:38', NULL, NULL, NULL, 'Duplicate username or email address!'),
(71, '9999@999', '2016-12-07 14:24:35', NULL, NULL, NULL, 'Duplicate username or email address!'),
(72, '9999@999', '2016-12-07 14:27:09', NULL, NULL, NULL, 'Duplicate username or email address!'),
(73, '9999@999', '2016-12-07 14:27:37', NULL, NULL, NULL, 'Duplicate username or email address!'),
(74, '9999@999', '2016-12-07 14:28:02', NULL, NULL, NULL, 'Duplicate username or email address!'),
(75, '9999@999', '2016-12-07 14:29:32', NULL, NULL, NULL, 'Duplicate username or email address!'),
(76, '9999@999', '2016-12-07 14:29:50', NULL, NULL, NULL, 'Duplicate username or email address!'),
(77, '9999@999', '2016-12-07 14:30:09', NULL, NULL, NULL, 'Duplicate username or email address!'),
(78, '9999@999', '2016-12-07 14:30:22', NULL, NULL, NULL, 'Duplicate username or email address!'),
(79, 'asdasd@asdasdasdasd', '2016-12-07 14:31:52', NULL, NULL, NULL, 'Duplicate username or email address!'),
(80, 'asdasd@asdasdasdasd', '2016-12-07 14:32:08', NULL, NULL, NULL, 'Duplicate username or email address!'),
(81, 'asdasd@asd', '2016-12-07 14:32:34', '2016-12-07 14:32:35', NULL, NULL, NULL),
(82, '9999@99922.com', '2016-12-07 14:36:51', NULL, NULL, NULL, 'Duplicate username or email address!'),
(83, '9999@99922.com', '2016-12-07 14:37:07', NULL, NULL, NULL, 'Duplicate username or email address!'),
(84, 'email@mail', '2016-12-07 15:38:36', NULL, NULL, NULL, 'Duplicate username or email address!'),
(85, 'email@mai', '2016-12-07 15:38:55', '2016-12-07 15:38:55', NULL, NULL, NULL),
(86, 'email@mail', '2016-12-07 16:06:22', NULL, NULL, NULL, 'Duplicate username or email address!'),
(87, 'email@maila', '2016-12-07 16:06:27', '2016-12-07 16:06:28', NULL, NULL, NULL),
(88, '12345@12345.12345', '2016-12-22 12:12:25', '2016-12-22 12:12:26', NULL, NULL, NULL),
(89, 'testiram@tcr-fsd.rs', '2016-12-22 12:14:02', '2016-12-22 12:14:02', NULL, NULL, NULL),
(90, 'test@test', '2016-12-26 12:04:25', '2016-12-26 12:04:26', NULL, NULL, NULL),
(91, 'testiranjeeeeee@testiranjeeeeee.com', '2016-12-26 12:08:11', '2016-12-26 12:08:12', NULL, NULL, NULL),
(92, 'testing@testing', '2016-12-26 12:09:04', '2016-12-26 12:09:04', NULL, NULL, NULL),
(93, 'poewrl@pole.com', '2016-12-26 12:10:00', '2016-12-26 12:10:01', NULL, NULL, NULL),
(94, 'testAgent@testAgent', '2016-12-26 12:20:11', '2016-12-26 12:20:12', NULL, NULL, NULL),
(95, 'af@asdjf', '2016-12-26 12:22:30', '2016-12-26 12:22:31', NULL, NULL, NULL),
(96, 'asdh@asd', '2016-12-26 12:24:05', '2016-12-26 12:24:06', NULL, NULL, NULL),
(97, 'Tester@mail', '2016-12-27 10:39:56', '2016-12-27 10:39:57', NULL, NULL, NULL),
(98, 'nikola@fsd.rs', '2017-01-10 12:05:51', '2017-01-10 12:05:53', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `al_db_session`
--
ALTER TABLE `al_db_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_agent`
--
ALTER TABLE `tcr_agent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_73A4318F3414710B` (`agent_id`);

--
-- Indexes for table `tcr_channel`
--
ALTER TABLE `tcr_channel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_726A74EE511FC912` (`pdf_id`);

--
-- Indexes for table `tcr_connect_fee`
--
ALTER TABLE `tcr_connect_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_26C8A7F959949888` (`settings_id`);

--
-- Indexes for table `tcr_exception_table`
--
ALTER TABLE `tcr_exception_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_free_packages`
--
ALTER TABLE `tcr_free_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_32C94BEDF44CABFF` (`package_id`);

--
-- Indexes for table `tcr_image`
--
ALTER TABLE `tcr_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_join_package_category`
--
ALTER TABLE `tcr_join_package_category`
  ADD PRIMARY KEY (`package_id`,`package_category_id`),
  ADD KEY `IDX_ADD41E93F44CABFF` (`package_id`),
  ADD KEY `IDX_ADD41E93DF9D8784` (`package_category_id`);

--
-- Indexes for table `tcr_join_package_channel`
--
ALTER TABLE `tcr_join_package_channel`
  ADD PRIMARY KEY (`package_id`,`channel_id`),
  ADD KEY `IDX_EBC38568F44CABFF` (`package_id`),
  ADD KEY `IDX_EBC3856872F5A1AA` (`channel_id`);

--
-- Indexes for table `tcr_join_package_price`
--
ALTER TABLE `tcr_join_package_price`
  ADD PRIMARY KEY (`package_id`,`package_country_price_id`),
  ADD KEY `IDX_3539F42BF44CABFF` (`package_id`),
  ADD KEY `IDX_3539F42B3380D09E` (`package_country_price_id`);

--
-- Indexes for table `tcr_notification`
--
ALTER TABLE `tcr_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_55D5BE58A76ED395` (`user_id`);

--
-- Indexes for table `tcr_one_time_setup_fee`
--
ALTER TABLE `tcr_one_time_setup_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_11A1F60159949888` (`settings_id`);

--
-- Indexes for table `tcr_order`
--
ALTER TABLE `tcr_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A0063E8AA76ED395` (`user_id`);

--
-- Indexes for table `tcr_order_item`
--
ALTER TABLE `tcr_order_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_316B2FF92437186` (`extended_item_id`),
  ADD UNIQUE KEY `UNIQ_316B2FF51D74ABA` (`activated_item_id`),
  ADD KEY `IDX_316B2FF8D9F6D38` (`order_id`),
  ADD KEY `IDX_316B2FF4584665A` (`product_id`);

--
-- Indexes for table `tcr_package`
--
ALTER TABLE `tcr_package`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EFB9D3C3DA5256D` (`image_id`);

--
-- Indexes for table `tcr_package_category`
--
ALTER TABLE `tcr_package_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_package_country_price`
--
ALTER TABLE `tcr_package_country_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_payment_account`
--
ALTER TABLE `tcr_payment_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_payment_security_token`
--
ALTER TABLE `tcr_payment_security_token`
  ADD PRIMARY KEY (`hash`);

--
-- Indexes for table `tcr_pay_pal_payment_details`
--
ALTER TABLE `tcr_pay_pal_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_pdf`
--
ALTER TABLE `tcr_pdf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcr_settings`
--
ALTER TABLE `tcr_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4A9F28733DA5256D` (`image_id`);

--
-- Indexes for table `tcr_stream_fee`
--
ALTER TABLE `tcr_stream_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6DD0513D59949888` (`settings_id`);

--
-- Indexes for table `tcr_transaction`
--
ALTER TABLE `tcr_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_26B8AE55A76ED395` (`user_id`);

--
-- Indexes for table `tcr_user`
--
ALTER TABLE `tcr_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A718EBFE92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_A718EBFEA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_A718EBFE86383B10` (`avatar_id`),
  ADD KEY `IDX_A718EBFE3414710B` (`agent_id`);

--
-- Indexes for table `tcr_user_log`
--
ALTER TABLE `tcr_user_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tcr_agent`
--
ALTER TABLE `tcr_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `tcr_channel`
--
ALTER TABLE `tcr_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tcr_connect_fee`
--
ALTER TABLE `tcr_connect_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tcr_exception_table`
--
ALTER TABLE `tcr_exception_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcr_free_packages`
--
ALTER TABLE `tcr_free_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tcr_image`
--
ALTER TABLE `tcr_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;
--
-- AUTO_INCREMENT for table `tcr_notification`
--
ALTER TABLE `tcr_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `tcr_one_time_setup_fee`
--
ALTER TABLE `tcr_one_time_setup_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tcr_order`
--
ALTER TABLE `tcr_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `tcr_order_item`
--
ALTER TABLE `tcr_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `tcr_package`
--
ALTER TABLE `tcr_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tcr_package_category`
--
ALTER TABLE `tcr_package_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tcr_package_country_price`
--
ALTER TABLE `tcr_package_country_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `tcr_payment_account`
--
ALTER TABLE `tcr_payment_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcr_pay_pal_payment_details`
--
ALTER TABLE `tcr_pay_pal_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tcr_pdf`
--
ALTER TABLE `tcr_pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tcr_settings`
--
ALTER TABLE `tcr_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tcr_stream_fee`
--
ALTER TABLE `tcr_stream_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tcr_transaction`
--
ALTER TABLE `tcr_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `tcr_user`
--
ALTER TABLE `tcr_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `tcr_user_log`
--
ALTER TABLE `tcr_user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tcr_channel`
--
ALTER TABLE `tcr_channel`
  ADD CONSTRAINT `FK_726A74EE511FC912` FOREIGN KEY (`pdf_id`) REFERENCES `tcr_pdf` (`id`);

--
-- Constraints for table `tcr_connect_fee`
--
ALTER TABLE `tcr_connect_fee`
  ADD CONSTRAINT `FK_26C8A7F959949888` FOREIGN KEY (`settings_id`) REFERENCES `tcr_settings` (`id`);

--
-- Constraints for table `tcr_free_packages`
--
ALTER TABLE `tcr_free_packages`
  ADD CONSTRAINT `FK_32C94BEDF44CABFF` FOREIGN KEY (`package_id`) REFERENCES `tcr_package` (`id`);

--
-- Constraints for table `tcr_join_package_category`
--
ALTER TABLE `tcr_join_package_category`
  ADD CONSTRAINT `FK_ADD41E93DF9D8784` FOREIGN KEY (`package_category_id`) REFERENCES `tcr_package_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ADD41E93F44CABFF` FOREIGN KEY (`package_id`) REFERENCES `tcr_package` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tcr_join_package_channel`
--
ALTER TABLE `tcr_join_package_channel`
  ADD CONSTRAINT `FK_EBC3856872F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `tcr_channel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EBC38568F44CABFF` FOREIGN KEY (`package_id`) REFERENCES `tcr_package` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tcr_join_package_price`
--
ALTER TABLE `tcr_join_package_price`
  ADD CONSTRAINT `FK_3539F42B3380D09E` FOREIGN KEY (`package_country_price_id`) REFERENCES `tcr_package_country_price` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3539F42BF44CABFF` FOREIGN KEY (`package_id`) REFERENCES `tcr_package` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tcr_notification`
--
ALTER TABLE `tcr_notification`
  ADD CONSTRAINT `FK_55D5BE58A76ED395` FOREIGN KEY (`user_id`) REFERENCES `tcr_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tcr_one_time_setup_fee`
--
ALTER TABLE `tcr_one_time_setup_fee`
  ADD CONSTRAINT `FK_11A1F60159949888` FOREIGN KEY (`settings_id`) REFERENCES `tcr_settings` (`id`);

--
-- Constraints for table `tcr_order`
--
ALTER TABLE `tcr_order`
  ADD CONSTRAINT `FK_A0063E8AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `tcr_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tcr_order_item`
--
ALTER TABLE `tcr_order_item`
  ADD CONSTRAINT `FK_316B2FF4584665A` FOREIGN KEY (`product_id`) REFERENCES `tcr_package` (`id`),
  ADD CONSTRAINT `FK_316B2FF51D74ABA` FOREIGN KEY (`activated_item_id`) REFERENCES `tcr_order_item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_316B2FF8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `tcr_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_316B2FF92437186` FOREIGN KEY (`extended_item_id`) REFERENCES `tcr_order_item` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tcr_package`
--
ALTER TABLE `tcr_package`
  ADD CONSTRAINT `FK_EFB9D3C3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `tcr_image` (`id`);

--
-- Constraints for table `tcr_settings`
--
ALTER TABLE `tcr_settings`
  ADD CONSTRAINT `FK_4A9F28733DA5256D` FOREIGN KEY (`image_id`) REFERENCES `tcr_image` (`id`);

--
-- Constraints for table `tcr_stream_fee`
--
ALTER TABLE `tcr_stream_fee`
  ADD CONSTRAINT `FK_6DD0513D59949888` FOREIGN KEY (`settings_id`) REFERENCES `tcr_settings` (`id`);

--
-- Constraints for table `tcr_transaction`
--
ALTER TABLE `tcr_transaction`
  ADD CONSTRAINT `FK_26B8AE55A76ED395` FOREIGN KEY (`user_id`) REFERENCES `tcr_user` (`id`);

--
-- Constraints for table `tcr_user`
--
ALTER TABLE `tcr_user`
  ADD CONSTRAINT `FK_A718EBFE3414710B` FOREIGN KEY (`agent_id`) REFERENCES `tcr_agent` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_A718EBFE86383B10` FOREIGN KEY (`avatar_id`) REFERENCES `tcr_image` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
