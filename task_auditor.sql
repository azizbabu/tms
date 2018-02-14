-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2018 at 09:20 AM
-- Server version: 5.6.20
-- PHP Version: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `task_auditor`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievement_logs`
--

CREATE TABLE IF NOT EXISTS `achievement_logs` (
`id` int(10) unsigned NOT NULL,
  `todo_list_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `achievement` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `achievement_logs`
--

INSERT INTO `achievement_logs` (`id`, `todo_list_id`, `date`, `achievement`, `created_at`, `updated_at`) VALUES
(1, 12, '2017-12-30', 9.00, '2017-12-30 06:24:16', '2017-12-30 06:26:12'),
(2, 12, '2017-12-31', 10.00, '2017-12-31 10:58:21', '2017-12-31 10:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_year` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `title`, `description`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `established_year`, `address`, `city`, `state`, `zip`, `country`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Vero', 'Soluta expedita eius soluta ea dolores. Ipsum et dignissimos consectetur ipsum recusandae non. Necessitatibus omnis qui sed quo voluptas.', 'Floy Stroman', NULL, NULL, '1991-09-23', '30957 Lorenza Plaza\nNorth Alyson, WI 10243', 'South Prince', 'Delaware', '76487-8341', 'NG', NULL, 1, 0, '2017-09-23 05:03:54', '2017-09-23 05:03:54'),
(2, 2, 'Magni', 'Ea accusantium ea corporis et non velit similique sapiente. Omnis ut earum placeat magnam voluptatem quae maiores.', 'Dagmar Robel', NULL, NULL, '1997-09-23', '499 Rupert Rapids\nNorth Dulceburgh, RI 18167-2415', 'Leopoldoview', 'Georgia', '26931-8051', 'RS', NULL, 1, 0, '2017-09-23 05:04:15', '2017-09-23 05:04:15'),
(3, 3, 'Omnis', 'Quis pariatur quas accusantium quia facilis accusamus. Consectetur velit vero aut molestiae molestiae et vel. Ullam ullam deleniti velit quae expedita.', 'Eula Gulgowski', NULL, NULL, '1977-09-23', '833 Rempel Streets Apt. 319\nWest Berenice, WA 70430', 'Edwardborough', 'Pennsylvania', '85079', 'GL', NULL, 1, 0, '2017-09-23 05:04:15', '2017-09-23 05:04:15'),
(4, 4, 'Magnam', 'Debitis unde fuga rerum culpa ipsum. Vel sed molestiae rerum sed praesentium. Vitae sunt dolore alias sunt nihil qui.', 'Elnora Grant', NULL, NULL, '1977-09-23', '544 Hermann Island\nRaphaelbury, GA 91818', 'Clementineshire', 'Mississippi', '95852-2674', 'MY', NULL, 1, 0, '2017-09-23 05:04:16', '2017-09-23 05:04:16'),
(5, 5, 'Fugiat', 'Eveniet totam commodi ullam qui. Fugiat molestiae voluptatibus velit porro numquam.', 'Donato Hilpert', NULL, NULL, '1980-09-23', '238 Kelsie Coves\nXandertown, TN 46434-7297', 'Boscoside', 'Missouri', '91025', 'RU', NULL, 1, 0, '2017-09-23 05:04:16', '2017-09-23 05:04:16'),
(6, 6, 'Laboriosam', 'Nihil doloribus dolores impedit iure et. Similique sint dolor molestias. Ratione qui inventore asperiores est qui.', 'Lulu Larkin', NULL, NULL, '1995-09-23', '9059 Wyman Rest\nMurrayburgh, MS 33336-4124', 'Elainaland', 'Iowa', '23403', 'EE', NULL, 1, 0, '2017-09-23 05:04:17', '2017-09-23 05:04:17'),
(7, 7, 'Dolore', 'Aperiam atque et numquam dolores inventore dolorem et. Qui praesentium doloribus et non. Dolorem quo aut dolorem ea.', 'Hester Fritsch', NULL, NULL, '1993-09-23', '327 Stark Fields\nKemmermouth, MA 93890', 'Julienfurt', 'Oregon', '84101', 'MS', NULL, 1, 0, '2017-09-23 05:04:17', '2017-09-23 05:04:17'),
(8, 8, 'Expedita', 'Impedit ut sit est consequatur dolor quam. Aut minima ducimus saepe dicta impedit quis provident. Porro dolore possimus repudiandae ipsa pariatur.', 'Prof. Logan Krajcik Jr.', NULL, NULL, '1987-09-23', '8824 Jairo Park\nSatterfieldshire, CT 93775', 'New Cara', 'Maine', '85644', 'TN', NULL, 1, 0, '2017-09-23 05:04:18', '2017-09-23 05:04:18'),
(9, 9, 'Consequatur', 'Esse ut qui voluptatem. Exercitationem atque fugit dolorum architecto explicabo ab. Praesentium nemo distinctio dolor non. Corporis enim sed libero ut fugit assumenda dolores.', 'Edmond Kovacek', NULL, NULL, '1985-09-23', '641 Willms Common\nMuhammadton, MN 86944', 'New Katheryn', 'Oregon', '43268', 'VC', NULL, 1, 0, '2017-09-23 05:04:18', '2017-09-23 05:04:18'),
(10, 1, 'Malibag', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo architecto excepturi nam porro, fugit debitis neque, nesciunt quae saepe sequi, cupiditate laborum consequatur eius deserunt rerum voluptas impedit quod. Mollitia earum harum, maxime reiciendis itaque asperiores cupiditate at sit, error rerum dolorum aliquid recusandae? Perferendis quae vero, molestias dicta sequi?', 'Naoshad Jahan Nayeem', '01915745636', 'naoshad@smartwebsource.com', '2009-06-11', '80/A Malibag, Dhaka', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 2, 2, '2017-09-23 06:09:55', '2017-11-20 05:35:03'),
(11, 10, 'Malibag', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab optio libero, quae, recusandae modi inventore ea nam officia labore. Sunt iste in saepe magni hic necessitatibus dolores at ipsum, veritatis mollitia totam provident maiores reiciendis deserunt placeat voluptatum, eligendi. Distinctio suscipit labore obcaecati praesentium, accusantium. Magnam quod eaque quos veniam!', 'Naoshad Jahan Nayeem', '01817655544', 'naoshad@smartwebsource.com', '2010-06-11', '80/A Malibag, Dhaka', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 1, 0, '2017-10-29 05:31:46', '2017-10-29 05:31:46'),
(13, 12, 'Kakrayl', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis commodi esse aliquam eligendi reprehenderit, numquam a odio autem labore officiis, ullam. Culpa fugiat modi quod asperiores labore perferendis ducimus id reprehenderit mollitia architecto autem deleniti beatae sed aut porro quam perspiciatis et rem, saepe, alias? Voluptatem, ea beatae dolorum delectus.', '', '', '', NULL, '112 Kakrayl, Dhaka -1217', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 1, 1, '2017-11-05 09:24:00', '2017-11-06 05:26:32'),
(14, 13, 'Dhanmondi', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae blanditiis dolorem, odio quam, voluptas maxime repudiandae doloribus officia unde reprehenderit molestias non. Modi explicabo corporis laboriosam pariatur nihil, sunt quam doloremque aliquid neque ratione, reiciendis vel obcaecati. Neque voluptatem autem possimus earum amet consequuntur doloribus, illum distinctio excepturi architecto soluta.', NULL, NULL, NULL, NULL, '120 D West Dhanmondi', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 1, 0, '2017-11-06 11:31:04', '2017-11-06 11:31:04'),
(15, 13, 'Motijheel', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem totam, perferendis, modi dolorum corrupti laborum aliquid esse est nostrum temporibus alias, accusantium. Aliquam, a molestias asperiores vel soluta nisi, ad corporis voluptatum sunt. Quam, ratione accusantium animi possimus. Aperiam fugiat tempore numquam natus, ea molestias maiores ad nesciunt amet minus.', 'Md.Abul Kalam Ajad', '01716543223', '', NULL, '52 Motijheel, Dhaka', 'Dhaka', 'Dhaka', '1000', 'BD', NULL, 21, 0, '2017-11-06 12:06:52', '2017-11-06 12:06:52'),
(16, 13, 'Malibag', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem totam, perferendis, modi dolorum corrupti laborum aliquid esse est nostrum temporibus alias, accusantium. Aliquam, a molestias asperiores vel soluta nisi, ad corporis voluptatum sunt. Quam, ratione accusantium animi possimus. Aperiam fugiat tempore numquam natus, ea molestias maiores ad nesciunt amet minus.', '', '', '', NULL, '88/A Malibag, Dhaka', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 1, 0, '2017-11-06 12:10:12', '2017-11-06 12:10:12'),
(17, 14, 'Motijheel', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates animi similique consequuntur nostrum ipsum laudantium eius commodi, ut fugit magni quis est, repellat quibusdam neque quod, minima sequi debitis. Inventore sapiente blanditiis nulla aspernatur molestias ratione asperiores at nesciunt odio, error, voluptatum fugiat saepe! Quis amet, perspiciatis dignissimos optio sapiente.', NULL, NULL, NULL, NULL, '76/B Motijheel, Dhaka', 'Dhaka', 'Dhaka', '1000', 'BD', NULL, 1, 0, '2017-11-08 05:11:46', '2017-11-08 05:11:46'),
(18, 14, 'Malibag', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates animi similique consequuntur nostrum ipsum laudantium eius commodi, ut fugit magni quis est, repellat quibusdam neque quod, minima sequi debitis. Inventore sapiente blanditiis nulla aspernatur molestias ratione asperiores at nesciunt odio, error, voluptatum fugiat saepe! Quis amet, perspiciatis dignissimos optio sapiente.', '', '', '', NULL, '88/A Malibag', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 1, 0, '2017-11-08 05:16:03', '2017-11-08 05:16:03'),
(19, 14, 'Paltan', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, adipisci quisquam minus nulla dicta alias illum sed pariatur asperiores? Fuga nihil voluptate eius maiores itaque, quibusdam, facere assumenda ipsam quae ex, illo veritatis voluptatibus! Expedita porro qui aliquam aliquid nihil dolorem blanditiis molestias, maxime quod fugiat esse, facere, voluptatum vero.', '', '', '', NULL, '52/4 Purana Paltan, Dhaka', 'Dhaka', 'Dhaka', '1200', 'BD', NULL, 25, 0, '2017-11-08 08:55:07', '2017-11-08 08:55:07'),
(20, 15, 'Malibag', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima vitae nesciunt reiciendis corrupti fugit sint illum, itaque natus nisi commodi praesentium, perferendis ipsum nulla laboriosam alias omnis soluta, labore autem. Atque vero ipsa molestias voluptate consequuntur aperiam, ab, debitis quia, veritatis officia delectus magnam iure eos sit nihil recusandae autem.', NULL, NULL, NULL, NULL, '80/A Malibag, Dhaka -1217', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, 1, 0, '2017-11-12 05:20:30', '2017-11-12 05:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_year` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `title`, `slug`, `description`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `established_year`, `address`, `city`, `state`, `zip`, `country`, `logo`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Franecki, Schinner and Langosh', '1-franecki-schinner-and-langosh', 'Dolorum et consequatur autem quis reprehenderit et sit. Minima blanditiis vel doloribus minus. Corporis dolorem nihil suscipit sed quis. Et molestias possimus et aut.', 'Jaleel Torp', '', '', '1993-09-23', '9000 Lawrence Islands Apt. 729\r\nLuettgenmouth, SC 59053-6097', 'Rodview', 'Michigan', '80347', 'NG', 'uploads/company-logo/desert119769462.jpg', NULL, 1, 2, '2017-09-23 05:03:54', '2017-11-11 12:48:31'),
(2, 'Bogan-Auer', 'bogan-auer', 'Omnis sequi expedita optio vero voluptas quo non rerum. Saepe optio quia cupiditate praesentium. Pariatur ex dicta sed et illo.', 'Una Blick', NULL, NULL, '1982-09-23', '5562 Stanton Crest Suite 271\nEast Chesleyburgh, LA 02395-1254', 'New Mac', 'North Dakota', '24581-3377', 'RS', NULL, NULL, 1, 0, '2017-09-23 05:04:15', '2017-09-23 05:04:15'),
(3, 'Nikolaus-Howe', 'nikolaus-howe', 'Ullam eveniet sed suscipit atque. Ad ipsa assumenda autem est aliquid. Quia iure ut numquam est. Soluta expedita voluptatem numquam odit saepe laborum ea est.', 'Mr. Orval Jacobson', NULL, NULL, '1981-09-23', '85190 Larue Fort Apt. 973\nWest Jacky, OR 15091', 'Freedafort', 'Arizona', '71543', 'GL', NULL, NULL, 1, 0, '2017-09-23 05:04:15', '2017-09-23 05:04:15'),
(4, 'Auer, Doyle and Pfeffer', 'auer-doyle-and-pfeffer', 'Quas nesciunt in quas et laudantium ut. Et est voluptatem pariatur quas deserunt optio. Aperiam qui et quibusdam dolor facere nesciunt esse.', 'Claudie Shanahan', NULL, NULL, '1997-09-23', '1975 Murazik Isle\nLake Telly, ND 46106-0531', 'Icieshire', 'Oregon', '58094', 'MY', NULL, NULL, 1, 0, '2017-09-23 05:04:16', '2017-09-23 05:04:16'),
(5, 'Kris-Mohr', 'kris-mohr', 'Inventore cupiditate eos et rerum. Officia est praesentium voluptates omnis. Nemo sapiente minima itaque voluptas quo cupiditate et.', 'Dameon Haley', NULL, NULL, '1982-09-23', '1757 Rogers Trail Suite 836\nNorth Alejandrinburgh, IN 36818', 'West Dave', 'Colorado', '73645-7559', 'RU', NULL, NULL, 1, 0, '2017-09-23 05:04:16', '2017-09-23 05:04:16'),
(6, 'King-Shanahan', 'king-shanahan', 'Voluptas voluptas eos maiores dolorem neque aspernatur earum veniam. Laboriosam tempore nulla dolorem enim. Omnis ut autem voluptas quas nemo distinctio.', 'Kendrick Hoppe', NULL, NULL, '1988-09-23', '566 Littel Glen\nStacyport, AK 92849-4990', 'Deborahborough', 'Delaware', '69149', 'EE', NULL, NULL, 1, 0, '2017-09-23 05:04:17', '2017-09-23 05:04:17'),
(7, 'Steuber-Shanahan', 'steuber-shanahan', 'Vel earum minus dolore ad id in. Maxime assumenda recusandae repudiandae.', 'Shannon Padberg', NULL, NULL, '1987-09-23', '9932 Francesca Mall\nBarrowstown, TN 43093', 'Ravenborough', 'Kentucky', '08960-1102', 'MS', NULL, NULL, 1, 0, '2017-09-23 05:04:17', '2017-09-23 05:04:17'),
(8, 'Watsica-Von', 'watsica-von', 'Et ipsum beatae voluptas. Nostrum sint numquam voluptatem repudiandae et. Nesciunt nam voluptate ut maxime quis quis et.', 'Ms. Ethelyn Schuppe', NULL, NULL, '1996-09-23', '6966 Braeden Ville\nWest Lea, HI 88525-3079', 'Naderland', 'Alaska', '27861', 'TN', NULL, NULL, 1, 0, '2017-09-23 05:04:18', '2017-09-23 05:04:18'),
(9, 'Wuckert-Mann', 'wuckert-mann', 'Repellendus voluptas aliquam unde quam. Iure velit reprehenderit nihil in beatae. Repellat mollitia dolorem facere veritatis eos.', 'Prof. Chelsey Oberbrunner', NULL, NULL, '1982-09-23', '697 Cartwright Stravenue Suite 999\nNew Mona, AL 91780-9011', 'East Rosina', 'Indiana', '86631', 'VC', NULL, NULL, 1, 0, '2017-09-23 05:04:18', '2017-09-23 05:04:18'),
(10, 'Noortech', '10-noortech', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab optio libero, quae, recusandae modi inventore ea nam officia labore. Sunt iste in saepe magni hic necessitatibus dolores at ipsum, veritatis mollitia totam provident maiores reiciendis deserunt placeat voluptatum, eligendi. Distinctio suscipit labore obcaecati praesentium, accusantium. Magnam quod eaque quos veniam!', 'Naoshad Jahan Nayeem', '01817655544', 'naoshad@smartwebsource.com', '2009-11-19', '80/A Malibag, Dhaka', 'Dhaka', 'Dhaka', '1217', 'BD', 'uploads/company-logo/chrysanthemum17877479.jpg', NULL, 1, 1, '2017-10-29 05:28:22', '2017-11-05 05:53:14'),
(12, 'Destiny 2000', '12-destiny-2000', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis commodi esse aliquam eligendi reprehenderit, numquam a odio autem labore officiis, ullam. Culpa fugiat modi quod asperiores labore perferendis ducimus id reprehenderit mollitia architecto autem deleniti beatae sed aut porro quam perspiciatis et rem, saepe, alias? Voluptatem, ea beatae dolorum delectus.', '', '', '', NULL, '112 Kakrayl, Dhaka -1217', 'Dhaka', 'Dhaka', '1217', 'BD', 'uploads/company-logo/hydrangeas74097076.jpg', NULL, 1, 1, '2017-11-05 09:24:00', '2017-11-06 05:30:31'),
(13, 'Walton', '13-walton', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae blanditiis dolorem, odio quam, voluptas maxime repudiandae doloribus officia unde reprehenderit molestias non. Modi explicabo corporis laboriosam pariatur nihil, sunt quam doloremque aliquid neque ratione, reiciendis vel obcaecati. Neque voluptatem autem possimus earum amet consequuntur doloribus, illum distinctio excepturi architecto soluta.', '', '', '', NULL, '120 D West Dhanmondi', 'Dhaka', 'Dhaka', '1100', 'BD', 'uploads/company-logo/desert.jpg', NULL, 1, 1, '2017-11-06 11:31:03', '2017-11-06 12:36:48'),
(14, 'Leads Corporation', '14-leads-corporation', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, ab eaque dolore rem alias neque. Natus eaque doloribus voluptates optio labore unde, sequi iusto! Repellat labore cupiditate numquam iste aperiam cum temporibus porro quos necessitatibus aliquid vitae doloribus, libero quasi perspiciatis sequi ut fuga, quam, nulla natus dignissimos repellendus tempore?', '', '', '', '2010-06-15', '76/B Motijheel, Dhaka', 'Dhaka', 'Dhaka', '1000', 'BD', 'uploads/company-logo/tulips.jpg', NULL, 1, 1, '2017-11-08 05:11:46', '2017-11-12 05:29:34'),
(15, 'SmartDataSoft', '15-smartdatasoft', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima vitae nesciunt reiciendis corrupti fugit sint illum, itaque natus nisi commodi praesentium, perferendis ipsum nulla laboriosam alias omnis soluta, labore autem. Atque vero ipsa molestias voluptate consequuntur aperiam, ab, debitis quia, veritatis officia delectus magnam iure eos sit nihil recusandae autem.', 'Arif Khan', '', '', NULL, '80/A Malibag, Dhaka -1217', 'Dhaka', 'Dhaka', '1217', 'BD', NULL, NULL, 1, 0, '2017-11-12 05:20:30', '2017-11-12 05:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_code`, `name`, `mobile_code`) VALUES
('AC', 'Ascension Island', '247'),
('AD', 'Andorra', '376'),
('AE', 'United Arab Emirates', '971'),
('AF', 'Afghanistan', '93'),
('AG', 'Antigua And Barbuda', '1 268'),
('AI', 'Anguilla', '1 264'),
('AL', 'Albania', '355'),
('AM', 'Armenia', '374'),
('AO', 'Angola', '244'),
('AQ', 'Antarctica', '672'),
('AR', 'Argentina', '54'),
('AS', 'American Samoa', '1 684'),
('AT', 'Austria', '43'),
('AU', 'Australia', '61'),
('AW', 'Aruba', '297'),
('AZ', 'Azerbaijan', '994'),
('BA', 'Bosnia & Herzegovina', '387'),
('BB', 'Barbados', '1 246'),
('BD', 'Bangladesh', '880'),
('BE', 'Belgium', '32'),
('BF', 'Burkina Faso', '226'),
('BG', 'Bulgaria', '359'),
('BH', 'Bahrain', '973'),
('BI', 'Burundi', '257'),
('BJ', 'Benin', '229'),
('BL', 'Saint Barthélemy', '590'),
('BM', 'Bermuda', '1 441'),
('BN', 'Brunei Darussalam', '673'),
('BO', 'Bolivia, Plurinational State Of', '591'),
('BQ', 'Bonaire, Saint Eustatius And Saba', '599'),
('BR', 'Brazil', '55'),
('BS', 'Bahamas', '1 242'),
('BT', 'Bhutan', '975'),
('BV', 'Bouvet Island', '47'),
('BW', 'Botswana', '267'),
('BY', 'Belarus', '375'),
('BZ', 'Belize', '501'),
('CA', 'Canada', '1'),
('CC', 'Cocos (Keeling) Islands', '61'),
('CD', 'Democratic Republic Of Congo', '243'),
('CF', 'Central African Republic', '236'),
('CG', 'Republic Of Congo', '242'),
('CH', 'Switzerland', '41'),
('CI', 'Cote d''Ivoire', '225'),
('CK', 'Cook Islands', '682'),
('CL', 'Chile', '56'),
('CM', 'Cameroon', '237'),
('CN', 'China', '86'),
('CO', 'Colombia', '57'),
('CR', 'Costa Rica', '506'),
('CU', 'Cuba', '53'),
('CV', 'Cape Verde', '238'),
('CW', 'Curacao', '599'),
('CX', 'Christmas Island', '61'),
('CY', 'Cyprus', '357'),
('CZ', 'Czech Republic', '420'),
('DE', 'Germany', '49'),
('DJ', 'Djibouti', '253'),
('DK', 'Denmark', '45'),
('DM', 'Dominica', '1 767'),
('DO', 'Dominican Republic', '1 809'),
('DZ', 'Algeria', '213'),
('EA', 'Ceuta, Mulilla', '34'),
('EC', 'Ecuador', '593'),
('EE', 'Estonia', '372'),
('EG', 'Egypt', '20'),
('EH', 'Western Sahara', '212'),
('ER', 'Eritrea', '291'),
('ES', 'Spain', '34'),
('ET', 'Ethiopia', '251'),
('EU', 'European Union', '388'),
('FI', 'Finland', '358'),
('FJ', 'Fiji', '679'),
('FK', 'Falkland Islands', '500'),
('FM', 'Micronesia, Federated States Of', '691'),
('FO', 'Faroe Islands', '298'),
('FR', 'France', '33'),
('FX', 'France, Metropolitan', '241'),
('GA', 'Gabon', '241'),
('GB', 'United Kingdom', '44'),
('GD', 'Grenada', '995'),
('GE', 'Georgia', '594'),
('GF', 'French Guiana', '594'),
('GG', 'Guernsey', '44'),
('GH', 'Ghana', '233'),
('GI', 'Gibraltar', '350'),
('GL', 'Greenland', '299'),
('GM', 'Gambia', '220'),
('GN', 'Guinea', '224'),
('GP', 'Guadeloupe', '590'),
('GQ', 'Equatorial Guinea', '240'),
('GR', 'Greece', '30'),
('GS', 'South Georgia And The South Sandwich Islands', '500'),
('GT', 'Guatemala', '502'),
('GU', 'Guam', '1 671'),
('GW', 'Guinea-bissau', '245'),
('GY', 'Guyana', '592'),
('HK', 'Hong Kong', '852'),
('HM', 'Heard Island And McDonald Islands', '672'),
('HN', 'Honduras', '504'),
('HR', 'Croatia', '385'),
('HT', 'Haiti', '509'),
('HU', 'Hungary', '36'),
('IC', 'Canary Islands', '34'),
('ID', 'Indonesia', '62'),
('IE', 'Ireland', '353'),
('IL', 'Israel', '972'),
('IM', 'Isle Of Man', '44'),
('IN', 'India', '91'),
('IO', 'British Indian Ocean Territory', '246'),
('IQ', 'Iraq', '964'),
('IR', 'Iran, Islamic Republic Of', '98'),
('IS', 'Iceland', '354'),
('IT', 'Italy', '39'),
('JE', 'Jersey', '44'),
('JM', 'Jamaica', '1 876'),
('JO', 'Jordan', '962'),
('JP', 'Japan', '81'),
('KE', 'Kenya', '254'),
('KG', 'Kyrgyzstan', '996'),
('KH', 'Cambodia', '855'),
('KI', 'Kiribati', '686'),
('KM', 'Comoros', '269'),
('KN', 'Saint Kitts And Nevis', '1 869'),
('KP', 'Korea, Democratic People''s Republic Of', '850'),
('KR', 'Korea, Republic Of', '82'),
('KW', 'Kuwait', '965'),
('KY', 'Cayman Islands', '1 345'),
('KZ', 'Kazakhstan', '7'),
('LA', 'Lao People''s Democratic Republic', '856'),
('LB', 'Lebanon', '961'),
('LC', 'Saint Lucia', '1 758'),
('LI', 'Liechtenstein', '423'),
('LK', 'Sri Lanka', '94'),
('LR', 'Liberia', '231'),
('LS', 'Lesotho', '266'),
('LT', 'Lithuania', '370'),
('LU', 'Luxembourg', '352'),
('LV', 'Latvia', '371'),
('LY', 'Libya', '218'),
('MA', 'Morocco', '212'),
('MC', 'Monaco', '377'),
('MD', 'Moldova', '373'),
('ME', 'Montenegro', '382'),
('MF', 'Saint Martin', '590'),
('MG', 'Madagascar', '261'),
('MH', 'Marshall Islands', '692'),
('MK', 'Macedonia, The Former Yugoslav Republic Of', '389'),
('ML', 'Mali', '223'),
('MM', 'Myanmar', '95'),
('MN', 'Mongolia', '976'),
('MO', 'Macao', '853'),
('MP', 'Northern Mariana Islands', '1 670'),
('MQ', 'Martinique', '596'),
('MR', 'Mauritania', '222'),
('MS', 'Montserrat', '1 664'),
('MT', 'Malta', '356'),
('MU', 'Mauritius', '230'),
('MV', 'Maldives', '960'),
('MW', 'Malawi', '265'),
('MX', 'Mexico', '52'),
('MY', 'Malaysia', '60'),
('MZ', 'Mozambique', '258'),
('NA', 'Namibia', '264'),
('NC', 'New Caledonia', '687'),
('NE', 'Niger', '227'),
('NF', 'Norfolk Island', '672'),
('NG', 'Nigeria', '234'),
('NI', 'Nicaragua', '505'),
('NL', 'Netherlands', '31'),
('NO', 'Norway', '47'),
('NP', 'Nepal', '977'),
('NR', 'Nauru', '674'),
('NU', 'Niue', '683'),
('NZ', 'New Zealand', '64'),
('OM', 'Oman', '968'),
('PA', 'Panama', '507'),
('PE', 'Peru', '51'),
('PF', 'French Polynesia', '689'),
('PG', 'Papua New Guinea', '675'),
('PH', 'Philippines', '63'),
('PK', 'Pakistan', '92'),
('PL', 'Poland', '48'),
('PM', 'Saint Pierre And Miquelon', '508'),
('PN', 'Pitcairn', '64'),
('PR', 'Puerto Rico', '1 787'),
('PS', 'Palestinian Territory, Occupied', '970'),
('PT', 'Portugal', '351'),
('PW', 'Palau', '680'),
('PY', 'Paraguay', '595'),
('QA', 'Qatar', '974'),
('RE', 'Reunion', '262'),
('RO', 'Romania', '40'),
('RS', 'Serbia', '381'),
('RU', 'Russian Federation', '7'),
('RW', 'Rwanda', '250'),
('SA', 'Saudi Arabia', '966'),
('SB', 'Solomon Islands', '677'),
('SC', 'Seychelles', '248'),
('SD', 'Sudan', '249'),
('SE', 'Sweden', '46'),
('SG', 'Singapore', '65'),
('SH', 'Saint Helena, Ascension And Tristan Da Cunha', '290'),
('SI', 'Slovenia', '386'),
('SJ', 'Svalbard And Jan Mayen', '47'),
('SK', 'Slovakia', '421'),
('SL', 'Sierra Leone', '232'),
('SM', 'San Marino', '378'),
('SN', 'Senegal', '221'),
('SO', 'Somalia', '252'),
('SR', 'Suriname', '597'),
('ST', 'Sao Tome And Principe', '239'),
('SV', 'El Salvador', '503'),
('SX', 'Sint Maarten', '1 721'),
('SY', 'Syrian Arab Republic', '963'),
('SZ', 'Swaziland', '268'),
('TA', 'Tristan de Cunha', '290'),
('TC', 'Turks And Caicos Islands', '1 649'),
('TD', 'Chad', '235'),
('TF', 'French Southern Territories', '262'),
('TG', 'Togo', '228'),
('TH', 'Thailand', '66'),
('TJ', 'Tajikistan', '992'),
('TK', 'Tokelau', '690'),
('TL', 'East Timor', '670'),
('TM', 'Turkmenistan', '993'),
('TN', 'Tunisia', '216'),
('TO', 'Tonga', '676'),
('TR', 'Turkey', '90'),
('TT', 'Trinidad And Tobago', '1 868'),
('TV', 'Tuvalu', '688'),
('TW', 'Taiwan, Province Of China', '886'),
('TZ', 'Tanzania, United Republic Of', '255'),
('UA', 'Ukraine', '380'),
('UG', 'Uganda', '256'),
('UM', 'United States Minor Outlying Islands', '1'),
('US', 'United States', '1'),
('UY', 'Uruguay', '598'),
('UZ', 'Uzbekistan', '998'),
('VA', 'Vatican City State', '379'),
('VC', 'Saint Vincent And The Grenadines', '1 784'),
('VE', 'Venezuela, Bolivarian Republic Of', '58'),
('VG', 'Virgin Islands (British)', '1 284'),
('VI', 'Virgin Islands (US)', '1 340'),
('VN', 'Viet Nam', '84'),
('VU', 'Vanuatu', '678'),
('WF', 'Wallis And Futuna', '681'),
('WS', 'Samoa', '685'),
('YE', 'Yemen', '967'),
('YT', 'Mayotte', '262'),
('ZA', 'South Africa', '27'),
('ZM', 'Zambia', '260'),
('ZW', 'Zimbabwe', '263');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
`id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `parent_id`, `company_id`, `branch_id`, `title`, `description`, `priority`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'Quaerat', 'Voluptas similique culpa quo natus laboriosam. Cumque praesentium quisquam incidunt eligendi enim voluptatum. Enim voluptates voluptatem modi.', 95, NULL, 1, 1, '2017-09-23 05:03:54', '2017-10-15 09:33:40'),
(2, 0, 2, 2, 'Sit', 'Culpa quasi voluptas necessitatibus quia illum. Deserunt fugit qui magnam aspernatur. Quia aut fuga aperiam necessitatibus.', 61, NULL, 1, 0, '2017-09-23 05:04:15', '2017-09-23 05:04:15'),
(3, 0, 3, 3, 'Nostrum', 'Inventore quia facilis est reiciendis dolore consequatur sunt. Sed reprehenderit et rerum ipsum. Totam in itaque voluptatem odio rerum qui.', 47, NULL, 1, 0, '2017-09-23 05:04:16', '2017-09-23 05:04:16'),
(4, 0, 4, 4, 'Non', 'Numquam ut quaerat consequuntur deleniti provident sed. Magnam odit qui optio ut quia est. Nam est deleniti quibusdam voluptates est quod earum. Rerum sapiente sit corrupti occaecati doloremque.', 82, NULL, 1, 0, '2017-09-23 05:04:16', '2017-09-23 05:04:16'),
(5, 0, 5, 5, 'Qui', 'Accusantium nobis consectetur ea nemo quisquam vero. Maiores quas perspiciatis reprehenderit temporibus animi. Nisi et qui unde autem eum quisquam. Delectus animi omnis quia ipsam magni.', 23, NULL, 1, 0, '2017-09-23 05:04:17', '2017-09-23 05:04:17'),
(6, 0, 6, 6, 'Ullam', 'Odit iure non dolorem sed quaerat molestiae voluptas. Fugiat provident omnis est accusamus sapiente modi excepturi. Neque dolor aut ut aut. Ut id rerum reprehenderit itaque qui iure harum.', 28, NULL, 1, 0, '2017-09-23 05:04:17', '2017-09-23 05:04:17'),
(7, 0, 7, 7, 'Sint', 'Sunt pariatur quis provident asperiores dignissimos recusandae molestiae at. In ea adipisci facilis at. Molestiae recusandae provident est. Repellendus sint earum qui nemo consequatur ut.', 37, NULL, 1, 0, '2017-09-23 05:04:18', '2017-09-23 05:04:18'),
(8, 0, 8, 8, 'Nam', 'Neque exercitationem omnis soluta debitis aut. Aut numquam ut quia omnis sit et. Quod dolor dolores vel nisi est quibusdam maxime.', 84, NULL, 1, 0, '2017-09-23 05:04:18', '2017-09-23 05:04:18'),
(9, 0, 9, 9, 'Sunt', 'Amet recusandae qui non unde non quia architecto. Eos illo alias mollitia numquam. Veritatis temporibus esse rerum eos eos ut quis.', 27, NULL, 1, 0, '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(10, 0, 1, 10, 'IT', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique et, deleniti voluptatibus praesentium quaerat porro! Fugiat natus officiis veritatis nesciunt, accusamus corporis, optio ducimus tempore impedit quam voluptatem quae, suscipit asperiores quos odio praesentium beatae dolores id maiores nihil consectetur! Deleniti omnis, necessitatibus dolore. Iure numquam sequi, saepe nulla quas!', 2, NULL, 2, 0, '2017-09-23 06:40:05', '2017-09-23 06:40:05'),
(11, 0, 1, 1, 'Accounts', 'This is description', 55, NULL, 1, 1, '2017-10-31 05:10:32', '2017-10-31 12:37:27'),
(12, 11, 1, 1, 'Finance', 'This is description', 0, NULL, 1, 1, '2017-11-04 06:54:38', '2017-11-07 09:42:41'),
(13, 10, 1, 10, 'Network', 'This is description', 0, NULL, 2, 0, '2017-11-04 06:56:45', '2017-11-04 06:56:45'),
(15, 0, 12, 13, 'Foriegn', '', 0, NULL, 1, 1, '2017-11-05 09:24:00', '2017-11-05 09:27:27'),
(16, 0, 13, 14, 'Electronics', NULL, 0, NULL, 1, 0, '2017-11-06 11:31:04', '2017-11-06 11:31:04'),
(17, 0, 13, 15, 'Network', 'This is description', 0, NULL, 21, 0, '2017-11-06 12:07:38', '2017-11-06 12:07:38'),
(18, 0, 13, 16, 'Accounting', 'This is description', 0, NULL, 1, 0, '2017-11-06 12:10:57', '2017-11-06 12:10:57'),
(19, 18, 13, 16, 'Finance', 'This is description', 0, NULL, 1, 0, '2017-11-06 12:11:30', '2017-11-06 12:11:30'),
(20, 0, 14, 17, 'Account', NULL, 0, NULL, 1, 0, '2017-11-08 05:11:47', '2017-11-08 05:11:47'),
(21, 20, 14, 17, 'Finance', '', 0, NULL, 1, 0, '2017-11-08 05:20:16', '2017-11-08 05:20:16'),
(22, 21, 14, 17, 'Management', '', 0, NULL, 1, 0, '2017-11-08 05:21:39', '2017-11-08 05:21:39'),
(23, 0, 14, 19, 'IT', '', 0, NULL, 25, 0, '2017-11-08 08:55:55', '2017-11-08 08:55:55'),
(24, 0, 15, 20, 'IT', NULL, 0, NULL, 1, 0, '2017-11-12 05:20:30', '2017-11-12 05:20:30'),
(25, 12, 1, 1, 'Management', '', 0, NULL, 2, 0, '2018-01-01 13:27:40', '2018-01-01 13:27:40'),
(26, 25, 1, 1, 'Sub Finance', '', 0, NULL, 2, 0, '2018-01-01 13:28:14', '2018-01-01 13:28:14'),
(27, 11, 1, 1, 'Deleted Department 1', '', 0, '2018-01-04 05:55:13', 1, 0, '2018-01-03 04:48:33', '2018-01-04 05:55:13');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE IF NOT EXISTS `designations` (
`id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=42 ;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `parent_id`, `company_id`, `branch_id`, `title`, `description`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 1, 'Est', 'Aut harum sint nostrum cupiditate. Sequi aut magnam occaecati nulla. Maiores facere eius quas ut illum optio in. Earum dignissimos cumque aut eos.', NULL, 1, 0, '2017-09-23 05:03:55', '2018-01-04 09:59:03'),
(2, 0, 2, 2, 'Ex', 'Accusantium iure reprehenderit ex corrupti impedit. Optio enim nam cum quod ratione. Et blanditiis vero non voluptas corporis ullam. Ut et sit perferendis.', NULL, 1, 0, '2017-09-23 05:04:15', '2018-01-04 09:59:03'),
(3, 0, 3, 3, 'Voluptatem', 'Accusantium laudantium laudantium error id eum ipsam consequatur. Velit quia vero architecto. Id ipsa omnis qui doloremque aut.', NULL, 1, 0, '2017-09-23 05:04:16', '2018-01-04 09:59:03'),
(4, 0, 4, 4, 'Nihil', 'Occaecati est id iure ut voluptate odit neque. Numquam perferendis odit eveniet est accusantium autem. Incidunt reprehenderit autem omnis voluptatem. Minima qui officiis illum nemo eos consectetur.', NULL, 1, 0, '2017-09-23 05:04:16', '2018-01-04 09:59:03'),
(5, 0, 5, 5, 'Asperiores', 'Voluptatem sequi autem enim amet maiores occaecati accusantium. Inventore ut aut illum dolorem omnis. Dolorum eum vel enim ut quibusdam est nemo.', NULL, 1, 0, '2017-09-23 05:04:17', '2018-01-04 09:59:03'),
(6, 0, 6, 6, 'Rerum', 'Aspernatur similique sint esse eligendi soluta fugit quos. Qui rerum excepturi omnis odit. Adipisci dolorum magni dignissimos illo tempore velit. Aspernatur sunt sapiente occaecati repellat eos.', NULL, 1, 0, '2017-09-23 05:04:17', '2018-01-04 09:59:03'),
(7, 0, 7, 7, 'Molestiae', 'Sapiente nihil non pariatur non. Nemo non et accusamus architecto. Aut quod non provident quaerat enim expedita corrupti.', NULL, 1, 0, '2017-09-23 05:04:18', '2018-01-04 09:59:03'),
(8, 0, 8, 8, 'Quisquam', 'Fugiat veritatis excepturi sit corrupti aut quaerat. Ut earum aut corrupti ipsam. Qui quo neque sequi explicabo labore nulla ut. Quo illo nesciunt quia laboriosam.', NULL, 1, 0, '2017-09-23 05:04:18', '2018-01-04 09:59:03'),
(9, 0, 9, 9, 'Quia', 'Sed unde doloremque placeat velit. Aut nam amet aliquid porro.', NULL, 1, 0, '2017-09-23 05:04:19', '2018-01-04 09:59:03'),
(10, 0, 1, 10, 'CEO', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate culpa, nulla reprehenderit voluptates amet quam molestiae, aut magnam quisquam libero natus consectetur? Numquam explicabo ea et, sunt optio ad libero ipsa, deleniti tenetur a unde labore eius magnam perferendis, ex adipisci quibusdam necessitatibus blanditiis quod! Possimus dolorem aut voluptatibus.', NULL, 2, 0, '2017-09-23 06:44:11', '2018-01-04 09:59:03'),
(11, 0, 1, 10, 'Team Leader', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate culpa, nulla reprehenderit voluptates amet quam molestiae, aut magnam quisquam libero natus consectetur? Numquam explicabo ea et, sunt optio ad libero ipsa, deleniti tenetur a unde labore eius magnam perferendis, ex adipisci quibusdam necessitatibus blanditiis quod! Possimus dolorem aut voluptatibus.', NULL, 2, 1, '2017-09-23 06:45:00', '2018-01-04 09:59:03'),
(12, 0, 1, 10, 'Web Developer', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate culpa, nulla reprehenderit voluptates amet quam molestiae, aut magnam quisquam libero natus consectetur? Numquam explicabo ea et, sunt optio ad libero ipsa, deleniti tenetur a unde labore eius magnam perferendis, ex adipisci quibusdam necessitatibus blanditiis quod! Possimus dolorem aut voluptatibus.', NULL, 2, 0, '2017-09-23 06:45:42', '2018-01-04 09:59:03'),
(13, 0, 1, 1, 'Junior Officer', 'This is description', NULL, 1, 0, '2017-10-31 09:15:32', '2018-01-04 09:59:03'),
(14, 0, 1, 1, 'Officer', 'This is description', NULL, 2, 2, '2017-10-31 09:16:00', '2018-01-04 09:59:03'),
(15, 0, 1, 1, 'Assistant Oficer', 'This is description', NULL, 15, 15, '2017-10-31 10:21:14', '2018-01-04 09:59:03'),
(17, 0, 12, 13, 'Manager', '', NULL, 1, 1, '2017-11-05 09:24:00', '2018-01-04 09:59:03'),
(18, 0, 13, 14, 'Chief Executive', NULL, NULL, 1, 0, '2017-11-06 11:31:04', '2018-01-04 09:59:03'),
(19, 0, 13, 15, 'Executive', 'This is description', NULL, 21, 0, '2017-11-06 12:08:20', '2018-01-04 09:59:03'),
(20, 0, 13, 16, 'Manager', 'This is description', NULL, 1, 0, '2017-11-06 12:12:11', '2018-01-04 09:59:03'),
(21, 0, 13, 16, 'Asistant Manager', 'This is description', NULL, 22, 0, '2017-11-06 12:58:38', '2018-01-04 09:59:03'),
(22, 0, 14, 17, 'Senior Manager', NULL, NULL, 1, 0, '2017-11-08 05:11:46', '2018-01-04 09:59:03'),
(23, 0, 14, 17, 'Manager', '', NULL, 1, 0, '2017-11-08 05:24:59', '2018-01-04 09:59:03'),
(24, 0, 14, 19, 'CEO', '', NULL, 25, 0, '2017-11-08 08:57:33', '2018-01-04 09:59:03'),
(25, 0, 14, 17, 'Assistant Manager', '', NULL, 26, 0, '2017-11-08 09:16:19', '2018-01-04 09:59:03'),
(26, 0, 14, 17, 'Assistant Manager', '', NULL, 26, 0, '2017-11-08 09:16:21', '2018-01-04 09:59:03'),
(27, 0, 14, 17, 'Dleet', '', NULL, 26, 0, '2017-11-08 09:18:18', '2018-01-04 09:59:03'),
(28, 0, 14, 19, 'Senior Web Developer', '', NULL, 27, 0, '2017-11-08 10:18:25', '2018-01-04 09:59:03'),
(29, 0, 15, 20, 'CEO', NULL, NULL, 1, 0, '2017-11-12 05:20:30', '2018-01-04 09:59:03'),
(30, 13, 1, 1, 'Senior Clurk', '', NULL, 1, 0, '2017-11-18 09:25:01', '2018-01-04 09:59:03'),
(31, 21, 13, 16, 'Assistant Officer', '', NULL, 22, 22, '2017-11-18 11:23:11', '2018-01-04 09:59:03'),
(32, 30, 1, 1, 'Junior Clurk', '', NULL, 2, 0, '2017-11-19 12:33:34', '2018-01-04 09:59:03'),
(33, 32, 1, 1, 'Sub Junior Clurk', '', NULL, 2, 0, '2018-01-01 13:25:22', '2018-01-04 09:59:03'),
(34, 13, 1, 1, 'Sub Junior Officer', '', NULL, 1, 1, '2018-01-02 12:06:58', '2018-01-04 09:59:03'),
(35, 34, 1, 1, 'Caretaker', '', NULL, 1, 0, '2018-01-02 12:10:14', '2018-01-04 09:59:03'),
(36, 32, 1, 1, 'Another Sub Junior Clurk', '', NULL, 1, 1, '2018-01-03 05:16:57', '2018-01-04 09:59:03'),
(39, 0, 1, 1, 'Deleted Designation 1', '', '2018-01-04 10:09:08', 2, 2, '2018-01-04 09:41:20', '2018-01-04 10:09:08'),
(40, 39, 1, 1, 'Deleted Designation 2', '', '2018-01-04 10:09:08', 2, 0, '2018-01-04 09:41:46', '2018-01-04 10:09:08'),
(41, 0, 1, 1, 'Deleted Designation', '', '2018-01-04 13:00:54', 2, 0, '2018-01-04 12:50:57', '2018-01-04 13:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `department_id` int(11) NOT NULL DEFAULT '0',
  `designation_id` int(11) NOT NULL DEFAULT '0',
  `reporting_boss` int(11) NOT NULL DEFAULT '0',
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fathers_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothers_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `religion` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_group` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci,
  `permanent_address` text COLLATE utf8mb4_unicode_ci,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `company_id`, `branch_id`, `department_id`, `designation_id`, `reporting_boss`, `code`, `joining_date`, `full_name`, `fathers_name`, `mothers_name`, `dob`, `religion`, `nationality`, `gender`, `nid`, `phone`, `blood_group`, `passport_no`, `tin`, `present_address`, `permanent_address`, `photo`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, 0, '22t4dIWJQk73uPByFpaB', '2017-06-23', 'Mr. Admin', 'Md. Abdul Malek', 'Mrs. Rokeya Shakawat', '1992-09-23', 'Islam', 'Bangladeshi', 'male', '12345678901234', '01917656543', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2017-09-23 05:03:53', '2018-01-04 12:24:58'),
(2, 1, 1, 1, 1, 0, '3699329726066', '2017-09-03', 'Kathlyn Jaskolski', 'Bertram Ferry', 'Ms. Queenie Howell', '1997-09-23', 'Islam', 'Bangladeshi', 'female', '952032355414', '393-781-7464 x58463', '', '', '33505266', '', '', 'uploads/avatar/lighthouse.jpg', NULL, 1, 2, '2017-09-23 05:03:55', '2018-01-04 12:24:58'),
(3, 1, 1, 1, 1, 1, '8125212905478', '2017-08-31', 'Emma Effertz', 'Dudley Dach', 'Miss Tiara Spencer DDS', '1979-09-23', 'Islam', 'Bangladeshi', 'female', '59321152721', '(295) 391-9175 x35371', NULL, NULL, '15988465', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:03:55', '2018-01-04 12:24:58'),
(4, 2, 2, 2, 2, 0, '3473596914759', '2017-08-25', 'Dr. Morris Roberts V', 'Kristofer Kunde', 'Vicenta Raynor', '1995-09-23', 'Islam', 'Bangladeshi', 'male', '64692572', '767-680-3918 x715', NULL, NULL, '08749497', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:15', '2018-01-04 12:24:58'),
(5, 3, 3, 3, 3, 0, '5062337866051', '2017-08-17', 'Vernon Murazik', 'Mr. Loy Goodwin V', 'Noelia Armstrong', '1983-09-23', 'Islam', 'Bangladeshi', 'male', '81038169', '489.671.1565', NULL, NULL, '55739342', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:16', '2018-01-04 12:24:58'),
(6, 4, 4, 4, 4, 0, '2906353857361', '2017-08-20', 'Violet Goodwin', 'Travon DuBuque', 'Dr. Hulda Spinka', '1990-09-23', 'Islam', 'Bangladeshi', 'female', '15681893097', '(317) 252-5240 x05681', NULL, NULL, '77589767', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:16', '2018-01-04 12:24:58'),
(7, 5, 5, 5, 5, 0, '3894076164653', '2017-08-21', 'Prof. Rey Ebert', 'Mr. Chet Fritsch', 'Lura Schmitt Sr.', '1980-09-23', 'Islam', 'Bangladeshi', 'male', '323261633', '1-457-604-4707 x88124', NULL, NULL, '98669518', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:17', '2018-01-04 12:24:58'),
(8, 6, 6, 6, 6, 0, '2344045900689', '2017-08-31', 'Domenica Conn', 'Mr. Sammie Streich', 'Brigitte Lang IV', '1980-09-23', 'Islam', 'Bangladeshi', 'female', '491554640710557', '1-662-948-6235 x93606', NULL, NULL, '65603116', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:17', '2018-01-04 12:24:58'),
(9, 7, 7, 7, 7, 0, '5966692493160', '2017-08-18', 'Mr. Chadd Hackett', 'Mr. Cleo Heidenreich V', 'Claudie Botsford', '1978-09-23', 'Islam', 'Bangladeshi', 'male', '9706146', '+1 (775) 792-1653', NULL, NULL, '01115008', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:18', '2018-01-04 12:24:58'),
(10, 8, 8, 8, 8, 0, '5798392068542', '2017-08-16', 'Sterling Carter', 'Zechariah Lesch IV', 'Mrs. Miracle Mann DVM', '1990-09-23', 'Islam', 'Bangladeshi', 'male', '2818359048140', '909-800-3262 x58571', NULL, NULL, '38041329', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:18', '2018-01-04 12:24:58'),
(11, 9, 9, 9, 9, 0, '2007322423713', '2017-08-26', 'Imogene Shanahan', 'Ellis Medhurst', 'Evie Marks', '1996-09-23', 'Islam', 'Bangladeshi', 'female', '9561464417', '348-662-8063 x60338', NULL, NULL, '46557302', NULL, NULL, NULL, NULL, 1, 0, '2017-09-23 05:04:19', '2018-01-04 12:24:58'),
(12, 1, 10, 10, 10, 2, '12313242423', '2017-09-23', 'Naoshad Jahan Nayeem', 'Md. Rafiq Jahan', 'Roksana Begum', '1983-06-23', 'Islam', 'Bangladeshi', 'male', '12324235365', '1913672836', '', '', '', '', '', NULL, NULL, 2, 2, '2017-09-23 06:51:47', '2018-01-04 12:24:58'),
(13, 1, 10, 10, 11, 12, '13124235456', '2017-09-23', 'Md. Mizanur Rahman', 'Md. Arafat Rahman', 'Khaleda Jia', '1992-03-12', 'Islam', 'Bangladeshi', 'male', '131245636656', '01716554433', '', '', '', '', '', NULL, NULL, 2, 2, '2017-09-23 06:56:38', '2018-01-04 12:24:58'),
(14, 1, 10, 10, 12, 13, '1231324545465', '2017-09-23', 'Abdul Aziz', 'Md. Ali Afzal', 'Hosne Ara Begum', '1985-10-25', 'Islam', 'Bangladeshi', 'male', '131234242345', '01674037388', '', '', '', '', '', NULL, NULL, 2, 2, '2017-09-23 07:00:53', '2018-01-04 12:24:58'),
(15, 1, 1, 1, 1, 3, '3699329726066', '2017-09-28', 'Md. Abbus Sattar', 'Md. Abul Hassem', 'Majeda Khanom', '1984-11-06', 'Islam', 'Bangladeshi', 'male', '81038169', '01817343321', '', '', '', '', '', NULL, NULL, 2, 2, '2017-09-25 04:54:45', '2018-01-04 12:24:58'),
(16, 1, 1, 11, 13, 3, '', NULL, 'Abdul Khalek', '', '', NULL, '', '', 'male', '', '01674037388', '', '', '', '', '', NULL, NULL, 2, 1, '2017-10-31 09:23:36', '2018-01-04 12:24:58'),
(17, 1, 10, 10, 10, 0, '', NULL, 'Md. Samsul Alam', '', '', NULL, '', '', 'male', '', '01817343321', '', '', '', '', '', NULL, NULL, 1, 1, '2017-10-31 12:17:50', '2018-01-04 12:24:58'),
(18, 1, 1, 11, 1, 12, '', '0000-00-00', 'Ferdous Al Hosainy', '', '', '0000-00-00', '', '', 'male', '', '01672343421', '', '', '', '', '', NULL, NULL, 15, 2, '2017-11-01 05:21:33', '2018-01-04 12:24:58'),
(19, 1, 1, 11, 14, 12, '', '0000-00-00', 'Md. Hamidur Rahman', '', '', NULL, '', '', 'male', '', '01717675645', '', '', '', '', '', NULL, NULL, 15, 2, '2017-11-01 05:27:57', '2018-01-04 12:24:58'),
(20, 1, 1, 1, 1, 12, '', '0000-00-00', 'Md. Nur Mohammad', '', '', NULL, '', '', 'male', '', '01817665544', '', '', '', '', '', NULL, NULL, 2, 2, '2017-11-01 05:29:16', '2018-01-04 12:24:58'),
(21, 12, 13, 15, 17, 0, NULL, NULL, 'Md. Wayejur Rahman', NULL, NULL, NULL, NULL, NULL, 'male', NULL, '01918774433', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-11-05 09:24:00', '2018-01-04 12:24:58'),
(22, 13, 14, 16, 18, 0, NULL, NULL, 'Md. Sabbir Hossain', NULL, NULL, NULL, NULL, NULL, 'male', NULL, '01817665522', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-11-06 11:31:04', '2018-01-04 12:24:58'),
(23, 13, 16, 18, 20, 22, '', NULL, 'Md. Abdul Malek', '', '', NULL, '', '', 'male', '', '01918774433', '', '', '', '', '', NULL, NULL, 1, 0, '2017-11-06 12:44:24', '2018-01-04 12:24:58'),
(24, 13, 16, 18, 20, 22, '', NULL, 'Md. Anissuzaman', '', '', NULL, '', '', 'male', '', '01672343421', '', '', '', '', '', NULL, NULL, 21, 0, '2017-11-06 12:50:55', '2018-01-04 12:24:58'),
(25, 13, 16, 18, 21, 23, '', NULL, 'Md. Rafikul Alam', '', '', NULL, '', '', 'male', '', '01718765643', '', '', '', '', '', NULL, NULL, 22, 21, '2017-11-07 05:18:11', '2018-01-04 12:24:58'),
(26, 14, 17, 20, 22, 0, NULL, NULL, 'Leads Admin', NULL, NULL, NULL, NULL, NULL, 'male', NULL, '01712345672', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-11-08 05:11:47', '2018-01-04 12:24:58'),
(27, 14, 17, 20, 23, 26, '', NULL, 'Leads Account Admin', '', '', '1986-07-17', '', '', 'male', '', '01717655543', '', '', '', '', '', 'uploads/avatar/hydrangeas.jpg', NULL, 1, 0, '2017-11-08 07:02:01', '2018-01-04 12:24:58'),
(28, 14, 19, 23, 24, 26, '', NULL, 'Leads IT Admin', '', '', NULL, '', '', 'male', '', '01674037388', '', '', '', '', '', NULL, NULL, 25, 0, '2017-11-08 09:00:41', '2018-01-04 12:24:58'),
(29, 14, 17, 20, 25, 27, '', NULL, 'Leads Account Employee', '', '', NULL, '', '', 'male', '', '01717676545', '', '', '', '', '', NULL, NULL, 26, 0, '2017-11-08 09:26:48', '2018-01-04 12:24:58'),
(30, 14, 19, 23, 28, 28, '', NULL, 'Leads IT Employee', '', '', NULL, '', '', 'male', '', '01717675645', '', '', '', '', '', NULL, NULL, 27, 0, '2017-11-08 10:21:03', '2018-01-04 12:24:58'),
(31, 15, 20, 24, 29, 0, NULL, NULL, 'Arif Khan', NULL, NULL, NULL, NULL, NULL, 'male', NULL, '01717890234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-11-12 05:20:30', '2018-01-04 12:24:58'),
(32, 13, 16, 18, 21, 23, '', NULL, 'Md. Hamid Mia', '', '', NULL, '', '', 'male', '', '01817665544', '', '', '', '', '', NULL, NULL, 22, 0, '2017-11-18 08:27:52', '2018-01-04 12:24:58'),
(33, 1, 10, 10, 12, 13, '', NULL, 'Amjad Hossain', '', '', NULL, '', '', 'male', '', '01818773322', '', '', '', '', '', NULL, NULL, 2, 2, '2017-12-05 12:00:55', '2018-01-04 12:24:58'),
(34, 1, 10, 10, 12, 13, '', NULL, 'Md. Amir Khan', '', '', NULL, '', '', 'male', '', '01712344400', '', '', '', '', '', NULL, NULL, 2, 2, '2017-12-10 06:17:11', '2018-01-04 12:24:58'),
(37, 14, 17, 20, 25, 27, '', NULL, 'Leads Account Employee 2', '', '', NULL, '', '', 'male', '', '01716543432', '', '', '', '', '', NULL, NULL, 26, 0, '2017-12-13 06:34:06', '2018-01-04 12:24:58'),
(38, 14, 17, 20, 25, 27, '', NULL, 'Leads Account Employee 3', '', '', NULL, '', '', 'male', '', '01717676776', '', '', '', '', '', NULL, NULL, 26, 0, '2017-12-13 06:35:15', '2018-01-04 12:24:58'),
(39, 14, 17, 21, 25, 27, '', NULL, 'Leads Finance Employee 1', '', '', NULL, '', '', 'male', '', '01918776622', '', '', '', '', '', NULL, NULL, 25, 0, '2017-12-13 12:52:41', '2018-01-04 12:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `employee_tasks`
--

CREATE TABLE IF NOT EXISTS `employee_tasks` (
`id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `target` int(11) DEFAULT NULL,
  `target_unit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_role_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deadline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `report_to` int(10) unsigned NOT NULL DEFAULT '0',
  `obsoleted` tinyint(1) NOT NULL DEFAULT '0',
  `assigned_by` int(10) unsigned NOT NULL DEFAULT '0',
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `employee_tasks`
--

INSERT INTO `employee_tasks` (`id`, `employee_id`, `task_id`, `target`, `target_unit`, `frequency_id`, `task_role_id`, `deadline`, `report_to`, `obsoleted`, `assigned_by`, `assigned_at`) VALUES
(1, 3, 8, NULL, NULL, 1, 1, '2017-12-04 13:30:00', 2, 0, 2, '2017-12-04 11:13:58'),
(2, 3, 9, NULL, NULL, 1, 2, '2017-12-05 11:30:00', 2, 0, 2, '2017-12-04 11:14:04'),
(17, 29, 19, 10, 'pieces', 2, 7, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:24:25'),
(18, 29, 20, 10, 'pieces', 2, 7, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:24:25'),
(19, 29, 23, 10, 'pieces', 2, 8, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:24:25'),
(20, 37, 19, 10, 'pieces', 2, 7, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:25:25'),
(21, 37, 20, 10, 'pieces', 2, 8, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:25:25'),
(22, 37, 23, 10, 'pieces', 2, 8, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:25:25'),
(23, 38, 19, 10, 'pieces', 2, 7, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:32:04'),
(24, 38, 20, 10, 'pieces', 2, 8, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:32:04'),
(25, 38, 23, 10, 'pieces', 2, 9, '2017-12-18 07:07:43', 27, 0, 26, '2017-12-13 08:32:04'),
(26, 39, 33, 10, 'pieces', 1, 13, '2017-12-19 09:06:10', 27, 0, 25, '2017-12-13 12:56:59'),
(27, 39, 19, 10, 'pieces', 2, 13, '2017-12-20 09:30:00', 27, 0, 25, '2017-12-19 09:15:15'),
(28, 33, 3, 10, 'pieces', 2, 10, '2018-01-07 05:00:00', 12, 0, 2, '2018-01-06 05:15:49'),
(29, 33, 7, 10, 'pieces', 2, 11, '2018-01-07 05:00:00', 12, 0, 2, '2018-01-06 05:15:49'),
(30, 33, 13, 10, 'pieces', 3, 11, '2018-01-13 05:00:00', 12, 0, 2, '2018-01-06 05:15:49'),
(31, 33, 11, 10, 'pieces', 5, 10, '2018-02-06 05:00:00', 12, 0, 2, '2018-01-06 05:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `frequencies`
--

CREATE TABLE IF NOT EXISTS `frequencies` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `frequencies`
--

INSERT INTO `frequencies` (`id`, `title`, `description`, `status`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Once', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:01', '2017-11-18 06:51:01'),
(2, 'Daily', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:01', '2017-11-18 06:51:01'),
(3, 'Weekly', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:01', '2017-11-18 06:51:01'),
(4, 'Forthnightly', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:01', '2017-11-18 06:51:01'),
(5, 'Monthly', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:01', '2017-11-18 06:51:01'),
(6, 'Quarterly', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:01', '2017-11-18 06:51:01'),
(7, 'Half Yearly', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:02', '2017-11-18 06:51:02'),
(8, 'Yearly', NULL, 'approved', NULL, 1, 0, '2017-11-18 06:51:02', '2017-11-18 06:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
`id` int(10) unsigned NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=362 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(320, '2014_10_12_000000_create_users_table', 1),
(321, '2014_10_12_100000_create_password_resets_table', 1),
(322, '2017_08_10_113200_create_employees_table', 1),
(323, '2017_08_13_123337_update_columns_of_employees_table', 1),
(324, '2017_08_14_114221_create_countries_table', 1),
(325, '2017_08_14_115814_create_companies_table', 1),
(326, '2017_08_14_171355_create_departments_table', 1),
(327, '2017_08_16_145452_create_designations_table', 1),
(328, '2017_08_16_163703_create_branches_table', 1),
(329, '2017_08_17_114717_add_company_id_to_branches_table', 1),
(330, '2017_08_17_173741_create_tasks_table', 1),
(331, '2017_08_19_124158_add_priority_to_dpartments_table', 1),
(332, '2017_08_21_172423_create_employee_tasks_table', 1),
(333, '2017_08_23_151450_add_two_columns_to_employee_tasks_table', 1),
(334, '2017_08_23_190133_rename_employee_task_table', 1),
(335, '2017_08_24_125624_create_employee_task_table', 1),
(336, '2017_08_24_141444_create_task_activities_table', 1),
(337, '2017_08_24_182536_add_slug_to_tasks_table', 1),
(338, '2017_08_28_155016_add_two_columns_to_todo_lists_table', 1),
(339, '2017_08_28_183826_create_options_table', 1),
(340, '2017_08_29_163511_create_notifications_table', 1),
(341, '2017_09_19_163717_create_task_roles_table', 1),
(342, '2017_09_23_175950_add_task_role_id_to_todo_lists_table', 2),
(343, '2017_09_24_191020_remove_unique_from_two_columns_in_employees_table', 3),
(344, '2017_10_15_122751_create_frequencies_table', 4),
(345, '2017_10_15_151747_add_parent_id_to_departments_table', 5),
(347, '2017_10_15_170809_add_some_columns_to_empoloyee_tasks_table', 6),
(348, '2017_11_01_143304_add_company_id_to_task_roles_table', 7),
(349, '2017_11_01_170025_change_deadline_column_type_to_employee_tasks_table', 8),
(350, '2017_11_05_121626_update_some_columns_of_employees_table', 9),
(351, '2017_11_06_111444_modify_establied_year_in_companies_table', 10),
(352, '2017_11_06_111838_modify_establied_year_in_branches_table', 11),
(353, '2017_11_18_144711_add_parent_id_to_designations_table', 12),
(354, '2017_11_18_161217_add_two_columns_to_task_roles_table', 13),
(355, '2017_11_28_182148_add_some_columns_to_todo_lists_table', 14),
(356, '2017_12_03_112813_add_todo_list_id_to_task_activisties_table', 15),
(357, '2017_12_11_125501_create_permissions_table', 16),
(358, '2017_12_13_122826_update_username_column_to_users_table', 17),
(359, '2017_12_14_113818_add_new_columns_in_employee_tasks_table', 18),
(360, '2017_12_23_122258_add_table_achievement_logs', 19),
(361, '2017_12_23_171618_add_employee_task_id_in_todo_list_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
`id` int(10) unsigned NOT NULL,
  `resource_id` int(10) unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `resource_id`, `type`, `title`, `short_description`, `status`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 12, 'task_completed', 'Task Completed:Equipment Management', '', 'unread', 28, 27, '2017-12-31 10:58:53', '2017-12-31 10:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=56 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `company_id`, `name`, `value`) VALUES
(1, 1, 'week_starts_on', '6'),
(2, 1, 'date_format', 'M d, Y'),
(3, 1, 'timezone', 'Asia/Dhaka'),
(4, 1, 'day_off', '5'),
(5, 2, 'week_starts_on', '6'),
(6, 2, 'date_format', 'M d, Y'),
(7, 2, 'timezone', 'Asia/Dhaka'),
(8, 2, 'day_off', '5'),
(9, 3, 'week_starts_on', '6'),
(10, 3, 'date_format', 'M d, Y'),
(11, 3, 'timezone', 'Asia/Dhaka'),
(12, 3, 'day_off', '5'),
(13, 4, 'week_starts_on', '6'),
(14, 4, 'date_format', 'M d, Y'),
(15, 4, 'timezone', 'Asia/Dhaka'),
(16, 4, 'day_off', '5'),
(17, 5, 'week_starts_on', '6'),
(18, 5, 'date_format', 'M d, Y'),
(19, 5, 'timezone', 'Asia/Dhaka'),
(20, 5, 'day_off', '5'),
(21, 6, 'week_starts_on', '6'),
(22, 6, 'date_format', 'M d, Y'),
(23, 6, 'timezone', 'Asia/Dhaka'),
(24, 6, 'day_off', '5'),
(25, 7, 'week_starts_on', '6'),
(26, 7, 'date_format', 'M d, Y'),
(27, 7, 'timezone', 'Asia/Dhaka'),
(28, 7, 'day_off', '5'),
(29, 8, 'week_starts_on', '6'),
(30, 8, 'date_format', 'M d, Y'),
(31, 8, 'timezone', 'Asia/Dhaka'),
(32, 8, 'day_off', '5'),
(33, 9, 'week_starts_on', '6'),
(34, 9, 'date_format', 'M d, Y'),
(35, 9, 'timezone', 'Asia/Dhaka'),
(36, 9, 'day_off', '5'),
(37, 1, 'task_weight_scale', '30'),
(38, 1, 'financial_year', 'july-to-june'),
(39, 1, 'audit_sytem', 'disable'),
(40, 0, 'week_starts_on', '1'),
(41, 0, 'date_format', 'M d, Y'),
(42, 0, 'timezone', 'Asia/Kabul'),
(43, 0, 'task_weight_scale', '80'),
(44, 0, 'financial_year', 'jan-to-dec'),
(45, 0, 'audit_sytem', 'enable'),
(46, 15, 'week_starts_on', '6'),
(47, 15, 'date_format', 'M d, Y'),
(48, 15, 'timezone', 'Asia/Dhaka'),
(49, 15, 'day_off', '5'),
(50, 1, 'extended_time_1', '5'),
(51, 1, 'extended_time_2', '10'),
(52, 17, 'week_starts_on', '6'),
(53, 17, 'date_format', 'M d, Y'),
(54, 17, 'timezone', 'Asia/Dhaka'),
(55, 17, 'day_off', '5');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `branch_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_ids` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `user_id`, `branch_ids`, `department_ids`, `created_at`, `updated_at`) VALUES
(1, 26, '17', '20,21,22', '2017-12-12 08:22:14', '2018-01-03 06:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  `department_id` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `job_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `company_id`, `branch_id`, `department_id`, `parent_id`, `job_type`, `title`, `slug`, `description`, `frequency`, `status`, `deadline`, `priority`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, 5, 5, 0, 'need_basis', 'Historian', '1-historian', 'Est voluptatem rerum voluptatem alias. Ut corporis voluptatum amet deleniti cupiditate. Et consectetur iusto tenetur ipsam aperiam consequuntur. Debitis accusantium consequatur omnis voluptatum quia.', 'yearly', 'pending', '2017-11-01', 'high', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(2, 8, 8, 8, 0, 'need_basis', 'Securities Sales Agent', '2-securities-sales-agent', 'Mollitia et autem qui libero sint at est. Ad voluptates consectetur omnis consequatur earum ut. Accusamus aut numquam aperiam.', 'once', 'pending', '2017-11-05', 'normal', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(3, 1, 10, 10, 0, 'pre_defined', 'Aircraft Engine Specialist', '3-aircraft-engine-specialist', 'Quibusdam quis esse ad molestiae. Quo et minus maiores ipsum sed qui.', 'daily', 'pending', '2017-10-28', 'normal', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(4, 6, 6, 6, 0, 'need_basis', 'Aircraft Cargo Handling Supervisor', '4-aircraft-cargo-handling-supervisor', 'Rerum eum ab accusantium quidem sed. Quia ut magnam qui perspiciatis. Sed fuga commodi ad sunt aut et rerum.\nEveniet et incidunt laborum sed optio. Eum dolorum at et.', 'quarterly', 'pending', '2017-11-06', 'high', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(5, 1, 10, 10, 0, 'need_basis', 'Patrol Officer', '5-patrol-officer', 'Quam culpa quaerat illum corrupti maiores laudantium cumque. Commodi aliquid omnis aliquid aliquam. Hic autem laboriosam hic mollitia. Sint et dolor at in id cumque.', 'quarterly', 'pending', '2017-11-10', 'normal', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(6, 3, 3, 3, 0, 'need_basis', 'Underground Mining', '6-underground-mining', 'Nesciunt consequatur iusto reprehenderit explicabo. Quia incidunt quia a similique neque. Hic facere assumenda error dolores provident nisi tempora.', 'forthnightly', 'pending', '2017-11-01', 'high', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(7, 1, 10, 10, 0, 'pre_defined', 'Electronic Engineering Technician', '7-electronic-engineering-technician', 'Error adipisci eius soluta omnis neque totam. Necessitatibus rem id nisi quia cupiditate. Et cumque et vitae repellendus. Doloremque tempore provident ut.', 'quarterly', 'pending', '2017-11-10', 'high', NULL, 1, 0, '2017-10-22 09:17:17', '2017-10-22 09:17:18'),
(8, 1, 1, 1, 0, 'need_basis', 'Human Resources Manager', '8-human-resources-manager', 'Vero sunt quibusdam qui hic et et. Aperiam eius doloremque aut in laborum. Et repellat et sequi quia nihil. Veritatis delectus cum blanditiis ut explicabo quas earum.', 'monthly', 'pending', '2017-11-03', 'highest', NULL, 1, 0, '2017-10-22 09:17:18', '2017-10-22 09:17:18'),
(9, 1, 1, 1, 0, 'need_basis', 'Hotel Management', '9-hotel-management', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi soluta laboriosam, autem nemo, magni quod praesentium optio adipisci, temporibus culpa commodi officia harum iusto, eaque quae atque asperiores at maxime eligendi! Excepturi voluptatibus, officiis dolorum sint minus magni quae animi eius nostrum deleniti beatae cumque nihil quos sequi! Unde, fuga.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-01 06:44:06', '2017-11-01 06:44:06'),
(10, 1, 1, 11, 9, 'need_basis', 'Super Star', '10-super-star', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. At alias ea totam numquam cum dolorem rem nihil! Error ducimus pariatur deleniti blanditiis at facilis cumque in dolore id, quibusdam veritatis, reiciendis beatae labore nisi repudiandae expedita recusandae maxime est sapiente dolorem? A totam praesentium consequatur dignissimos, fuga blanditiis et! Nam!', '', 'pending', '0000-00-00', '', NULL, 2, 0, '2017-11-01 06:50:06', '2017-11-01 06:50:06'),
(11, 1, 1, 11, 9, 'pre_defined', 'Hot News', '11-hot-news', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ipsam veritatis nesciunt accusamus neque expedita ullam incidunt aliquam ut temporibus? Aliquam omnis voluptatem accusantium repellendus debitis quisquam aut natus deleniti quasi voluptatibus saepe corporis, eveniet, ipsum ducimus nemo optio aliquid laudantium quas expedita, doloremque maiores cumque ullam amet ab odit.', '', 'pending', '0000-00-00', '', NULL, 15, 15, '2017-11-01 06:57:43', '2017-11-01 08:28:48'),
(12, 1, 1, 11, 11, 'pre_defined', 'Sports', '12-sports', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora ipsa, nam commodi dolorem, tenetur blanditiis fugit ut laboriosam maxime doloremque officiis repellat neque fugiat vitae magni minus qui doloribus fuga repellendus earum ea quod corporis? Ab provident, nulla, maxime magnam, sunt alias delectus eos a corporis reiciendis officiis. Iusto, impedit.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-04 05:59:41', '2017-11-04 05:59:41'),
(13, 1, 10, 10, 5, 'pre_defined', 'Environment Management', '13-environment-management', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora ipsa, nam commodi dolorem, tenetur blanditiis fugit ut laboriosam maxime doloremque officiis repellat neque fugiat vitae magni minus qui doloribus fuga repellendus earum ea quod corporis? Ab provident, nulla, maxime magnam, sunt alias delectus eos a corporis reiciendis officiis. Iusto, impedit.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-04 06:02:34', '2017-11-04 06:02:34'),
(14, 13, 16, 18, 0, 'pre_defined', 'Machine Operations', '14-machine-operations', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum nihil deleniti labore, eos ratione omnis nam fuga dignissimos architecto eum temporibus voluptate, molestiae iusto ipsam quisquam rem hic mollitia earum sed sit tenetur, quo dolor. Quam autem, odit nulla voluptates ipsam veniam ipsa, perferendis nobis delectus neque explicabo reiciendis ipsum.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-07 06:22:05', '2017-11-07 06:22:05'),
(15, 13, 16, 18, 14, 'pre_defined', 'Machine Collection', '15-machine-collection', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum nihil deleniti labore, eos ratione omnis nam fuga dignissimos architecto eum temporibus voluptate, molestiae iusto ipsam quisquam rem hic mollitia earum sed sit tenetur, quo dolor. Quam autem, odit nulla voluptates ipsam veniam ipsa, perferendis nobis delectus neque explicabo reiciendis ipsum.', '', 'pending', '0000-00-00', '', NULL, 1, 1, '2017-11-07 06:22:54', '2017-11-07 06:41:22'),
(16, 13, 16, 18, 15, 'need_basis', 'Machine Arrangement', '16-machine-arrangement', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit quia, facilis illo et dolore perspiciatis, quae esse ex obcaecati culpa in rerum aut hic molestiae consequatur aspernatur animi enim maxime ipsam quam. Veritatis nostrum ab alias ratione esse, iure maiores, explicabo a quisquam quod. Rerum esse, laborum vitae fugit expedita.', '', 'pending', '0000-00-00', '', NULL, 21, 0, '2017-11-07 08:40:25', '2017-11-07 08:40:25'),
(17, 13, 16, 18, 14, 'need_basis', 'Machine Maintenance', '17-machine-maintenance', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut distinctio sed iusto incidunt ex quod dignissimos tempore ratione sint eos nulla sunt, explicabo qui facilis adipisci nemo doloremque repellendus consequuntur magni nobis amet illo veniam quae debitis? Laudantium nisi, voluptatem eum cupiditate possimus ipsa incidunt perspiciatis facere unde soluta. Tempore!', '', 'pending', '0000-00-00', '', NULL, 22, 22, '2017-11-07 08:45:54', '2017-11-07 08:56:57'),
(18, 13, 16, 18, 0, 'pre_defined', 'Security Management', '18-security-management', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur at nemo repellendus maxime, asperiores nulla molestias iste obcaecati facere. Tempore amet libero iure quos beatae pariatur consectetur quod possimus voluptates dolore similique natus, minima qui consequuntur ratione aliquam itaque repellat. Similique mollitia labore tenetur dolore maxime? Voluptates quasi error eius!', '', 'pending', '0000-00-00', '', NULL, 22, 0, '2017-11-07 09:46:00', '2017-11-07 09:46:01'),
(19, 14, 17, 20, 0, 'pre_defined', 'Accounting', '19-accounting', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla, perspiciatis cumque praesentium dolores enim perferendis odio dolore incidunt, officia reprehenderit, possimus temporibus? Deserunt explicabo accusamus libero dignissimos amet minus ratione porro nostrum, ipsa, numquam pariatur cum necessitatibus placeat nemo. Modi quas quaerat facilis nesciunt qui sapiente non optio fugiat molestiae.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-08 08:32:09', '2017-11-08 08:32:10'),
(20, 14, 17, 20, 19, 'pre_defined', 'Equipment Accounting', '20-equipment-accounting', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam ad ducimus doloremque aspernatur neque similique ab alias dolorum at incidunt animi, officia asperiores ut eius praesentium ipsum recusandae, in accusamus voluptate nostrum facere quod vel necessitatibus qui. Suscipit magni quasi dolorem quibusdam voluptatem fuga, architecto fugiat recusandae dolorum aspernatur officiis!', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-08 08:39:47', '2017-11-08 08:39:47'),
(21, 14, 17, 21, 0, 'pre_defined', 'Financial Functionalities', '21-financial-functionalities', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias modi odit, tenetur facere provident porro illo amet alias quia quisquam accusamus quasi nobis aspernatur, veritatis, debitis tempore. Mollitia repudiandae dolore architecto ex dignissimos, maxime ipsum veritatis placeat, quam, minus, eligendi libero consequatur esse praesentium quaerat aspernatur itaque. Temporibus, nesciunt iure!', '', 'pending', '0000-00-00', '', NULL, 25, 0, '2017-11-08 09:03:31', '2017-11-08 09:03:31'),
(22, 14, 19, 23, 0, 'pre_defined', 'Job Site Application', '22-job-site-application', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus doloribus dolorem, aperiam cumque! Laborum consequuntur, ducimus. Eos laudantium id quaerat sit ipsum illo fuga alias itaque, dignissimos aspernatur temporibus est nihil vero incidunt quam a fugit qui consequatur fugiat reprehenderit unde voluptates? Nulla autem nostrum, expedita vitae alias tempora corporis!', '', 'pending', '0000-00-00', '', NULL, 25, 0, '2017-11-08 09:05:22', '2017-11-08 09:05:22'),
(23, 14, 17, 20, 20, 'pre_defined', 'Equipment Management', '23-equipment-management', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima magni recusandae eius error soluta dignissimos, ipsam consequatur quam. Delectus voluptatum, laudantium facilis repudiandae, quas dolorem neque natus recusandae nisi iure ut. Molestias fugit minima magnam praesentium molestiae, aliquam nemo eveniet tempora reiciendis. Natus perferendis quam nisi, veritatis nam facilis est.', '', 'pending', '0000-00-00', '', NULL, 26, 26, '2017-11-08 09:29:30', '2017-12-13 08:30:51'),
(24, 14, 17, 20, 0, 'need_basis', 'Product Collection', '24-product-collection', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima magni recusandae eius error soluta dignissimos, ipsam consequatur quam. Delectus voluptatum, laudantium facilis repudiandae, quas dolorem neque natus recusandae nisi iure ut. Molestias fugit minima magnam praesentium molestiae, aliquam nemo eveniet tempora reiciendis. Natus perferendis quam nisi, veritatis nam facilis est.', '', 'pending', '0000-00-00', '', NULL, 26, 0, '2017-11-08 09:36:50', '2017-11-08 09:36:50'),
(25, 14, 19, 23, 22, 'need_basis', 'Job Seeker Registration', '25-job-seeker-registration', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates animi similique consequuntur nostrum ipsum laudantium eius commodi, ut fugit magni quis est, repellat quibusdam neque quod, minima sequi debitis. Inventore sapiente blanditiis nulla aspernatur molestias ratione asperiores at nesciunt odio, error, voluptatum fugiat saepe! Quis amet, perspiciatis dignissimos optio sapiente.', '', 'pending', '0000-00-00', '', NULL, 27, 0, '2017-11-08 10:25:40', '2017-11-08 10:25:40'),
(26, 14, 19, 23, 0, 'need_basis', 'Ecommerce Application', '26-ecommerce-application', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates animi similique consequuntur nostrum ipsum laudantium eius commodi, ut fugit magni quis est, repellat quibusdam neque quod, minima sequi debitis. Inventore sapiente blanditiis nulla aspernatur molestias ratione asperiores at nesciunt odio, error, voluptatum fugiat saepe! Quis amet, perspiciatis dignissimos optio sapiente.', '', 'pending', '0000-00-00', '', NULL, 27, 0, '2017-11-08 10:27:02', '2017-11-08 10:27:02'),
(27, 1, 10, 10, 0, 'need_basis', 'New Need Basis IT Task', '27-new-need-basis-it-task', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem soluta hic sint expedita saepe earum eligendi animi rem, at explicabo cupiditate tenetur excepturi laborum, non dolorum tempore necessitatibus impedit. Doloremque fugiat iusto provident mollitia, vitae vero architecto, assumenda molestias molestiae voluptate omnis soluta voluptatem deleniti, atque, sapiente tenetur! Facilis, quia.', '', 'pending', '0000-00-00', '', NULL, 2, 0, '2017-11-11 10:22:11', '2017-11-11 10:22:11'),
(28, 1, 10, 10, 0, 'need_basis', 'IT Need Basis Task', '28-it-need-basis-task', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia aliquid similique totam vel debitis quis non, quo, ipsum neque voluptates omnis, aut eos sapiente esse hic illum quidem blanditiis inventore ratione ducimus rerum commodi quos accusamus. Nihil eligendi totam, non mollitia. Ipsa, dicta animi autem deserunt voluptas blanditiis perferendis consequuntur.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-20 10:11:52', '2017-11-20 10:11:52'),
(29, 1, 10, 10, 0, 'need_basis', 'IT Another Need Basis Task', '29-it-another-need-basis-task', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia aliquid similique totam vel debitis quis non, quo, ipsum neque voluptates omnis, aut eos sapiente esse hic illum quidem blanditiis inventore ratione ducimus rerum commodi quos accusamus. Nihil eligendi totam, non mollitia. Ipsa, dicta animi autem deserunt voluptas blanditiis perferendis consequuntur.', '', 'pending', '0000-00-00', '', NULL, 1, 0, '2017-11-20 10:15:22', '2017-11-20 10:15:22'),
(30, 1, 10, 10, 0, 'need_basis', 'IT Need Basis Task 3', '30-it-need-basis-task-3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus assumenda quae enim dolorum hic adipisci cumque officia, neque quasi quidem. Quod similique ut itaque eum quos, optio quibusdam rem hic delectus excepturi nisi suscipit, reiciendis ducimus voluptatum facilis odio et minima. Ea alias quis et perferendis vero, delectus unde. Dolore.', '', 'pending', '0000-00-00', '', NULL, 2, 0, '2017-11-21 06:02:52', '2017-11-21 06:02:52'),
(31, 1, 10, 10, 0, 'need_basis', 'IT Need Basis Task 4', '31-it-need-basis-task-4', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id inventore, nemo architecto esse quos ex dolore doloremque enim quasi velit, consequuntur sunt commodi nulla repellendus, facere placeat officia. Ipsa rem at amet minus quidem fugit quae voluptatibus, voluptate dolorum repudiandae animi maiores officiis enim possimus omnis molestiae et incidunt quasi?', '', 'pending', '0000-00-00', '', NULL, 2, 0, '2017-11-29 05:50:44', '2017-11-29 05:50:44'),
(32, 1, 10, 10, 0, 'pre_defined', 'Sport Collection(WK)', '32-sport-collectionwk', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum itaque, sint impedit recusandae sunt vel optio voluptas laudantium doloremque aspernatur deleniti autem delectus expedita veritatis explicabo quidem perspiciatis sapiente praesentium ratione, ea. Beatae praesentium possimus explicabo rerum quia architecto itaque a vero, odio, dolores saepe quisquam natus vel, eos veniam!', '', 'pending', '0000-00-00', '', NULL, 2, 0, '2017-12-04 10:25:40', '2017-12-04 10:25:40'),
(33, 14, 17, 21, 0, 'need_basis', 'Finance Need Basis Task', '33-finance-need-basis-task', 'Test', '', 'pending', '0000-00-00', '', NULL, 25, 0, '2017-12-13 12:54:19', '2017-12-13 12:54:19'),
(34, 1, 1, 1, 0, 'pre_defined', 'Deletd', '34-deletd', 'deleted', '', 'pending', '0000-00-00', '', '2017-12-17 08:29:43', 1, 0, '2017-12-17 08:29:34', '2017-12-17 08:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `task_activities`
--

CREATE TABLE IF NOT EXISTS `task_activities` (
`id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `todo_list_id` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=246 ;

--
-- Dumping data for table `task_activities`
--

INSERT INTO `task_activities` (`id`, `employee_id`, `task_id`, `todo_list_id`, `comments`, `deleted_at`, `created_at`, `updated_at`) VALUES
(127, 29, 23, 12, 'Changed task status to accepted', NULL, '2017-12-31 10:57:53', '2017-12-31 10:57:53'),
(128, 28, 23, 12, '<p>This is comment<br></p>', NULL, '2017-12-31 10:58:01', '2017-12-31 10:58:01'),
(129, 29, 23, 12, 'Changed task status to completed', NULL, '2017-12-31 10:58:53', '2017-12-31 10:58:53'),
(130, 33, 3, 193, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(131, 33, 7, 194, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(132, 33, 11, 195, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(133, 33, 3, 196, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(134, 33, 7, 197, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(135, 33, 3, 198, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(136, 33, 7, 199, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(137, 33, 3, 200, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(138, 33, 7, 201, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(139, 33, 13, 202, 'Changed task status to completed', NULL, '2018-01-06 05:16:06', '2018-01-06 05:16:06'),
(140, 33, 3, 203, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(141, 33, 7, 204, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(142, 33, 3, 205, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(143, 33, 7, 206, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(144, 33, 3, 207, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(145, 33, 7, 208, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(146, 33, 3, 209, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(147, 33, 7, 210, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(148, 33, 3, 211, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(149, 33, 7, 212, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(150, 33, 3, 213, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(151, 33, 7, 214, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(152, 33, 13, 215, 'Changed task status to completed', NULL, '2018-01-06 05:16:07', '2018-01-06 05:16:07'),
(153, 33, 3, 216, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(154, 33, 7, 217, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(155, 33, 3, 218, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(156, 33, 7, 219, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(157, 33, 3, 220, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(158, 33, 7, 221, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(159, 33, 3, 222, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(160, 33, 7, 223, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(161, 33, 3, 224, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(162, 33, 7, 225, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(163, 33, 3, 226, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(164, 33, 7, 227, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(165, 33, 13, 228, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(166, 33, 3, 229, 'Changed task status to completed', NULL, '2018-01-06 05:16:08', '2018-01-06 05:16:08'),
(167, 33, 7, 230, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(168, 33, 3, 231, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(169, 33, 7, 232, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(170, 33, 3, 233, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(171, 33, 7, 234, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(172, 33, 3, 235, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(173, 33, 7, 236, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(174, 33, 3, 237, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(175, 33, 7, 238, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(176, 33, 3, 239, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(177, 33, 7, 240, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(178, 33, 13, 241, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(179, 33, 11, 242, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(180, 33, 3, 243, 'Changed task status to completed', NULL, '2018-01-06 05:16:09', '2018-01-06 05:16:09'),
(181, 33, 7, 244, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(182, 33, 3, 245, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(183, 33, 7, 246, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(184, 33, 3, 247, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(185, 33, 7, 248, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(186, 33, 3, 249, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(187, 33, 7, 250, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(188, 33, 3, 251, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(189, 33, 7, 252, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(190, 33, 3, 253, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(191, 33, 7, 254, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(192, 33, 13, 255, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(193, 33, 3, 256, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(194, 33, 7, 257, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(195, 33, 3, 258, 'Changed task status to completed', NULL, '2018-01-06 05:16:10', '2018-01-06 05:16:10'),
(196, 33, 7, 259, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(197, 33, 3, 260, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(198, 33, 7, 261, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(199, 33, 3, 262, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(200, 33, 7, 263, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(201, 33, 3, 264, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(202, 33, 7, 265, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(203, 33, 3, 266, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(204, 33, 7, 267, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(205, 33, 13, 268, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(206, 33, 3, 269, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(207, 33, 7, 270, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(208, 33, 3, 271, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(209, 33, 7, 272, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(210, 33, 3, 273, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(211, 33, 7, 274, 'Changed task status to completed', NULL, '2018-01-06 05:16:11', '2018-01-06 05:16:11'),
(212, 33, 3, 275, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(213, 33, 7, 276, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(214, 33, 3, 277, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(215, 33, 7, 278, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(216, 33, 3, 279, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(217, 33, 7, 280, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(218, 33, 13, 281, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(219, 33, 3, 282, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(220, 33, 7, 283, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(221, 33, 3, 284, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(222, 33, 7, 285, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(223, 33, 3, 286, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(224, 33, 7, 287, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(225, 33, 3, 288, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(226, 33, 7, 289, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(227, 33, 3, 290, 'Changed task status to completed', NULL, '2018-01-06 05:16:12', '2018-01-06 05:16:12'),
(228, 33, 7, 291, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(229, 33, 3, 292, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(230, 33, 7, 293, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(231, 33, 13, 294, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(232, 33, 3, 295, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(233, 33, 7, 296, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(234, 33, 3, 297, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(235, 33, 7, 298, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(236, 33, 11, 299, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(237, 33, 3, 300, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(238, 33, 7, 301, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(239, 33, 3, 302, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(240, 33, 7, 303, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(241, 33, 3, 304, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(242, 33, 7, 305, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(243, 33, 3, 306, 'Changed task status to completed', NULL, '2018-01-06 05:16:13', '2018-01-06 05:16:13'),
(244, 33, 7, 307, 'Changed task status to completed', NULL, '2018-01-06 05:16:14', '2018-01-06 05:16:14'),
(245, 33, 13, 308, 'Changed task status to completed', NULL, '2018-01-06 05:16:14', '2018-01-06 05:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `task_roles`
--

CREATE TABLE IF NOT EXISTS `task_roles` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  `department_id` int(10) unsigned NOT NULL DEFAULT '0',
  `role_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_weight` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `task_roles`
--

INSERT INTO `task_roles` (`id`, `company_id`, `branch_id`, `department_id`, `role_name`, `role_weight`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Executor', 20, NULL, 2, 1, '2017-09-23 11:51:44', '2017-11-18 12:32:43'),
(2, 1, 1, 1, 'Supervisor', 30, NULL, 2, 1, '2017-09-23 11:52:08', '2017-11-18 12:33:22'),
(3, 1, 1, 1, 'Co Executor', 30, NULL, 2, 1, '2017-09-23 11:52:32', '2017-11-18 12:33:44'),
(4, 13, 0, 0, 'Gold', 50, NULL, 1, 0, '2017-11-06 11:44:01', '2017-11-06 11:44:01'),
(5, 13, 0, 0, 'Silver', 30, NULL, 21, 0, '2017-11-06 12:04:27', '2017-11-06 12:04:27'),
(6, 13, 0, 0, 'Bronj', 20, NULL, 22, 0, '2017-11-07 04:55:42', '2017-11-07 04:55:42'),
(7, 14, 17, 20, 'High', 50, NULL, 1, 25, '2017-11-08 08:22:29', '2017-12-13 08:21:58'),
(8, 14, 17, 20, 'Medium', 30, NULL, 25, 25, '2017-11-08 09:07:03', '2017-12-13 08:22:08'),
(9, 14, 17, 20, 'Low', 20, NULL, 26, 25, '2017-11-08 09:34:44', '2017-12-13 08:22:20'),
(10, 1, 10, 10, 'Executor', 20, NULL, 1, 1, '2017-11-19 05:30:51', '2017-11-19 05:31:34'),
(11, 1, 10, 10, 'Supervisor', 30, NULL, 1, 0, '2017-11-19 05:32:18', '2017-11-19 05:32:18'),
(12, 1, 10, 10, 'Co Executor', 30, NULL, 2, 0, '2017-11-19 05:33:32', '2017-11-19 05:33:32'),
(13, 14, 17, 21, 'High', 50, NULL, 25, 0, '2017-12-13 12:55:45', '2017-12-13 12:55:45'),
(14, 14, 17, 21, 'Medium', 30, NULL, 25, 0, '2017-12-13 12:56:04', '2017-12-13 12:56:04'),
(15, 14, 17, 21, 'Low', 20, NULL, 25, 0, '2017-12-13 12:56:20', '2017-12-13 12:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `todo_lists`
--

CREATE TABLE IF NOT EXISTS `todo_lists` (
`id` int(10) unsigned NOT NULL,
  `employee_task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_role_id` int(11) NOT NULL DEFAULT '0',
  `earned_point` double(8,2) NOT NULL DEFAULT '0.00',
  `deadline` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `finished_at` timestamp NULL DEFAULT NULL,
  `assigned_via` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cron',
  `approved_by` int(10) unsigned NOT NULL DEFAULT '0',
  `approved_on` timestamp NULL DEFAULT NULL,
  `achievement` int(11) NOT NULL DEFAULT '0',
  `extended_dateline_1` timestamp NULL DEFAULT NULL,
  `extended_dateline_2` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `assigned_by` int(10) unsigned NOT NULL DEFAULT '0',
  `assigned_at` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=322 ;

--
-- Dumping data for table `todo_lists`
--

INSERT INTO `todo_lists` (`id`, `employee_task_id`, `task_id`, `employee_id`, `task_role_id`, `earned_point`, `deadline`, `status`, `finished_at`, `assigned_via`, `approved_by`, `approved_on`, `achievement`, `extended_dateline_1`, `extended_dateline_2`, `deleted_at`, `assigned_by`, `assigned_at`) VALUES
(10, 17, 19, 29, 7, 0.00, '2017-12-31 05:10:29', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-05 05:10:29', '2018-01-10 05:10:29', NULL, 26, '2017-12-30 11:10:29'),
(11, 18, 20, 29, 7, 0.00, '2017-12-31 05:10:35', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-05 05:10:35', '2018-01-10 05:10:35', NULL, 26, '2017-12-30 11:10:35'),
(12, 19, 23, 29, 8, 30.00, '2017-12-31 05:10:40', 'completed', '2017-12-31 10:58:53', 'cron', 0, NULL, 0, '2018-01-05 05:10:40', '2018-01-10 05:10:40', NULL, 26, '2017-12-30 11:10:40'),
(149, 17, 19, 29, 7, 0.00, '2018-01-01 06:15:37', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:15:37', '2018-01-11 06:15:37', NULL, 26, '2017-12-31 12:15:37'),
(150, 18, 20, 29, 7, 0.00, '2018-01-01 06:15:42', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:15:42', '2018-01-11 06:15:42', NULL, 26, '2017-12-31 12:15:42'),
(151, 19, 23, 29, 8, 0.00, '2018-01-01 06:15:48', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:15:48', '2018-01-11 06:15:48', NULL, 26, '2017-12-31 12:15:48'),
(152, 20, 19, 37, 7, 0.00, '2018-01-01 06:15:53', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:15:53', '2018-01-11 06:15:53', NULL, 26, '2017-12-31 12:15:53'),
(153, 21, 20, 37, 8, 0.00, '2018-01-01 06:15:58', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:15:58', '2018-01-11 06:15:58', NULL, 26, '2017-12-31 12:15:58'),
(154, 22, 23, 37, 8, 0.00, '2018-01-01 06:16:04', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:16:04', '2018-01-11 06:16:04', NULL, 26, '2017-12-31 12:16:04'),
(155, 23, 19, 38, 7, 0.00, '2018-01-01 06:16:09', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:16:09', '2018-01-11 06:16:09', NULL, 26, '2017-12-31 12:16:09'),
(156, 24, 20, 38, 8, 0.00, '2018-01-01 06:16:14', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:16:14', '2018-01-11 06:16:14', NULL, 26, '2017-12-31 12:16:14'),
(157, 25, 23, 38, 9, 0.00, '2018-01-01 06:16:20', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:16:20', '2018-01-11 06:16:20', NULL, 26, '2017-12-31 12:16:20'),
(158, 27, 19, 39, 13, 0.00, '2018-01-01 06:16:25', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-06 06:16:25', '2018-01-11 06:16:25', NULL, 25, '2017-12-31 12:16:25'),
(168, 17, 19, 29, 7, 0.00, '2018-01-02 04:43:43', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:43:43', '2018-01-12 04:43:43', NULL, 26, '2018-01-01 10:43:43'),
(169, 18, 20, 29, 7, 0.00, '2018-01-02 04:43:48', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:43:48', '2018-01-12 04:43:48', NULL, 26, '2018-01-01 10:43:48'),
(170, 19, 23, 29, 8, 0.00, '2018-01-02 04:43:54', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:43:54', '2018-01-12 04:43:54', NULL, 26, '2018-01-01 10:43:54'),
(171, 20, 19, 37, 7, 0.00, '2018-01-02 04:44:00', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:00', '2018-01-12 04:44:00', NULL, 26, '2018-01-01 10:44:00'),
(172, 21, 20, 37, 8, 0.00, '2018-01-02 04:44:05', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:05', '2018-01-12 04:44:05', NULL, 26, '2018-01-01 10:44:05'),
(173, 22, 23, 37, 8, 0.00, '2018-01-02 04:44:12', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:12', '2018-01-12 04:44:12', NULL, 26, '2018-01-01 10:44:12'),
(174, 23, 19, 38, 7, 0.00, '2018-01-02 04:44:19', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:19', '2018-01-12 04:44:19', NULL, 26, '2018-01-01 10:44:19'),
(175, 24, 20, 38, 8, 0.00, '2018-01-02 04:44:25', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:25', '2018-01-12 04:44:25', NULL, 26, '2018-01-01 10:44:25'),
(176, 25, 23, 38, 9, 0.00, '2018-01-02 04:44:31', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:31', '2018-01-12 04:44:31', NULL, 26, '2018-01-01 10:44:31'),
(177, 27, 19, 39, 13, 0.00, '2018-01-02 04:44:39', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-07 04:44:39', '2018-01-12 04:44:39', NULL, 25, '2018-01-01 10:44:39'),
(183, 17, 19, 29, 7, 0.00, '2018-01-03 04:50:38', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:50:38', '2018-01-13 04:50:38', NULL, 26, '2018-01-02 10:50:38'),
(184, 18, 20, 29, 7, 0.00, '2018-01-03 04:50:44', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:50:44', '2018-01-13 04:50:44', NULL, 26, '2018-01-02 10:50:44'),
(185, 19, 23, 29, 8, 0.00, '2018-01-03 04:50:49', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:50:49', '2018-01-13 04:50:49', NULL, 26, '2018-01-02 10:50:49'),
(186, 20, 19, 37, 7, 0.00, '2018-01-03 04:50:55', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:50:55', '2018-01-13 04:50:55', NULL, 26, '2018-01-02 10:50:55'),
(187, 21, 20, 37, 8, 0.00, '2018-01-03 04:51:01', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:51:01', '2018-01-13 04:51:01', NULL, 26, '2018-01-02 10:51:01'),
(188, 22, 23, 37, 8, 0.00, '2018-01-03 04:51:06', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:51:06', '2018-01-13 04:51:06', NULL, 26, '2018-01-02 10:51:06'),
(189, 23, 19, 38, 7, 0.00, '2018-01-03 04:51:11', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:51:11', '2018-01-13 04:51:11', NULL, 26, '2018-01-02 10:51:11'),
(190, 24, 20, 38, 8, 0.00, '2018-01-03 04:51:17', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:51:17', '2018-01-13 04:51:17', NULL, 26, '2018-01-02 10:51:17'),
(191, 25, 23, 38, 9, 0.00, '2018-01-03 04:51:22', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:51:22', '2018-01-13 04:51:22', NULL, 26, '2018-01-02 10:51:22'),
(192, 27, 19, 39, 13, 0.00, '2018-01-03 04:51:27', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-08 04:51:27', '2018-01-13 04:51:27', NULL, 25, '2018-01-02 10:51:27'),
(193, 28, 3, 33, 10, 20.00, '2017-11-07 05:00:00', 'completed', '2017-11-07 05:00:00', 'cron', 0, NULL, 0, '2017-11-12 05:00:00', '2017-11-17 05:00:00', NULL, 2, '2017-11-07 11:16:06'),
(194, 29, 7, 33, 11, 30.00, '2017-11-07 05:00:00', 'completed', '2017-11-07 05:00:00', 'cron', 0, NULL, 0, '2017-11-12 05:00:00', '2017-11-17 05:00:00', NULL, 2, '2017-11-07 11:16:06'),
(195, 31, 11, 33, 10, 20.00, '2017-12-07 05:00:00', 'completed', '2017-12-07 05:00:00', 'cron', 0, NULL, 0, '2017-12-12 05:00:00', '2017-12-17 05:00:00', NULL, 2, '2017-11-07 11:16:06'),
(196, 28, 3, 33, 10, 20.00, '2017-11-08 05:00:00', 'completed', '2017-11-08 05:00:00', 'cron', 0, NULL, 0, '2017-11-13 05:00:00', '2017-11-18 05:00:00', NULL, 2, '2017-11-08 11:16:06'),
(197, 29, 7, 33, 11, 30.00, '2017-11-08 05:00:00', 'completed', '2017-11-08 05:00:00', 'cron', 0, NULL, 0, '2017-11-13 05:00:00', '2017-11-18 05:00:00', NULL, 2, '2017-11-08 11:16:06'),
(198, 28, 3, 33, 10, 20.00, '2017-11-09 05:00:00', 'completed', '2017-11-09 05:00:00', 'cron', 0, NULL, 0, '2017-11-14 05:00:00', '2017-11-19 05:00:00', NULL, 2, '2017-11-09 11:16:06'),
(199, 29, 7, 33, 11, 30.00, '2017-11-09 05:00:00', 'completed', '2017-11-09 05:00:00', 'cron', 0, NULL, 0, '2017-11-14 05:00:00', '2017-11-19 05:00:00', NULL, 2, '2017-11-09 11:16:06'),
(200, 28, 3, 33, 10, 20.00, '2017-11-11 05:00:00', 'completed', '2017-11-11 05:00:00', 'cron', 0, NULL, 0, '2017-11-16 05:00:00', '2017-11-21 05:00:00', NULL, 2, '2017-11-11 11:16:06'),
(201, 29, 7, 33, 11, 30.00, '2017-11-11 05:00:00', 'completed', '2017-11-11 05:00:00', 'cron', 0, NULL, 0, '2017-11-16 05:00:00', '2017-11-21 05:00:00', NULL, 2, '2017-11-11 11:16:06'),
(202, 30, 13, 33, 11, 30.00, '2017-11-18 05:00:00', 'completed', '2017-11-18 05:00:00', 'cron', 0, NULL, 0, '2017-11-23 05:00:00', '2017-11-28 05:00:00', NULL, 2, '2017-11-11 11:16:06'),
(203, 28, 3, 33, 10, 20.00, '2017-11-12 05:00:00', 'completed', '2017-11-12 05:00:00', 'cron', 0, NULL, 0, '2017-11-17 05:00:00', '2017-11-22 05:00:00', NULL, 2, '2017-11-12 11:16:06'),
(204, 29, 7, 33, 11, 30.00, '2017-11-12 05:00:00', 'completed', '2017-11-12 05:00:00', 'cron', 0, NULL, 0, '2017-11-17 05:00:00', '2017-11-22 05:00:00', NULL, 2, '2017-11-12 11:16:06'),
(205, 28, 3, 33, 10, 20.00, '2017-11-13 05:00:00', 'completed', '2017-11-13 05:00:00', 'cron', 0, NULL, 0, '2017-11-18 05:00:00', '2017-11-23 05:00:00', NULL, 2, '2017-11-13 11:16:06'),
(206, 29, 7, 33, 11, 30.00, '2017-11-13 05:00:00', 'completed', '2017-11-13 05:00:00', 'cron', 0, NULL, 0, '2017-11-18 05:00:00', '2017-11-23 05:00:00', NULL, 2, '2017-11-13 11:16:06'),
(207, 28, 3, 33, 10, 20.00, '2017-11-14 05:00:00', 'completed', '2017-11-14 05:00:00', 'cron', 0, NULL, 0, '2017-11-19 05:00:00', '2017-11-24 05:00:00', NULL, 2, '2017-11-14 11:16:06'),
(208, 29, 7, 33, 11, 30.00, '2017-11-14 05:00:00', 'completed', '2017-11-14 05:00:00', 'cron', 0, NULL, 0, '2017-11-19 05:00:00', '2017-11-24 05:00:00', NULL, 2, '2017-11-14 11:16:06'),
(209, 28, 3, 33, 10, 20.00, '2017-11-15 05:00:00', 'completed', '2017-11-15 05:00:00', 'cron', 0, NULL, 0, '2017-11-20 05:00:00', '2017-11-25 05:00:00', NULL, 2, '2017-11-15 11:16:06'),
(210, 29, 7, 33, 11, 30.00, '2017-11-15 05:00:00', 'completed', '2017-11-15 05:00:00', 'cron', 0, NULL, 0, '2017-11-20 05:00:00', '2017-11-25 05:00:00', NULL, 2, '2017-11-15 11:16:06'),
(211, 28, 3, 33, 10, 20.00, '2017-11-16 05:00:00', 'completed', '2017-11-16 05:00:00', 'cron', 0, NULL, 0, '2017-11-21 05:00:00', '2017-11-26 05:00:00', NULL, 2, '2017-11-16 11:16:06'),
(212, 29, 7, 33, 11, 30.00, '2017-11-16 05:00:00', 'completed', '2017-11-16 05:00:00', 'cron', 0, NULL, 0, '2017-11-21 05:00:00', '2017-11-26 05:00:00', NULL, 2, '2017-11-16 11:16:06'),
(213, 28, 3, 33, 10, 20.00, '2017-11-18 05:00:00', 'completed', '2017-11-18 05:00:00', 'cron', 0, NULL, 0, '2017-11-23 05:00:00', '2017-11-28 05:00:00', NULL, 2, '2017-11-18 11:16:06'),
(214, 29, 7, 33, 11, 30.00, '2017-11-18 05:00:00', 'completed', '2017-11-18 05:00:00', 'cron', 0, NULL, 0, '2017-11-23 05:00:00', '2017-11-28 05:00:00', NULL, 2, '2017-11-18 11:16:06'),
(215, 30, 13, 33, 11, 30.00, '2017-11-25 05:00:00', 'completed', '2017-11-25 05:00:00', 'cron', 0, NULL, 0, '2017-11-30 05:00:00', '2017-12-05 05:00:00', NULL, 2, '2017-11-18 11:16:06'),
(216, 28, 3, 33, 10, 20.00, '2017-11-19 05:00:00', 'completed', '2017-11-19 05:00:00', 'cron', 0, NULL, 0, '2017-11-24 05:00:00', '2017-11-29 05:00:00', NULL, 2, '2017-11-19 11:16:06'),
(217, 29, 7, 33, 11, 30.00, '2017-11-19 05:00:00', 'completed', '2017-11-19 05:00:00', 'cron', 0, NULL, 0, '2017-11-24 05:00:00', '2017-11-29 05:00:00', NULL, 2, '2017-11-19 11:16:06'),
(218, 28, 3, 33, 10, 20.00, '2017-11-20 05:00:00', 'completed', '2017-11-20 05:00:00', 'cron', 0, NULL, 0, '2017-11-25 05:00:00', '2017-11-30 05:00:00', NULL, 2, '2017-11-20 11:16:06'),
(219, 29, 7, 33, 11, 30.00, '2017-11-20 05:00:00', 'completed', '2017-11-20 05:00:00', 'cron', 0, NULL, 0, '2017-11-25 05:00:00', '2017-11-30 05:00:00', NULL, 2, '2017-11-20 11:16:06'),
(220, 28, 3, 33, 10, 20.00, '2017-11-21 05:00:00', 'completed', '2017-11-21 05:00:00', 'cron', 0, NULL, 0, '2017-11-26 05:00:00', '2017-12-01 05:00:00', NULL, 2, '2017-11-21 11:16:06'),
(221, 29, 7, 33, 11, 30.00, '2017-11-21 05:00:00', 'completed', '2017-11-21 05:00:00', 'cron', 0, NULL, 0, '2017-11-26 05:00:00', '2017-12-01 05:00:00', NULL, 2, '2017-11-21 11:16:06'),
(222, 28, 3, 33, 10, 20.00, '2017-11-22 05:00:00', 'completed', '2017-11-22 05:00:00', 'cron', 0, NULL, 0, '2017-11-27 05:00:00', '2017-12-02 05:00:00', NULL, 2, '2017-11-22 11:16:06'),
(223, 29, 7, 33, 11, 30.00, '2017-11-22 05:00:00', 'completed', '2017-11-22 05:00:00', 'cron', 0, NULL, 0, '2017-11-27 05:00:00', '2017-12-02 05:00:00', NULL, 2, '2017-11-22 11:16:06'),
(224, 28, 3, 33, 10, 20.00, '2017-11-23 05:00:00', 'completed', '2017-11-23 05:00:00', 'cron', 0, NULL, 0, '2017-11-28 05:00:00', '2017-12-03 05:00:00', NULL, 2, '2017-11-23 11:16:06'),
(225, 29, 7, 33, 11, 30.00, '2017-11-23 05:00:00', 'completed', '2017-11-23 05:00:00', 'cron', 0, NULL, 0, '2017-11-28 05:00:00', '2017-12-03 05:00:00', NULL, 2, '2017-11-23 11:16:06'),
(226, 28, 3, 33, 10, 20.00, '2017-11-25 05:00:00', 'completed', '2017-11-25 05:00:00', 'cron', 0, NULL, 0, '2017-11-30 05:00:00', '2017-12-05 05:00:00', NULL, 2, '2017-11-25 11:16:06'),
(227, 29, 7, 33, 11, 30.00, '2017-11-25 05:00:00', 'completed', '2017-11-25 05:00:00', 'cron', 0, NULL, 0, '2017-11-30 05:00:00', '2017-12-05 05:00:00', NULL, 2, '2017-11-25 11:16:06'),
(228, 30, 13, 33, 11, 30.00, '2017-12-02 05:00:00', 'completed', '2017-12-02 05:00:00', 'cron', 0, NULL, 0, '2017-12-07 05:00:00', '2017-12-12 05:00:00', NULL, 2, '2017-11-25 11:16:06'),
(229, 28, 3, 33, 10, 20.00, '2017-11-26 05:00:00', 'completed', '2017-11-26 05:00:00', 'cron', 0, NULL, 0, '2017-12-01 05:00:00', '2017-12-06 05:00:00', NULL, 2, '2017-11-26 11:16:06'),
(230, 29, 7, 33, 11, 30.00, '2017-11-26 05:00:00', 'completed', '2017-11-26 05:00:00', 'cron', 0, NULL, 0, '2017-12-01 05:00:00', '2017-12-06 05:00:00', NULL, 2, '2017-11-26 11:16:06'),
(231, 28, 3, 33, 10, 20.00, '2017-11-27 05:00:00', 'completed', '2017-11-27 05:00:00', 'cron', 0, NULL, 0, '2017-12-02 05:00:00', '2017-12-07 05:00:00', NULL, 2, '2017-11-27 11:16:06'),
(232, 29, 7, 33, 11, 30.00, '2017-11-27 05:00:00', 'completed', '2017-11-27 05:00:00', 'cron', 0, NULL, 0, '2017-12-02 05:00:00', '2017-12-07 05:00:00', NULL, 2, '2017-11-27 11:16:06'),
(233, 28, 3, 33, 10, 20.00, '2017-11-28 05:00:00', 'completed', '2017-11-28 05:00:00', 'cron', 0, NULL, 0, '2017-12-03 05:00:00', '2017-12-08 05:00:00', NULL, 2, '2017-11-28 11:16:06'),
(234, 29, 7, 33, 11, 30.00, '2017-11-28 05:00:00', 'completed', '2017-11-28 05:00:00', 'cron', 0, NULL, 0, '2017-12-03 05:00:00', '2017-12-08 05:00:00', NULL, 2, '2017-11-28 11:16:06'),
(235, 28, 3, 33, 10, 20.00, '2017-11-29 05:00:00', 'completed', '2017-11-29 05:00:00', 'cron', 0, NULL, 0, '2017-12-04 05:00:00', '2017-12-09 05:00:00', NULL, 2, '2017-11-29 11:16:06'),
(236, 29, 7, 33, 11, 30.00, '2017-11-29 05:00:00', 'completed', '2017-11-29 05:00:00', 'cron', 0, NULL, 0, '2017-12-04 05:00:00', '2017-12-09 05:00:00', NULL, 2, '2017-11-29 11:16:06'),
(237, 28, 3, 33, 10, 20.00, '2017-11-30 05:00:00', 'completed', '2017-11-30 05:00:00', 'cron', 0, NULL, 0, '2017-12-05 05:00:00', '2017-12-10 05:00:00', NULL, 2, '2017-11-30 11:16:06'),
(238, 29, 7, 33, 11, 30.00, '2017-11-30 05:00:00', 'completed', '2017-11-30 05:00:00', 'cron', 0, NULL, 0, '2017-12-05 05:00:00', '2017-12-10 05:00:00', NULL, 2, '2017-11-30 11:16:06'),
(239, 28, 3, 33, 10, 20.00, '2017-12-02 05:00:00', 'completed', '2017-12-02 05:00:00', 'cron', 0, NULL, 0, '2017-12-07 05:00:00', '2017-12-12 05:00:00', NULL, 2, '2017-12-02 11:16:06'),
(240, 29, 7, 33, 11, 30.00, '2017-12-02 05:00:00', 'completed', '2017-12-02 05:00:00', 'cron', 0, NULL, 0, '2017-12-07 05:00:00', '2017-12-12 05:00:00', NULL, 2, '2017-12-02 11:16:06'),
(241, 30, 13, 33, 11, 30.00, '2017-12-09 05:00:00', 'completed', '2017-12-09 05:00:00', 'cron', 0, NULL, 0, '2017-12-14 05:00:00', '2017-12-19 05:00:00', NULL, 2, '2017-12-02 11:16:06'),
(242, 31, 11, 33, 10, 20.00, '2018-01-02 05:00:00', 'completed', '2018-01-02 05:00:00', 'cron', 0, NULL, 0, '2018-01-07 05:00:00', '2018-01-12 05:00:00', NULL, 2, '2017-12-02 11:16:06'),
(243, 28, 3, 33, 10, 20.00, '2017-12-03 05:00:00', 'completed', '2017-12-03 05:00:00', 'cron', 0, NULL, 0, '2017-12-08 05:00:00', '2017-12-13 05:00:00', NULL, 2, '2017-12-03 11:16:06'),
(244, 29, 7, 33, 11, 30.00, '2017-12-03 05:00:00', 'completed', '2017-12-03 05:00:00', 'cron', 0, NULL, 0, '2017-12-08 05:00:00', '2017-12-13 05:00:00', NULL, 2, '2017-12-03 11:16:06'),
(245, 28, 3, 33, 10, 20.00, '2017-12-04 05:00:00', 'completed', '2017-12-04 05:00:00', 'cron', 0, NULL, 0, '2017-12-09 05:00:00', '2017-12-14 05:00:00', NULL, 2, '2017-12-04 11:16:06'),
(246, 29, 7, 33, 11, 30.00, '2017-12-04 05:00:00', 'completed', '2017-12-04 05:00:00', 'cron', 0, NULL, 0, '2017-12-09 05:00:00', '2017-12-14 05:00:00', NULL, 2, '2017-12-04 11:16:06'),
(247, 28, 3, 33, 10, 20.00, '2017-12-05 05:00:00', 'completed', '2017-12-05 05:00:00', 'cron', 0, NULL, 0, '2017-12-10 05:00:00', '2017-12-15 05:00:00', NULL, 2, '2017-12-05 11:16:06'),
(248, 29, 7, 33, 11, 30.00, '2017-12-05 05:00:00', 'completed', '2017-12-05 05:00:00', 'cron', 0, NULL, 0, '2017-12-10 05:00:00', '2017-12-15 05:00:00', NULL, 2, '2017-12-05 11:16:06'),
(249, 28, 3, 33, 10, 20.00, '2017-12-06 05:00:00', 'completed', '2017-12-06 05:00:00', 'cron', 0, NULL, 0, '2017-12-11 05:00:00', '2017-12-16 05:00:00', NULL, 2, '2017-12-06 11:16:06'),
(250, 29, 7, 33, 11, 30.00, '2017-12-06 05:00:00', 'completed', '2017-12-06 05:00:00', 'cron', 0, NULL, 0, '2017-12-11 05:00:00', '2017-12-16 05:00:00', NULL, 2, '2017-12-06 11:16:06'),
(251, 28, 3, 33, 10, 20.00, '2017-12-07 05:00:00', 'completed', '2017-12-07 05:00:00', 'cron', 0, NULL, 0, '2017-12-12 05:00:00', '2017-12-17 05:00:00', NULL, 2, '2017-12-07 11:16:06'),
(252, 29, 7, 33, 11, 30.00, '2017-12-07 05:00:00', 'completed', '2017-12-07 05:00:00', 'cron', 0, NULL, 0, '2017-12-12 05:00:00', '2017-12-17 05:00:00', NULL, 2, '2017-12-07 11:16:06'),
(253, 28, 3, 33, 10, 20.00, '2017-12-09 05:00:00', 'completed', '2017-12-09 05:00:00', 'cron', 0, NULL, 0, '2017-12-14 05:00:00', '2017-12-19 05:00:00', NULL, 2, '2017-12-09 11:16:06'),
(254, 29, 7, 33, 11, 30.00, '2017-12-09 05:00:00', 'completed', '2017-12-09 05:00:00', 'cron', 0, NULL, 0, '2017-12-14 05:00:00', '2017-12-19 05:00:00', NULL, 2, '2017-12-09 11:16:06'),
(255, 30, 13, 33, 11, 30.00, '2017-12-16 05:00:00', 'completed', '2017-12-16 05:00:00', 'cron', 0, NULL, 0, '2017-12-21 05:00:00', '2017-12-26 05:00:00', NULL, 2, '2017-12-09 11:16:06'),
(256, 28, 3, 33, 10, 20.00, '2017-12-10 05:00:00', 'completed', '2017-12-10 05:00:00', 'cron', 0, NULL, 0, '2017-12-15 05:00:00', '2017-12-20 05:00:00', NULL, 2, '2017-12-10 11:16:06'),
(257, 29, 7, 33, 11, 30.00, '2017-12-10 05:00:00', 'completed', '2017-12-10 05:00:00', 'cron', 0, NULL, 0, '2017-12-15 05:00:00', '2017-12-20 05:00:00', NULL, 2, '2017-12-10 11:16:06'),
(258, 28, 3, 33, 10, 20.00, '2017-12-11 05:00:00', 'completed', '2017-12-11 05:00:00', 'cron', 0, NULL, 0, '2017-12-16 05:00:00', '2017-12-21 05:00:00', NULL, 2, '2017-12-11 11:16:06'),
(259, 29, 7, 33, 11, 30.00, '2017-12-11 05:00:00', 'completed', '2017-12-11 05:00:00', 'cron', 0, NULL, 0, '2017-12-16 05:00:00', '2017-12-21 05:00:00', NULL, 2, '2017-12-11 11:16:06'),
(260, 28, 3, 33, 10, 20.00, '2017-12-12 05:00:00', 'completed', '2017-12-12 05:00:00', 'cron', 0, NULL, 0, '2017-12-17 05:00:00', '2017-12-22 05:00:00', NULL, 2, '2017-12-12 11:16:06'),
(261, 29, 7, 33, 11, 30.00, '2017-12-12 05:00:00', 'completed', '2017-12-12 05:00:00', 'cron', 0, NULL, 0, '2017-12-17 05:00:00', '2017-12-22 05:00:00', NULL, 2, '2017-12-12 11:16:06'),
(262, 28, 3, 33, 10, 20.00, '2017-12-13 05:00:00', 'completed', '2017-12-13 05:00:00', 'cron', 0, NULL, 0, '2017-12-18 05:00:00', '2017-12-23 05:00:00', NULL, 2, '2017-12-13 11:16:06'),
(263, 29, 7, 33, 11, 30.00, '2017-12-13 05:00:00', 'completed', '2017-12-13 05:00:00', 'cron', 0, NULL, 0, '2017-12-18 05:00:00', '2017-12-23 05:00:00', NULL, 2, '2017-12-13 11:16:06'),
(264, 28, 3, 33, 10, 20.00, '2017-12-14 05:00:00', 'completed', '2017-12-14 05:00:00', 'cron', 0, NULL, 0, '2017-12-19 05:00:00', '2017-12-24 05:00:00', NULL, 2, '2017-12-14 11:16:06'),
(265, 29, 7, 33, 11, 30.00, '2017-12-14 05:00:00', 'completed', '2017-12-14 05:00:00', 'cron', 0, NULL, 0, '2017-12-19 05:00:00', '2017-12-24 05:00:00', NULL, 2, '2017-12-14 11:16:06'),
(266, 28, 3, 33, 10, 20.00, '2017-12-16 05:00:00', 'completed', '2017-12-16 05:00:00', 'cron', 0, NULL, 0, '2017-12-21 05:00:00', '2017-12-26 05:00:00', NULL, 2, '2017-12-16 11:16:06'),
(267, 29, 7, 33, 11, 30.00, '2017-12-16 05:00:00', 'completed', '2017-12-16 05:00:00', 'cron', 0, NULL, 0, '2017-12-21 05:00:00', '2017-12-26 05:00:00', NULL, 2, '2017-12-16 11:16:06'),
(268, 30, 13, 33, 11, 30.00, '2017-12-23 05:00:00', 'completed', '2017-12-23 05:00:00', 'cron', 0, NULL, 0, '2017-12-28 05:00:00', '2018-01-02 05:00:00', NULL, 2, '2017-12-16 11:16:06'),
(269, 28, 3, 33, 10, 20.00, '2017-12-17 05:00:00', 'completed', '2017-12-17 05:00:00', 'cron', 0, NULL, 0, '2017-12-22 05:00:00', '2017-12-27 05:00:00', NULL, 2, '2017-12-17 11:16:06'),
(270, 29, 7, 33, 11, 30.00, '2017-12-17 05:00:00', 'completed', '2017-12-17 05:00:00', 'cron', 0, NULL, 0, '2017-12-22 05:00:00', '2017-12-27 05:00:00', NULL, 2, '2017-12-17 11:16:06'),
(271, 28, 3, 33, 10, 20.00, '2017-12-18 05:00:00', 'completed', '2017-12-18 05:00:00', 'cron', 0, NULL, 0, '2017-12-23 05:00:00', '2017-12-28 05:00:00', NULL, 2, '2017-12-18 11:16:06'),
(272, 29, 7, 33, 11, 30.00, '2017-12-18 05:00:00', 'completed', '2017-12-18 05:00:00', 'cron', 0, NULL, 0, '2017-12-23 05:00:00', '2017-12-28 05:00:00', NULL, 2, '2017-12-18 11:16:06'),
(273, 28, 3, 33, 10, 20.00, '2017-12-19 05:00:00', 'completed', '2017-12-19 05:00:00', 'cron', 0, NULL, 0, '2017-12-24 05:00:00', '2017-12-29 05:00:00', NULL, 2, '2017-12-19 11:16:06'),
(274, 29, 7, 33, 11, 30.00, '2017-12-19 05:00:00', 'completed', '2017-12-19 05:00:00', 'cron', 0, NULL, 0, '2017-12-24 05:00:00', '2017-12-29 05:00:00', NULL, 2, '2017-12-19 11:16:06'),
(275, 28, 3, 33, 10, 20.00, '2017-12-20 05:00:00', 'completed', '2017-12-20 05:00:00', 'cron', 0, NULL, 0, '2017-12-25 05:00:00', '2017-12-30 05:00:00', NULL, 2, '2017-12-20 11:16:06'),
(276, 29, 7, 33, 11, 30.00, '2017-12-20 05:00:00', 'completed', '2017-12-20 05:00:00', 'cron', 0, NULL, 0, '2017-12-25 05:00:00', '2017-12-30 05:00:00', NULL, 2, '2017-12-20 11:16:06'),
(277, 28, 3, 33, 10, 20.00, '2017-12-21 05:00:00', 'completed', '2017-12-21 05:00:00', 'cron', 0, NULL, 0, '2017-12-26 05:00:00', '2017-12-31 05:00:00', NULL, 2, '2017-12-21 11:16:06'),
(278, 29, 7, 33, 11, 30.00, '2017-12-21 05:00:00', 'completed', '2017-12-21 05:00:00', 'cron', 0, NULL, 0, '2017-12-26 05:00:00', '2017-12-31 05:00:00', NULL, 2, '2017-12-21 11:16:06'),
(279, 28, 3, 33, 10, 20.00, '2017-12-23 05:00:00', 'completed', '2017-12-23 05:00:00', 'cron', 0, NULL, 0, '2017-12-28 05:00:00', '2018-01-02 05:00:00', NULL, 2, '2017-12-23 11:16:06'),
(280, 29, 7, 33, 11, 30.00, '2017-12-23 05:00:00', 'completed', '2017-12-23 05:00:00', 'cron', 0, NULL, 0, '2017-12-28 05:00:00', '2018-01-02 05:00:00', NULL, 2, '2017-12-23 11:16:06'),
(281, 30, 13, 33, 11, 30.00, '2017-12-30 05:00:00', 'completed', '2017-12-30 05:00:00', 'cron', 0, NULL, 0, '2018-01-04 05:00:00', '2018-01-09 05:00:00', NULL, 2, '2017-12-23 11:16:06'),
(282, 28, 3, 33, 10, 20.00, '2017-12-24 05:00:00', 'completed', '2017-12-24 05:00:00', 'cron', 0, NULL, 0, '2017-12-29 05:00:00', '2018-01-03 05:00:00', NULL, 2, '2017-12-24 11:16:06'),
(283, 29, 7, 33, 11, 30.00, '2017-12-24 05:00:00', 'completed', '2017-12-24 05:00:00', 'cron', 0, NULL, 0, '2017-12-29 05:00:00', '2018-01-03 05:00:00', NULL, 2, '2017-12-24 11:16:06'),
(284, 28, 3, 33, 10, 20.00, '2017-12-25 05:00:00', 'completed', '2017-12-25 05:00:00', 'cron', 0, NULL, 0, '2017-12-30 05:00:00', '2018-01-04 05:00:00', NULL, 2, '2017-12-25 11:16:06'),
(285, 29, 7, 33, 11, 30.00, '2017-12-25 05:00:00', 'completed', '2017-12-25 05:00:00', 'cron', 0, NULL, 0, '2017-12-30 05:00:00', '2018-01-04 05:00:00', NULL, 2, '2017-12-25 11:16:06'),
(286, 28, 3, 33, 10, 20.00, '2017-12-26 05:00:00', 'completed', '2017-12-26 05:00:00', 'cron', 0, NULL, 0, '2017-12-31 05:00:00', '2018-01-05 05:00:00', NULL, 2, '2017-12-26 11:16:06'),
(287, 29, 7, 33, 11, 30.00, '2017-12-26 05:00:00', 'completed', '2017-12-26 05:00:00', 'cron', 0, NULL, 0, '2017-12-31 05:00:00', '2018-01-05 05:00:00', NULL, 2, '2017-12-26 11:16:06'),
(288, 28, 3, 33, 10, 20.00, '2017-12-27 05:00:00', 'completed', '2017-12-27 05:00:00', 'cron', 0, NULL, 0, '2018-01-01 05:00:00', '2018-01-06 05:00:00', NULL, 2, '2017-12-27 11:16:06'),
(289, 29, 7, 33, 11, 30.00, '2017-12-27 05:00:00', 'completed', '2017-12-27 05:00:00', 'cron', 0, NULL, 0, '2018-01-01 05:00:00', '2018-01-06 05:00:00', NULL, 2, '2017-12-27 11:16:06'),
(290, 28, 3, 33, 10, 20.00, '2017-12-28 05:00:00', 'completed', '2017-12-28 05:00:00', 'cron', 0, NULL, 0, '2018-01-02 05:00:00', '2018-01-07 05:00:00', NULL, 2, '2017-12-28 11:16:06'),
(291, 29, 7, 33, 11, 30.00, '2017-12-28 05:00:00', 'completed', '2017-12-28 05:00:00', 'cron', 0, NULL, 0, '2018-01-02 05:00:00', '2018-01-07 05:00:00', NULL, 2, '2017-12-28 11:16:06'),
(292, 28, 3, 33, 10, 20.00, '2017-12-30 05:00:00', 'completed', '2017-12-30 05:00:00', 'cron', 0, NULL, 0, '2018-01-04 05:00:00', '2018-01-09 05:00:00', NULL, 2, '2017-12-30 11:16:06'),
(293, 29, 7, 33, 11, 30.00, '2017-12-30 05:00:00', 'completed', '2017-12-30 05:00:00', 'cron', 0, NULL, 0, '2018-01-04 05:00:00', '2018-01-09 05:00:00', NULL, 2, '2017-12-30 11:16:06'),
(294, 30, 13, 33, 11, 30.00, '2018-01-06 05:00:00', 'completed', '2018-01-06 05:00:00', 'cron', 0, NULL, 0, '2018-01-11 05:00:00', '2018-01-16 05:00:00', NULL, 2, '2017-12-30 11:16:06'),
(295, 28, 3, 33, 10, 20.00, '2017-12-31 05:00:00', 'completed', '2017-12-31 05:00:00', 'cron', 0, NULL, 0, '2018-01-05 05:00:00', '2018-01-10 05:00:00', NULL, 2, '2017-12-31 11:16:06'),
(296, 29, 7, 33, 11, 30.00, '2017-12-31 05:00:00', 'completed', '2017-12-31 05:00:00', 'cron', 0, NULL, 0, '2018-01-05 05:00:00', '2018-01-10 05:00:00', NULL, 2, '2017-12-31 11:16:06'),
(297, 28, 3, 33, 10, 20.00, '2018-01-01 05:00:00', 'completed', '2018-01-01 05:00:00', 'cron', 0, NULL, 0, '2018-01-06 05:00:00', '2018-01-11 05:00:00', NULL, 2, '2018-01-01 11:16:06'),
(298, 29, 7, 33, 11, 30.00, '2018-01-01 05:00:00', 'completed', '2018-01-01 05:00:00', 'cron', 0, NULL, 0, '2018-01-06 05:00:00', '2018-01-11 05:00:00', NULL, 2, '2018-01-01 11:16:06'),
(299, 31, 11, 33, 10, 20.00, '2018-02-01 05:00:00', 'completed', '2018-02-01 05:00:00', 'cron', 0, NULL, 0, '2018-02-06 05:00:00', '2018-02-11 05:00:00', NULL, 2, '2018-01-01 11:16:06'),
(300, 28, 3, 33, 10, 20.00, '2018-01-02 05:00:00', 'completed', '2018-01-02 05:00:00', 'cron', 0, NULL, 0, '2018-01-07 05:00:00', '2018-01-12 05:00:00', NULL, 2, '2018-01-02 11:16:06'),
(301, 29, 7, 33, 11, 30.00, '2018-01-02 05:00:00', 'completed', '2018-01-02 05:00:00', 'cron', 0, NULL, 0, '2018-01-07 05:00:00', '2018-01-12 05:00:00', NULL, 2, '2018-01-02 11:16:06'),
(302, 28, 3, 33, 10, 20.00, '2018-01-03 05:00:00', 'completed', '2018-01-03 05:00:00', 'cron', 0, NULL, 0, '2018-01-08 05:00:00', '2018-01-13 05:00:00', NULL, 2, '2018-01-03 11:16:06'),
(303, 29, 7, 33, 11, 30.00, '2018-01-03 05:00:00', 'completed', '2018-01-03 05:00:00', 'cron', 0, NULL, 0, '2018-01-08 05:00:00', '2018-01-13 05:00:00', NULL, 2, '2018-01-03 11:16:06'),
(304, 28, 3, 33, 10, 20.00, '2018-01-04 05:00:00', 'completed', '2018-01-04 05:00:00', 'cron', 0, NULL, 0, '2018-01-09 05:00:00', '2018-01-14 05:00:00', NULL, 2, '2018-01-04 11:16:06'),
(305, 29, 7, 33, 11, 30.00, '2018-01-04 05:00:00', 'completed', '2018-01-04 05:00:00', 'cron', 0, NULL, 0, '2018-01-09 05:00:00', '2018-01-14 05:00:00', NULL, 2, '2018-01-04 11:16:06'),
(306, 28, 3, 33, 10, 20.00, '2018-01-06 05:00:00', 'completed', '2018-01-06 05:00:00', 'cron', 0, NULL, 0, '2018-01-11 05:00:00', '2018-01-16 05:00:00', NULL, 2, '2018-01-06 11:16:06'),
(307, 29, 7, 33, 11, 30.00, '2018-01-06 05:00:00', 'completed', '2018-01-06 05:00:00', 'cron', 0, NULL, 0, '2018-01-11 05:00:00', '2018-01-16 05:00:00', NULL, 2, '2018-01-06 11:16:06'),
(308, 30, 13, 33, 11, 30.00, '2018-01-13 05:00:00', 'completed', '2018-01-13 05:00:00', 'cron', 0, NULL, 0, '2018-01-18 05:00:00', '2018-01-23 05:00:00', NULL, 2, '2018-01-06 11:16:06'),
(309, 17, 19, 29, 7, 0.00, '2018-01-07 05:19:32', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:19:32', '2018-01-17 05:19:32', NULL, 26, '2018-01-06 11:19:32'),
(310, 18, 20, 29, 7, 0.00, '2018-01-07 05:19:46', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:19:46', '2018-01-17 05:19:46', NULL, 26, '2018-01-06 11:19:46'),
(311, 19, 23, 29, 8, 0.00, '2018-01-07 05:19:52', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:19:52', '2018-01-17 05:19:52', NULL, 26, '2018-01-06 11:19:52'),
(312, 20, 19, 37, 7, 0.00, '2018-01-07 05:19:57', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:19:57', '2018-01-17 05:19:57', NULL, 26, '2018-01-06 11:19:57'),
(313, 21, 20, 37, 8, 0.00, '2018-01-07 05:20:02', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:02', '2018-01-17 05:20:02', NULL, 26, '2018-01-06 11:20:02'),
(314, 22, 23, 37, 8, 0.00, '2018-01-07 05:20:08', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:08', '2018-01-17 05:20:08', NULL, 26, '2018-01-06 11:20:08'),
(315, 23, 19, 38, 7, 0.00, '2018-01-07 05:20:13', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:13', '2018-01-17 05:20:13', NULL, 26, '2018-01-06 11:20:13'),
(316, 24, 20, 38, 8, 0.00, '2018-01-07 05:20:19', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:19', '2018-01-17 05:20:19', NULL, 26, '2018-01-06 11:20:19'),
(317, 25, 23, 38, 9, 0.00, '2018-01-07 05:20:24', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:24', '2018-01-17 05:20:24', NULL, 26, '2018-01-06 11:20:24'),
(318, 27, 19, 39, 13, 0.00, '2018-01-07 05:20:30', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:30', '2018-01-17 05:20:30', NULL, 25, '2018-01-06 11:20:30'),
(319, 28, 3, 33, 10, 0.00, '2018-01-07 05:20:35', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:35', '2018-01-17 05:20:35', NULL, 2, '2018-01-06 11:20:35'),
(320, 29, 7, 33, 11, 0.00, '2018-01-07 05:20:41', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-12 05:20:41', '2018-01-17 05:20:41', NULL, 2, '2018-01-06 11:20:41'),
(321, 30, 13, 33, 11, 0.00, '2018-01-13 05:20:46', 'new', NULL, 'cron', 0, NULL, 0, '2018-01-18 05:20:46', '2018-01-23 05:20:46', NULL, 2, '2018-01-06 11:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `last_ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=50 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `branch_id`, `employee_id`, `username`, `email`, `role`, `active`, `last_login`, `last_ip`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 1, 'super-admin', 'super-admin@example.com', 'super-admin', 1, '2018-01-03 10:56:12', '127.0.0.1', '$2y$10$X/QsuyTfpb2t9b0FqKn1letANM0sj2mf/yBMfSxQ/81iQb3qef.Em', 'TgRkiz4ByVROqFtPf2Elaq4vmc44oWAL2JJ4nPVVBBLcYO3HpVwXOUI6q8PP', '2017-09-23 05:03:53', '2018-01-03 10:56:12'),
(2, 1, 1, 2, 'admin', 'admin@example.com', 'admin', 1, '2018-01-06 04:58:47', NULL, '$2y$10$IR7cY03lGwVJ2K5Lv0657OqmJY9QdPlzzOuHyrD133d9G5G4iR/4C', 'Eec0vwOnW21sMxjEBAftSFUWiSmnIuHliCw0yq3fkknuxF1sntRLywH3itBW', '2017-09-23 05:03:55', '2018-01-06 04:58:47'),
(3, 1, 1, 3, 'employee', 'employee@example.com', 'employee', 1, '2017-12-30 04:55:18', NULL, '$2y$10$P/aQDcZ34Wn6pJ7lWbYOXuC5Bk/.806uVWYiNgaK6xrmL1mAE3BPu', '9QCVk419cGGtvuJpQ5ttYM5vM7anA6VkrzVI12phCVxy8jYC7dIucUC1gF5j', '2017-09-23 05:03:55', '2017-12-30 04:55:18'),
(4, 2, 2, 4, 'mandy.sawayn', 'nickolas53@example.org', 'employee', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'nDSLwVOtNa', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(5, 3, 3, 5, 'olson.elian', 'evert71@example.com', 'admin', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'mIWWIarMQ8', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(6, 4, 4, 6, 'dibbert.jevon', 'zella19@example.com', 'employee', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'H65xmw3tsv', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(7, 5, 5, 7, 'alexandre06', 'gconsidine@example.org', 'admin', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'sMiFvlPG3h', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(8, 6, 6, 8, 'ybruen', 'lueilwitz.emerson@example.org', 'admin', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'fLGznmNdko', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(9, 7, 7, 9, 'xhalvorson', 'jturner@example.org', 'employee', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'dbneh8mImv', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(10, 8, 8, 10, 'trantow.chelsey', 'nella61@example.com', 'employee', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'ThFpWgVdJj', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(11, 9, 9, 11, 'wreilly', 'libby.hand@example.org', 'employee', 1, NULL, NULL, '$2y$10$JBBqrFrID/heK8EWyfVcF.SiMsTAUG3SHuiB3rgPSkXSSHjoJyC2m', 'DWSY8FBkSa', '2017-09-23 05:04:19', '2017-09-23 05:04:19'),
(15, 1, 1, 16, 'abdul_khalek', 'abdul_khalek@yahoo.com', 'department-admin', 1, '2017-11-01 12:29:18', NULL, '$2y$10$0TNOAiJJ4Z8.QiWiMvqXCu6PdQk9b4CVJeocwmpMHBVmLgHN04AEW', 'CCUh1wwd9oKK55rUxfIVkn5rY80woGA5UJQfHbhh1tu4TD9xpx8g6hU4POE6', '2017-10-31 09:23:37', '2017-11-01 12:29:18'),
(16, 1, 10, 17, 'samsul_alam', 'samsul_alam@yahoo.com', 'admin', 1, NULL, NULL, '$2y$10$2XoLtfH2znYWUjC5cwztTOoDD6DqDRpzARDgteIBIexRbE2MFnOuO', NULL, '2017-10-31 12:17:51', '2017-10-31 12:39:54'),
(20, 12, 13, 21, 'wayejur.rahman', 'wayejur.rahman@yahoo.com', 'employee', 0, NULL, NULL, '$2y$10$F.u6du0mAPEeyPTI5eG8wOuo8kGBW7vZak8lf5DdVPLMKMmbLVXTy', NULL, '2017-11-05 09:24:01', '2017-11-05 09:24:01'),
(21, 13, 14, 22, 'sabbir.hossain', 'sabbir.hossain@example.com', 'admin', 1, '2017-11-07 12:38:26', NULL, '$2y$10$Y45.grH1NkUuP5T6XcKb9eicNbLP6YEDxlgUToWSpKUCANOXrXJnC', 'RAnmyyQ3BQBxvG42JZkPXXJ9dfZf4M4jsy99AI8z3w5lZdQ1Cbsqmj59HFQh', '2017-11-06 11:31:04', '2017-11-07 12:38:26'),
(22, 13, 16, 23, 'abdul.malek', 'abdul.malek@yahoo.com', 'department-admin', 1, '2017-11-18 11:15:33', NULL, '$2y$10$QHVQTU3i/If9.TvsPJtyEu2LBLsrUGOw5v03zxwl0dNwHN6PRlMjG', 'z2fWepyUCGTbJdWHoxLISf25uRIlSDv9qpoA4jlDfV7GfLOZzQId6WTHECLl', '2017-11-06 12:44:25', '2017-11-18 11:15:33'),
(23, 13, 16, 24, 'anis123', 'anis123@gmail.com', 'department-admin', 1, '2017-11-07 12:54:59', NULL, '$2y$10$yWsQ5YNZxwPbqQe/ZAEY0uuRjZhMsh2ZKaOhkG5IYtDTkc7VBuPPO', '5wGIY7pUMd9FnypXl0xxbXG0OQnxQ8mUbsx21GWQqY2l0dvUBZKNqDXowRcD', '2017-11-06 12:50:55', '2017-11-07 12:54:59'),
(24, 13, 16, 25, 'rafikul.alam', 'rafikul.alam@yahoo.com', 'employee', 1, '2017-11-08 04:48:00', NULL, '$2y$10$KrBzMg6kWERU0c0yDoCkdeOOyceEOdi3MEQIwHrnvwZeiGcJXqWLC', 'LyvNVG5vtZLFNZxfnP8oSp39jhSEhc0k1rou1t2ji6HDKPiPwLtuRoNkuFL0', '2017-11-07 05:18:11', '2017-11-08 04:48:00'),
(25, 14, 17, 26, 'leads_admin', 'leads_admin@example.com', 'admin', 1, '2018-01-03 12:17:22', NULL, '$2y$10$DSuzYqSWYbr5ukP/B6sySOM1RsVzQhDbuTQMXwL.P.NVU5Dht1ilW', 'EPJPSEZANlrLvaoru3OrWk2cTvQpb2HLL5PuV9nXCOk8NaQ3yIkYGX7klQrT', '2017-11-08 05:11:47', '2018-01-03 12:17:22'),
(26, 14, 17, 27, 'leads_account_admin', 'leads_account_admin@example.com', 'department-admin', 1, '2018-01-03 12:17:32', NULL, '$2y$10$kcTVJApGxk2LngxA92Avx.QMVmQDAlqdm36FABVROH4Optmuudcoq', '6dwAaisYFLP5xjbJgS2Krihcg13GQ8zqW9SmFCg80zj7z5jFgKVqpfsV0QK0', '2017-11-08 07:02:01', '2018-01-03 12:17:32'),
(27, 14, 19, 28, 'leads_it_admin', 'leads_it_admin@example.com', 'department-admin', 1, '2017-11-08 10:40:25', NULL, '$2y$10$0EkbjQZTyh5McdMzFnx2yue3Tq26nreBDS8kD7NBdZSI5JZwwiT5i', 'uouzUwf4oTNJEJp2U0CYW2fuQtuGunF6xMqEatKt0xEm0yKAK1IyToiA4UKj', '2017-11-08 09:00:41', '2017-11-08 10:40:25'),
(28, 14, 17, 29, 'leads_account_employ', 'leads_account_employee@example.com', 'employee', 1, '2017-12-31 10:57:35', NULL, '$2y$10$C2bpSpM3Us8yeWXJam2vOOgbejxyUR3mK/0cUZGw/GzRxrul4amdC', 'ewXxFsUOvhe5mW4J9PKPZPczyqGZAd9CuGj4IPZLsTqHNeNJtejTppM4sNDF', '2017-11-08 09:26:48', '2017-12-31 10:57:35'),
(29, 14, 19, 30, 'leads_it_employee', 'leads_it_employee@example.com', 'employee', 1, '2017-11-08 10:41:10', NULL, '$2y$10$vTx3HiMEMB2TvxWZLq3RleiZB38d4ioag6kvZZh/86msADaj8WNCe', 'SlOHiukJzkyclAfyWMzWloYCVyrufR8GEgYiNN5KhFtZ2KYXXXMBq0Sp1wXI', '2017-11-08 10:21:04', '2017-11-11 12:15:41'),
(30, 15, 20, 31, 'arif.khan', 'arif.khan@yahoo.com', 'admin', 1, '2017-11-12 05:40:05', NULL, '$2y$10$agx1S6Z9750nVc.fLY9Nf.dlqUIOV9OuLExH06ounZdMDEGUA1Gru', 'D1Eg7UI1B0aIIDxNnoh8ir0MHMCepvrAhUhAB7NHYV3tkluce7JRZ2LBVHjj', '2017-11-12 05:20:31', '2017-11-12 05:40:05'),
(31, 13, 16, 32, 'hamid.mia', 'hamid.mia@gmail.com', 'employee', 0, NULL, NULL, '$2y$10$aaFlQbljLNlgeEKm621bIuB/SJI5cnuZZ.0KyjKaSTIqryVHtuCR6', NULL, '2017-11-18 08:27:53', '2017-11-18 08:27:53'),
(36, 14, 17, 37, 'leads_account_employee2', 'leads_account_employee2@example.com', 'employee', 1, '2017-12-13 09:21:40', NULL, '$2y$10$MvIGmhB8l9oZmEgvKHVVLeCQzVnCvfe8PoPrMxxYOaImNnovXOT5O', 'c7gaiUPPcnftTGIbU9Pua2fn3ijaXN3jOsZ4G7xm99uCwplfk1ElzPwQfXZv', '2017-12-13 06:34:06', '2017-12-13 09:21:40'),
(37, 14, 17, 38, 'leads_account_employee3', 'leads_account_employee3@example.com', 'employee', 1, '2017-12-13 09:54:15', NULL, '$2y$10$rtxUg4y70inGjv6TODQp5e.0pub/59Cx/QBLahzpDHsPkiA9gqVIq', 'CceiZLxgJrPGcImzdZlqxJnn65L4eVzxaH0rowfnqY1Jaha6N7IHD12xJjiT', '2017-12-13 06:35:15', '2017-12-13 09:54:15'),
(38, 14, 17, 39, 'leads_finance_employee1', 'leads_finance_employee1@example.com', 'employee', 1, '2017-12-19 09:22:04', NULL, '$2y$10$LkNzmxCwCaiRFHZezgbtXekI9pID/kRfRQFgX0kZyFP5Ay9sABKbG', 'bhuGHatOZyS7g6l0JdhPECuSvh5hBmGBIdxW6CTTOfx8WweCAvGPJcCDEMNL', '2017-12-13 12:52:41', '2017-12-19 09:22:04'),
(41, 1, 10, 12, 'naoshad', 'naoshad@smartwebsource.com', 'employee', 1, NULL, NULL, '$2y$10$cQaOsJhS/IIuEznhqrGtDuN3IKzTfJgtdLmDuxiZM/0kJUQsA0Ugm', NULL, '2018-01-04 11:00:11', '2018-01-04 11:00:11'),
(42, 1, 10, 13, 'mizanur.rahman', 'mizanur.rahman@smartwebsource.com', 'employee', 1, NULL, NULL, '$2y$10$0wtoCu9tMPgl/C2vmbS2G.jvFtQmnOMmC.TYY80GTX0tvCx9MscZy', NULL, '2018-01-04 11:23:04', '2018-01-04 11:23:16'),
(43, 1, 10, 14, 'abdul.aziz', 'abdul.aziz@smartwebsource.com', 'employee', 1, NULL, NULL, '$2y$10$CbY2EQc6VxeHgJ0oaosFPuykQArSlIPfpTCEpT0CcvT1uXyxbMDRu', NULL, '2018-01-04 11:23:42', '2018-01-04 11:23:51'),
(44, 1, 1, 15, 'abbus.sattar', 'abbus.sattar@example.com', 'employee', 1, NULL, NULL, '$2y$10$7PDUBQeVm0zJx/kaXhvO2.Lx0KGOF07AgQ2qHGbrEBEIyzp8SKAim', NULL, '2018-01-04 11:24:11', '2018-01-04 11:24:49'),
(45, 1, 1, 18, 'ferdous', 'ferdous@yahoo.com', 'employee', 1, NULL, NULL, '$2y$10$kl05lVSkA0.v6HP9LqVkE.EpWLqNmq.LvgV8QtMeN6aNiM8JDdObC', NULL, '2018-01-04 11:25:31', '2018-01-04 11:25:40'),
(46, 1, 1, 19, 'hamidur_rahman', 'hamidur_rahman@gmail.com', 'employee', 1, NULL, NULL, '$2y$10$n.Subf5clb9kqZgce0k50uVrYrQYLvzfMxVTDXmoGjhLvJ/fWfnTm', NULL, '2018-01-04 11:28:48', '2018-01-04 11:29:04'),
(47, 1, 1, 20, 'nur_mohammad', 'nur_mohammad@yahoo.com', 'employee', 1, NULL, NULL, '$2y$10$x1e7wLaw5kNYdpRhA4x7NOoBv8kpVmpyLI.HGAeTn/2Jeorv3DN3e', NULL, '2018-01-04 11:30:04', '2018-01-04 11:30:15'),
(48, 1, 10, 33, 'amjad', 'amjad@yahoo.com', 'employee', 1, '2018-01-06 05:21:39', NULL, '$2y$10$c/0okGrmZLF8GodVr203se0rHaZ9Pcz0NQO9QPvoy0NSa2StMlibK', 'Lh8F0uwe4Xiq8v5ECd7alUkApOV9DcafYb1BLGVZNDbFqP2iMvoHK9A5prAA', '2018-01-04 11:30:34', '2018-01-06 05:21:39'),
(49, 1, 10, 34, 'amir_khan', 'amir_khan@yahoo.com', 'employee', 1, NULL, NULL, '$2y$10$mASJeJgTuIJyzX47UzRyZO0FrtdMjSeXwpW1Nq94XmY.plUZpYl8i', NULL, '2018-01-04 11:31:49', '2018-01-04 11:31:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievement_logs`
--
ALTER TABLE `achievement_logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
 ADD PRIMARY KEY (`country_code`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_tasks`
--
ALTER TABLE `employee_tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frequencies`
--
ALTER TABLE `frequencies`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
 ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_activities`
--
ALTER TABLE `task_activities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_roles`
--
ALTER TABLE `task_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo_lists`
--
ALTER TABLE `todo_lists`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_username_unique` (`username`), ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievement_logs`
--
ALTER TABLE `achievement_logs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `employee_tasks`
--
ALTER TABLE `employee_tasks`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `frequencies`
--
ALTER TABLE `frequencies`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=362;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `task_activities`
--
ALTER TABLE `task_activities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=246;
--
-- AUTO_INCREMENT for table `task_roles`
--
ALTER TABLE `task_roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `todo_lists`
--
ALTER TABLE `todo_lists`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=322;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
