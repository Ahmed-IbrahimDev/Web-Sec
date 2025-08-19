-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2025 at 12:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websec_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bought_products`
--

CREATE TABLE `bought_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price_paid` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bought_products`
--

INSERT INTO `bought_products` (`id`, `user_id`, `product_id`, `price_paid`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 7.50, 1, '2025-08-11 05:52:05', '2025-08-11 05:52:05'),
(2, 2, 3, 7.50, 1, '2025-08-11 05:56:40', '2025-08-11 05:56:40'),
(3, 2, 4, 29.00, 1, '2025-08-11 06:01:08', '2025-08-11 06:01:08'),
(4, 2, 4, 29.00, 1, '2025-08-11 06:51:49', '2025-08-11 06:51:49'),
(5, 2, 6, 19.99, 1, '2025-08-12 18:19:50', '2025-08-12 18:19:50'),
(6, 2, 7, 5.00, 1, '2025-08-13 16:16:42', '2025-08-13 16:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_15_000000_create_products_table', 1),
(6, '2023_05_15_000001_create_roles_table', 1),
(7, '2023_05_15_000002_create_permissions_table', 1),
(8, '2023_05_15_000003_create_role_user_table', 1),
(9, '2023_05_15_000004_create_permission_role_table', 1),
(10, '2024_01_01_000000_add_google_id_to_users_table', 1),
(11, '2025_08_10_140604_add_microsoft_id_to_users_table', 1),
(12, '2025_08_11_014805_add_linkedin_id_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'view_products', 'View products', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(2, 'create_products', 'Create new products', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(3, 'edit_products', 'Edit existing products', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(4, 'delete_products', 'Delete products', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(5, 'view_dashboard', 'View dashboard', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(6, 'buy_products', 'Purchase products', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(7, 'manage_users', 'Manage users', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(8, 'manage_roles', 'Manage roles and permissions', '2025-08-11 04:50:50', '2025-08-11 04:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, NULL),
(2, 2, 4, NULL, NULL),
(3, 3, 4, NULL, NULL),
(4, 4, 4, NULL, NULL),
(5, 5, 4, NULL, NULL),
(6, 6, 4, NULL, NULL),
(7, 7, 4, NULL, NULL),
(8, 8, 4, NULL, NULL),
(15, 1, 7, NULL, NULL),
(16, 2, 7, NULL, NULL),
(17, 3, 7, NULL, NULL),
(18, 5, 7, NULL, NULL),
(19, 6, 7, NULL, NULL),
(20, 1, 3, NULL, NULL),
(22, 6, 3, NULL, NULL),
(23, 1, 1, NULL, NULL),
(24, 2, 1, NULL, NULL),
(25, 3, 1, NULL, NULL),
(26, 4, 1, NULL, NULL),
(27, 5, 1, NULL, NULL),
(28, 6, 1, NULL, NULL),
(29, 7, 1, NULL, NULL),
(32, 1, 5, NULL, NULL),
(33, 2, 5, NULL, NULL),
(34, 3, 5, NULL, NULL),
(35, 4, 5, NULL, NULL),
(36, 5, 5, NULL, NULL),
(37, 6, 5, NULL, NULL),
(38, 7, 5, NULL, NULL),
(39, 8, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created_at`, `updated_at`) VALUES
(4, '1r34njdmnfmjdjn', 'Aluminum adjustable laptop stand', 29.55, '2025-08-11 05:32:24', '2025-08-13 16:05:07'),
(5, 'He', 'Over-ear noise-isolating headphones', 39.99, '2025-08-11 05:32:24', '2025-08-12 18:53:36'),
(6, 'Wirel', 'Ergonomic 2.4G wireless mouse', 0.00, '2025-08-11 06:44:29', '2025-08-13 16:06:59'),
(7, 'Mechanicl', 'RGB backlit mechanical keyboard', 5.00, '2025-08-11 06:44:29', '2025-08-12 18:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'employee', 'Employee with system access and management capabilities', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(2, 'custmer', 'Custmer with access to view products and make purchases', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(3, 'user', 'Regular user with basic access', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(4, 'super_admin', 'Super administrator with full system access', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(5, 'owner', 'System owner with complete control', '2025-08-11 04:50:50', '2025-08-11 04:50:50'),
(7, 'manager', 'Manager with product management access', '2025-08-11 06:38:15', '2025-08-11 06:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 3, 5, NULL, NULL),
(6, 3, 6, NULL, NULL),
(7, 4, 7, NULL, NULL),
(8, 5, 4, NULL, NULL),
(13, 1, 1, NULL, NULL),
(16, 4, 3, NULL, NULL),
(20, 3, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `linkedin_id` varchar(255) DEFAULT NULL,
  `microsoft_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `credit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `linkedin_id`, `microsoft_id`, `email_verified_at`, `password`, `credit`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Employee User', 'employee@example.com', NULL, NULL, NULL, NULL, '$2y$10$BFvSn1zCQOnFfj/32ywtmOVhpPht1YiyFHpBabM1wGYEwFXVqDRVi', 100.00, NULL, '2025-08-11 04:50:51', '2025-08-11 04:50:51'),
(2, 'Custmer User', 'custmer@example.com', NULL, NULL, NULL, NULL, '$2y$10$pJUqBzRdmj8qWab8SLwMPuQbljIimhoj6fSb4CIHUjplA0rOXZ4tO', 2.01, NULL, '2025-08-11 04:50:51', '2025-08-13 16:16:42'),
(3, 'Super Admin', 'admin@example.com', NULL, NULL, NULL, NULL, '$2y$10$NKIJpXo7VzvRnX2KX9PHDeHP5xAxZVCmdqv/WlalgP9YQpIR.UAJ2', 0.00, NULL, '2025-08-11 04:58:16', '2025-08-11 06:01:36'),
(4, 'Owner User', 'owner@example.com', NULL, NULL, NULL, NULL, '$2y$10$XdsB2TQhmz8J04VCi8Lno.SRZAh2qMepNICZfk51VQOsABwVa8EVa', 0.00, NULL, '2025-08-11 04:58:16', '2025-08-11 04:58:16'),
(5, 'Regular User', 'user@example.com', NULL, NULL, NULL, NULL, '$2y$10$tmf7q9L0JBGNwTy/C9xgT.iUiff4ZHicT/0hhO90ecK4L..wQ5x3.', 100.00, NULL, '2025-08-11 04:58:17', '2025-08-11 04:58:17'),
(6, 'Ahmed AhmedZaid', 'aahmedzaid301@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$GvOGiCHly6GE7.8By3JOPu2YLI/i4OeFrJxbptVqI10OJ59cC4Fsm', 0.00, NULL, '2025-08-11 06:03:02', '2025-08-11 06:03:02'),
(7, 'Super Admin', 'superadmin@example.com', NULL, NULL, NULL, NULL, '$2y$10$ea/GPTWPq3CKeUfNRISlduqEjHGKwL7rgBOcgvKR5gj5S2jjbhTzW', 0.00, NULL, '2025-08-11 06:39:01', '2025-08-11 06:39:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bought_products`
--
ALTER TABLE `bought_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bought_products_user_id_product_id_index` (`user_id`,`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_role_permission_id_role_id_unique` (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_user_role_id_user_id_unique` (`role_id`,`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bought_products`
--
ALTER TABLE `bought_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
