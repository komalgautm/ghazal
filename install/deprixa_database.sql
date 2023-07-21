-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-09-2021 a las 23:41:19
-- Versión del servidor: 10.3.24-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u534845804_deprixaexten1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_address_shipments`
--

CREATE TABLE `cdb_address_shipments` (
  `id` int(11) NOT NULL,
  `order_track` varchar(350) DEFAULT NULL,
  `sender_address` varchar(300) DEFAULT NULL,
  `sender_country` varchar(300) DEFAULT NULL,
  `sender_city` varchar(300) DEFAULT NULL,
  `sender_zip_code` varchar(300) DEFAULT NULL,
  `recipient_address` varchar(300) DEFAULT NULL,
  `recipient_country` varchar(300) DEFAULT NULL,
  `recipient_city` varchar(300) DEFAULT NULL,
  `recipient_zip_code` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_add_order`
--

CREATE TABLE `cdb_add_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_prefix` varchar(300) DEFAULT NULL,
  `order_no` varchar(350) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_address_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `receiver_address_id` int(11) DEFAULT NULL,
  `tax_value` float DEFAULT NULL,
  `tax_insurance_value` float DEFAULT NULL,
  `tax_custom_tariffis_value` float DEFAULT NULL,
  `value_weight` float DEFAULT NULL,
  `declared_value` float NOT NULL,
  `volumetric_percentage` varchar(300) DEFAULT NULL,
  `total_weight` float DEFAULT NULL,
  `sub_total` float DEFAULT NULL,
  `tax_discount` float DEFAULT NULL,
  `total_tax_insurance` float DEFAULT NULL,
  `total_tax_custom_tariffis` float DEFAULT NULL,
  `total_tax` float DEFAULT NULL,
  `total_declared_value` float NOT NULL,
  `total_tax_discount` float DEFAULT NULL,
  `total_reexp` float DEFAULT NULL,
  `total_order` float DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `agency` int(11) DEFAULT NULL,
  `origin_off` int(11) DEFAULT NULL,
  `order_package` int(11) DEFAULT NULL,
  `order_courier` int(11) DEFAULT NULL,
  `order_service_options` int(11) DEFAULT NULL,
  `order_deli_time` int(11) DEFAULT NULL,
  `order_pay_mode` int(11) DEFAULT NULL,
  `order_payment_method` int(11) DEFAULT NULL,
  `status_courier` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `person_receives` varchar(300) DEFAULT NULL,
  `photo_delivered` varchar(300) DEFAULT NULL,
  `is_pickup` tinyint(1) DEFAULT 0,
  `is_consolidate` tinyint(1) DEFAULT 0,
  `due_date` date DEFAULT NULL,
  `status_invoice` int(11) DEFAULT NULL,
  `reason_cancel` mediumtext DEFAULT NULL,
  `order_incomplete` tinyint(4) DEFAULT 1,
  `url_payment_attach` varchar(500) DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_add_order_item`
--

CREATE TABLE `cdb_add_order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_item_description` varchar(250) DEFAULT NULL,
  `order_item_category` int(11) DEFAULT NULL,
  `order_item_quantity` decimal(10,2) DEFAULT NULL,
  `order_item_weight` varchar(120) DEFAULT NULL,
  `order_item_length` varchar(120) DEFAULT NULL,
  `order_item_width` varchar(120) DEFAULT NULL,
  `order_item_height` varchar(120) DEFAULT NULL,
  `order_item_declared_value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_branchoffices`
--

CREATE TABLE `cdb_branchoffices` (
  `id` int(10) NOT NULL,
  `name_branch` varchar(100) DEFAULT NULL,
  `branch_address` varchar(120) DEFAULT NULL,
  `branch_city` varchar(100) DEFAULT NULL,
  `phone_branch` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_branchoffices`
--

INSERT INTO `cdb_branchoffices` (`id`, `name_branch`, `branch_address`, `branch_city`, `phone_branch`) VALUES
(1, 'AGENCY 1', 'Miami', 'Miami', '123456789'),
(2, 'AGENCY 2', 'Chile', 'Chile', '123456789'),
(3, 'AGENCY 3', 'Panama', 'Panama', '123456789'),
(4, 'ALL AGENCIES', 'MIAMI', 'MIAMI', '1234567');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_category`
--

CREATE TABLE `cdb_category` (
  `id` int(5) NOT NULL,
  `name_item` varchar(120) DEFAULT NULL,
  `detail_item` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_category`
--

INSERT INTO `cdb_category` (`id`, `name_item`, `detail_item`) VALUES
(1, 'Accessory (no-battery)', 'Accessory (no-battery)'),
(2, 'Accessory (with battery)', 'Accessory (with battery)'),
(3, 'Audio Video', 'Audio Video'),
(4, 'Bags & Luggages', 'Bags & Luggages'),
(5, 'Books & Collectibles', 'Books & Collectibles'),
(6, 'Cameras', 'Cameras'),
(7, 'Computers & Laptops', 'Computers & Laptops'),
(8, 'Documents', 'Documents'),
(9, 'Dry Food & Supplements', 'Dry Food & Supplements'),
(10, 'Fashion', 'Fashion'),
(11, 'Gaming', 'Gaming'),
(12, 'Health & Beauty', 'Health & Beauty'),
(13, 'Home Appliances', 'Home Appliances'),
(14, 'Home Decor', 'Home Decor'),
(15, 'Jewelry', 'Jewelry'),
(16, 'Mobile Phones', 'Mobile Phones'),
(17, 'Pet Accessory', 'Pet Accessory'),
(18, 'Sauce', 'Sauce'),
(19, 'Sport & Leisure', 'Sport & Leisure'),
(20, 'Tablets', 'Tablets'),
(21, 'Toys', 'Toys'),
(22, 'Watches', 'Watches'),
(23, NULL, NULL),
(24, NULL, NULL),
(25, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_charges_order`
--

CREATE TABLE `cdb_charges_order` (
  `id_charge` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `charge_date` date DEFAULT NULL,
  `total` double(5,2) DEFAULT NULL,
  `number_reference` varchar(500) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_consolidate`
--

CREATE TABLE `cdb_consolidate` (
  `consolidate_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `c_prefix` varchar(300) DEFAULT NULL,
  `c_no` varchar(350) DEFAULT NULL,
  `c_date` date DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_address_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `receiver_address_id` int(11) DEFAULT NULL,
  `tax_value` float DEFAULT NULL,
  `tax_insurance_value` float DEFAULT NULL,
  `tax_custom_tariffis_value` float DEFAULT NULL,
  `value_weight` float DEFAULT NULL,
  `volumetric_percentage` varchar(300) DEFAULT NULL,
  `total_weight` float DEFAULT NULL,
  `sub_total` float DEFAULT NULL,
  `tax_discount` float DEFAULT NULL,
  `total_tax_insurance` float DEFAULT NULL,
  `total_tax_custom_tariffis` float DEFAULT NULL,
  `total_tax` float DEFAULT NULL,
  `total_tax_discount` float DEFAULT NULL,
  `total_reexp` float DEFAULT NULL,
  `total_order` float DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `agency` varchar(250) DEFAULT NULL,
  `origin_off` varchar(250) DEFAULT NULL,
  `order_package` varchar(250) DEFAULT NULL,
  `order_courier` varchar(250) DEFAULT NULL,
  `order_service_options` varchar(250) DEFAULT NULL,
  `order_deli_time` varchar(250) DEFAULT NULL,
  `order_pay_mode` varchar(250) DEFAULT NULL,
  `status_courier` varchar(250) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `person_receives` varchar(300) DEFAULT NULL,
  `photo_delivered` varchar(300) DEFAULT NULL,
  `seals_package` varchar(300) DEFAULT NULL,
  `status_invoice` int(11) DEFAULT NULL,
  `url_payment_attach` varchar(350) DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_consolidate_detail`
--

CREATE TABLE `cdb_consolidate_detail` (
  `detail_id` int(11) NOT NULL,
  `consolidate_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_prefix` varchar(300) DEFAULT NULL,
  `order_no` varchar(300) DEFAULT NULL,
  `weight` varchar(300) DEFAULT NULL,
  `length` varchar(300) DEFAULT NULL,
  `width` varchar(300) DEFAULT NULL,
  `height` varchar(300) DEFAULT NULL,
  `weight_vol` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_countries`
--

CREATE TABLE `cdb_countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_3166_2` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iso_3166_3` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cdb_countries`
--

INSERT INTO `cdb_countries` (`id`, `full_name`, `iso_3166_2`, `iso_3166_3`, `name`) VALUES
(4, 'Islamic Republic of Afghanistan', 'AF', 'AFG', 'Afghanistan'),
(8, 'Republic of Albania', 'AL', 'ALB', 'Albania'),
(10, 'Antarctica', 'AQ', 'ATA', 'Antarctica'),
(12, 'People’s Democratic Republic of Algeria', 'DZ', 'DZA', 'Algeria'),
(16, 'Territory of American', 'AS', 'ASM', 'American Samoa'),
(20, 'Principality of Andorra', 'AD', 'AND', 'Andorra'),
(24, 'Republic of Angola', 'AO', 'AGO', 'Angola'),
(28, 'Antigua and Barbuda', 'AG', 'ATG', 'Antigua and Barbuda'),
(31, 'Republic of Azerbaijan', 'AZ', 'AZE', 'Azerbaijan'),
(32, 'Argentine Republic', 'AR', 'ARG', 'Argentina'),
(36, 'Commonwealth of Australia', 'AU', 'AUS', 'Australia'),
(40, 'Republic of Austria', 'AT', 'AUT', 'Austria'),
(44, 'Commonwealth of the Bahamas', 'BS', 'BHS', 'Bahamas'),
(48, 'Kingdom of Bahrain', 'BH', 'BHR', 'Bahrain'),
(50, 'People’s Republic of Bangladesh', 'BD', 'BGD', 'Bangladesh'),
(51, 'Republic of Armenia', 'AM', 'ARM', 'Armenia'),
(52, 'Barbados', 'BB', 'BRB', 'Barbados'),
(56, 'Kingdom of Belgium', 'BE', 'BEL', 'Belgium'),
(60, 'Bermuda', 'BM', 'BMU', 'Bermuda'),
(64, 'Kingdom of Bhutan', 'BT', 'BTN', 'Bhutan'),
(68, 'Plurinational State of Bolivia', 'BO', 'BOL', 'Bolivia, Plurinational State of'),
(70, 'Bosnia and Herzegovina', 'BA', 'BIH', 'Bosnia and Herzegovina'),
(72, 'Republic of Botswana', 'BW', 'BWA', 'Botswana'),
(74, 'Bouvet Island', 'BV', 'BVT', 'Bouvet Island'),
(76, 'Federative Republic of Brazil', 'BR', 'BRA', 'Brazil'),
(84, 'Belize', 'BZ', 'BLZ', 'Belize'),
(86, 'British Indian Ocean Territory', 'IO', 'IOT', 'British Indian Ocean Territory'),
(90, 'Solomon Islands', 'SB', 'SLB', 'Solomon Islands'),
(92, 'British Virgin Islands', 'VG', 'VGB', 'Virgin Islands, British'),
(96, 'Brunei Darussalam', 'BN', 'BRN', 'Brunei Darussalam'),
(100, 'Republic of Bulgaria', 'BG', 'BGR', 'Bulgaria'),
(104, 'Union of Myanmar/', 'MM', 'MMR', 'Myanmar'),
(108, 'Republic of Burundi', 'BI', 'BDI', 'Burundi'),
(112, 'Republic of Belarus', 'BY', 'BLR', 'Belarus'),
(116, 'Kingdom of Cambodia', 'KH', 'KHM', 'Cambodia'),
(120, 'Republic of Cameroon', 'CM', 'CMR', 'Cameroon'),
(124, 'Canada', 'CA', 'CAN', 'Canada'),
(132, 'Republic of Cape Verde', 'CV', 'CPV', 'Cape Verde'),
(136, 'Cayman Islands', 'KY', 'CYM', 'Cayman Islands'),
(140, 'Central African Republic', 'CF', 'CAF', 'Central African Republic'),
(144, 'Democratic Socialist Republic of Sri Lanka', 'LK', 'LKA', 'Sri Lanka'),
(148, 'Republic of Chad', 'TD', 'TCD', 'Chad'),
(152, 'Republic of Chile', 'CL', 'CHL', 'Chile'),
(156, 'People’s Republic of China', 'CN', 'CHN', 'China'),
(158, 'Republic of China, Taiwan (TW1)', 'TW', 'TWN', 'Taiwan, Province of China'),
(162, 'Christmas Island Territory', 'CX', 'CXR', 'Christmas Island'),
(166, 'Territory of Cocos (Keeling) Islands', 'CC', 'CCK', 'Cocos (Keeling) Islands'),
(170, 'Republic of Colombia', 'CO', 'COL', 'Colombia'),
(174, 'Union of the Comoros', 'KM', 'COM', 'Comoros'),
(175, 'Departmental Collectivity of Mayotte', 'YT', 'MYT', 'Mayotte'),
(178, 'Republic of the Congo', 'CG', 'COG', 'Congo'),
(180, 'Democratic Republic of the Congo', 'CD', 'COD', 'Congo, the Democratic Republic of the'),
(184, 'Cook Islands', 'CK', 'COK', 'Cook Islands'),
(188, 'Republic of Costa Rica', 'CR', 'CRI', 'Costa Rica'),
(191, 'Republic of Croatia', 'HR', 'HRV', 'Croatia'),
(192, 'Republic of Cuba', 'CU', 'CUB', 'Cuba'),
(196, 'Republic of Cyprus', 'CY', 'CYP', 'Cyprus'),
(203, 'Czech Republic', 'CZ', 'CZE', 'Czech Republic'),
(204, 'Republic of Benin', 'BJ', 'BEN', 'Benin'),
(208, 'Kingdom of Denmark', 'DK', 'DNK', 'Denmark'),
(212, 'Commonwealth of Dominica', 'DM', 'DMA', 'Dominica'),
(214, 'Dominican Republic', 'DO', 'DOM', 'Dominican Republic'),
(218, 'Republic of Ecuador', 'EC', 'ECU', 'Ecuador'),
(222, 'Republic of El Salvador', 'SV', 'SLV', 'El Salvador'),
(226, 'Republic of Equatorial Guinea', 'GQ', 'GNQ', 'Equatorial Guinea'),
(231, 'Federal Democratic Republic of Ethiopia', 'ET', 'ETH', 'Ethiopia'),
(232, 'State of Eritrea', 'ER', 'ERI', 'Eritrea'),
(233, 'Republic of Estonia', 'EE', 'EST', 'Estonia'),
(234, 'Faeroe Islands', 'FO', 'FRO', 'Faroe Islands'),
(238, 'Falkland Islands', 'FK', 'FLK', 'Falkland Islands (Malvinas)'),
(239, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', 'South Georgia and the South Sandwich Islands'),
(242, 'Republic of Fiji', 'FJ', 'FJI', 'Fiji'),
(246, 'Republic of Finland', 'FI', 'FIN', 'Finland'),
(248, 'Åland Islands', 'AX', 'ALA', 'Åland Islands'),
(250, 'French Republic', 'FR', 'FRA', 'France'),
(254, 'French Guiana', 'GF', 'GUF', 'French Guiana'),
(258, 'French Polynesia', 'PF', 'PYF', 'French Polynesia'),
(260, 'French Southern and Antarctic Lands', 'TF', 'ATF', 'French Southern Territories'),
(262, 'Republic of Djibouti', 'DJ', 'DJI', 'Djibouti'),
(266, 'Gabonese Republic', 'GA', 'GAB', 'Gabon'),
(268, 'Georgia', 'GE', 'GEO', 'Georgia'),
(270, 'Republic of the Gambia', 'GM', 'GMB', 'Gambia'),
(275, NULL, 'PS', 'PSE', 'Palestinian Territory, Occupied'),
(276, 'Federal Republic of Germany', 'DE', 'DEU', 'Germany'),
(288, 'Republic of Ghana', 'GH', 'GHA', 'Ghana'),
(292, 'Gibraltar', 'GI', 'GIB', 'Gibraltar'),
(296, 'Republic of Kiribati', 'KI', 'KIR', 'Kiribati'),
(300, 'Hellenic Republic', 'GR', 'GRC', 'Greece'),
(304, 'Greenland', 'GL', 'GRL', 'Greenland'),
(308, 'Grenada', 'GD', 'GRD', 'Grenada'),
(312, 'Guadeloupe', 'GP', 'GLP', 'Guadeloupe'),
(316, 'Territory of Guam', 'GU', 'GUM', 'Guam'),
(320, 'Republic of Guatemala', 'GT', 'GTM', 'Guatemala'),
(324, 'Republic of Guinea', 'GN', 'GIN', 'Guinea'),
(328, 'Cooperative Republic of Guyana', 'GY', 'GUY', 'Guyana'),
(332, 'Republic of Haiti', 'HT', 'HTI', 'Haiti'),
(334, 'Territory of Heard Island and McDonald Islands', 'HM', 'HMD', 'Heard Island and McDonald Islands'),
(336, 'the Holy See/ Vatican City State', 'VA', 'VAT', 'Holy See (Vatican City State)'),
(340, 'Republic of Honduras', 'HN', 'HND', 'Honduras'),
(344, 'Hong Kong Special Administrative Region of the People’s Republic of China (HK2)', 'HK', 'HKG', 'Hong Kong'),
(348, 'Republic of Hungary', 'HU', 'HUN', 'Hungary'),
(352, 'Republic of Iceland', 'IS', 'ISL', 'Iceland'),
(356, 'Republic of India', 'IN', 'IND', 'India'),
(360, 'Republic of Indonesia', 'ID', 'IDN', 'Indonesia'),
(364, 'Islamic Republic of Iran', 'IR', 'IRN', 'Iran, Islamic Republic of'),
(368, 'Republic of Iraq', 'IQ', 'IRQ', 'Iraq'),
(372, 'Ireland (IE1)', 'IE', 'IRL', 'Ireland'),
(376, 'State of Israel', 'IL', 'ISR', 'Israel'),
(380, 'Italian Republic', 'IT', 'ITA', 'Italy'),
(384, 'Republic of Côte d’Ivoire', 'CI', 'CIV', 'Côte d\'Ivoire'),
(388, 'Jamaica', 'JM', 'JAM', 'Jamaica'),
(392, 'Japan', 'JP', 'JPN', 'Japan'),
(398, 'Republic of Kazakhstan', 'KZ', 'KAZ', 'Kazakhstan'),
(400, 'Hashemite Kingdom of Jordan', 'JO', 'JOR', 'Jordan'),
(404, 'Republic of Kenya', 'KE', 'KEN', 'Kenya'),
(408, 'Democratic People’s Republic of Korea', 'KP', 'PRK', 'Korea, Democratic People\'s Republic of'),
(410, 'Republic of Korea', 'KR', 'KOR', 'Korea, Republic of'),
(414, 'State of Kuwait', 'KW', 'KWT', 'Kuwait'),
(417, 'Kyrgyz Republic', 'KG', 'KGZ', 'Kyrgyzstan'),
(418, 'Lao People’s Democratic Republic', 'LA', 'LAO', 'Lao People\'s Democratic Republic'),
(422, 'Lebanese Republic', 'LB', 'LBN', 'Lebanon'),
(426, 'Kingdom of Lesotho', 'LS', 'LSO', 'Lesotho'),
(428, 'Republic of Latvia', 'LV', 'LVA', 'Latvia'),
(430, 'Republic of Liberia', 'LR', 'LBR', 'Liberia'),
(434, 'Socialist People’s Libyan Arab Jamahiriya', 'LY', 'LBY', 'Libya'),
(438, 'Principality of Liechtenstein', 'LI', 'LIE', 'Liechtenstein'),
(440, 'Republic of Lithuania', 'LT', 'LTU', 'Lithuania'),
(442, 'Grand Duchy of Luxembourg', 'LU', 'LUX', 'Luxembourg'),
(446, 'Macao Special Administrative Region of the People’s Republic of China (MO2)', 'MO', 'MAC', 'Macao'),
(450, 'Republic of Madagascar', 'MG', 'MDG', 'Madagascar'),
(454, 'Republic of Malawi', 'MW', 'MWI', 'Malawi'),
(458, 'Malaysia', 'MY', 'MYS', 'Malaysia'),
(462, 'Republic of Maldives', 'MV', 'MDV', 'Maldives'),
(466, 'Republic of Mali', 'ML', 'MLI', 'Mali'),
(470, 'Republic of Malta', 'MT', 'MLT', 'Malta'),
(474, 'Martinique', 'MQ', 'MTQ', 'Martinique'),
(478, 'Islamic Republic of Mauritania', 'MR', 'MRT', 'Mauritania'),
(480, 'Republic of Mauritius', 'MU', 'MUS', 'Mauritius'),
(484, 'United Mexican States', 'MX', 'MEX', 'Mexico'),
(492, 'Principality of Monaco', 'MC', 'MCO', 'Monaco'),
(496, 'Mongolia', 'MN', 'MNG', 'Mongolia'),
(498, 'Republic of Moldova', 'MD', 'MDA', 'Moldova, Republic of'),
(499, 'Montenegro', 'ME', 'MNE', 'Montenegro'),
(500, 'Montserrat', 'MS', 'MSR', 'Montserrat'),
(504, 'Kingdom of Morocco', 'MA', 'MAR', 'Morocco'),
(508, 'Republic of Mozambique', 'MZ', 'MOZ', 'Mozambique'),
(512, 'Sultanate of Oman', 'OM', 'OMN', 'Oman'),
(516, 'Republic of Namibia', 'NA', 'NAM', 'Namibia'),
(520, 'Republic of Nauru', 'NR', 'NRU', 'Nauru'),
(524, 'Nepal', 'NP', 'NPL', 'Nepal'),
(528, 'Kingdom of the Netherlands', 'NL', 'NLD', 'Netherlands'),
(531, 'Curaçao', 'CW', 'CUW', 'Curaçao'),
(533, 'Aruba', 'AW', 'ABW', 'Aruba'),
(534, 'Sint Maarten', 'SX', 'SXM', 'Sint Maarten (Dutch part)'),
(535, NULL, 'BQ', 'BES', 'Bonaire, Sint Eustatius and Saba'),
(540, 'New Caledonia', 'NC', 'NCL', 'New Caledonia'),
(548, 'Republic of Vanuatu', 'VU', 'VUT', 'Vanuatu'),
(554, 'New Zealand', 'NZ', 'NZL', 'New Zealand'),
(558, 'Republic of Nicaragua', 'NI', 'NIC', 'Nicaragua'),
(562, 'Republic of Niger', 'NE', 'NER', 'Niger'),
(566, 'Federal Republic of Nigeria', 'NG', 'NGA', 'Nigeria'),
(570, 'Niue', 'NU', 'NIU', 'Niue'),
(574, 'Territory of Norfolk Island', 'NF', 'NFK', 'Norfolk Island'),
(578, 'Kingdom of Norway', 'NO', 'NOR', 'Norway'),
(580, 'Commonwealth of the Northern Mariana Islands', 'MP', 'MNP', 'Northern Mariana Islands'),
(581, 'United States Minor Outlying Islands', 'UM', 'UMI', 'United States Minor Outlying Islands'),
(583, 'Federated States of Micronesia', 'FM', 'FSM', 'Micronesia, Federated States of'),
(584, 'Republic of the Marshall Islands', 'MH', 'MHL', 'Marshall Islands'),
(585, 'Republic of Palau', 'PW', 'PLW', 'Palau'),
(586, 'Islamic Republic of Pakistan', 'PK', 'PAK', 'Pakistan'),
(591, 'Republic of Panama', 'PA', 'PAN', 'Panama'),
(598, 'Independent State of Papua New Guinea', 'PG', 'PNG', 'Papua New Guinea'),
(600, 'Republic of Paraguay', 'PY', 'PRY', 'Paraguay'),
(604, 'Republic of Peru', 'PE', 'PER', 'Peru'),
(608, 'Republic of the Philippines', 'PH', 'PHL', 'Philippines'),
(612, 'Pitcairn Islands', 'PN', 'PCN', 'Pitcairn'),
(616, 'Republic of Poland', 'PL', 'POL', 'Poland'),
(620, 'Portuguese Republic', 'PT', 'PRT', 'Portugal'),
(624, 'Republic of Guinea-Bissau', 'GW', 'GNB', 'Guinea-Bissau'),
(626, 'Democratic Republic of East Timor', 'TL', 'TLS', 'Timor-Leste'),
(630, 'Commonwealth of Puerto Rico', 'PR', 'PRI', 'Puerto Rico'),
(634, 'State of Qatar', 'QA', 'QAT', 'Qatar'),
(638, 'Réunion', 'RE', 'REU', 'Réunion'),
(642, 'Romania', 'RO', 'ROU', 'Romania'),
(643, 'Russian Federation', 'RU', 'RUS', 'Russian Federation'),
(646, 'Republic of Rwanda', 'RW', 'RWA', 'Rwanda'),
(652, 'Collectivity of Saint Barthélemy', 'BL', 'BLM', 'Saint Barthélemy'),
(654, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN', 'Saint Helena, Ascension and Tristan da Cunha'),
(659, 'Federation of Saint Kitts and Nevis', 'KN', 'KNA', 'Saint Kitts and Nevis'),
(660, 'Anguilla', 'AI', 'AIA', 'Anguilla'),
(662, 'Saint Lucia', 'LC', 'LCA', 'Saint Lucia'),
(663, 'Collectivity of Saint Martin', 'MF', 'MAF', 'Saint Martin (French part)'),
(666, 'Territorial Collectivity of Saint Pierre and Miquelon', 'PM', 'SPM', 'Saint Pierre and Miquelon'),
(670, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 'Saint Vincent and the Grenadines'),
(674, 'Republic of San Marino', 'SM', 'SMR', 'San Marino'),
(678, 'Democratic Republic of São Tomé and Príncipe', 'ST', 'STP', 'Sao Tome and Principe'),
(682, 'Kingdom of Saudi Arabia', 'SA', 'SAU', 'Saudi Arabia'),
(686, 'Republic of Senegal', 'SN', 'SEN', 'Senegal'),
(688, 'Republic of Serbia', 'RS', 'SRB', 'Serbia'),
(690, 'Republic of Seychelles', 'SC', 'SYC', 'Seychelles'),
(694, 'Republic of Sierra Leone', 'SL', 'SLE', 'Sierra Leone'),
(702, 'Republic of Singapore', 'SG', 'SGP', 'Singapore'),
(703, 'Slovak Republic', 'SK', 'SVK', 'Slovakia'),
(704, 'Socialist Republic of Vietnam', 'VN', 'VNM', 'Viet Nam'),
(705, 'Republic of Slovenia', 'SI', 'SVN', 'Slovenia'),
(706, 'Somali Republic', 'SO', 'SOM', 'Somalia'),
(710, 'Republic of South Africa', 'ZA', 'ZAF', 'South Africa'),
(716, 'Republic of Zimbabwe', 'ZW', 'ZWE', 'Zimbabwe'),
(724, 'Kingdom of Spain', 'ES', 'ESP', 'Spain'),
(728, 'Republic of South Sudan', 'SS', 'SSD', 'South Sudan'),
(729, 'Republic of the Sudan', 'SD', 'SDN', 'Sudan'),
(732, 'Western Sahara', 'EH', 'ESH', 'Western Sahara'),
(740, 'Republic of Suriname', 'SR', 'SUR', 'Suriname'),
(744, 'Svalbard and Jan Mayen', 'SJ', 'SJM', 'Svalbard and Jan Mayen'),
(748, 'Kingdom of Swaziland', 'SZ', 'SWZ', 'Swaziland'),
(752, 'Kingdom of Sweden', 'SE', 'SWE', 'Sweden'),
(756, 'Swiss Confederation', 'CH', 'CHE', 'Switzerland'),
(760, 'Syrian Arab Republic', 'SY', 'SYR', 'Syrian Arab Republic'),
(762, 'Republic of Tajikistan', 'TJ', 'TJK', 'Tajikistan'),
(764, 'Kingdom of Thailand', 'TH', 'THA', 'Thailand'),
(768, 'Togolese Republic', 'TG', 'TGO', 'Togo'),
(772, 'Tokelau', 'TK', 'TKL', 'Tokelau'),
(776, 'Kingdom of Tonga', 'TO', 'TON', 'Tonga'),
(780, 'Republic of Trinidad and Tobago', 'TT', 'TTO', 'Trinidad and Tobago'),
(784, 'United Arab Emirates', 'AE', 'ARE', 'United Arab Emirates'),
(788, 'Republic of Tunisia', 'TN', 'TUN', 'Tunisia'),
(792, 'Republic of Turkey', 'TR', 'TUR', 'Turkey'),
(795, 'Turkmenistan', 'TM', 'TKM', 'Turkmenistan'),
(796, 'Turks and Caicos Islands', 'TC', 'TCA', 'Turks and Caicos Islands'),
(798, 'Tuvalu', 'TV', 'TUV', 'Tuvalu'),
(800, 'Republic of Uganda', 'UG', 'UGA', 'Uganda'),
(804, 'Ukraine', 'UA', 'UKR', 'Ukraine'),
(807, 'the former Yugoslav Republic of Macedonia', 'MK', 'MKD', 'Macedonia, the former Yugoslav Republic of'),
(818, 'Arab Republic of Egypt', 'EG', 'EGY', 'Egypt'),
(826, 'United Kingdom of Great Britain and Northern Ireland', 'GB', 'GBR', 'United Kingdom'),
(831, 'Bailiwick of Guernsey', 'GG', 'GGY', 'Guernsey'),
(832, 'Bailiwick of Jersey', 'JE', 'JEY', 'Jersey'),
(833, 'Isle of Man', 'IM', 'IMN', 'Isle of Man'),
(834, 'United Republic of Tanzania', 'TZ', 'TZA', 'Tanzania, United Republic of'),
(840, 'United States of America', 'US', 'USA', 'United States'),
(850, 'United States Virgin Islands', 'VI', 'VIR', 'Virgin Islands, U.S.'),
(854, 'Burkina Faso', 'BF', 'BFA', 'Burkina Faso'),
(858, 'Eastern Republic of Uruguay', 'UY', 'URY', 'Uruguay'),
(860, 'Republic of Uzbekistan', 'UZ', 'UZB', 'Uzbekistan'),
(862, 'Bolivarian Republic of Venezuela', 'VE', 'VEN', 'Venezuela, Bolivarian Republic of'),
(876, 'Wallis and Futuna', 'WF', 'WLF', 'Wallis and Futuna'),
(882, 'Independent State of Samoa', 'WS', 'WSM', 'Samoa'),
(887, 'Republic of Yemen', 'YE', 'YEM', 'Yemen'),
(894, 'Republic of Zambia', 'ZM', 'ZMB', 'Zambia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_courier_com`
--

CREATE TABLE `cdb_courier_com` (
  `id` int(10) NOT NULL,
  `name_com` varchar(100) DEFAULT NULL,
  `address_cou` varchar(120) DEFAULT NULL,
  `phone_cou` varchar(20) DEFAULT NULL,
  `country_cou` varchar(100) DEFAULT NULL,
  `city_cou` varchar(100) DEFAULT NULL,
  `postal_cou` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_courier_com`
--

INSERT INTO `cdb_courier_com` (`id`, `name_com`, `address_cou`, `phone_cou`, `country_cou`, `city_cou`, `postal_cou`) VALUES
(83, 'USPS / international mail', 'WASHINGTON DC', '+1-800-275-8777', 'U.S', 'WASHINGTON DC', '5781'),
(78, 'FedEx', 'Renaissance Center 1715 Aaron Brenner Drive Suite 600 Memphis,', '1.866.393.4585', 'UNITED STATES', 'Memphis', '38120'),
(85, 'DHL/Airborne', 'WASHINGTON DC', '1-800-225-5345', 'UNITED STATES', 'WASHINGTON DC', '38120'),
(86, 'TNT', 'WASHINGTON DC', '800-003-3339', 'UNITED STATES', 'WASHINGTON DC', '38120'),
(87, 'UPS', 'WASHINGTON DC', '01 8000 120 920', 'UNITED STATES', 'MIAMI', '38120'),
(88, 'ROYAL MAIL', '100 Victoria Embankment London EC4Y 0HQ', '34758598', 'REINO UNIDO', 'LONDRES', '38120'),
(89, 'FedEx Freight', 'Renaissance Center 1715 Aaron Brenner Drive Suite 600 Memphis,', '1.866.393.4585', 'UNITED STATES', 'Memphis', '38120'),
(90, 'LaserShip', 'LaserShip Inc. 1912 Woodford Road Vienna, VA 22182 United States', '(804) 414-2590', 'UNITED STATES', 'New Jersey', '38120'),
(91, 'UPS Mail Innovations', 'WASHINGTON DC', '01 8000 120 920', 'UNITED STATES', 'MMIAMI', '38120'),
(92, 'China Post / international mail', 'No.3 Financial Street, Xicheng District, Beijing', '8610 4008909999', 'CHINA', 'Pekin', '100808');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_courier_track`
--

CREATE TABLE `cdb_courier_track` (
  `id` int(10) NOT NULL,
  `order_track` varchar(100) DEFAULT NULL,
  `t_dest` varchar(255) DEFAULT NULL,
  `t_city` varchar(250) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `t_date` datetime DEFAULT NULL,
  `status_courier` int(11) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_customers_packages`
--

CREATE TABLE `cdb_customers_packages` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_prefix` varchar(300) DEFAULT NULL,
  `order_no` varchar(350) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_address_id` int(11) DEFAULT NULL,
  `tax_value` float DEFAULT NULL,
  `tax_insurance_value` float DEFAULT NULL,
  `tax_custom_tariffis_value` float DEFAULT NULL,
  `value_weight` float DEFAULT NULL,
  `declared_value` float NOT NULL,
  `volumetric_percentage` varchar(300) DEFAULT NULL,
  `total_weight` float DEFAULT NULL,
  `sub_total` float DEFAULT NULL,
  `tax_discount` float DEFAULT NULL,
  `total_tax_insurance` float DEFAULT NULL,
  `total_tax_custom_tariffis` float DEFAULT NULL,
  `total_tax` float DEFAULT NULL,
  `total_declared_value` float NOT NULL,
  `total_tax_discount` float DEFAULT NULL,
  `total_reexp` float DEFAULT NULL,
  `total_order` float DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `agency` int(11) DEFAULT NULL,
  `origin_off` int(11) DEFAULT NULL,
  `order_package` int(11) DEFAULT NULL,
  `order_courier` int(11) DEFAULT NULL,
  `order_service_options` int(11) DEFAULT NULL,
  `order_deli_time` int(11) DEFAULT NULL,
  `order_pay_mode` int(11) DEFAULT NULL,
  `order_payment_method` int(11) DEFAULT NULL,
  `status_courier` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `person_receives` varchar(300) DEFAULT NULL,
  `photo_delivered` varchar(300) DEFAULT NULL,
  `status_invoice` int(11) DEFAULT NULL,
  `tracking_purchase` varchar(300) DEFAULT NULL,
  `provider_purchase` varchar(300) DEFAULT NULL,
  `price_purchase` double(5,2) DEFAULT NULL,
  `url_payment_attach` varchar(300) DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `is_prealert` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_customers_packages_detail`
--

CREATE TABLE `cdb_customers_packages_detail` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_item_description` varchar(250) DEFAULT NULL,
  `order_item_category` int(11) DEFAULT NULL,
  `order_item_quantity` decimal(10,2) DEFAULT NULL,
  `order_item_weight` varchar(120) DEFAULT NULL,
  `order_item_length` varchar(120) DEFAULT NULL,
  `order_item_width` varchar(120) DEFAULT NULL,
  `order_item_height` varchar(120) DEFAULT NULL,
  `order_item_declared_value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_delivery_time`
--

CREATE TABLE `cdb_delivery_time` (
  `id` int(11) NOT NULL,
  `delitime` varchar(200) DEFAULT NULL,
  `detail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_delivery_time`
--

INSERT INTO `cdb_delivery_time` (`id`, `delitime`, `detail`) VALUES
(1, '1 - 2 Days', 'Delivery time from 1 to 2 days'),
(2, '1 - 3 Days', 'Delivery time from 1 to 3 days'),
(3, '1 - 4 Days', 'Delivery time from 1 to 4 days'),
(4, '1 - 5 Days', 'Delivery time from 1 to 5 days'),
(5, '1 - 6 Days', 'Delivery time from 1 to 6 days'),
(6, '1 - 7 Days', 'Delivery time from 1 to 7 days'),
(7, '1  Week', 'Delivery time from 1 week'),
(8, '2 Week', 'Delivery time from 2 week'),
(9, '3 Week', 'Delivery time from 3 week'),
(10, '1 Month', 'Delivery time from 1 month'),
(11, '2 Month', 'Delivery time from 2 month');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_email_templates`
--

CREATE TABLE `cdb_email_templates` (
  `id` int(5) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `help` text DEFAULT NULL,
  `body` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cdb_email_templates`
--

INSERT INTO `cdb_email_templates` (`id`, `name`, `subject`, `help`, `body`) VALUES
(1, 'New consolidate notification', 'Consolidate', 'This template is used to notify the shipment of consolidated.', '                                                                                                           \r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\n¡Sending a consolidate to you!\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n         \r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Shipping date: <b>[DELIVERY_TIME]</b>\r\n                                                                <br><br>\r\n                                                                Follow up on your consolidate by entering the following link and you will have detailed information on the status of your shipments. <br>\r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see consolidate tracking</a>\r\n                \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n                   '),
(2, 'I forgot my email password', 'Password Reset', 'This template is used to recover lost user password.', '                                             \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><br><br><br>\r\n                Thanks,<br>\r\n               [SITE_NAME] Team,<br><a href=\"[URL]\">[URL]</a><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hi!\r\n             </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             <strong>[USERNAME]</strong>\r\n           </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               You\'re now a member of [SITE_NAME].\r\n                <br>\r\n                It seems that you or someone requested a new password for you.\r\n                We have generated a new password, as requested:\r\n               <br><br>\r\n                Your new password: <b>[PASSWORD]</b>\r\n                <br><br>\r\n                To use the new password you need to activate it. To do this click the link provided below and login with your new password.\r\n               <br><br>\r\n                <a href=\"[LINK]\">[LINK]</a><br>\r\n               <br><br>\r\n                You can change your password after you sign in.<hr>\r\n               Password requested from IP: [IP]</td>\r\n               \r\n                \r\n              \r\n            </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                To reply to this message you can simply reply this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                          '),
(3, 'Welcome Mail From Admin', 'You have been registered', 'This template is used to send welcome email, when user is added by administrator', '                                              &lt;!doctype html&gt;\r\n&lt;html&gt;\r\n\r\n&lt;head&gt;\r\n&lt;link href=&#039;https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600&#039; rel=&#039;stylesheet&#039; type=&#039;text/css&#039;&gt;\r\n&lt;/head&gt;\r\n\r\n&lt;body style=&#039;margin: 0; padding: 20px; font-family: Montserrat, Arial, sans serif; font-size: 12px;font-weight:400;word-break: break-word;color:#555;line-height: 18px;&#039;&gt;\r\n  &lt;table border=&#039;0&#039; cellpadding=&#039;0&#039; cellspacing=&#039;0&#039; width=&#039;100%&#039;&gt;\r\n   &lt;table align=&#039;center&#039; border=&#039;0&#039; cellpadding=&#039;0&#039; cellspacing=&#039;0&#039; width=&#039;100%&#039; style=&#039;max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;&#039;&gt; \r\n\r\n      &lt;tr bgcolor=&#039;#f62d51&#039; height=&#039;5px&#039;&gt;\r\n       &lt;td align=&#039;center&#039; style=&#039;font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;&#039;&gt;\r\n       &lt;/td&gt;\r\n     &lt;/tr&gt;\r\n     &lt;tr bgcolor=&#039;#f9f9f9&#039;&gt;\r\n        &lt;td style=&#039;padding:40px;&#039;&gt;\r\n          &lt;table border=&#039;0&#039; cellpadding=&#039;0&#039; cellspacing=&#039;0&#039; width=&#039;100%&#039;&gt;\r\n           &lt;tr&gt;&lt;td&gt;&lt;img src=&quot;[URL]/assets/uploads/logo.png&quot; class=&quot;logo&quot;/&gt;&lt;/td&gt;&lt;/tr&gt;\r\n           &lt;br&gt;&lt;br&gt;\r\n            &lt;tr height=&#039;30&#039;&gt;&lt;/tr&gt;\r\n           &lt;tr&gt;\r\n              &lt;td style=&#039;font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:17px; font-weight:400;&#039;&gt;\r\n              Hi! [NAME]!, Welcome You have been Registered\r\n             &lt;/td&gt;\r\n           &lt;/tr&gt;\r\n           &lt;tr height=&#039;15&#039;&gt;&lt;/tr&gt;\r\n           &lt;td style=&#039;font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;&#039;&gt;\r\n             You&#039;re now a member of [SITE_NAME].\r\n            &lt;/td&gt;\r\n           &lt;tr height=&#039;30&#039;&gt;&lt;/tr&gt;\r\n           &lt;tr&gt;\r\n              &lt;td style=&quot;margin: 40px 0;line-height: 22px; font-family: &#039;Montserrat&#039;, Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;&quot;&gt;\r\n               Here are your login details. Please keep them in a safe place:\r\n                &lt;br&gt;&lt;br&gt;\r\n                Username: &lt;b&gt;[USERNAME]&lt;/b&gt;\r\n               &lt;br&gt;\r\n                Password: &lt;b&gt;[PASSWORD]&lt;/b&gt;               \r\n                &lt;br&gt;&lt;br&gt;&lt;br&gt;\r\n                Thanks,&lt;br&gt;\r\n               [SITE_NAME] Team,&lt;br&gt;\r\n               &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\r\n             &lt;/td&gt;\r\n           &lt;/tr&gt;\r\n           &lt;tr height=&#039;50&#039;&gt;&lt;/tr&gt;\r\n           &lt;tr&gt;\r\n              &lt;td style=&#039;margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;&#039;&gt;\r\n                To reply to this message you can simply reply this email.\r\n             &lt;/td&gt;\r\n           &lt;/tr&gt;\r\n         &lt;/table&gt;\r\n        &lt;/td&gt;\r\n     &lt;/tr&gt;\r\n   &lt;/table&gt; \r\n &lt;/table&gt;\r\n&lt;/body&gt;\r\n&lt;/html&gt;                                          '),
(4, 'Default mail', 'Newsletter', 'This is a default newsletter template.', '                                             &lt;link href=&quot;https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot;&gt; &lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;   &lt;/table&gt;&lt;table align=&quot;center&quot; border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot; style=&quot;max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;&quot;&gt;       &lt;tbody&gt;&lt;tr bgcolor=&quot;#f62d51&quot; height=&quot;5px&quot;&gt;        &lt;td align=&quot;center&quot; style=&quot;font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;&quot;&gt;       &lt;/td&gt;     &lt;/tr&gt;     &lt;tr bgcolor=&quot;#f9f9f9&quot;&gt;        &lt;td style=&quot;padding:40px;&quot;&gt;          &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;           &lt;tbody&gt;&lt;tr&gt;&lt;td&gt;&lt;img src=&quot;[URL]/assets/uploads/logo.png&quot; class=&quot;logo&quot;&gt;&lt;/td&gt;&lt;/tr&gt;                       &lt;tr height=&quot;15&quot;&gt;&lt;/tr&gt;           &lt;tr&gt;              &lt;td style=&quot;font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;&quot;&gt;              Hello! [NAME]!              &lt;/td&gt;           &lt;/tr&gt;           &lt;tr height=&quot;30&quot;&gt;&lt;/tr&gt;           &lt;tr&gt;              &lt;td style=&quot;margin: 40px 0;line-height: 22px; font-family: &#039;Montserrat&#039;, Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;&quot;&gt;               You are now a member of [SITE_NAME].                                &lt;br&gt;&lt;br&gt;                  You are receiving this email as part of your newsletter subscription.                 &lt;hr&gt;                  Here is the content of your newsletter                  &lt;hr&gt;                &lt;br&gt;&lt;br&gt;&lt;br&gt;                Thank you,&lt;br&gt;                [SITE_NAME] Team,&lt;br&gt;               &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/td&gt;                          &lt;/tr&gt;           &lt;tr height=&quot;50&quot;&gt;&lt;/tr&gt;           &lt;tr&gt;              &lt;td style=&quot;margin: 40px 0px; line-height: 22px; word-break: break-word; padding-top: 10px; border-top: 1px solid rgb(226, 226, 226);&quot;&gt;&lt;font face=&quot;Montserrat, Arial, sans serif&quot;&gt;&lt;span style=&quot;font-size: 11px;&quot;&gt;&lt;i&gt;To stop receiving future newsletters, log in to your account and uncheck the newsletter subscription box.&lt;/i&gt;&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;br&gt;&lt;font face=&quot;Montserrat, Arial, sans serif&quot;&gt;&lt;span style=&quot;font-size: 12px;&quot;&gt;To reply to this message, you can simply reply to this email.&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;/td&gt;            &lt;/tr&gt;         &lt;/tbody&gt;&lt;/table&gt;        &lt;/td&gt;     &lt;/tr&gt;   &lt;/tbody&gt;&lt;/table&gt;                                                                      '),
(7, 'Welcome customer registration', 'Thank you for signing up for Deprixa Pro', 'This template is used to welcome newly registered user when Configuration->Registration Verification and Configuration->Auto Registration are both set to YES', '                                                                                                                                                                               <table style=\"font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; justify-content: center;align-items: center;font-weight: 600; max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n <tbody>\r\n   <tr>\r\n      <td class=\"m_-8364453557841243647logo\">\r\n       <a href=\"https://colbox.online\">\r\n          <img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\">\r\n       </a>          \r\n      </td>\r\n   </tr>\r\n   <tr>\r\n      <td>\r\n        <table border=\"0\" width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\r\n         <tbody>\r\n           <tr>\r\n              <td style=\"height:5px;width:100%;background:#ff636f\"></td>\r\n            </tr>\r\n         </tbody>\r\n        </table>\r\n      </td>\r\n   </tr>\r\n   <tr style=\"background:#f9f9f9\">\r\n     <td class=\"m_-8364453557841243647container-padding\" bgcolor=\"#fff\" style=\"background-color:#fff;padding-left:30px;padding-right:30px\">\r\n        <br><br>\r\n        <p>\r\n         [NAME]! Thanks for registering. \r\n        </p>\r\n\r\n        <p>\r\n         Great news! Your account has been activated and you can start shopping online using your US shipping address.\r\n       </p>\r\n\r\n        <table class=\"m_-8364453557841243647table\">\r\n         <tbody>\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">\r\n                You are now a member of [SITE_NAME].\r\n                <br>\r\n                Here are your login details. Keep them in a safe place:\r\n               <br><br>\r\n                Username: <b>[USERNAME]</b>\r\n               <br>\r\n                Password: <b>[PASSWORD]</b>\r\n               <br><br><br>\r\n              </td>\r\n             \r\n            </tr>\r\n         </tbody>\r\n        </table>\r\n\r\n        <p>Locker Address:</p>\r\n        \r\n        <table class=\"m_-8364453557841243647table\">\r\n         <tbody>\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\"> Full name:</td>\r\n              <td><strong>[NAME]</strong></td>\r\n            </tr>\r\n\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">Direction Line 1:</td>\r\n              <td><strong>[VIRTUAL_LOCKER]</strong></td>\r\n            </tr>\r\n\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">Address line 2:</td>\r\n              <td><strong>[LOCKER]</strong></td>\r\n            </tr>\r\n\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">City:</td>\r\n              <td><strong>[CCOUNTRY]</strong></td>\r\n            </tr>\r\n\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">State:</td>\r\n             <td><strong>[CCITY]</strong></td>\r\n           </tr>\r\n\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">CP:</td>\r\n              <td><strong>[CPOSTAL]</strong></td>\r\n           </tr>\r\n\r\n           <tr>\r\n              <td class=\"m_-8364453557841243647first\">Phone:</td>\r\n             <td><strong>[CPHONE]</strong></td>\r\n            </tr>\r\n         </tbody>\r\n        </table>\r\n\r\n        <p>\r\n         \"Line 2\" of your address is the part that identifies you, and it is very important to include it when you add your shipping address in online stores.\r\n       </p>\r\n\r\n        <p>When your packages arrive at the warehouse, we will notify you and you can see them in your locker.<br></p>\r\n\r\n\r\n        <p>\r\n         <a style=\"background: #ff636f;border-radius: 100px;line-height: 1;border-style: none;display: inline-block;font-size: 16px;padding: 13px 22px 12px;text-decoration: none;color: white;outline: none;\" href=\"[URL]\">\r\n         Access your <span class=\"il\">locker</span> →\r\n        </a></p>\r\n\r\n        <p>\r\n         If you have any questions, just reply to this email. We are here to help you!\r\n       </p>\r\n\r\n        <p>\r\n         Best regards,<br> [SITE_NAME] Team.</p>\r\n     </td>\r\n        </tr>\r\n        <tr>\r\n          <td>\r\n            <table border=\"0\" width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\r\n              <tbody><tr>\r\n     <td style=\"height:2px;width:100%;background:#ff636f\"></td>\r\n              </tr>\r\n            </tbody></table>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"center\" style=\"padding:30px;text-align:center\">\r\n            <a style=\"font-size:18px;color:#ff636f;text-decoration:none\" href=\"[URL]\">[URL]</a> - Service at your door\r\n          </td>\r\n        </tr>\r\n    </tbody>\r\n</table>                                                                                                                                                                                '),
(10, 'Updated shipment tracking', 'Updated shipment tracking', 'This template is used to update the shipment.', '                                                                                                                                                                                 \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\nwe have updated the status of your shipment.\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               \r\nshipment has been updated. [NAME].\r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                New status: <b>[COURIER] </b>\r\n                                                                <br>\r\n                                                                New address: <b>[NEW_ADDRESS]</b>\r\n                                                                <br>\r\n                                                                Comments: <b>[COMMENT]</b>\r\n                                                                <br>\r\n                                                                Update date: <b>[DELIVERY_TIME]</b>\r\n               <br><br>\r\nFollow up on your shipment by entering the following link and you will have detailed information on the status of your shipments.               \r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see shipment tracking.</a>\r\n                \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                                                  '),
(20, 'New pre alert notification', 'Pre alert', 'This template is used to notify the pre alert of packages online.', '                                                                                                                \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\n¡Sending a pre alert to you!\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n         \r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Shipping date: <b>[DELIVERY_TIME]</b>\r\n                                                                <br><br>\r\n                                                                Please verify your pre alert and in this way send the package to the address mentioned\r\n\r\n               <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see package pre alert</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                      '),
(12, 'Single Email', 'Single User Email', 'This template is used to email single user', '<!doctype html>\r\n<html>\r\n\r\n<head>\r\n<link href=\'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\' rel=\'stylesheet\' type=\'text/css\'>\r\n</head>\r\n\r\n<body style=\'margin: 0; padding: 20px; font-family: Montserrat, Arial, sans serif; font-size: 12px;font-weight:400;word-break: break-word;color:#555;line-height: 18px;\'>\r\n <table border=\'0\' cellpadding=\'0\' cellspacing=\'0\' width=\'100%\'>\r\n   <table align=\'center\' border=\'0\' cellpadding=\'0\' cellspacing=\'0\' width=\'100%\' style=\'max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\'> \r\n\r\n      <tr bgcolor=\'#f62d51\' height=\'5px\'>\r\n       <td align=\'center\' style=\'font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\'>\r\n\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\'#f9f9f9\'>\r\n        <td style=\'padding:40px;\'>\r\n          <table border=\'0\' cellpadding=\'0\' cellspacing=\'0\' width=\'100%\'>\r\n           <tr><td><img src=\"assets/uploads/logo.png\" class=\"logo\"/></td></tr>\r\n           <br><br><br>\r\n            <tr height=\'15\'></tr>\r\n           <tr>\r\n              <td style=\'font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\'>\r\n              Hello [NAME]\r\n              </td>\r\n           </tr>\r\n           <tr height=\'30\'></tr>\r\n           <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               <br><br>\r\n                  Your message goes here...         \r\n                  \r\n                <br><br>\r\n                <span style=\'color:#846add;\'>Thanks,</span><br><br>\r\n               <span>\r\n                [SITE_NAME] Team\r\n                </span>\r\n             </td>\r\n           </tr>\r\n           <tr height=\'50\'></tr>\r\n           <tr>\r\n              <td style=\'margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\'>\r\n                To reply to this message you can simply reply this email.\r\n             </td>\r\n           </tr>\r\n         </table>\r\n        </td>\r\n     </tr>\r\n   </table> \r\n </table>\r\n</body>\r\n</html>'),
(13, 'Administrator Notification', 'New User Registration', 'This template is used to notify the administrator of the new record when Configuration- &amp; gt; Registration notification is set to YES New User Registration', '                                              \n\n\n\n&lt;link href=&quot;https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot;&gt;\n\n\n\n &lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;\n   &lt;/table&gt;&lt;table align=&quot;center&quot; border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot; style=&quot;max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;&quot;&gt; \n\n      &lt;tbody&gt;&lt;tr bgcolor=&quot;#6610f2&quot; height=&quot;5px&quot;&gt;\n        &lt;td align=&quot;center&quot; style=&quot;font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;&quot;&gt;\n       &lt;/td&gt;\n     &lt;/tr&gt;\n     &lt;tr bgcolor=&quot;#f9f9f9&quot;&gt;\n        &lt;td style=&quot;padding:40px;&quot;&gt;\n          &lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;\n           &lt;tbody&gt;&lt;tr&gt;\n             &lt;td style=&quot;font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;&quot;&gt;\n              Hello!\n              &lt;/td&gt;\n           &lt;/tr&gt;\n           \n            &lt;tr&gt;&lt;td style=&quot;font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;&quot;&gt;\n             You have a new user registration. You can log in to your administration panel to see the details:\n           &lt;/td&gt;\n           &lt;/tr&gt;&lt;tr height=&quot;30&quot;&gt;&lt;/tr&gt;\n            &lt;tr&gt;\n              &lt;td style=&quot;margin: 40px 0;line-height: 22px; font-family: &#039;Montserrat&#039;, Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;&quot;&gt;\n               Username: &lt;b&gt;[USERNAME]&lt;/b&gt;\n               &lt;br&gt;\n                Name: &lt;b&gt;[NAME]&lt;/b&gt;\n               &lt;br&gt;Address IP:   &lt;b&gt;[IP]&lt;/b&gt;\n               &lt;br&gt;\n              &lt;/td&gt;\n           &lt;/tr&gt;\n         &lt;/tbody&gt;&lt;/table&gt;\n        &lt;/td&gt;\n     &lt;/tr&gt;\n   &lt;/tbody&gt;&lt;/table&gt; \n \n\n                                          '),
(14, 'Notification of delivery of consolidate', 'Delivered consolidate', 'This template is used to notify the delivery of consolidated.', '\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\nWe have delivered your package.\r\n           </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               \r\nThese are the data of your consolidate. [NAME].\r\n               <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Delivery status: <b><span style=\"background: #68c251;\" class=\"label label-large\"> [COURIER] </span></b>\r\n                                                                <br>\r\n                                                                Delivery date: <b>[DELIVERY_TIME]</b>\r\n                <br><br>\r\nFollow up on your consolidate by entering the following link and you will have detailed information on the status of your consolidate.                \r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see consolidate tracking.</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n\r\n                                                                                                     '),
(19, 'Updated consolidate tracking', 'Updated consolidate tracking', 'This template is used to update the consolidate.', '                                                                                                                                                                                                        \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\nwe have updated the status of your consolidate.\r\n           </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               \r\nconsolidate has been updated. [NAME].\r\n               <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                New status: <b>[COURIER] </b>\r\n                                                                <br>\r\n                                                                New address: <b>[NEW_ADDRESS]</b>\r\n                                                                <br>\r\n                                                                Comments: <b>[COMMENT]</b>\r\n                                                                <br>\r\n                                                                Update date: <b>[DELIVERY_TIME]</b>\r\n               <br><br>\r\nFollow up on your consolidate by entering the following link and you will have detailed information on the status of your consolidate.                \r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see consolidate tracking.</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                                                                      '),
(16, 'New shipment notification', 'Shipment notification', 'This template is used to notify customers of the shipment.', '                                                                                                                \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\n¡Sending a package to you!\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n         \r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Shipping date: <b>[DELIVERY_TIME]</b>\r\n                                                                <br><br>\r\n                                                                Follow up on your shipment by entering the following link and you will have detailed information on the status of your shipments. <br>\r\n               <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see shipment tracking</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                      '),
(17, 'Account activation', 'Your account has been activated', 'This template is used to notify the user when manual account activation is complete.', '                                                                                                                                                               \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#36bea6\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/uploads/logo.png\" class=\"logo\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello, [NAME]!\r\n              </td>\r\n           </tr>\r\n           <tr height=\"30\"></tr>\r\n           <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               You are now a member of [SITE_NAME].\r\n                <br><br>\r\n                Your account is now fully activated, and you can log in to\r\n                <br><br>\r\n                <a href=\"[URL]\">[URL]</a>\r\n               <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] work team,<br>\r\n                <a href=\"[URL]\">[URL]</a></td>\r\n              \r\n            </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                                  ');
INSERT INTO `cdb_email_templates` (`id`, `name`, `subject`, `help`, `body`) VALUES
(18, 'Notification of delivery of shipments', 'Shipment has been delivered', 'This form is used for the delivery of shipments', '                                                                                                                                                           \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\nWe have delivered your package.\r\n           </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               \r\nThese are the data of your shipment. [NAME].\r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Delivery status: <b><span style=\"background: #68c251;\" class=\"label label-large\"> [COURIER] </span></b>\r\n                                                                <br>\r\n                                                                Delivery date: <b>[DELIVERY_TIME]</b>\r\n                <br><br>\r\nFollow up on your shipment by entering the following link and you will have detailed information on the status of your shipments.               \r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see shipment tracking.</a>\r\n                \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                              '),
(21, 'New package notification', 'Package notification', 'This template is used to notify customers of the package.', '                                                                                                                                     \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\n¡Sending a package to you!\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n         \r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Shipping date: <b>[DELIVERY_TIME]</b>\r\n                                                                <br><br>\r\n                                                                Please make the payment of the shipment, once your payment is confirmed, the shipment tracking begins.\r\n\r\n\r\n                             <br> <br>\r\n\r\n                            Follow up on your package by entering the following link and you will have detailed information on the status of your packages. <br><br>\r\n               <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see package tracking</a>\r\n                \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                          '),
(22, 'Updated package tracking', 'Updated package tracking', 'This template is used to update package.', '                                                                                                                                                                                                                              \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\nwe have updated the status of your package.\r\n           </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               \r\npackage has been updated. [NAME].\r\n               <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                New status: <b>[COURIER] </b>\r\n                                                                <br>\r\n                                                                New address: <b>[NEW_ADDRESS]</b>\r\n                                                                <br>\r\n                                                                Comments: <b>[COMMENT]</b>\r\n                                                                <br>\r\n                                                                Update date: <b>[DELIVERY_TIME]</b>\r\n               <br><br>\r\nFollow up on your package by entering the following link and you will have detailed information on the status of your packages.               \r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see package tracking.</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                                                                                          '),
(23, 'Notification of delivery of package', 'Package has been delivered', 'This form is used for the delivery of package', '                                                                                                                                                                                  \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\nWe have delivered your package.\r\n           </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n               \r\nThese are the data of your package. [NAME].\r\n               <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Delivery status: <b><span style=\"background: #68c251;\" class=\"label label-large\"> [COURIER] </span></b>\r\n                                                                <br>\r\n                                                                Delivery date: <b>[DELIVERY_TIME]</b>\r\n                <br><br>\r\nFollow up on your package by entering the following link and you will have detailed information on the status of your package.                \r\n                <br><br>\r\n                <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see package tracking.</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                                                  '),
(24, 'New shipment (pickup) customer notification', 'pickup customer notification', 'This template is used to notify customers of the pickup.', '                                                                                                                                                           \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\n¡Sending a shipment pickup to you!\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n         \r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Shipping date: <b>[DELIVERY_TIME]</b>\r\n                                                                <br><br>\r\n                                                               \r\n\r\n                            Notification of shipment collection was sent, verify your dashboard or pick-up lists and approval for the complete shipment to the destination.. <br><br>\r\n               <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see pickup tracking</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                              '),
(25, 'New shipment (pick up) created by the admin notifications', 'pickup admin notification', 'This template is used to notify customer of the pickup, created admin.', '                                                                                                                                                            \r\n\r\n\r\n\r\n<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600\" rel=\"stylesheet\" type=\"text/css\">\r\n\r\n\r\n\r\n <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n   </table><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;\"> \r\n\r\n      <tbody><tr bgcolor=\"#f62d51\" height=\"5px\">\r\n        <td align=\"center\" style=\"font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;\">\r\n       </td>\r\n     </tr>\r\n     <tr bgcolor=\"#f9f9f9\">\r\n        <td style=\"padding:40px;\">\r\n          <br><br><br><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n           <tbody><tr><td><img src=\"[URL]/assets/[URL_LINK]\" width=\"190\" height=\"39\"></td></tr>\r\n            \r\n            <tr height=\"15\"></tr>\r\n           <tr>\r\n              <td style=\"font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;\">\r\n              Hello!\r\n              </td>\r\n           </tr>\r\n           <tr><td style=\"font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;\">\r\n             [NAME], \r\n¡Sending a shipment pickup to you!\r\n            </td>\r\n           </tr><tr height=\"30\"></tr>\r\n            <tr>\r\n              <td style=\"margin: 40px 0;line-height: 22px; font-family: \'Montserrat\', Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;\">\r\n         \r\n                <br><br>\r\n                Tracking number: <b>[TRACKING]</b>\r\n                <br>\r\n                Shipping date: <b>[DELIVERY_TIME]</b>\r\n                                                                <br><br>\r\n                                                               \r\n\r\n                            Notification of shipment collection was sent, verify your dashboard or pick-up lists and approval for the complete shipment to the destination.. <br><br>\r\n               <br><br>\r\n                <a href=\"[URL_SHIP]\">Click to see pickup tracking</a>\r\n               \r\n                <br><br><br>\r\n                Thank you,<br>\r\n                [SITE_NAME] Team,<br>\r\n               <a href=\"[URL]\">[URL]</a>\r\n             </td>\r\n           </tr>\r\n           <tr height=\"50\"></tr>\r\n           <tr>\r\n              <td style=\"margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;\">\r\n                \r\nTo reply to this message, you can simply reply to this email.\r\n             </td>\r\n           </tr>\r\n         </tbody></table>\r\n        </td>\r\n     </tr>\r\n   </tbody></table> \r\n \r\n\r\n                                                                                                                                              '),
(26, 'Registration user ', 'Registration user ', 'This template is used to email single user', '&lt;link href=&quot;https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot;&gt; &lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;   &lt;/table&gt;&lt;table align=&quot;center&quot; border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot; style=&quot;max-width:500px; margin:40px auto;border-collapse: collapse;border-radius: 2px;overflow: hidden;&quot;&gt;       &lt;tbody&gt;&lt;tr bgcolor=&quot;#f62d51&quot; height=&quot;5px&quot;&gt;        &lt;td align=&quot;center&quot; style=&quot;font-family: Montserrat, Arial, sans serif; color: #fff;text-transform: uppercase;font-size: 20px;justify-content: center;align-items: center;letter-spacing: 4px;font-weight: 600;&quot;&gt;       &lt;/td&gt;     &lt;/tr&gt;     &lt;tr bgcolor=&quot;#f9f9f9&quot;&gt;        &lt;td style=&quot;padding:40px;&quot;&gt;          &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;           &lt;tbody&gt;&lt;tr&gt;&lt;td&gt;&lt;img src=&quot;[URL]/assets/uploads/logo.png&quot; class=&quot;logo&quot;&gt;&lt;/td&gt;&lt;/tr&gt;                       &lt;tr&gt;              &lt;td style=&quot;font-family: Montserrat, Arial, sans serif; margin:0; color:#846add; font-size:20px; font-weight:400;&quot;&gt;              Hi!             &lt;/td&gt;           &lt;/tr&gt;           &lt;tr&gt;&lt;td style=&quot;font-family: Montserrat, Arial, sans serif; margin:5px 0 0; font-size: 12px; font-weight:400;word-break: break-word;color:#333;line-height: 22px; position: relative; top: 10px;&quot;&gt;             [NAME]! Thanks for registering.           &lt;/td&gt;           &lt;/tr&gt;&lt;tr height=&quot;30&quot;&gt;&lt;/tr&gt;            &lt;tr&gt;              &lt;td style=&quot;margin: 40px 0;line-height: 22px; font-family: &#039;Montserrat&#039;, Arial, sans serif; font-size: 12px;font-weight:100; word-break: break-word; color:#333;&quot;&gt;               You&#039;re now a member of [SITE_NAME].                &lt;br&gt;                Here are your login details. Please keep them in a safe place:                &lt;br&gt;&lt;br&gt;                Username: &lt;b&gt;[USERNAME]&lt;/b&gt;               &lt;br&gt;                Password: &lt;b&gt;[PASSWORD]&lt;/b&gt;                                                                &lt;br&gt;                                                                Locker: &lt;b&gt;[LOCKER]&lt;/b&gt;                &lt;br&gt;&lt;br&gt;                  The administrator of this site has requested all new accounts                 to be activated by the users who created them thus your account                 is currently inactive. To activate your account,                  please visit the link below and enter the following:                &lt;br&gt;&lt;br&gt;                &lt;span style=&quot;color:#846add;&quot;&gt;Activate Information:&lt;/span&gt;&lt;br&gt;&lt;br&gt;               &lt;span&gt;                                &lt;br&gt;                Email: [EMAIL]            &lt;/span&gt;               &lt;br&gt;&lt;br&gt;&lt;br&gt;                Thanks,&lt;br&gt;               [SITE_NAME] Team,&lt;br&gt;               &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/td&gt;                          &lt;/tr&gt;           &lt;tr height=&quot;50&quot;&gt;&lt;/tr&gt;           &lt;tr&gt;              &lt;td style=&quot;margin:40px 0; line-height: 22px; font-family: Montserrat, Arial, sans serif; font-size: 12px; font-weight:400; word-break: break-word; color:#333; padding-top: 10px; border-top: 1px solid #e2e2e2;&quot;&gt;                To reply to this message you can simply reply this email.             &lt;/td&gt;           &lt;/tr&gt;         &lt;/tbody&gt;&lt;/table&gt;        &lt;/td&gt;     &lt;/tr&gt;   &lt;/tbody&gt;&lt;/table&gt;                        ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_incoterm`
--

CREATE TABLE `cdb_incoterm` (
  `id` int(11) NOT NULL,
  `inco_name` varchar(200) DEFAULT NULL,
  `detail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_incoterm`
--

INSERT INTO `cdb_incoterm` (`id`, `inco_name`, `detail`) VALUES
(1, 'EXW', 'EXW - ExWorks'),
(2, 'FCA', 'FCA - Free Carrier'),
(3, 'FAS', 'FAS - Free Alongside Ship'),
(4, 'FOB', 'FOB - Free On Board'),
(5, 'CFR', 'CFR - Cost and Freight'),
(6, 'CIF', 'CIF - Cost, Insurance, Freight'),
(7, 'CIP', 'CIP - Carriage and Insurance Paid'),
(8, 'CPT', 'CPT - Carriage Paid To'),
(9, 'DAF', 'DAF - Delivered At Frontier'),
(10, 'DES', 'DES - Delivered Ex Ship'),
(11, 'DEQ', 'DEQ - Delivered Ex Quay'),
(12, 'DDU', 'DDU - Delivered Duty Unpaid'),
(13, 'DDP', 'DDP - Delivered Duty Paid'),
(14, 'DAT', 'DAT – Delivered at Terminal (named terminal at port or place of destination)'),
(15, 'DAP', 'DAP - Delivered At Place (named place of destination)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_met_payment`
--

CREATE TABLE `cdb_met_payment` (
  `id` int(11) NOT NULL,
  `met_payment` varchar(200) DEFAULT NULL,
  `detail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_met_payment`
--

INSERT INTO `cdb_met_payment` (`id`, `met_payment`, `detail`) VALUES
(1, 'Cash', 'Cash Payment'),
(2, 'Credit Card', 'Payment with Credit Card'),
(5, 'Wire Transfer', 'Payment with Wire transfer'),
(6, 'Paypal', 'Paypal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_news`
--

CREATE TABLE `cdb_news` (
  `id` int(11) NOT NULL,
  `title` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `author` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cdb_news`
--

INSERT INTO `cdb_news` (`id`, `title`, `body`, `author`, `created`, `active`) VALUES
(6, 'Welcome to our Client Area!', '&lt;p&gt;We are pleased to announce the new release DEPRIXA PRO v6.3.4.2&lt;br&gt;&lt;/p&gt;', 'Administrator', '2021-09-17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_notifications`
--

CREATE TABLE `cdb_notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `notification_description` varchar(350) DEFAULT NULL,
  `shipping_type` int(11) DEFAULT NULL,
  `notification_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_notifications_users`
--

CREATE TABLE `cdb_notifications_users` (
  `id_notifi_user` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `notification_read` tinyint(1) DEFAULT 0,
  `notification_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_offices`
--

CREATE TABLE `cdb_offices` (
  `id` int(10) NOT NULL,
  `name_off` varchar(100) DEFAULT NULL,
  `code_off` varchar(60) DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone_off` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_offices`
--

INSERT INTO `cdb_offices` (`id`, `name_off`, `code_off`, `address`, `city`, `phone_off`) VALUES
(83, 'Miami Lakes FL 33053', 'AG1560', 'NW 169th Ter Miami Lakes', 'Miami Fl', '4362574357'),
(78, 'Miami Beach FL 33141', 'AG1598', 'Water Way avenue at 45', 'Miami Fl', '1234576878'),
(82, 'Miami Garden FL 33054', 'AG1599', '15401 NW 18th Ave ?garden', 'Miami Fl', '55215');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_order_files`
--

CREATE TABLE `cdb_order_files` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `date_file` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_consolidate` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_order_user_history`
--

CREATE TABLE `cdb_order_user_history` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `action` varchar(500) DEFAULT NULL,
  `date_history` datetime DEFAULT NULL,
  `is_consolidate` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_packaging`
--

CREATE TABLE `cdb_packaging` (
  `id` int(5) NOT NULL,
  `name_pack` varchar(120) DEFAULT NULL,
  `detail_pack` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_packaging`
--

INSERT INTO `cdb_packaging` (`id`, `name_pack`, `detail_pack`) VALUES
(12, 'Paperboard boxes', 'Paperboard is a paper-based material that is lightweight, yet strong.'),
(13, 'Corrugated boxes', 'Corrugated boxes simply refer to what is commonly known as: Cardboard....'),
(14, 'Plastic boxes', 'Corrugated boxes simply refer to what is commonly known as: Cardboard.Plastic is used in a wide range of products, from spaceships to paper clips.'),
(15, 'Rigid boxes', 'A rigid box is made out of highly condensed paperboard that is 4 times thicker than the paperboard used in the construction of a standard folding carton.'),
(16, 'Chipboard packaging', 'Chipboard packaging is used in industries such as electronic, medical, food, cosmetic, and beverage.'),
(17, 'Poly bags', 'A poly bag, also known as a pouch or a plastic bag, is manufactured out of flexible, thin, plastic film fabric.'),
(18, 'Foil sealed bags', 'Foil sealed bags can be seen typically in most coffee and tea packaging.'),
(20, 'Container', 'Foil sealed bags can be seen typically in most coffee and tea packaging.'),
(21, 'Pallets', 'Foil sealed bags can be seen typically in most coffee and tea packaging.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_payments_gateway`
--

CREATE TABLE `cdb_payments_gateway` (
  `id` int(11) NOT NULL,
  `order_track` varchar(300) DEFAULT NULL,
  `order_track_customer_id` int(11) DEFAULT NULL,
  `gateway` varchar(300) DEFAULT NULL,
  `payment_transaction` varchar(300) DEFAULT NULL,
  `amount` double(5,2) DEFAULT NULL,
  `status` varchar(300) DEFAULT NULL,
  `type_transaccition_courier` varchar(300) DEFAULT NULL,
  `currency` varchar(300) DEFAULT NULL,
  `date_payment` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_payment_methods`
--

CREATE TABLE `cdb_payment_methods` (
  `id` int(11) NOT NULL,
  `label` varchar(200) DEFAULT NULL,
  `days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cdb_payment_methods`
--

INSERT INTO `cdb_payment_methods` (`id`, `label`, `days`) VALUES
(1, 'Cash', 0),
(3, '15 day credit', 15),
(4, '5 day credit', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_pre_alert`
--

CREATE TABLE `cdb_pre_alert` (
  `pre_alert_id` int(11) NOT NULL,
  `tracking` varchar(200) DEFAULT NULL,
  `provider_shop` varchar(200) DEFAULT NULL,
  `courier_com` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `purchase_price` double(5,2) DEFAULT NULL,
  `package_description` mediumtext DEFAULT NULL,
  `estimated_date` date DEFAULT NULL,
  `prealert_date` datetime DEFAULT NULL,
  `url_invoice` varchar(300) DEFAULT NULL,
  `is_package` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_settings`
--

CREATE TABLE `cdb_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(50) DEFAULT NULL,
  `c_nit` varchar(30) DEFAULT NULL,
  `c_phone` varchar(30) DEFAULT NULL,
  `cell_phone` varchar(30) DEFAULT NULL,
  `c_address` varchar(60) DEFAULT NULL,
  `locker_address` text DEFAULT NULL,
  `c_country` varchar(60) DEFAULT NULL,
  `c_city` varchar(60) DEFAULT NULL,
  `c_postal` varchar(30) DEFAULT NULL,
  `site_email` varchar(40) DEFAULT NULL,
  `mailer` enum('PHP','SMTP') DEFAULT 'PHP',
  `smtp_names` varchar(120) DEFAULT NULL,
  `email_address` varchar(120) DEFAULT NULL,
  `smtp_host` varchar(120) DEFAULT NULL,
  `smtp_user` varchar(120) DEFAULT NULL,
  `smtp_password` varchar(60) DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT NULL,
  `smtp_secure` varchar(10) DEFAULT NULL,
  `interms` text DEFAULT NULL,
  `signing_customer` varchar(60) DEFAULT NULL,
  `signing_company` varchar(60) DEFAULT NULL,
  `site_url` varchar(200) DEFAULT NULL,
  `paypal_client_id` varchar(250) DEFAULT NULL,
  `public_key_stripe` varchar(300) DEFAULT NULL,
  `secret_key_stripe` varchar(300) DEFAULT NULL,
  `public_key_paystack` varchar(500) DEFAULT NULL,
  `secret_key_paystack` varchar(500) DEFAULT NULL,
  `active_paypal` tinyint(4) DEFAULT NULL,
  `active_paystack` tinyint(4) DEFAULT NULL,
  `active_stripe` tinyint(4) DEFAULT NULL,
  `active_attach_proof` tinyint(4) DEFAULT NULL,
  `active_whatsapp` tinyint(4) DEFAULT NULL,
  `twilio_sid` varchar(500) DEFAULT NULL,
  `twilio_token` varchar(500) DEFAULT NULL,
  `twilio_number` varchar(500) DEFAULT NULL,
  `thumb_w` varchar(4) DEFAULT NULL,
  `thumb_h` varchar(4) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `favicon` varchar(500) DEFAULT NULL,
  `backup` varchar(600) DEFAULT NULL,
  `version` varchar(5) DEFAULT NULL,
  `prefix` varchar(6) DEFAULT NULL,
  `track_digit` varchar(15) DEFAULT NULL,
  `prefix_con` varchar(6) DEFAULT NULL,
  `track_container` varchar(12) DEFAULT NULL,
  `prefix_consolidate` varchar(6) DEFAULT NULL,
  `track_consolidate` varchar(12) DEFAULT NULL,
  `track_online_shopping` varchar(20) DEFAULT NULL,
  `prefix_online_shopping` varchar(20) DEFAULT NULL,
  `tax` varchar(4) DEFAULT NULL,
  `insurance` varchar(4) DEFAULT NULL,
  `value_weight` varchar(16) DEFAULT NULL,
  `meter` varchar(16) DEFAULT NULL,
  `c_tariffs` varchar(4) DEFAULT NULL,
  `currency` varchar(120) DEFAULT NULL,
  `timezone` varchar(120) DEFAULT NULL,
  `language` varchar(120) DEFAULT NULL,
  `min_cost_tax` float(5,2) DEFAULT NULL,
  `notify_admin` varchar(200) DEFAULT NULL,
  `user_limit` varchar(200) DEFAULT NULL,
  `reg_allowed` varchar(200) DEFAULT NULL,
  `auto_verify` varchar(200) DEFAULT NULL,
  `reg_verify` varchar(200) DEFAULT NULL,
  `user_perpage` varchar(200) DEFAULT NULL,
  `declared_tax` float NOT NULL,
  `min_cost_declared_tax` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cdb_settings`
--

INSERT INTO `cdb_settings` (`id`, `site_name`, `c_nit`, `c_phone`, `cell_phone`, `c_address`, `locker_address`, `c_country`, `c_city`, `c_postal`, `site_email`, `mailer`, `smtp_names`, `email_address`, `smtp_host`, `smtp_user`, `smtp_password`, `smtp_port`, `smtp_secure`, `interms`, `signing_customer`, `signing_company`, `site_url`, `paypal_client_id`, `public_key_stripe`, `secret_key_stripe`, `public_key_paystack`, `secret_key_paystack`, `active_paypal`, `active_paystack`, `active_stripe`, `active_attach_proof`, `active_whatsapp`, `twilio_sid`, `twilio_token`, `twilio_number`, `thumb_w`, `thumb_h`, `logo`, `favicon`, `backup`, `version`, `prefix`, `track_digit`, `prefix_con`, `track_container`, `prefix_consolidate`, `track_consolidate`, `track_online_shopping`, `prefix_online_shopping`, `tax`, `insurance`, `value_weight`, `meter`, `c_tariffs`, `currency`, `timezone`, `language`, `min_cost_tax`, `notify_admin`, `user_limit`, `reg_allowed`, `auto_verify`, `reg_verify`, `user_perpage`, `declared_tax`, `min_cost_declared_tax`) VALUES
(1, 'DEPRIXA PRO', '800124570-87', '3193196868', '3193196868', '7801 NW 37th St. Doral – FL 33195 - 6503', '7801 NW 37th St. Doral – FL 33195 - 6503', 'Miami', 'FL', '43364457', 'info@mydomain.com', 'PHP', 'DEPRIXA PRO', 'info@mydomain.com', 'smtp.mydomain.com', 'info@mydomain.com', '1234567890', '587', 'TLS', 'ACCEPTED: This Invoice is a title value in accordance with the provisions of art. 3 of law 1231 of July 17/08. The signature by third parties in representation, mandate or other quality on behalf of the buyer implies its obligation in accordance with art. 640 of the commercial code.', 'SIGNATURE / SEAL WHO RECEIVES', 'COMPANY SIGNATURE', 'https://deprixapro.com/demo-deprixa/', 'AYeLzTfPgZm4bT0MjSecdWrnR6c1jDXXyEiVet7jmVhWiZv97ZjMD9_6HAlzrYcK3OVcru0Fnzekja1Z', 'pk_test_51IV5pmETH4GffSNmtwF5zWEewcFT1U9qbrQyQmRKU62HquQjAC6F4d2YvOtaiRgkHfXbhZhB1woXb2vM04KifRZe00fF3O00G8', 'sk_test_51IV5pmETH4GffSNmyHjgO3SgYvR9bt6RBEKlqtDE36jUcaCT246lyY9qvOyixUdrkbe3jlTgeH6AghEdX32jeQUX00OhKNNdj8', 'pk_test_96c0f6fad9d8acbf95e9fd2c3801912bcbe0e893', 'sk_test_3302ed6590018993efb9270c45ba41474c8c521c', 1, 1, 1, 1, 0, 'ACa2757cca6391b071738a2731b0f2016b', 'd59dea6d7d6fd8b8d257060898f8b7e8', '+14155238886', '200', '200', 'uploads/1625682660_logo.png', 'uploads/1625682660_favicon.png', 'backup_14-Apr-2021_20-41-37.sql', '3.2.7', 'AWB', '6', NULL, NULL, 'COEE', '6', '6', 'CPI', '17', '16', '3.50', '5000', '2.1', 'USD', 'America/Chicago', 'en', 86.00, '1', '1', '1', '1', '0', '', 15, 88);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_shipping_line`
--

CREATE TABLE `cdb_shipping_line` (
  `id` int(11) NOT NULL,
  `ship_line` varchar(200) DEFAULT NULL,
  `detail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_shipping_line`
--

INSERT INTO `cdb_shipping_line` (`id`, `ship_line`, `detail`) VALUES
(1, 'Atlantic Container Line', 'Freight forwarding - Atlantic Container Line'),
(2, 'American President Lines', 'Freight forwarding - American President Lines (APL)'),
(3, 'Atlantic Ro-Ro Carriers', 'Atlantic Ro-Ro Carriers'),
(4, 'China Shipping', 'Freight forwarding - China Shipping'),
(5, 'CMA CGM', 'Freight forwarding - CMA CGM Group'),
(6, 'Evergreen Marine Corp.', 'Freight forwarding - Evergreen Marine Corp (EMC)'),
(7, 'Fesco Transportation Group', 'FESCO Transportation Group'),
(8, 'Hanjin Shipping', 'Hanjin Shipping - Container Carrier'),
(9, 'Hamburg Süd Group', 'Hamburg Süd Group - Ocean Freight'),
(10, 'Hapag Lloyd', 'Freight forwarding - Hapag-Lloyd'),
(11, 'Maersk Sealand', 'Freight forwarding - Maersk Line'),
(12, 'MSC Mediterranean Shipping Company', 'Freight forwarding - Mediterranean Shipping Company'),
(13, 'OOCL Logistics', 'OOCL Vessel &amp; Rail Tracking'),
(14, 'Safmarine', 'Safmarine Container Lines'),
(15, 'Zim Integrated Shipping Services', 'Freight forwarding - ZIM Integrated Shipping Services'),
(16, 'Wallenius Lines', 'Freight forwarding - Wallenius Logistics');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_shipping_mode`
--

CREATE TABLE `cdb_shipping_mode` (
  `id` int(11) NOT NULL,
  `ship_mode` varchar(200) DEFAULT NULL,
  `detail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_shipping_mode`
--

INSERT INTO `cdb_shipping_mode` (`id`, `ship_mode`, `detail`) VALUES
(1, 'Priority Mail Express', 'Priority Mail Express'),
(2, 'Priority Mail', 'Priority Mail ExpressPriority Mail'),
(3, 'Priority MailFirst-Class Mail', 'First-Class Mail'),
(4, 'International Economy', 'International Economy'),
(5, 'International Priority', 'International Priority'),
(6, 'Express Domestic', 'Express Domestic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_styles`
--

CREATE TABLE `cdb_styles` (
  `id` int(11) NOT NULL,
  `mod_style` varchar(200) DEFAULT NULL,
  `detail` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cdb_styles`
--

INSERT INTO `cdb_styles` (`id`, `mod_style`, `detail`, `color`) VALUES
(1, 'Pending Collection', 'Pending Collection', '#a3a3a3'),
(2, 'Received Office', 'Received Office', '#36bea6'),
(3, 'In Transit', 'In Transit', '#00e39a'),
(4, 'In Warehouse', 'In Warehouse', '#e0ce07'),
(5, 'Distribution', 'Distribution', '#cd88ee'),
(6, 'Available', 'Available (only when you must retire at the offices)', '#0ae4ff'),
(7, 'On Route', 'En route for delivery (only when it\'s door to door)', '#7460ee'),
(8, 'Delivered', 'Deliveries delivered', '#43bd00'),
(10, 'Approved', 'Reserve Approved', '#ffa6a6'),
(11, 'Pending', 'Pending', '#ffbc34'),
(12, 'Rejected', 'Booking Online Canceled', '#fb8c00'),
(13, 'Consolidate', 'Consolidated Shipments', '#00ffbb'),
(14, 'Pick up', 'Pick up package', '#2962FF'),
(15, 'Picked up', 'Picked up package', '#00adf2'),
(16, 'No Picked up', 'Not picked up package', '#ff008c'),
(17, 'Quotation', 'Quotation List', '#00ffc4'),
(18, 'Pending quote', 'Pending quote', '#68c251'),
(19, 'Invoiced', 'Quotation approved quotation', '#1ac9d9'),
(21, 'Cancelled', 'cancelled', '#f62d51'),
(23, 'Pending payment', 'pending payment', '#ffbc34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_users`
--

CREATE TABLE `cdb_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name_off` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `locker` varchar(255) DEFAULT NULL,
  `userlevel` tinyint(1) UNSIGNED DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `avatar` varchar(350) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `lastip` varchar(16) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `enrollment` varchar(20) DEFAULT NULL,
  `vehiclecode` varchar(20) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT 0,
  `terms` varchar(120) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `create_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cdb_users`
--

INSERT INTO `cdb_users` (`id`, `username`, `name_off`, `password`, `locker`, `userlevel`, `email`, `fname`, `lname`, `avatar`, `ip`, `created`, `lastlogin`, `lastip`, `notes`, `phone`, `enrollment`, `vehiclecode`, `gender`, `newsletter`, `terms`, `active`, `create_user`) VALUES
(1, 'admin', 'OFFICE 1', '$2y$10$kZYl081blosadis1wluyoOkZ9.ef3zEOxr0jDLHRANHjh4OA6o58q', '', 9, 'deprixapro@gmail.com', 'JOHAN', 'OSORIO', 'uploads/AVT_9E93B4-A5CA6C-21F30E-9FAFD7-E13FBD-96C1E0.png', '', '2019-01-01 01:11:46', '2021-09-22 18:04:03', '181.136.209.170', 'Deprixa pro', '+573116149087', '', '', 'Male', 1, '', 1, 0),
(2, 'driver', 'OFFICE 1', '$2y$10$XTXeZ1oGH0FmrncbpaW9/eH.QhaCTvxFZv8gPlL22PXd3KiTGY4Me', '', 3, 'driver@demo.com', 'JOSE', 'JOSE', 'uploads/AVT_9E93B4-A5CA6C-21F30E-9FAFD7-E13FBD-96C1E0.png', '', '2019-01-04 21:12:00', '2021-05-26 09:06:43', '219.91.230.1', 'nones', '+13053046677', 'MNW952', '81', 'Male', 0, '', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_users_multiple_addresses`
--

CREATE TABLE `cdb_users_multiple_addresses` (
  `id_addresses` int(11) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `country` varchar(300) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `zip_code` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cdb_users_multiple_addresses`
--

INSERT INTO `cdb_users_multiple_addresses` (`id_addresses`, `address`, `country`, `city`, `zip_code`, `user_id`) VALUES
(1, 'direccion vnzla', 'venezuela', 'caracas', '3201', 4),
(2, 'direccion', 'Venezuela', 'd', '3201', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cdb_zone`
--

CREATE TABLE `cdb_zone` (
  `zone_id` int(10) NOT NULL,
  `country_code` char(2) COLLATE utf8_bin NOT NULL,
  `zone_name` varchar(35) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cdb_zone`
--

INSERT INTO `cdb_zone` (`zone_id`, `country_code`, `zone_name`) VALUES
(1, 'AD', 'Europe/Andorra'),
(2, 'AE', 'Asia/Dubai'),
(3, 'AF', 'Asia/Kabul'),
(4, 'AG', 'America/Antigua'),
(5, 'AI', 'America/Anguilla'),
(6, 'AL', 'Europe/Tirane'),
(7, 'AM', 'Asia/Yerevan'),
(8, 'AO', 'Africa/Luanda'),
(9, 'AQ', 'Antarctica/McMurdo'),
(10, 'AQ', 'Antarctica/Casey'),
(11, 'AQ', 'Antarctica/Davis'),
(12, 'AQ', 'Antarctica/DumontDUrville'),
(13, 'AQ', 'Antarctica/Mawson'),
(14, 'AQ', 'Antarctica/Palmer'),
(15, 'AQ', 'Antarctica/Rothera'),
(16, 'AQ', 'Antarctica/Syowa'),
(17, 'AQ', 'Antarctica/Troll'),
(18, 'AQ', 'Antarctica/Vostok'),
(19, 'AR', 'America/Argentina/Buenos_Aires'),
(20, 'AR', 'America/Argentina/Cordoba'),
(21, 'AR', 'America/Argentina/Salta'),
(22, 'AR', 'America/Argentina/Jujuy'),
(23, 'AR', 'America/Argentina/Tucuman'),
(24, 'AR', 'America/Argentina/Catamarca'),
(25, 'AR', 'America/Argentina/La_Rioja'),
(26, 'AR', 'America/Argentina/San_Juan'),
(27, 'AR', 'America/Argentina/Mendoza'),
(28, 'AR', 'America/Argentina/San_Luis'),
(29, 'AR', 'America/Argentina/Rio_Gallegos'),
(30, 'AR', 'America/Argentina/Ushuaia'),
(31, 'AS', 'Pacific/Pago_Pago'),
(32, 'AT', 'Europe/Vienna'),
(33, 'AU', 'Australia/Lord_Howe'),
(34, 'AU', 'Antarctica/Macquarie'),
(35, 'AU', 'Australia/Hobart'),
(36, 'AU', 'Australia/Currie'),
(37, 'AU', 'Australia/Melbourne'),
(38, 'AU', 'Australia/Sydney'),
(39, 'AU', 'Australia/Broken_Hill'),
(40, 'AU', 'Australia/Brisbane'),
(41, 'AU', 'Australia/Lindeman'),
(42, 'AU', 'Australia/Adelaide'),
(43, 'AU', 'Australia/Darwin'),
(44, 'AU', 'Australia/Perth'),
(45, 'AU', 'Australia/Eucla'),
(46, 'AW', 'America/Aruba'),
(47, 'AX', 'Europe/Mariehamn'),
(48, 'AZ', 'Asia/Baku'),
(49, 'BA', 'Europe/Sarajevo'),
(50, 'BB', 'America/Barbados'),
(51, 'BD', 'Asia/Dhaka'),
(52, 'BE', 'Europe/Brussels'),
(53, 'BF', 'Africa/Ouagadougou'),
(54, 'BG', 'Europe/Sofia'),
(55, 'BH', 'Asia/Bahrain'),
(56, 'BI', 'Africa/Bujumbura'),
(57, 'BJ', 'Africa/Porto-Novo'),
(58, 'BL', 'America/St_Barthelemy'),
(59, 'BM', 'Atlantic/Bermuda'),
(60, 'BN', 'Asia/Brunei'),
(61, 'BO', 'America/La_Paz'),
(62, 'BQ', 'America/Kralendijk'),
(63, 'BR', 'America/Noronha'),
(64, 'BR', 'America/Belem'),
(65, 'BR', 'America/Fortaleza'),
(66, 'BR', 'America/Recife'),
(67, 'BR', 'America/Araguaina'),
(68, 'BR', 'America/Maceio'),
(69, 'BR', 'America/Bahia'),
(70, 'BR', 'America/Sao_Paulo'),
(71, 'BR', 'America/Campo_Grande'),
(72, 'BR', 'America/Cuiaba'),
(73, 'BR', 'America/Santarem'),
(74, 'BR', 'America/Porto_Velho'),
(75, 'BR', 'America/Boa_Vista'),
(76, 'BR', 'America/Manaus'),
(77, 'BR', 'America/Eirunepe'),
(78, 'BR', 'America/Rio_Branco'),
(79, 'BS', 'America/Nassau'),
(80, 'BT', 'Asia/Thimphu'),
(81, 'BW', 'Africa/Gaborone'),
(82, 'BY', 'Europe/Minsk'),
(83, 'BZ', 'America/Belize'),
(84, 'CA', 'America/St_Johns'),
(85, 'CA', 'America/Halifax'),
(86, 'CA', 'America/Glace_Bay'),
(87, 'CA', 'America/Moncton'),
(88, 'CA', 'America/Goose_Bay'),
(89, 'CA', 'America/Blanc-Sablon'),
(90, 'CA', 'America/Toronto'),
(91, 'CA', 'America/Nipigon'),
(92, 'CA', 'America/Thunder_Bay'),
(93, 'CA', 'America/Iqaluit'),
(94, 'CA', 'America/Pangnirtung'),
(95, 'CA', 'America/Atikokan'),
(96, 'CA', 'America/Winnipeg'),
(97, 'CA', 'America/Rainy_River'),
(98, 'CA', 'America/Resolute'),
(99, 'CA', 'America/Rankin_Inlet'),
(100, 'CA', 'America/Regina'),
(101, 'CA', 'America/Swift_Current'),
(102, 'CA', 'America/Edmonton'),
(103, 'CA', 'America/Cambridge_Bay'),
(104, 'CA', 'America/Yellowknife'),
(105, 'CA', 'America/Inuvik'),
(106, 'CA', 'America/Creston'),
(107, 'CA', 'America/Dawson_Creek'),
(108, 'CA', 'America/Fort_Nelson'),
(109, 'CA', 'America/Vancouver'),
(110, 'CA', 'America/Whitehorse'),
(111, 'CA', 'America/Dawson'),
(112, 'CC', 'Indian/Cocos'),
(113, 'CD', 'Africa/Kinshasa'),
(114, 'CD', 'Africa/Lubumbashi'),
(115, 'CF', 'Africa/Bangui'),
(116, 'CG', 'Africa/Brazzaville'),
(117, 'CH', 'Europe/Zurich'),
(118, 'CI', 'Africa/Abidjan'),
(119, 'CK', 'Pacific/Rarotonga'),
(120, 'CL', 'America/Santiago'),
(121, 'CL', 'America/Punta_Arenas'),
(122, 'CL', 'Pacific/Easter'),
(123, 'CM', 'Africa/Douala'),
(124, 'CN', 'Asia/Shanghai'),
(125, 'CN', 'Asia/Urumqi'),
(126, 'CO', 'America/Bogota'),
(127, 'CR', 'America/Costa_Rica'),
(128, 'CU', 'America/Havana'),
(129, 'CV', 'Atlantic/Cape_Verde'),
(130, 'CW', 'America/Curacao'),
(131, 'CX', 'Indian/Christmas'),
(132, 'CY', 'Asia/Nicosia'),
(133, 'CY', 'Asia/Famagusta'),
(134, 'CZ', 'Europe/Prague'),
(135, 'DE', 'Europe/Berlin'),
(136, 'DE', 'Europe/Busingen'),
(137, 'DJ', 'Africa/Djibouti'),
(138, 'DK', 'Europe/Copenhagen'),
(139, 'DM', 'America/Dominica'),
(140, 'DO', 'America/Santo_Domingo'),
(141, 'DZ', 'Africa/Algiers'),
(142, 'EC', 'America/Guayaquil'),
(143, 'EC', 'Pacific/Galapagos'),
(144, 'EE', 'Europe/Tallinn'),
(145, 'EG', 'Africa/Cairo'),
(146, 'EH', 'Africa/El_Aaiun'),
(147, 'ER', 'Africa/Asmara'),
(148, 'ES', 'Europe/Madrid'),
(149, 'ES', 'Africa/Ceuta'),
(150, 'ES', 'Atlantic/Canary'),
(151, 'ET', 'Africa/Addis_Ababa'),
(152, 'FI', 'Europe/Helsinki'),
(153, 'FJ', 'Pacific/Fiji'),
(154, 'FK', 'Atlantic/Stanley'),
(155, 'FM', 'Pacific/Chuuk'),
(156, 'FM', 'Pacific/Pohnpei'),
(157, 'FM', 'Pacific/Kosrae'),
(158, 'FO', 'Atlantic/Faroe'),
(159, 'FR', 'Europe/Paris'),
(160, 'GA', 'Africa/Libreville'),
(161, 'GB', 'Europe/London'),
(162, 'GD', 'America/Grenada'),
(163, 'GE', 'Asia/Tbilisi'),
(164, 'GF', 'America/Cayenne'),
(165, 'GG', 'Europe/Guernsey'),
(166, 'GH', 'Africa/Accra'),
(167, 'GI', 'Europe/Gibraltar'),
(168, 'GL', 'America/Godthab'),
(169, 'GL', 'America/Danmarkshavn'),
(170, 'GL', 'America/Scoresbysund'),
(171, 'GL', 'America/Thule'),
(172, 'GM', 'Africa/Banjul'),
(173, 'GN', 'Africa/Conakry'),
(174, 'GP', 'America/Guadeloupe'),
(175, 'GQ', 'Africa/Malabo'),
(176, 'GR', 'Europe/Athens'),
(177, 'GS', 'Atlantic/South_Georgia'),
(178, 'GT', 'America/Guatemala'),
(179, 'GU', 'Pacific/Guam'),
(180, 'GW', 'Africa/Bissau'),
(181, 'GY', 'America/Guyana'),
(182, 'HK', 'Asia/Hong_Kong'),
(183, 'HN', 'America/Tegucigalpa'),
(184, 'HR', 'Europe/Zagreb'),
(185, 'HT', 'America/Port-au-Prince'),
(186, 'HU', 'Europe/Budapest'),
(187, 'ID', 'Asia/Jakarta'),
(188, 'ID', 'Asia/Pontianak'),
(189, 'ID', 'Asia/Makassar'),
(190, 'ID', 'Asia/Jayapura'),
(191, 'IE', 'Europe/Dublin'),
(192, 'IL', 'Asia/Jerusalem'),
(193, 'IM', 'Europe/Isle_of_Man'),
(194, 'IN', 'Asia/Kolkata'),
(195, 'IO', 'Indian/Chagos'),
(196, 'IQ', 'Asia/Baghdad'),
(197, 'IR', 'Asia/Tehran'),
(198, 'IS', 'Atlantic/Reykjavik'),
(199, 'IT', 'Europe/Rome'),
(200, 'JE', 'Europe/Jersey'),
(201, 'JM', 'America/Jamaica'),
(202, 'JO', 'Asia/Amman'),
(203, 'JP', 'Asia/Tokyo'),
(204, 'KE', 'Africa/Nairobi'),
(205, 'KG', 'Asia/Bishkek'),
(206, 'KH', 'Asia/Phnom_Penh'),
(207, 'KI', 'Pacific/Tarawa'),
(208, 'KI', 'Pacific/Enderbury'),
(209, 'KI', 'Pacific/Kiritimati'),
(210, 'KM', 'Indian/Comoro'),
(211, 'KN', 'America/St_Kitts'),
(212, 'KP', 'Asia/Pyongyang'),
(213, 'KR', 'Asia/Seoul'),
(214, 'KW', 'Asia/Kuwait'),
(215, 'KY', 'America/Cayman'),
(216, 'KZ', 'Asia/Almaty'),
(217, 'KZ', 'Asia/Qyzylorda'),
(218, 'KZ', 'Asia/Aqtobe'),
(219, 'KZ', 'Asia/Aqtau'),
(220, 'KZ', 'Asia/Atyrau'),
(221, 'KZ', 'Asia/Oral'),
(222, 'LA', 'Asia/Vientiane'),
(223, 'LB', 'Asia/Beirut'),
(224, 'LC', 'America/St_Lucia'),
(225, 'LI', 'Europe/Vaduz'),
(226, 'LK', 'Asia/Colombo'),
(227, 'LR', 'Africa/Monrovia'),
(228, 'LS', 'Africa/Maseru'),
(229, 'LT', 'Europe/Vilnius'),
(230, 'LU', 'Europe/Luxembourg'),
(231, 'LV', 'Europe/Riga'),
(232, 'LY', 'Africa/Tripoli'),
(233, 'MA', 'Africa/Casablanca'),
(234, 'MC', 'Europe/Monaco'),
(235, 'MD', 'Europe/Chisinau'),
(236, 'ME', 'Europe/Podgorica'),
(237, 'MF', 'America/Marigot'),
(238, 'MG', 'Indian/Antananarivo'),
(239, 'MH', 'Pacific/Majuro'),
(240, 'MH', 'Pacific/Kwajalein'),
(241, 'MK', 'Europe/Skopje'),
(242, 'ML', 'Africa/Bamako'),
(243, 'MM', 'Asia/Yangon'),
(244, 'MN', 'Asia/Ulaanbaatar'),
(245, 'MN', 'Asia/Hovd'),
(246, 'MN', 'Asia/Choibalsan'),
(247, 'MO', 'Asia/Macau'),
(248, 'MP', 'Pacific/Saipan'),
(249, 'MQ', 'America/Martinique'),
(250, 'MR', 'Africa/Nouakchott'),
(251, 'MS', 'America/Montserrat'),
(252, 'MT', 'Europe/Malta'),
(253, 'MU', 'Indian/Mauritius'),
(254, 'MV', 'Indian/Maldives'),
(255, 'MW', 'Africa/Blantyre'),
(256, 'MX', 'America/Mexico_City'),
(257, 'MX', 'America/Cancun'),
(258, 'MX', 'America/Merida'),
(259, 'MX', 'America/Monterrey'),
(260, 'MX', 'America/Matamoros'),
(261, 'MX', 'America/Mazatlan'),
(262, 'MX', 'America/Chihuahua'),
(263, 'MX', 'America/Ojinaga'),
(264, 'MX', 'America/Hermosillo'),
(265, 'MX', 'America/Tijuana'),
(266, 'MX', 'America/Bahia_Banderas'),
(267, 'MY', 'Asia/Kuala_Lumpur'),
(268, 'MY', 'Asia/Kuching'),
(269, 'MZ', 'Africa/Maputo'),
(270, 'NA', 'Africa/Windhoek'),
(271, 'NC', 'Pacific/Noumea'),
(272, 'NE', 'Africa/Niamey'),
(273, 'NF', 'Pacific/Norfolk'),
(274, 'NG', 'Africa/Lagos'),
(275, 'NI', 'America/Managua'),
(276, 'NL', 'Europe/Amsterdam'),
(277, 'NO', 'Europe/Oslo'),
(278, 'NP', 'Asia/Kathmandu'),
(279, 'NR', 'Pacific/Nauru'),
(280, 'NU', 'Pacific/Niue'),
(281, 'NZ', 'Pacific/Auckland'),
(282, 'NZ', 'Pacific/Chatham'),
(283, 'OM', 'Asia/Muscat'),
(284, 'PA', 'America/Panama'),
(285, 'PE', 'America/Lima'),
(286, 'PF', 'Pacific/Tahiti'),
(287, 'PF', 'Pacific/Marquesas'),
(288, 'PF', 'Pacific/Gambier'),
(289, 'PG', 'Pacific/Port_Moresby'),
(290, 'PG', 'Pacific/Bougainville'),
(291, 'PH', 'Asia/Manila'),
(292, 'PK', 'Asia/Karachi'),
(293, 'PL', 'Europe/Warsaw'),
(294, 'PM', 'America/Miquelon'),
(295, 'PN', 'Pacific/Pitcairn'),
(296, 'PR', 'America/Puerto_Rico'),
(297, 'PS', 'Asia/Gaza'),
(298, 'PS', 'Asia/Hebron'),
(299, 'PT', 'Europe/Lisbon'),
(300, 'PT', 'Atlantic/Madeira'),
(301, 'PT', 'Atlantic/Azores'),
(302, 'PW', 'Pacific/Palau'),
(303, 'PY', 'America/Asuncion'),
(304, 'QA', 'Asia/Qatar'),
(305, 'RE', 'Indian/Reunion'),
(306, 'RO', 'Europe/Bucharest'),
(307, 'RS', 'Europe/Belgrade'),
(308, 'RU', 'Europe/Kaliningrad'),
(309, 'RU', 'Europe/Moscow'),
(310, 'RU', 'Europe/Simferopol'),
(311, 'RU', 'Europe/Volgograd'),
(312, 'RU', 'Europe/Kirov'),
(313, 'RU', 'Europe/Astrakhan'),
(314, 'RU', 'Europe/Saratov'),
(315, 'RU', 'Europe/Ulyanovsk'),
(316, 'RU', 'Europe/Samara'),
(317, 'RU', 'Asia/Yekaterinburg'),
(318, 'RU', 'Asia/Omsk'),
(319, 'RU', 'Asia/Novosibirsk'),
(320, 'RU', 'Asia/Barnaul'),
(321, 'RU', 'Asia/Tomsk'),
(322, 'RU', 'Asia/Novokuznetsk'),
(323, 'RU', 'Asia/Krasnoyarsk'),
(324, 'RU', 'Asia/Irkutsk'),
(325, 'RU', 'Asia/Chita'),
(326, 'RU', 'Asia/Yakutsk'),
(327, 'RU', 'Asia/Khandyga'),
(328, 'RU', 'Asia/Vladivostok'),
(329, 'RU', 'Asia/Ust-Nera'),
(330, 'RU', 'Asia/Magadan'),
(331, 'RU', 'Asia/Sakhalin'),
(332, 'RU', 'Asia/Srednekolymsk'),
(333, 'RU', 'Asia/Kamchatka'),
(334, 'RU', 'Asia/Anadyr'),
(335, 'RW', 'Africa/Kigali'),
(336, 'SA', 'Asia/Riyadh'),
(337, 'SB', 'Pacific/Guadalcanal'),
(338, 'SC', 'Indian/Mahe'),
(339, 'SD', 'Africa/Khartoum'),
(340, 'SE', 'Europe/Stockholm'),
(341, 'SG', 'Asia/Singapore'),
(342, 'SH', 'Atlantic/St_Helena'),
(343, 'SI', 'Europe/Ljubljana'),
(344, 'SJ', 'Arctic/Longyearbyen'),
(345, 'SK', 'Europe/Bratislava'),
(346, 'SL', 'Africa/Freetown'),
(347, 'SM', 'Europe/San_Marino'),
(348, 'SN', 'Africa/Dakar'),
(349, 'SO', 'Africa/Mogadishu'),
(350, 'SR', 'America/Paramaribo'),
(351, 'SS', 'Africa/Juba'),
(352, 'ST', 'Africa/Sao_Tome'),
(353, 'SV', 'America/El_Salvador'),
(354, 'SX', 'America/Lower_Princes'),
(355, 'SY', 'Asia/Damascus'),
(356, 'SZ', 'Africa/Mbabane'),
(357, 'TC', 'America/Grand_Turk'),
(358, 'TD', 'Africa/Ndjamena'),
(359, 'TF', 'Indian/Kerguelen'),
(360, 'TG', 'Africa/Lome'),
(361, 'TH', 'Asia/Bangkok'),
(362, 'TJ', 'Asia/Dushanbe'),
(363, 'TK', 'Pacific/Fakaofo'),
(364, 'TL', 'Asia/Dili'),
(365, 'TM', 'Asia/Ashgabat'),
(366, 'TN', 'Africa/Tunis'),
(367, 'TO', 'Pacific/Tongatapu'),
(368, 'TR', 'Europe/Istanbul'),
(369, 'TT', 'America/Port_of_Spain'),
(370, 'TV', 'Pacific/Funafuti'),
(371, 'TW', 'Asia/Taipei'),
(372, 'TZ', 'Africa/Dar_es_Salaam'),
(373, 'UA', 'Europe/Kiev'),
(374, 'UA', 'Europe/Uzhgorod'),
(375, 'UA', 'Europe/Zaporozhye'),
(376, 'UG', 'Africa/Kampala'),
(377, 'UM', 'Pacific/Midway'),
(378, 'UM', 'Pacific/Wake'),
(379, 'US', 'America/New_York'),
(380, 'US', 'America/Detroit'),
(381, 'US', 'America/Kentucky/Louisville'),
(382, 'US', 'America/Kentucky/Monticello'),
(383, 'US', 'America/Indiana/Indianapolis'),
(384, 'US', 'America/Indiana/Vincennes'),
(385, 'US', 'America/Indiana/Winamac'),
(386, 'US', 'America/Indiana/Marengo'),
(387, 'US', 'America/Indiana/Petersburg'),
(388, 'US', 'America/Indiana/Vevay'),
(389, 'US', 'America/Chicago'),
(390, 'US', 'America/Indiana/Tell_City'),
(391, 'US', 'America/Indiana/Knox'),
(392, 'US', 'America/Menominee'),
(393, 'US', 'America/North_Dakota/Center'),
(394, 'US', 'America/North_Dakota/New_Salem'),
(395, 'US', 'America/North_Dakota/Beulah'),
(396, 'US', 'America/Denver'),
(397, 'US', 'America/Boise'),
(398, 'US', 'America/Phoenix'),
(399, 'US', 'America/Los_Angeles'),
(400, 'US', 'America/Anchorage'),
(401, 'US', 'America/Juneau'),
(402, 'US', 'America/Sitka'),
(403, 'US', 'America/Metlakatla'),
(404, 'US', 'America/Yakutat'),
(405, 'US', 'America/Nome'),
(406, 'US', 'America/Adak'),
(407, 'US', 'Pacific/Honolulu'),
(408, 'UY', 'America/Montevideo'),
(409, 'UZ', 'Asia/Samarkand'),
(410, 'UZ', 'Asia/Tashkent'),
(411, 'VA', 'Europe/Vatican'),
(412, 'VC', 'America/St_Vincent'),
(413, 'VE', 'America/Caracas'),
(414, 'VG', 'America/Tortola'),
(415, 'VI', 'America/St_Thomas'),
(416, 'VN', 'Asia/Ho_Chi_Minh'),
(417, 'VU', 'Pacific/Efate'),
(418, 'WF', 'Pacific/Wallis'),
(419, 'WS', 'Pacific/Apia'),
(420, 'YE', 'Asia/Aden'),
(421, 'YT', 'Indian/Mayotte'),
(422, 'ZA', 'Africa/Johannesburg'),
(423, 'ZM', 'Africa/Lusaka'),
(424, 'ZW', 'Africa/Harare');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cdb_address_shipments`
--
ALTER TABLE `cdb_address_shipments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_add_order`
--
ALTER TABLE `cdb_add_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `cdb_add_order_item`
--
ALTER TABLE `cdb_add_order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indices de la tabla `cdb_branchoffices`
--
ALTER TABLE `cdb_branchoffices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_category`
--
ALTER TABLE `cdb_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_charges_order`
--
ALTER TABLE `cdb_charges_order`
  ADD PRIMARY KEY (`id_charge`);

--
-- Indices de la tabla `cdb_consolidate`
--
ALTER TABLE `cdb_consolidate`
  ADD PRIMARY KEY (`consolidate_id`);

--
-- Indices de la tabla `cdb_consolidate_detail`
--
ALTER TABLE `cdb_consolidate_detail`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indices de la tabla `cdb_countries`
--
ALTER TABLE `cdb_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_courier_com`
--
ALTER TABLE `cdb_courier_com`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_courier_track`
--
ALTER TABLE `cdb_courier_track`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_customers_packages`
--
ALTER TABLE `cdb_customers_packages`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `cdb_customers_packages_detail`
--
ALTER TABLE `cdb_customers_packages_detail`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indices de la tabla `cdb_delivery_time`
--
ALTER TABLE `cdb_delivery_time`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_email_templates`
--
ALTER TABLE `cdb_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_incoterm`
--
ALTER TABLE `cdb_incoterm`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_met_payment`
--
ALTER TABLE `cdb_met_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_news`
--
ALTER TABLE `cdb_news`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_notifications`
--
ALTER TABLE `cdb_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indices de la tabla `cdb_notifications_users`
--
ALTER TABLE `cdb_notifications_users`
  ADD PRIMARY KEY (`id_notifi_user`);

--
-- Indices de la tabla `cdb_offices`
--
ALTER TABLE `cdb_offices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_order_files`
--
ALTER TABLE `cdb_order_files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_order_user_history`
--
ALTER TABLE `cdb_order_user_history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indices de la tabla `cdb_packaging`
--
ALTER TABLE `cdb_packaging`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_payments_gateway`
--
ALTER TABLE `cdb_payments_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_payment_methods`
--
ALTER TABLE `cdb_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_pre_alert`
--
ALTER TABLE `cdb_pre_alert`
  ADD PRIMARY KEY (`pre_alert_id`);

--
-- Indices de la tabla `cdb_settings`
--
ALTER TABLE `cdb_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_shipping_line`
--
ALTER TABLE `cdb_shipping_line`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_shipping_mode`
--
ALTER TABLE `cdb_shipping_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_styles`
--
ALTER TABLE `cdb_styles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_users`
--
ALTER TABLE `cdb_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cdb_users_multiple_addresses`
--
ALTER TABLE `cdb_users_multiple_addresses`
  ADD PRIMARY KEY (`id_addresses`);

--
-- Indices de la tabla `cdb_zone`
--
ALTER TABLE `cdb_zone`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `idx_country_code` (`country_code`),
  ADD KEY `idx_zone_name` (`zone_name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cdb_address_shipments`
--
ALTER TABLE `cdb_address_shipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_add_order`
--
ALTER TABLE `cdb_add_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_add_order_item`
--
ALTER TABLE `cdb_add_order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_branchoffices`
--
ALTER TABLE `cdb_branchoffices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cdb_category`
--
ALTER TABLE `cdb_category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `cdb_charges_order`
--
ALTER TABLE `cdb_charges_order`
  MODIFY `id_charge` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_consolidate`
--
ALTER TABLE `cdb_consolidate`
  MODIFY `consolidate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_consolidate_detail`
--
ALTER TABLE `cdb_consolidate_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_courier_com`
--
ALTER TABLE `cdb_courier_com`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `cdb_courier_track`
--
ALTER TABLE `cdb_courier_track`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_customers_packages`
--
ALTER TABLE `cdb_customers_packages`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_customers_packages_detail`
--
ALTER TABLE `cdb_customers_packages_detail`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_delivery_time`
--
ALTER TABLE `cdb_delivery_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cdb_email_templates`
--
ALTER TABLE `cdb_email_templates`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `cdb_incoterm`
--
ALTER TABLE `cdb_incoterm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cdb_met_payment`
--
ALTER TABLE `cdb_met_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cdb_news`
--
ALTER TABLE `cdb_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cdb_notifications`
--
ALTER TABLE `cdb_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_notifications_users`
--
ALTER TABLE `cdb_notifications_users`
  MODIFY `id_notifi_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_offices`
--
ALTER TABLE `cdb_offices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `cdb_order_files`
--
ALTER TABLE `cdb_order_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_order_user_history`
--
ALTER TABLE `cdb_order_user_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_packaging`
--
ALTER TABLE `cdb_packaging`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cdb_payments_gateway`
--
ALTER TABLE `cdb_payments_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_payment_methods`
--
ALTER TABLE `cdb_payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cdb_pre_alert`
--
ALTER TABLE `cdb_pre_alert`
  MODIFY `pre_alert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cdb_settings`
--
ALTER TABLE `cdb_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cdb_shipping_line`
--
ALTER TABLE `cdb_shipping_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cdb_shipping_mode`
--
ALTER TABLE `cdb_shipping_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cdb_styles`
--
ALTER TABLE `cdb_styles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `cdb_users`
--
ALTER TABLE `cdb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cdb_users_multiple_addresses`
--
ALTER TABLE `cdb_users_multiple_addresses`
  MODIFY `id_addresses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cdb_zone`
--
ALTER TABLE `cdb_zone`
  MODIFY `zone_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
