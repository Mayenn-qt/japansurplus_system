-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table ohaiyo_japan_erp.branches: ~3 rows (approximately)
INSERT INTO `branches` (`id`, `branch_name`, `address`, `phone`, `email`, `manager_name`, `created_at`, `updated_at`) VALUES
	(1, 'Main Branch', 'Pangpang', NULL, 'main@ohaiyojapan.com', NULL, '2026-09-01 18:46:10', '2026-09-01 18:46:10'),
	(2, 'Juban Branch', 'Juban', NULL, 'juban@ohaiyojapan.com', NULL, '2026-09-01 18:46:10', '2026-09-01 18:46:10'),
	(3, 'Masbate Branch', 'Masbate', NULL, 'masbate@ohaiyojapan.com', NULL, '2026-09-01 18:46:10', '2026-09-01 18:46:10');

-- Dumping data for table ohaiyo_japan_erp.cache: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.cache_locks: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.categories: ~8 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Furniture', NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12'),
	(2, 'Kitchenware', NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12'),
	(3, 'Heavy Equipment & Machinery', NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12'),
	(4, 'Bags & Luggage', NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12'),
	(5, 'Tools & Equipment', NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12'),
	(6, 'Ceramics', NULL, '2026-09-25 22:57:01', '2026-09-25 22:57:01'),
	(7, 'Sports and Outdoors', NULL, '2026-09-26 21:15:41', '2026-09-26 21:15:41'),
	(8, 'Musical Instrument', NULL, '2026-09-26 21:15:41', '2026-09-26 21:15:41');

-- Dumping data for table ohaiyo_japan_erp.customers: ~3 rows (approximately)
INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `branch_id`, `exact_location`, `notes`, `created_at`, `updated_at`) VALUES
	(7, 'Marianne', '09123456789', NULL, 1, 'Brgy. Sirangan, Sorsogon City', NULL, '2026-10-19 19:39:08', '2026-10-19 19:39:08'),
	(8, 'John Juan', '09987654321', NULL, 2, 'Brgy. Catanusan, Juban, Sorsogon', NULL, '2026-10-19 19:39:59', '2026-10-19 19:39:59'),
	(9, 'Gennie Rose', '09098763564', NULL, 3, 'Brgy. Nursery, Masbate City', NULL, '2026-10-19 19:40:30', '2026-10-19 19:40:30');

-- Dumping data for table ohaiyo_japan_erp.failed_jobs: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.inventories: ~51 rows (approximately)
INSERT INTO `inventories` (`id`, `branch_id`, `product_id`, `current_stock`, `created_at`, `updated_at`) VALUES
	(76, 1, 26, 2, '2026-09-25 21:31:35', '2026-09-26 22:09:43'),
	(77, 2, 26, 4, '2026-09-25 21:31:35', '2026-09-26 22:09:43'),
	(78, 3, 26, 1, '2026-09-25 21:31:35', '2026-09-25 21:31:35'),
	(79, 1, 27, 4, '2026-09-25 21:33:06', '2026-09-26 22:09:28'),
	(80, 2, 27, 3, '2026-09-25 21:33:06', '2026-10-07 18:28:51'),
	(81, 3, 27, 4, '2026-09-25 21:33:06', '2026-09-26 22:09:28'),
	(85, 1, 29, 4, '2026-09-25 21:42:48', '2026-09-26 22:09:07'),
	(86, 2, 29, 4, '2026-09-25 21:42:48', '2026-09-26 22:09:07'),
	(87, 3, 29, 2, '2026-09-25 21:42:48', '2026-09-26 22:09:07'),
	(88, 1, 30, 1, '2026-09-25 21:49:12', '2026-09-25 21:49:12'),
	(89, 2, 30, 1, '2026-09-25 21:49:12', '2026-09-25 21:49:12'),
	(90, 3, 30, 0, '2026-09-25 21:49:12', '2026-09-25 21:49:12'),
	(91, 1, 31, 1, '2026-09-25 21:53:22', '2026-09-25 21:53:22'),
	(92, 2, 31, 1, '2026-09-25 21:53:22', '2026-09-25 21:53:22'),
	(93, 3, 31, 1, '2026-09-25 21:53:22', '2026-09-25 21:53:22'),
	(94, 1, 32, 1, '2026-09-25 21:56:46', '2026-09-25 21:56:46'),
	(95, 2, 32, 1, '2026-09-25 21:56:46', '2026-09-25 21:56:46'),
	(96, 3, 32, 1, '2026-09-25 21:56:46', '2026-09-25 21:56:46'),
	(103, 1, 35, 19, '2026-09-25 23:20:11', '2026-09-29 16:09:04'),
	(104, 2, 35, 9, '2026-09-25 23:20:11', '2026-09-28 17:12:30'),
	(105, 3, 35, 13, '2026-09-25 23:20:11', '2026-10-07 18:29:43'),
	(106, 1, 36, 50, '2026-09-25 23:22:09', '2026-09-26 22:07:32'),
	(107, 2, 36, 21, '2026-09-25 23:22:09', '2026-10-07 18:28:51'),
	(108, 3, 36, 30, '2026-09-25 23:22:09', '2026-09-26 22:07:32'),
	(109, 1, 37, 60, '2026-09-25 23:26:43', '2026-09-26 22:07:01'),
	(110, 2, 37, 32, '2026-09-25 23:26:43', '2026-09-28 17:12:30'),
	(111, 3, 37, 40, '2026-09-25 23:26:43', '2026-10-07 18:29:43'),
	(112, 1, 38, 8, '2026-09-26 20:31:23', '2026-09-26 22:06:23'),
	(113, 2, 38, 4, '2026-09-26 20:31:23', '2026-10-07 18:28:51'),
	(114, 3, 38, 4, '2026-09-26 20:31:23', '2026-09-26 22:06:23'),
	(115, 1, 39, 8, '2026-09-26 20:37:40', '2026-10-19 22:21:47'),
	(116, 2, 39, 5, '2026-09-26 20:37:40', '2026-09-26 22:06:03'),
	(117, 3, 39, 3, '2026-09-26 20:37:40', '2026-09-26 22:06:03'),
	(118, 1, 40, 6, '2026-09-26 20:40:52', '2026-10-01 20:29:31'),
	(119, 2, 40, 1, '2026-09-26 20:40:52', '2026-09-26 20:40:52'),
	(120, 3, 40, 3, '2026-09-26 20:40:52', '2026-10-07 18:29:43'),
	(121, 1, 41, 1, '2026-09-26 21:00:13', '2026-09-26 21:00:13'),
	(122, 2, 41, 1, '2026-09-26 21:00:13', '2026-09-26 21:00:13'),
	(123, 3, 41, 0, '2026-09-26 21:00:13', '2026-09-26 21:00:13'),
	(124, 1, 42, 1, '2026-09-26 21:04:34', '2026-09-26 21:04:34'),
	(125, 2, 42, 1, '2026-09-26 21:04:34', '2026-09-26 21:04:34'),
	(126, 3, 42, 1, '2026-09-26 21:04:34', '2026-09-26 22:05:27'),
	(127, 1, 43, 0, '2026-09-26 21:09:21', '2026-09-29 16:09:04'),
	(128, 2, 43, 0, '2026-09-26 21:09:21', '2026-09-26 21:09:21'),
	(129, 3, 43, 0, '2026-09-26 21:09:21', '2026-09-26 21:09:21'),
	(130, 1, 44, 1, '2026-09-26 21:12:12', '2026-09-26 21:12:12'),
	(131, 2, 44, 0, '2026-09-26 21:12:12', '2026-09-26 21:12:12'),
	(132, 3, 44, 1, '2026-09-26 21:12:12', '2026-09-26 21:12:12'),
	(133, 1, 45, 10, '2026-09-26 21:18:40', '2026-09-26 22:04:48'),
	(134, 2, 45, 4, '2026-09-26 21:18:40', '2026-09-28 17:12:30'),
	(135, 3, 45, 7, '2026-09-26 21:18:40', '2026-09-26 22:04:48');

-- Dumping data for table ohaiyo_japan_erp.jobs: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.job_batches: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.migrations: ~24 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_07_23_052559_create_branches_table', 1),
	(5, '2026_07_30_024306_create_products_table', 1),
	(6, '2026_08_08_041246_create_categories_table', 1),
	(7, '2026_08_08_041259_create_inventories_table', 1),
	(8, '2026_08_08_041405_create_sms_logs_table', 1),
	(9, '2026_08_25_061128_create_stocks_table', 1),
	(10, '2026_08_25_061138_create_stock_logs_table', 1),
	(11, '2026_08_27_021517_add_image_to_products_table', 1),
	(12, '2026_09_02_022001_create_sales_and_sale_items_tables', 1),
	(13, '2026_09_09_000000_add_cascade_delete_to_stock_product_foreign_keys', 2),
	(14, '2026_09_09_000001_cleanup_orphaned_inventory_foreign_key', 3),
	(15, '2026_09_13_000000_add_product_management_fields', 4),
	(16, '2026_09_13_000001_backfill_product_sale_prices', 5),
	(17, '2026_09_17_000000_create_product_images_table', 6),
	(18, '2026_09_17_000001_add_location_to_products_table', 7),
	(19, '2026_09_17_000002_create_customers_table', 8),
	(20, '2026_09_21_000000_rename_magallanes_branch_to_masbate', 9),
	(22, '2026_09_26_000002_replace_inventory_quantity_with_availability', 10),
	(23, '2026_09_26_000003_remove_legacy_stock_tracking', 11),
	(24, '2026_09_27_000000_restore_inventory_current_stock', 12),
	(25, '2026_10_20_000000_add_exact_location_to_customers_table', 13);

-- Dumping data for table ohaiyo_japan_erp.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.products: ~17 rows (approximately)
INSERT INTO `products` (`id`, `name`, `sku`, `category_id`, `price`, `supplier_price`, `sale_price`, `condition`, `location`, `remarks`, `date_last_sold`, `image`, `reorder_level`, `created_at`, `updated_at`) VALUES
	(26, 'Vintage Wooden Swivel  Chair', 'PRD-LVG7HC1NWR', '1', 2500.00, 1500.00, 2500.00, 'Good', NULL, 'Needs thorough cleaning due to minor dust and surface stains on the upholstery.', NULL, '3ced0239-1445-4d98-ae62-aecd82fda1e9.jpg', 5, '2026-09-25 21:31:35', '2026-09-26 21:04:46'),
	(27, 'Fabric Lounge Chair', 'PRD-QHSWBQ9M82', '1', 2500.00, 1500.00, 2500.00, 'Good', NULL, 'Needs thorough cleaning due to surface dust or minor fabric marks.', '2026-10-07 18:28:51', '1790401036_hays.jpg', 5, '2026-09-25 21:33:06', '2026-10-07 18:28:51'),
	(29, 'White Wooden Dining Chairs', 'PRD-UD7V9HZQAO', '1', 1500.00, 750.00, 1500.00, 'Good', NULL, 'Good condition with minor dust or scratches from display', NULL, 'dc2f3655-ff88-4256-a437-dd7e45e9c2f0.jpg', 5, '2026-09-25 21:42:48', '2026-09-26 22:09:07'),
	(30, 'Small Wooden Utility Table', 'PRD-KGB6NM3OHX', '1', 2500.00, 1000.00, 2500.00, 'Good', NULL, 'sturdy, minor display scratches', NULL, '1790401766_Gemini_Generated_Image_ry25sdry25sdry25.jpg', 5, '2026-09-25 21:49:12', '2026-09-25 21:49:26'),
	(31, 'Wooden Dining Table', 'PRD-L1KMNABFMX', '1', 10000.00, 6000.00, 10000.00, 'Very Good', 'Showroom Floor', 'good condition', NULL, '76c680aa-5e19-42e2-b0c8-9fa5b319e938.jpg', 5, '2026-09-25 21:53:22', '2026-09-25 21:53:22'),
	(32, 'Light Wood Dining Table', 'PRD-PJETANJWJD', '1', 6000.00, 4000.00, 6000.00, 'Good', 'Showroom Floor', 'sturdy, minor display scratches.', NULL, 'aea776ae-03ff-4507-8781-fa93a3c30724.jpg', 5, '2026-09-25 21:56:46', '2026-09-25 21:56:46'),
	(35, 'Japanese Ceramic Dining Set', 'PRD-I4AE8MKVFE', '2', 500.00, 250.00, 500.00, 'Good', NULL, 'good condition, no cracks or chips', '2026-10-07 18:29:43', 'f718bdf4-4218-4d8a-8bc5-d95b6b333bbf.jpg', 5, '2026-09-25 23:20:11', '2026-10-07 18:29:43'),
	(36, 'Japanese Ceramic Plate', 'PRD-MNKCD7DEGF', '6', 300.00, 150.00, 300.00, 'Good', NULL, 'clean surface, vintage finish', '2026-10-07 18:28:51', '1237e509-3ebb-4ecc-9afb-d882506459c3.jpg', 5, '2026-09-25 23:22:09', '2026-10-07 18:28:51'),
	(37, 'Japanese Ceramic Bowl and Teapot', 'PRD-7FSTUQ8US9', '6', 100.00, 50.00, 100.00, 'Good', NULL, 'excellent display and dining condition, no cracks or chips.', '2026-10-07 18:29:43', '1f37ed66-e29e-456d-b8f1-a5f6f4b1d421.jpg', 5, '2026-09-25 23:26:43', '2026-10-07 18:29:43'),
	(38, 'Vintage Travel Luggage Bag', 'PRD-Z9K3OF4Q1L', '4', 1500.00, 800.00, 1500.00, 'Good', NULL, 'sturdy build, functional zippers/handles', '2026-10-07 18:28:51', '6a1439f0-b1ce-4ee3-9430-cfcbe768881c.jpg', 5, '2026-09-26 20:31:23', '2026-10-07 18:28:51'),
	(39, 'Water Pumps / Power Sprayers', 'PRD-ONUZ2U73OF', '5', 5000.00, 2000.00, 5000.00, 'Good', NULL, 'complete with hose, tested', '2026-10-19 22:21:47', '6502f346-8a8b-48fc-969f-7e42d2311cce.jpg', 5, '2026-09-26 20:37:40', '2026-10-19 22:21:47'),
	(40, 'Denyo Generator', 'PRD-6XJHQFFWLP', '3', 7000.00, 4500.00, 7000.00, 'Good', NULL, 'tested and functional engine, sturdy metal frame', '2026-10-07 18:29:43', '9e30718a-2af7-4883-baf1-761072fa2a18.jpg', 5, '2026-09-26 20:40:52', '2026-10-07 18:29:43'),
	(41, 'Multi-Layer Drawer Cabinet', 'PRD-NHQQ3PZXQ0', '1', 7000.00, 4000.00, 7000.00, 'With Minor Damage', NULL, 'minor scratches', NULL, 'dcb58285-52fe-41f0-af16-8593af3945ee.jpg', 5, '2026-09-26 21:00:13', '2026-09-26 21:02:03'),
	(42, 'Combination Wardrobe & Drawer Cabinet', 'PRD-BXU8BWETFH', '1', 10000.00, 5500.00, 10000.00, 'With Minor Damage', NULL, 'Spacious wardrobe section with hanging space plus built-in pull-out drawers, sturdy build', NULL, '27a60e35-e120-4f69-873c-50831c276b47.jpg', 5, '2026-09-26 21:04:34', '2026-09-26 21:05:36'),
	(43, '3-Door Wardrobe Cabinet', 'PRD-NJBFDZDIGM', '1', 20000.00, 13000.00, 20000.00, 'Good', 'Showroom - Furniture Section', 'heavy-duty build, dark wood finish', '2026-09-29 16:09:04', 'ee055ce2-858d-4b11-ad3c-3532f332c5c0.jpg', 5, '2026-09-26 21:09:21', '2026-09-29 16:09:04'),
	(44, 'Victor Upright Piano - Black Gloss', 'PRD-FHXFEMNFYQ', '8', 60000.00, 35000.00, 60000.00, 'Good', NULL, 'full 88-key keyboard with brass pedals', NULL, '6766f36b-36e2-48fd-b195-49f21497a569.jpg', 5, '2026-09-26 21:12:12', '2026-09-26 21:16:30'),
	(45, 'Bicycle', 'PRD-AKOOH3WVNA', '7', 7000.00, 3500.00, 7000.00, 'Good', NULL, 'durable frame, equipped with fenders/basket', '2026-09-28 17:12:30', '4672a103-4801-427a-aebf-ad95445686d1.jpg', 5, '2026-09-26 21:18:40', '2026-09-28 17:12:30');

-- Dumping data for table ohaiyo_japan_erp.product_images: ~23 rows (approximately)
INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
	(34, 26, 'c637cdb3-98ce-41b8-bb74-318bd584d5c3.jpg', '2026-09-25 21:31:35', '2026-09-25 21:31:35'),
	(35, 26, '1c78c2c9-ce6a-414a-8b9a-ca2955eb4ddc.jpg', '2026-09-25 21:31:35', '2026-09-25 21:31:35'),
	(36, 26, '9aa7f63f-b100-4dc2-8367-852e14dce6cb.jpg', '2026-09-25 21:31:35', '2026-09-25 21:31:35'),
	(37, 27, 'd6f30d1a-7ce1-4c4d-bc56-f276bd69f755.jpg', '2026-09-25 21:33:06', '2026-09-25 21:33:06'),
	(38, 27, '65312795-befb-400f-b959-45a79666db04.jpg', '2026-09-25 21:33:06', '2026-09-25 21:33:06'),
	(41, 29, '8ead16ea-4cc1-4e06-a9e6-0c80d8449e8b.jpg', '2026-09-25 21:42:48', '2026-09-25 21:42:48'),
	(42, 29, '3411aedc-fb1b-4141-8a6b-0dc399f1dc52.jpg', '2026-09-25 21:42:48', '2026-09-25 21:42:48'),
	(43, 30, '62ce5998-4b9f-4ef3-af94-e2503bd314d2.jpg', '2026-09-25 21:49:50', '2026-09-25 21:49:50'),
	(44, 31, 'e0e81810-90db-429a-b9a3-95b8472e6b82.jpg', '2026-09-25 21:53:22', '2026-09-25 21:53:22'),
	(45, 32, 'be938bf6-abbc-495e-9798-d71fc1f2cc35.jpg', '2026-09-25 21:56:46', '2026-09-25 21:56:46'),
	(49, 35, '4c28f99f-8295-447d-9239-65126b83044f.jpg', '2026-09-25 23:20:34', '2026-09-25 23:20:34'),
	(50, 35, '0db773cc-6c3f-43ae-a038-86463224ae22.jpg', '2026-09-25 23:20:34', '2026-09-25 23:20:34'),
	(51, 36, '3a902aeb-6b05-44d1-9361-d51c06479f0e.jpg', '2026-09-25 23:22:09', '2026-09-25 23:22:09'),
	(52, 36, 'c5b9ef96-b2c6-4cd2-8b97-d75303edef85.jpg', '2026-09-25 23:22:09', '2026-09-25 23:22:09'),
	(53, 37, 'eff8642a-038e-48cb-8c85-2c66dca1fd69.jpg', '2026-09-25 23:27:22', '2026-09-25 23:27:22'),
	(54, 37, '3a37e8b9-baa1-4adb-9072-2e4353e9e16e.jpg', '2026-09-25 23:27:22', '2026-09-25 23:27:22'),
	(55, 38, '7e19273c-2b9b-4e51-9402-88dcca29cce4.jpg', '2026-09-26 20:31:23', '2026-09-26 20:31:23'),
	(56, 39, '828d6c65-abd3-4cdf-993d-4113e41d1569.jpg', '2026-09-26 20:37:57', '2026-09-26 20:37:57'),
	(57, 41, 'deeb79ae-c558-48f9-a274-0a10c2d652b9.jpg', '2026-09-26 21:00:13', '2026-09-26 21:00:13'),
	(58, 41, '5699b3c2-ee55-465c-bd4e-abc0bebe4031.jpg', '2026-09-26 21:02:03', '2026-09-26 21:02:03'),
	(59, 41, '98426142-f121-492c-968f-892703f23daa.jpg', '2026-09-26 21:02:03', '2026-09-26 21:02:03'),
	(60, 42, '4a32d460-1a30-46be-980c-a3a93dd13f47.jpg', '2026-09-26 21:06:05', '2026-09-26 21:06:05'),
	(61, 42, '7f92131a-cd2b-43a2-a938-7782179e6b51.jpg', '2026-09-26 21:06:05', '2026-09-26 21:06:05');

-- Dumping data for table ohaiyo_japan_erp.sales: ~8 rows (approximately)
INSERT INTO `sales` (`id`, `user_id`, `branch_id`, `order_type`, `subtotal`, `discount`, `total_amount`, `money_received`, `change`, `is_suki`, `created_at`, `updated_at`) VALUES
	(14, 2, 1, 'walk-in', 1000.00, 0.00, 1000.00, 1000.00, 0.00, 0, '2026-09-26 21:43:25', '2026-09-26 21:43:25'),
	(15, 3, 2, 'walk-in', 7500.00, 0.00, 7500.00, 8000.00, 500.00, 0, '2026-09-28 17:12:30', '2026-09-28 17:12:30'),
	(16, 4, 3, 'walk-in', 7000.00, 500.00, 6500.00, 7000.00, 500.00, 0, '2026-09-29 15:24:52', '2026-09-29 15:24:52'),
	(17, 2, 1, 'walk-in', 20000.00, 5000.00, 15000.00, 20000.00, 5000.00, 0, '2026-09-29 16:09:04', '2026-09-29 16:09:04'),
	(18, 2, 1, 'walk-in', 12000.00, 1500.00, 10500.00, 10500.00, 0.00, 0, '2026-10-01 20:29:30', '2026-10-01 20:29:30'),
	(19, 3, 2, 'walk-in', 4900.00, 500.00, 4400.00, 4500.00, 100.00, 0, '2026-10-07 18:28:51', '2026-10-07 18:28:51'),
	(20, 4, 3, 'walk-in', 8000.00, 0.00, 8000.00, 8000.00, 0.00, 0, '2026-10-07 18:29:43', '2026-10-07 18:29:43'),
	(21, 2, 1, 'walk-in', 5000.00, 0.00, 5000.00, 5000.00, 0.00, 0, '2026-10-19 22:21:47', '2026-10-19 22:21:47');

-- Dumping data for table ohaiyo_japan_erp.sale_items: ~17 rows (approximately)
INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
	(23, 14, 35, 2, 500.00, 1000.00, '2026-09-26 21:43:25', '2026-09-26 21:43:25'),
	(24, 14, 37, 5, 0.00, 0.00, '2026-09-26 21:43:25', '2026-09-26 21:43:25'),
	(25, 15, 45, 1, 7000.00, 7000.00, '2026-09-28 17:12:30', '2026-09-28 17:12:30'),
	(26, 15, 35, 1, 500.00, 500.00, '2026-09-28 17:12:30', '2026-09-28 17:12:30'),
	(27, 15, 37, 3, 0.00, 0.00, '2026-09-28 17:12:30', '2026-09-28 17:12:30'),
	(28, 16, 40, 1, 7000.00, 7000.00, '2026-09-29 15:24:52', '2026-09-29 15:24:52'),
	(29, 17, 43, 1, 20000.00, 20000.00, '2026-09-29 16:09:04', '2026-09-29 16:09:04'),
	(30, 17, 35, 1, 0.00, 0.00, '2026-09-29 16:09:04', '2026-09-29 16:09:04'),
	(31, 18, 40, 1, 7000.00, 7000.00, '2026-10-01 20:29:30', '2026-10-01 20:29:30'),
	(32, 18, 39, 1, 5000.00, 5000.00, '2026-10-01 20:29:30', '2026-10-01 20:29:30'),
	(33, 19, 36, 3, 300.00, 900.00, '2026-10-07 18:28:51', '2026-10-07 18:28:51'),
	(34, 19, 38, 1, 1500.00, 1500.00, '2026-10-07 18:28:51', '2026-10-07 18:28:51'),
	(35, 19, 27, 1, 2500.00, 2500.00, '2026-10-07 18:28:51', '2026-10-07 18:28:51'),
	(36, 20, 35, 2, 500.00, 1000.00, '2026-10-07 18:29:43', '2026-10-07 18:29:43'),
	(37, 20, 40, 1, 7000.00, 7000.00, '2026-10-07 18:29:43', '2026-10-07 18:29:43'),
	(38, 20, 37, 5, 0.00, 0.00, '2026-10-07 18:29:43', '2026-10-07 18:29:43'),
	(39, 21, 39, 1, 5000.00, 5000.00, '2026-10-19 22:21:47', '2026-10-19 22:21:47');

-- Dumping data for table ohaiyo_japan_erp.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('9mUgmf71S1YUT42YMcyGPvq0avaf3jVxMRc5Xlib', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJQT1p4Vmw4Z3BLenhZekw2cnJIT2NYS1l5bW9ReWRJTmIzSkx5WFpyIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9vd25lclwvcmVwb3J0c1wvc2FsZXM/dHJlbmRfcGVyaW9kPXdlZWtseSIsInJvdXRlIjoib3duZXIucmVwb3J0cy5zYWxlcyJ9fQ==', 1792479341),
	('S58KqlyTgk5xrmyH1UsAQK6RWSnMN2RRLmMTCun6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJCU09GWnFaY3RGRWs5UzVYUjU5QndGQXFHMEJRMExNQmtnQjZldDN0IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1792479216);

-- Dumping data for table ohaiyo_japan_erp.sms_logs: ~0 rows (approximately)

-- Dumping data for table ohaiyo_japan_erp.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `branch_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Store Owner', 'owner@ohaiyojapan.com', NULL, '$2y$12$YtDkKhghsJEj5rehgCXSI.zqRWRACFknET11S0297MN9UA2DJLs.C', 'owner', 1, NULL, '2026-09-01 18:46:11', '2026-09-01 18:46:11'),
	(2, 'Main Staff', 'staffmain@ohaiyojapan.com', NULL, '$2y$12$V1cE6BblWr/r8IARatH4HeppyjvaZb.Aa5DHYOoiaujLhA1S01cfe', 'staff', 1, NULL, '2026-09-01 18:46:11', '2026-09-01 18:46:11'),
	(3, 'Juban Staff', 'staffjuban@ohaiyojapan.com', NULL, '$2y$12$W/e01SPFTWPI/13DIwYC7ODDgusSH7igt4NfqEy/RvUW.J0BgZJHe', 'staff', 2, NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12'),
	(4, 'Masbate Staff', 'staffmasbate@ohaiyojapan.com', NULL, '$2y$12$retNNUxOx98JMbPE4B.l6.bxvOSs1wNQ.5yD8GE7jreud38yrvbvu', 'staff', 3, NULL, '2026-09-01 18:46:12', '2026-09-01 18:46:12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
