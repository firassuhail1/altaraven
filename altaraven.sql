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

-- Dumping structure for table altaraven.albums
CREATE TABLE IF NOT EXISTS `albums` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_year` year NOT NULL,
  `spotify_album_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spotify_embed_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('album','ep','single') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'album',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `albums_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.albums: ~1 rows (approximately)
INSERT INTO `albums` (`id`, `title`, `slug`, `description`, `cover_image`, `release_year`, `spotify_album_id`, `spotify_embed_url`, `type`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES
	(1, 'Nova Libertas', 'nova-libertas', 'Dua tahun sejak pertama kali kami mulai merakit mesin pembantai bernama ALTARAVEN ini dengan segala tantangan dan kesulitan - kesulitan luar biasa yang kami lewati akhirnya kami berhasil meluncurkan rudal pertama kami yang berjudul NOVA LIBERTAS yang artinya kebebasan baru.\r\n\r\nMelalui NOVA LIBERTAS kami berharap para RAVENS bisa lebih meresapi dan memaknai caci maki kami terhadap kebusukan - kebusukan dunia yang terjadi akhir - akhir ini. Pada intinya kami menolak diam atas tirani, invasi maupun oligarki yang kami rasa semakin hari semakin menginjak - injak hak asasi manusia secara harafiah. Dan juga keresahan kami tentang sosial yang mana kemajuan teknologi mengiringi kemunduran adab dan kultur. Semua itu kami susun didalam rakitan 8 hulu ledak dan kami solidkan didalam 1 rudal bernama NOVA LIBERTAS', 'music/covers/iOffft7MfxxrplLJvICzVaNyCGCeUzLGhR2RP8we.png', '2025', NULL, NULL, 'album', 1, 1, '2026-03-29 03:09:33', '2026-03-29 03:10:04');

-- Dumping structure for table altaraven.band_info
CREATE TABLE IF NOT EXISTS `band_info` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `band_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ALTARAVEN',
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `history` longtext COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `founded_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` json DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.band_info: ~1 rows (approximately)
INSERT INTO `band_info` (`id`, `band_name`, `tagline`, `history`, `description`, `founded_year`, `genre`, `origin`, `hero_image`, `hero_video`, `social_links`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'ALTARAVEN', 'We don\'t play music. We wage war.', 'Born from the underground, ALTARAVEN formed in 2017 with a singular mission: to create music that is as uncompromising as it is powerful.\r\n\r\nDrawing inspiration from the darkest corners of metal — from the crushing weight of doom to the precision of progressive — the band has carved their own identity in the scene.\r\n\r\nAfter years of relentless gigging and honing their craft, they emerged with a sound that is distinctly their own: heavy, melodic, and unapologetically dark.', 'ALTARAVEN is a metal band from Indonesia, forging heavy sounds that cut through silence and leave no room for the mundane.', '2017', 'Brutal Death Metal', 'Kudus, Jawa Tengah, Indonesia', NULL, NULL, '{"tiktok": null, "spotify": "https://open.spotify.com/artist/1uGMye1s96MFY6FGlAiWWd?si=_6NxUtCvRe-_F5t7FmG2wA", "youtube": "https://youtube.com/@altaraven", "facebook": null, "instagram": "https://instagram.com/_altaraven_"}', 'altaraven.id@gmail.com', '2026-03-29 02:10:04', '2026-03-29 02:52:56');

-- Dumping structure for table altaraven.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.cache: ~0 rows (approximately)

-- Dumping structure for table altaraven.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.cache_locks: ~0 rows (approximately)

-- Dumping structure for table altaraven.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chat_room_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `sender_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_type` enum('customer','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_chat_room_id_foreign` (`chat_room_id`),
  KEY `chat_messages_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_messages_chat_room_id_foreign` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.chat_messages: ~0 rows (approximately)
INSERT INTO `chat_messages` (`id`, `chat_room_id`, `user_id`, `sender_name`, `sender_type`, `message`, `attachment`, `is_read`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'adit', 'customer', 'halo kak', NULL, 1, '2026-03-29 07:36:58', '2026-03-30 00:25:58'),
	(2, 1, 1, 'Admin ALTARAVEN', 'admin', 'halo kak, kita proses ya pesanannya kak', NULL, 1, '2026-03-29 14:38:36', '2026-03-29 14:45:35'),
	(3, 1, NULL, 'adit', 'customer', 'iyaa ditunggu ya kak', NULL, 1, '2026-03-29 14:39:18', '2026-03-30 00:25:58'),
	(4, 1, 1, 'Admin ALTARAVEN', 'admin', 'iyaa baik kak', NULL, 1, '2026-03-29 14:40:00', '2026-03-29 14:45:35'),
	(5, 1, 1, 'Admin ALTARAVEN', 'admin', 'sudah di konfirmasi kak', NULL, 1, '2026-03-29 14:45:11', '2026-03-29 14:45:35'),
	(6, 2, NULL, 'attar', 'customer', 'halo kak selamat malam', NULL, 1, '2026-03-29 16:46:47', '2026-03-29 16:48:35');

-- Dumping structure for table altaraven.chat_rooms
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('open','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_rooms_room_key_unique` (`room_key`),
  KEY `chat_rooms_order_id_foreign` (`order_id`),
  CONSTRAINT `chat_rooms_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.chat_rooms: ~0 rows (approximately)
INSERT INTO `chat_rooms` (`id`, `room_key`, `order_id`, `customer_name`, `customer_email`, `subject`, `status`, `last_message_at`, `created_at`, `updated_at`) VALUES
	(1, '9937f80f-1396-4cc9-b268-dd24b3a37154', 1, 'adit', 'adit@gmail.com', 'Order #AR-2026-000001', 'closed', '2026-03-29 14:45:11', '2026-03-29 07:34:16', '2026-03-29 14:45:19'),
	(2, '42c6b1fe-09d8-410f-8e69-511f4ab216c8', 2, 'attar', 'attar@gmail.com', 'Order #AR-2026-000002', 'open', '2026-03-29 16:46:47', '2026-03-29 16:42:33', '2026-03-29 16:46:47');

-- Dumping structure for table altaraven.contact_messages
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.contact_messages: ~0 rows (approximately)
INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
	(1, 'Adit', 'adit@gmail.com', 'pembelian merch', 'boleh tau tentang metode pembayarannya?', 1, '2026-03-29 16:38:46', '2026-03-29 07:22:47', '2026-03-29 16:38:46');

-- Dumping structure for table altaraven.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `ticket_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('upcoming','past','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `ticket_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.events: ~1 rows (approximately)
INSERT INTO `events` (`id`, `name`, `slug`, `description`, `event_date`, `event_time`, `venue`, `city`, `country`, `ticket_url`, `poster_image`, `status`, `is_featured`, `ticket_price`, `created_at`, `updated_at`) VALUES
	(1, 'PELATAR', 'platar-2026-09-27-000000', 'Siapkan diri untuk malam yang mengguncang jiwa dan meremukkan panggung! Bergabunglah bersama kami dalam Metal Mayhem 2026, menghadirkan band-band metal terbaik dari skena lokal dan internasional.\r\n\r\n🎸 Line-up:\r\n\r\n[Nama Band 1] – Thrash Metal yang menghentak hati\r\n[Nama Band 2] – Death Metal penuh energi brutal\r\n[Nama Band 3] – Black Metal atmosferik dan gelap\r\n\r\n📅 Tanggal: Sabtu, 12 Juni 2026\r\n📍 Lokasi: [Nama Venue], [Kota]\r\n⏰ Waktu: 19.00 – 02.00 WIB\r\n\r\n💀 Kenapa wajib hadir:\r\n\r\nPengalaman live yang intens dan mencekam\r\nAtmosfer underground khas metal sejati\r\nMerchandise eksklusif dan booth interaktif\r\n\r\n⚡ Jangan sampai ketinggalan, karena malam ini panggung akan dihancurkan dengan riff, scream, dan energi metal tanpa kompromi! 🤘', '2026-09-27', '15:30:00', 'Lapangan GBK', 'Jakarta', 'Indonesia', 'https://localhost:8000/ticket', 'events/1S0sfWZc37aVLH0D4DxBfNY8fTnt4y9yLmTOfKqg.jpg', 'upcoming', 1, 150000.00, '2026-03-29 03:14:41', '2026-03-29 03:25:48');

-- Dumping structure for table altaraven.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table altaraven.gallery_items
CREATE TABLE IF NOT EXISTS `gallery_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.gallery_items: ~5 rows (approximately)
INSERT INTO `gallery_items` (`id`, `title`, `image_path`, `slot`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Main Visual', 'gallery/i8C3zTy5pq39GcxdUj9FuC9T9Xlfc7Z4UDIX43vG.jpg', NULL, 1, 1, '2026-03-29 04:53:57', '2026-04-01 11:52:14'),
	(3, NULL, 'gallery/MkywDB1ikwU6ZLExixQBCTzYXTGDlGCsAqetLX1A.png', NULL, 3, 1, '2026-03-29 05:02:39', '2026-04-01 11:52:14'),
	(4, NULL, 'gallery/RNCTBrr7jiuPl6BgPRe1V1VKS1KMtGEBIpkqbYQk.jpg', NULL, 2, 1, '2026-03-29 05:02:54', '2026-04-01 11:52:14'),
	(5, NULL, 'gallery/RspM3oqNBSR5n3e67V0JJhu1t1Ec5k0F6dpfpyy9.jpg', NULL, 4, 1, '2026-03-29 05:07:33', '2026-04-01 11:52:14'),
	(6, NULL, 'gallery/YMfZHi2ilnXT660vLOYqt7AEdMgvlDi1Dopu5YwI.jpg', NULL, 5, 1, '2026-03-29 05:07:49', '2026-04-01 11:52:14'),
	(7, 'Invasi Feodal', 'gallery/JT3XpeY345VTkPwjhhPmt7UDMVFFVTavYRzDi37W.png', NULL, 6, 1, '2026-03-29 05:10:12', '2026-04-01 11:52:14'),
	(8, 'resistensi', 'gallery/9U10eWGmF6miZuLjmQg2nWjBrjRX4bMleEkHseZY.png', NULL, 8, 1, '2026-04-01 11:52:09', '2026-04-01 11:52:14'),
	(9, 'berita degradasi kultur', 'gallery/PHLOEXcj0Xs7vc8dbuuSZJUYS58Et3PxDQx2Wv5S.png', NULL, 7, 1, '2026-04-01 11:52:09', '2026-04-01 11:52:14');

-- Dumping structure for table altaraven.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.jobs: ~0 rows (approximately)
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"uuid":"48e0fb5f-aea2-434b-8f68-95770d8f0903","displayName":"App\\\\Events\\\\NewChatMessage","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:25:\\"App\\\\Events\\\\NewChatMessage\\":1:{s:11:\\"chatMessage\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:22:\\"App\\\\Models\\\\ChatMessage\\";s:2:\\"id\\";i:1;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1774795019,"delay":null}', 0, NULL, 1774795019, 1774795019),
	(2, 'default', '{"uuid":"fa85de0b-49a6-49d7-8a39-b57c9b0b3b71","displayName":"App\\\\Events\\\\NewChatMessage","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:25:\\"App\\\\Events\\\\NewChatMessage\\":1:{s:11:\\"chatMessage\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:22:\\"App\\\\Models\\\\ChatMessage\\";s:2:\\"id\\";i:2;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1774795116,"delay":null}', 0, NULL, 1774795116, 1774795116),
	(3, 'default', '{"uuid":"532880e1-0163-4c72-a479-ee982c7ded6f","displayName":"App\\\\Events\\\\NewChatMessage","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:25:\\"App\\\\Events\\\\NewChatMessage\\":1:{s:11:\\"chatMessage\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:22:\\"App\\\\Models\\\\ChatMessage\\";s:2:\\"id\\";i:3;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1774795158,"delay":null}', 0, NULL, 1774795158, 1774795158),
	(4, 'default', '{"uuid":"c0c2a8f0-175c-4d15-bab9-756f542eb59a","displayName":"App\\\\Events\\\\NewChatMessage","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:25:\\"App\\\\Events\\\\NewChatMessage\\":1:{s:11:\\"chatMessage\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:22:\\"App\\\\Models\\\\ChatMessage\\";s:2:\\"id\\";i:4;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1774795200,"delay":null}', 0, NULL, 1774795200, 1774795200),
	(5, 'default', '{"uuid":"16f31a01-7609-452b-903e-d0e3cf4e639b","displayName":"App\\\\Events\\\\NewChatMessage","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:25:\\"App\\\\Events\\\\NewChatMessage\\":1:{s:11:\\"chatMessage\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:22:\\"App\\\\Models\\\\ChatMessage\\";s:2:\\"id\\";i:5;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1774795511,"delay":null}', 0, NULL, 1774795511, 1774795511),
	(6, 'default', '{"uuid":"7ec61cd1-c3cb-4d1e-b06e-a593ba5987a8","displayName":"App\\\\Events\\\\NewChatMessage","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":17:{s:5:\\"event\\";O:25:\\"App\\\\Events\\\\NewChatMessage\\":1:{s:11:\\"chatMessage\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:22:\\"App\\\\Models\\\\ChatMessage\\";s:2:\\"id\\";i:6;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:23:\\"deleteWhenMissingModels\\";b:1;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1774802808,"delay":null}', 0, NULL, 1774802808, 1774802808);

-- Dumping structure for table altaraven.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.job_batches: ~0 rows (approximately)

-- Dumping structure for table altaraven.members
CREATE TABLE IF NOT EXISTS `members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.members: ~5 rows (approximately)
INSERT INTO `members` (`id`, `name`, `role`, `bio`, `photo`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Lochma Ferry', 'Vocals', 'The voice of ALTARAVEN. Raw, powerful, and relentless.', 'members/o4zUvVcxDAyR5hDouJvvBSqRURx1vC1lueiqODn0.png', 1, 1, '2026-03-29 02:10:04', '2026-03-29 02:51:29'),
	(2, 'Jeff Ajedah', 'Guitar', 'Riff architect. Writes the soundtrack to your darkest nights.', 'members/MUMtA44DS0CTLm0En7h2OwbrDt3yosAxkCdCv7uu.png', 2, 1, '2026-03-29 02:10:04', '2026-03-29 02:51:42'),
	(3, 'Pieter Anro Putra', 'Guitar', 'Lead guitar and melody. The light in the darkness.', 'members/Ajv8D6FjxSSnDR0UFSwnn2UH5LvqnisLB4AjbUtV.png', 3, 1, '2026-03-29 02:10:04', '2026-03-29 02:51:54'),
	(4, 'Najib', 'Bass', 'The low-end foundation that shakes the earth.', 'members/trXqK9O74hfBQ99EuqSA82kimFERVwLIhydjzhR9.png', 4, 1, '2026-03-29 02:10:04', '2026-03-29 02:52:07'),
	(5, 'Daneas Marcelino (Nino)', 'Drums', 'The engine of ALTARAVEN. Precision and power in equal measure.', 'members/HQZG7vyx2H0LYiUn23WGJ1jAFM9mAsTbjFHEZJSx.png', 5, 1, '2026-03-29 02:10:04', '2026-03-29 02:52:18');

-- Dumping structure for table altaraven.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_01_01_000001_create_band_info_table', 1),
	(5, '2024_01_01_000002_create_members_table', 1),
	(6, '2024_01_01_000003_create_music_tables', 1),
	(7, '2024_01_01_000004_create_events_table', 1),
	(8, '2024_01_01_000005_create_products_tables', 1),
	(9, '2024_01_01_000006_create_orders_tables', 1),
	(10, '2024_01_01_000007_create_messages_tables', 1),
	(11, '2026_03_29_113337_create_gallery_items_table', 2);

-- Dumping structure for table altaraven.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','confirmed','paid','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `paid_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.orders: ~0 rows (approximately)
INSERT INTO `orders` (`id`, `order_number`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_province`, `shipping_postal_code`, `shipping_country`, `subtotal`, `shipping_cost`, `total`, `status`, `payment_method`, `payment_proof`, `notes`, `admin_notes`, `paid_at`, `shipped_at`, `tracking_number`, `created_at`, `updated_at`) VALUES
	(1, 'AR-2026-000001', 'adit', 'adit@gmail.com', '089509209188', 'jln. rembang', 'rembang', 'jawa tengah', NULL, 'Indonesia', 150000.00, 0.00, 150000.00, 'confirmed', NULL, NULL, 'di kirim secepatnya ya kak', NULL, NULL, NULL, NULL, '2026-03-29 07:34:13', '2026-03-29 14:41:56'),
	(2, 'AR-2026-000002', 'attar', 'attar@gmail.com', '085467564546', 'jati', 'kudus', 'Jawa tengah', NULL, 'Indonesia', 150000.00, 0.00, 150000.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-29 16:42:26', '2026-03-29 16:42:26');

-- Dumping structure for table altaraven.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_variant_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.order_items: ~0 rows (approximately)
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_name`, `variant_info`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 3, 'Resistensi Long Sleeve', 'M / Short Sleeve', 150000.00, 1, 150000.00, '2026-03-29 07:34:13', '2026-03-29 07:34:13'),
	(2, 2, 1, 3, 'Resistensi T-Shirt', 'M / Short Sleeve', 150000.00, 1, 150000.00, '2026-03-29 16:42:26', '2026-03-29 16:42:26');

-- Dumping structure for table altaraven.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table altaraven.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `base_price` decimal(10,2) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'apparel',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.products: ~1 rows (approximately)
INSERT INTO `products` (`id`, `name`, `slug`, `description`, `base_price`, `category`, `is_active`, `is_featured`, `order`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Resistensi T-Shirt', 'resistensi-long-sleeve', 'ugyg', 150000.00, 'apparel', 1, 1, 1, '2026-03-29 02:26:50', '2026-03-29 03:33:14', NULL);

-- Dumping structure for table altaraven.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.product_images: ~1 rows (approximately)
INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `order`, `created_at`, `updated_at`) VALUES
	(1, 1, 'products/1/FJl95FhBEwi413CHaM25HCmoAgPAL9GnWzKrM3i9.jpg', 1, 0, '2026-03-29 02:26:50', '2026-03-29 02:26:50');

-- Dumping structure for table altaraven.product_variants
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_hex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_option` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_modifier` decimal(8,2) NOT NULL DEFAULT '0.00',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_sku_unique` (`sku`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.product_variants: ~1 rows (approximately)
INSERT INTO `product_variants` (`id`, `product_id`, `size`, `type`, `color`, `color_hex`, `custom_option`, `price_modifier`, `sku`, `is_active`, `created_at`, `updated_at`) VALUES
	(3, 1, 'M', 'Short Sleeve', NULL, '#000000', NULL, 0.00, NULL, 1, '2026-03-29 02:50:06', '2026-03-29 02:50:06');

-- Dumping structure for table altaraven.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('9YS4YmevQcjAQvncjBnX5V8BFUv11Kpf4m5gtcjJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicEI2NWVNV1h3V1RJeHNzb3dMeHdqTVNaODJRSXVKalpWZU9oc1M4UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGF0LzEvbWVzc2FnZXMiO3M6NToicm91dGUiO3M6MTM6ImNoYXQubWVzc2FnZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1774803057),
	('AlsT2wIJvpvYddWPMtYi9b6CrfbJTylMSlWcrtGS', 1, '192.168.0.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ09qZkt3b1h3SlpJaXFzdExMYXJTUGhBMmtKWFdRWVZpbzNVMHJVMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjAuMTEwOjgwMDAvYWRtaW4vbXVzaWMiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLm11c2ljLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774830331),
	('NNCnZAjCMHPgV6U5X7f1s7UR4DQOcXlxtSaQuxb0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOU9mQ3A4TktHWTlwMU9uTXFjdXNiUmVSQUdqcjFJSG5WdzJkRTN2SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9nYWxsZXJ5IjtzOjU6InJvdXRlIjtzOjEzOiJnYWxsZXJ5LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1775044353),
	('qO07BHVzFXhlm6AdACNdq7y7457YNvXBek0bxwkR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRGZ1MFJSd0ZUVElJaWFuTm5ucnZVa2RFSklUVkZ3SlNONWVwNDUxTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGF0LzEvbWVzc2FnZXMiO3M6NToicm91dGUiO3M6MTM6ImNoYXQubWVzc2FnZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774830358),
	('qqk8oNjBb21XNmcuoBU8wDXsdtRexwzxAgtitfis', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDVmanB0Y3hFRGNaRXVZdnpJVXlmMG5MQTE5QW1YTk91MGZTbm9zZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGF0LzEvbWVzc2FnZXMiO3M6NToicm91dGUiO3M6MTM6ImNoYXQubWVzc2FnZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774830211),
	('r0zcHcd9xqv28uantjzsk7RoRHN7HBWPBw2RtLFY', 1, '192.168.0.104', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTkyaFZvSllVWERlbjhKM0ZodG5YbEh6dndic0w1b0dCNHhraXNMSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xOTIuMTY4LjAuMTEwOjgwMDAvYWRtaW4vb3JkZXJzLzIiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLm9yZGVycy5zaG93Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774802941);

-- Dumping structure for table altaraven.stock_adjustments
CREATE TABLE IF NOT EXISTS `stock_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `quantity_change` int NOT NULL,
  `quantity_before` int NOT NULL,
  `quantity_after` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_adjustments_product_variant_id_foreign` (`product_variant_id`),
  KEY `stock_adjustments_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_adjustments_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.stock_adjustments: ~0 rows (approximately)

-- Dumping structure for table altaraven.tracks
CREATE TABLE IF NOT EXISTS `tracks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `album_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `track_number` int NOT NULL DEFAULT '1',
  `spotify_track_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spotify_embed_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_year` year DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tracks_slug_unique` (`slug`),
  KEY `tracks_album_id_foreign` (`album_id`),
  CONSTRAINT `tracks_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.tracks: ~3 rows (approximately)
INSERT INTO `tracks` (`id`, `album_id`, `title`, `slug`, `duration`, `track_number`, `spotify_track_id`, `spotify_embed_url`, `cover_image`, `release_year`, `is_featured`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Intro', 'intro-69c8fa8d9f1ed', '1:43', 1, '1', NULL, NULL, NULL, 0, '2026-03-29 03:10:21', '2026-03-29 03:10:21'),
	(2, 1, 'Resistensi', 'resistensi-69c8faac31271', '4:01', 2, '2', NULL, NULL, NULL, 0, '2026-03-29 03:10:52', '2026-03-29 03:10:52'),
	(3, 1, 'Kalibrasi Iblis', 'kalibrasi-iblis-69c8fabd1cc1e', '3:56', 3, '3', NULL, NULL, NULL, 0, '2026-03-29 03:11:09', '2026-03-29 03:11:09');

-- Dumping structure for table altaraven.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin ALTARAVEN', 'admin@altaraven.com', '2026-03-29 02:10:04', '$2y$12$gJaMUwjsvoicbF5yWesQveYNOlZzaZXmo1SaobOeObagyXspKoCj.', NULL, '2026-03-29 02:10:04', '2026-03-29 02:10:04');

-- Dumping structure for table altaraven.variant_stocks
CREATE TABLE IF NOT EXISTS `variant_stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `low_stock_threshold` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variant_stocks_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `variant_stocks_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table altaraven.variant_stocks: ~1 rows (approximately)
INSERT INTO `variant_stocks` (`id`, `product_variant_id`, `quantity`, `low_stock_threshold`, `created_at`, `updated_at`) VALUES
	(3, 3, 12, 5, '2026-03-29 02:50:06', '2026-03-29 02:50:06');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
