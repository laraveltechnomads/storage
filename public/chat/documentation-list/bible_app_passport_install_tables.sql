-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2022 at 05:28 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bible_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0113110150b789c9e821ebf751e25a179635b65362ead0a034075ba7468e8aa6b228eca2afc3d909', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:35:46', '2021-12-01 08:35:46', '2022-12-01 14:05:46'),
('0567c168a580399a1e895049bd75ad9bbe8ad526d65f8468c384de1762f7447dc167c9cac10afef3', 41, 1, 'API Token', '[]', 0, '2022-03-03 06:54:38', '2022-03-03 06:54:38', '2023-03-03 12:24:38'),
('06b0dab9167f28c79fd2b7ad3346ccc71eb32429f6bf32aaeb9ff659a2e8ce2811156ff6e069f94d', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:42:27', '2021-12-01 06:42:27', '2022-12-01 12:12:27'),
('08cf229919423c54f068955ed5ea3f867d12b707fe35cbb9890ad491d892e30c822c130e8eab4a9e', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:20', '2021-11-26 06:49:20', '2022-11-26 12:19:20'),
('0c6d83f81975a216d189dc6d3969ada3b8e83469eca5b4400581f613cadbb1991519c0e999cf3466', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:16:02', '2022-01-03 05:16:02', '2023-01-03 10:46:02'),
('0d150fb1e42d532e5ed9e4265946183bd30b51d905b6cd9223bec6428e81071ba49ff6bed6457b2c', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:00:53', '2021-11-25 00:00:53', '2022-11-25 05:30:53'),
('0e2526945f618fda1f0209124f323d8104481219c08181cc88fe1f7e5f22634ba3592a01c9614f72', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:20', '2021-11-26 06:49:20', '2022-11-26 12:19:20'),
('10a638487eaf4b60089ce3c7f7e7ee2eea37fb0b6e6ed18d1e3143d0f715c06c3061cc15c44d51a6', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:45:05', '2021-12-01 08:45:05', '2022-12-01 14:15:05'),
('12def3b896feb9be276e5b731e6ececc39dccaace48489ae1fc55b35667eca4e1aeb583bf253b973', 26, 1, 'API Token', '[]', 0, '2021-12-09 05:24:36', '2021-12-09 05:24:36', '2022-12-09 10:54:36'),
('132779b05fad0be809bbbb9239841d957df72d9792f55d0ddb11d1429cf17e17760a34c4c892bb18', 24, 1, 'API Token', '[]', 0, '2021-12-28 09:50:22', '2021-12-28 09:50:22', '2022-12-28 15:20:22'),
('13e687561d762b650d62f6bc311c9ddcd97f6e112c04c9307ea132f766ef0b8094904e72ecc8e63b', 10, 1, 'API Token', '[]', 0, '2021-12-01 08:46:26', '2021-12-01 08:46:26', '2022-12-01 14:16:26'),
('1582f935ff3dd9da2ca37b8f4169b2141ef496420e4fd9b6824f9ac3a792ad837262db23d91ee282', 24, 1, 'API Token', '[]', 0, '2021-12-09 10:09:52', '2021-12-09 10:09:52', '2022-12-09 15:39:52'),
('187e24a76ec15c66bf7c2577c8372b35fd03a3d021f907ebd351ea3e5c261ddcea2e9bc447f7bfef', 10, 1, 'API Token', '[]', 0, '2021-11-26 07:06:20', '2021-11-26 07:06:20', '2022-11-26 12:36:20'),
('1a3f6adf396e50c387d9185d4a084ff7f21768364fafa1e5684c52fd1be35c41c21cc31b948a1129', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:44:55', '2021-12-14 08:44:55', '2022-12-14 14:14:55'),
('1d380f36ec2d0565382160f1ff45a1d43831714ff0d2e781a9375f10a049877f69b7e6dd2948c3e0', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:44:41', '2021-12-01 08:44:41', '2022-12-01 14:14:41'),
('1d6b13d2a1f2844f1d8ebe1defe6b35e2c64ada4ee0cf3438cf06587c937486416a54f711d8b7775', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:44:50', '2021-12-21 10:44:50', '2022-12-21 16:14:50'),
('21780a6faa8a0068b4b8cc35370fa623c68e0d4909ba5b6109919190864dc772258a497ba900a540', 26, 1, 'API Token', '[]', 0, '2021-12-07 10:50:32', '2021-12-07 10:50:32', '2022-12-07 16:20:32'),
('223b2737925c8dd88f32e166f8302802c26edb262f363bd2fcc0bb148e4be3d0466dcfcf47cd1fcd', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:39:01', '2021-12-01 08:39:01', '2022-12-01 14:09:01'),
('2300b654ab0178d2b0428f67a5337b254795c88d73f7f64877f632fd62346264c25b445d4c179428', 15, 1, 'API Token', '[]', 0, '2021-11-30 09:19:34', '2021-11-30 09:19:34', '2022-11-30 14:49:34'),
('2443a7b83a4029c6cb170fdf6fbcd580118d0228e981a68cae1758e2531fea644c62ae999c43793b', 26, 1, 'API Token', '[]', 0, '2021-12-07 04:33:52', '2021-12-07 04:33:52', '2022-12-07 10:03:52'),
('2979c7c51a3cfa0f0c73dd40dab5f450770ea2be730ba9f975f9f86b17b73ef94ac381478e318921', 26, 1, 'API Token', '[]', 0, '2021-12-07 04:32:54', '2021-12-07 04:32:54', '2022-12-07 10:02:54'),
('29e2f5545939de16446bd86903084c9628f0836cd52369316965dc3ba7a7700f164bb9e0ea5e4dfd', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:44:27', '2021-12-21 10:44:27', '2022-12-21 16:14:27'),
('300810f2402189ace8053264bd424c9413b8400237c6f018a6eef749fc799a19e1fb99a7dc9bc8b7', 3, 1, 'API Token', '[]', 0, '2021-11-24 23:51:40', '2021-11-24 23:51:40', '2022-11-25 05:21:40'),
('3020113568a076aeeed2c30d93a44707053f99b46009354e1e1948aad1493775d24e651ad66225b8', 17, 1, 'API Token', '[]', 0, '2021-12-01 08:42:26', '2021-12-01 08:42:26', '2022-12-01 14:12:26'),
('31f2590166748977de08527edf151b4726ae71e5d5e632a02304666bdd3f79ad6901609557408371', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:19', '2021-11-26 06:49:19', '2022-11-26 12:19:19'),
('338a79c1031451cce6ab9536a9c0811c452c21702b5c1d5889b39f8c29943b30de8a39df5e5c0fff', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:15:12', '2021-11-25 00:15:12', '2022-11-25 05:45:12'),
('33a192f3183c2812b7198485b55f14a4eaafdb06ab47a87e888b659ada7fa5bfe660c679772565e0', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:15:56', '2022-01-03 05:15:56', '2023-01-03 10:45:56'),
('35dd85d8ddab82f67664bd114acca9d276a11c29317c5f907f864fe51f1adf6f97eed7e8a60886a8', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:40:24', '2021-12-01 08:40:24', '2022-12-01 14:10:24'),
('3698f55aebd64d6e8e26a6493f3fb63d242e6cd2a49b96a4e4c17e907ceff8f7d5bd4df7eeb11ad1', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:40:57', '2021-11-26 06:40:57', '2022-11-26 12:10:57'),
('3ea26e25042285ba2bfbe9f008d34245993d85f3b1ac24d49d3ee455d0d01fc6dc932e6faaff44da', 4, 1, 'API Token', '[]', 0, '2021-11-25 04:43:37', '2021-11-25 04:43:37', '2022-11-25 10:13:37'),
('4c42e367064d7b0575130f217a63797eb712a7203029aa097cdbe58284ef70d84d02d1bb066db20e', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:44:16', '2021-12-14 08:44:16', '2022-12-14 14:14:16'),
('4cf1b30b41d172666c7fee1725cbf310bbc370b9c4e92c32b0e36343de801dd0f2d788913701c446', 10, 1, 'API Token', '[]', 0, '2021-12-07 11:40:07', '2021-12-07 11:40:07', '2022-12-07 17:10:07'),
('51e0ef51e5fdbdc97e430d9a2c1cc41083fe15526e6ac31f26146cf45b667b330ce65bcae7541800', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:00:53', '2021-11-25 00:00:53', '2022-11-25 05:30:53'),
('52ad23b575d221f696e246537a0cbab17d0457be7a6bd8074f4f72acee6930a14172c0f7f90b67a7', 26, 1, 'API Token', '[]', 0, '2021-12-31 04:33:12', '2021-12-31 04:33:12', '2022-12-31 10:03:12'),
('5323b86a8689cf1d0a58b5ced68bdc9c1d63454a8b9ae80de0e21d39d08ade8bac29e2998878afca', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:41:43', '2021-12-01 06:41:43', '2022-12-01 12:11:43'),
('5340e6f2503423b124abacce359b2ee4fff14d3f7c23f90dfbf7bb03274a5bc9ddefc4677faed63c', 24, 1, 'API Token', '[]', 0, '2021-12-09 10:10:09', '2021-12-09 10:10:09', '2022-12-09 15:40:09'),
('5483db8f96fa3b42539a3b03f0bacd1db895ad60ab00c3728245ec9537fd7a74ccbfce212a4997b6', 4, 1, 'API Token', '[]', 0, '2021-12-11 10:56:01', '2021-12-11 10:56:01', '2022-12-11 16:26:01'),
('57680a373e3bcd6c3dcc9af8b5369eb94cd59e39df54f3ec2c341b317206f44b1cfd94202f8a4431', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:50:37', '2021-12-14 08:50:37', '2022-12-14 14:20:37'),
('59fb9ce866b171612d9d80884944ffe630371c55729af2f7ef7b6b900526fe636ae3ee3d6204a73a', 10, 1, 'API Token', '[]', 0, '2021-12-01 08:47:13', '2021-12-01 08:47:13', '2022-12-01 14:17:13'),
('5fa6bf01f30a93116ddb348d58cb5eb5c0e8a263b859cbfc8ea39b42db8ca5f8f16a196c804c2bb5', 10, 1, 'API Token', '[]', 0, '2021-12-09 05:05:11', '2021-12-09 05:05:11', '2022-12-09 10:35:11'),
('62bad5ffdad44faf3d6b5e4ad52df730fdfa9005538c58cc1cbb4a888a34f88445343bbbcd26557d', 26, 1, 'API Token', '[]', 0, '2021-12-06 08:12:14', '2021-12-06 08:12:14', '2022-12-06 13:42:14'),
('64c00979656467c7c82177a35ac325f41ebb89eed9262459433d4a460a06fa8dd1c4bd78a7da2131', 12, 1, 'API Token', '[]', 0, '2021-11-30 12:56:49', '2021-11-30 12:56:49', '2022-11-30 18:26:49'),
('6cc3717332e0ccb6b207a3ca5f18baa86baaebad1419c15b22a8eecc1c3b42eff6b08289b673affb', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:16', '2021-11-27 01:23:16', '2022-11-27 06:53:16'),
('6dc331e915bf2de9005fe279b086ad53417788c566ddbb06d83580f5e64c4458438f0e6a022bbf3a', 10, 1, 'API Token', '[]', 0, '2021-12-02 05:52:04', '2021-12-02 05:52:04', '2022-12-02 11:22:04'),
('79634fd6e5b93fa8866e4ee18b439c9dd0e9b1fe4aee2d25673a0d97ed27eb9f324dbec1fc6cc03e', 1, 1, 'API Token', '[]', 0, '2021-11-26 07:49:54', '2021-11-26 07:49:54', '2022-11-26 13:19:54'),
('7bbde1086f02a187ad475530cd54af429846a3ec470d6369f2810566ab6c96325ba6bc851e9532ba', 10, 1, 'API Token', '[]', 0, '2021-11-26 08:04:24', '2021-11-26 08:04:24', '2022-11-26 13:34:24'),
('7d84d94bbecfa7a3c87ea13a0c1966c4ea45bb939e6013a9dc045bb4b4f2d274c0f87b6865c2337c', 1, 1, 'API Token', '[]', 0, '2021-11-26 07:49:52', '2021-11-26 07:49:52', '2022-11-26 13:19:52'),
('7f99e6dd35431bb00645259b3e4c6c2261f6e4166a5f7af1e3db25e9a43d392feac6562dee922555', 10, 1, 'API Token', '[]', 0, '2021-11-26 07:05:51', '2021-11-26 07:05:51', '2022-11-26 12:35:51'),
('7fde3207eb72ec86ec636d576aab7905322923be6c3e263e28108574a440fd8aeb32e3b03236686b', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:15:41', '2021-11-25 00:15:41', '2022-11-25 05:45:41'),
('83de41912e7dbbc3cf0fb8681bdfe6eb4d62b4bf8439131703c01eba50a401f13ed9e91527476615', 10, 1, 'API Token', '[]', 0, '2021-12-09 12:49:58', '2021-12-09 12:49:58', '2022-12-09 18:19:58'),
('8b2bcc5463ed2f7d266029992376650d9ee19a71fb8101f71b2ca05c24b7b4b85ad92c6a3a455dd2', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:19', '2021-11-26 06:49:19', '2022-11-26 12:19:19'),
('8b2f39a76f11bb7cf8c99116de2395c53af5d9ac59d3d72700d4fc29ba9ad9891dbafa9d701ac016', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:51:57', '2021-12-21 10:51:57', '2022-12-21 16:21:57'),
('8c5ead1999b7a1fc490f4c1a0d61dac40fb6863dfff2aa40b7748771c62d1e02649eb3cb3b939fb3', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:45:44', '2021-12-14 08:45:44', '2022-12-14 14:15:44'),
('91b2a4ccf7124f80e0d2e6924ade45ab8298355172e0fb11e96a33e370b1f7a5f5d23cdd5e4381e3', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:15:49', '2022-01-03 05:15:49', '2023-01-03 10:45:49'),
('9e243b5463df553802e9eef13ae1cb346a83c8be9a46b9648261c59dcf8288f0579de9f544743bbc', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:22:33', '2021-11-27 01:22:33', '2022-11-27 06:52:33'),
('9e7aaf7968c6dca934067c570b262fa7e2df9c2b80cc8383839d3afaa32b2666cd49c72ba263bb22', 3, 1, 'API Token', '[]', 0, '2021-11-24 23:59:50', '2021-11-24 23:59:50', '2022-11-25 05:29:50'),
('a03bbe965d8828efd483bacc96094aae111dc0e81cccef9127a14b7f2b56bce937db02daa4ab78f2', 32, 1, 'API Token', '[]', 0, '2021-12-06 06:36:53', '2021-12-06 06:36:53', '2022-12-06 12:06:53'),
('a3aaf30aab7c0a2da622e364bb0bf3834c6e36674273ae8b1bcc80d1ad404502ec996efcce257996', 26, 1, 'API Token', '[]', 0, '2021-12-09 10:43:28', '2021-12-09 10:43:28', '2022-12-09 16:13:28'),
('a4614545a742751bc7c3b99b61fbd8ab1235d9622753d9e6f5f4e0e03cb8b08783ef4c082bf7440c', 32, 1, 'API Token', '[]', 0, '2021-12-06 11:12:12', '2021-12-06 11:12:12', '2022-12-06 16:42:12'),
('a77f1a528abbedeef7fbcdf3054db4c005cce2edad611ffa5bcfc60779427ed68548b7ebcbc5ba55', 10, 1, 'API Token', '[]', 0, '2021-12-02 05:42:14', '2021-12-02 05:42:14', '2022-12-02 11:12:14'),
('a80f434d9bdaa053f338391116efb7334ae9c1d068000fd722a6038764e81517867a523f44e081e3', 26, 1, 'API Token', '[]', 0, '2021-12-20 07:14:20', '2021-12-20 07:14:20', '2022-12-20 12:44:20'),
('a8a38766f0e8002cbf15caf8d907564befc4bd48bd364514e6ec17acc763916009970cbb0d396718', 10, 1, 'API Token', '[]', 0, '2021-12-02 05:51:40', '2021-12-02 05:51:40', '2022-12-02 11:21:40'),
('ab3004b9559013c555cadfffacf6b881bbfa05a8bc210d95d3e368a4969e4bed9bb2ccdb084011c3', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:20', '2021-11-26 06:49:20', '2022-11-26 12:19:20'),
('af9002915aa123029ef882f55e570ef187b7c3b177c26feae02494a5a8bbab2b38f6b6c2dac0b772', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:15', '2021-11-27 01:23:15', '2022-11-27 06:53:15'),
('b1f7b301c30e0bf48cc7422dcbeb6fb51ad47f9594bd2ba58c315177c437d1838b09c051042dd373', 26, 1, 'API Token', '[]', 0, '2021-12-07 04:34:50', '2021-12-07 04:34:50', '2022-12-07 10:04:50'),
('b7dd1f11956a6ed416b5fd49278e98503a2a34b3f4bd646b7e7a4a43d99fa2e245cabd553bf8d453', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:16', '2021-11-27 01:23:16', '2022-11-27 06:53:16'),
('c1fa20c9730c246ea3992dac9de1447672cfa64623d0e39ddee44c24a1289fa894acb5ea18a6c519', 43, 1, 'API Token', '[]', 0, '2022-03-03 12:47:44', '2022-03-03 12:47:44', '2023-03-03 18:17:44'),
('c8f648cf712cf57cb1873ee55e55d9595c4e9f30f1b7046410146808a02375b395e0df71424833cf', 32, 1, 'API Token', '[]', 0, '2021-12-06 11:11:13', '2021-12-06 11:11:13', '2022-12-06 16:41:13'),
('ccbcae3e2d55d7066516eb8319300639a1c9f0274306df401590ca81a77e9fff61c8d2cc768f98d6', 10, 1, 'API Token', '[]', 0, '2021-11-26 08:02:34', '2021-11-26 08:02:34', '2022-11-26 13:32:34'),
('ce8cd8fe00fb5f9a357c7b165f828b6e7b2dbef608581bd485f0079eeb2ad0283f201ab08caf01fd', 26, 1, 'API Token', '[]', 0, '2021-12-09 05:23:42', '2021-12-09 05:23:42', '2022-12-09 10:53:42'),
('d36ef785f77ea369f916c06ccde1a3ef5fed4846ccdd0ac63c5b449364c174828421448d9d00a367', 26, 1, 'API Token', '[]', 0, '2021-12-07 10:50:59', '2021-12-07 10:50:59', '2022-12-07 16:20:59'),
('d68f533442c0e5480510e24ef7f610c94e230b9104188d0e785303f51b5e67336659059e1e5b2d43', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:38:31', '2021-11-26 06:38:31', '2022-11-26 12:08:31'),
('dd317996fb8a6b1b331ba93234e2952ad54095a983c40bb8e36c3fb227d544791173b88f35f537f6', 12, 1, 'API Token', '[]', 0, '2021-11-30 12:56:29', '2021-11-30 12:56:29', '2022-11-30 18:26:29'),
('dd3f1ed297df350fc2332cbe22635646a303a2ca6538a1ee64a528cd4755e209daaa91979606c4df', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:00:22', '2021-11-25 00:00:22', '2022-11-25 05:30:22'),
('def0302004482c72da7dbefdea9289cc6f60020e503d382beae2070a71dca3e4d63dcd00fc5e19f0', 10, 1, 'API Token', '[]', 0, '2021-12-07 11:40:27', '2021-12-07 11:40:27', '2022-12-07 17:10:27'),
('e1e5019f3b9b01d245d8bd3517bc93493e895920561769e0a000c6db4aa6022ed4ec769acf79878c', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:52:07', '2021-12-21 10:52:07', '2022-12-21 16:22:07'),
('e28c2079f41e039d57a04b011178e34e0d0ba3b1a9eec1fdb74e6597250d04183bbc558373455ecc', 3, 1, 'API Token', '[]', 0, '2021-11-25 23:07:33', '2021-11-25 23:07:33', '2022-11-26 04:37:33'),
('e38a77e0e2551b08afae3925a3901f15d8a3417955c3838948d6b47859b36ccb0bfacd98727fcdc5', 32, 1, 'API Token', '[]', 0, '2021-12-06 11:13:15', '2021-12-06 11:13:15', '2022-12-06 16:43:15'),
('e5a07e7dfce4185b92c750604dc27c346550142abc2135d548898935fb27dc0b49a41ba57e5cecb8', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:14', '2021-11-27 01:23:14', '2022-11-27 06:53:14'),
('e800a665cba4229b2e1b36a85f7477ad143134229d52ee819a979b49033f5eb331c992efa7ffc173', 24, 1, 'API Token', '[]', 0, '2021-12-06 08:08:31', '2021-12-06 08:08:31', '2022-12-06 13:38:31'),
('e9b9d2f573ff1a6a90f7fd2a7ecaf28768c545748618ec22ea90b820ec6601c6a80e6bf3066afba1', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:40:03', '2021-12-01 06:40:03', '2022-12-01 12:10:03'),
('ea0dcac6da77687985791b5c4e74d7554a447f42046b1344398d1f54a17812879db9a2ecf2be0000', 17, 1, 'API Token', '[]', 0, '2021-12-01 08:42:47', '2021-12-01 08:42:47', '2022-12-01 14:12:47'),
('eeebc4449aa0410e7a48af409e1f33082adca4ac8fcd37b6aca021ba801aca25b51923d682066a16', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:39:55', '2021-12-01 06:39:55', '2022-12-01 12:09:55'),
('f0012e9612a17f699b6d2e563447d8b983fcc055bf8534ba6bcf1174736ccd5eab46d12cf7c62f5c', 4, 1, 'API Token', '[]', 0, '2021-12-11 10:56:21', '2021-12-11 10:56:21', '2022-12-11 16:26:21'),
('f10d4d54450aca2a5c6397509e7fd1b5f8d6dd40e2e2acb3fc8d086737e2a000dd17597dfbad6379', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:16:14', '2022-01-03 05:16:14', '2023-01-03 10:46:14'),
('f91c1196ab960422a0ba86ce0084e3e926e1b4eaf990c430d4b85ff1c27a12374be7531276d91c05', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:22:30', '2021-11-27 01:22:30', '2022-11-27 06:52:30'),
('f922ef3c4a599e9ef9453b25bfed631044416e0f06d1b92744acc49b95b6dde606a6920a8e1450b8', 44, 1, 'API Token', '[]', 0, '2022-03-08 10:50:01', '2022-03-08 10:50:01', '2023-03-08 16:20:01'),
('fa295149553b4b452f713c51caaf4069747e03ff932757880c95f6f1385636be4c8d05dde7f6eb0a', 10, 1, 'API Token', '[]', 0, '2021-12-09 05:04:24', '2021-12-09 05:04:24', '2022-12-09 10:34:24'),
('fa9966be010a9a44a0a484a1f65662be9302c21ecb1a319ae8a64022bf2c8f0f8a8f4460a2b1085c', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:39:17', '2021-12-01 06:39:17', '2022-12-01 12:09:17'),
('fbc16e43d8f7770622c412725c5b1702b404b13b28c76d302d2ee586b259d4172c1ae4049a74d24e', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:22:32', '2021-11-27 01:22:32', '2022-11-27 06:52:32'),
('fe3d0c347b58b89db26d91bc7054ff3170afb415114da21f701f7e56935cff135d49643bc16df330', 24, 1, 'API Token', '[]', 0, '2021-11-30 13:44:08', '2021-11-30 13:44:08', '2022-11-30 19:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'BibleChat Personal Access Client', 'XQhiBl9bWSJS4ATNy2g0BkLOCBFApumQPcnp8Fsv', NULL, 'http://localhost', 1, 0, 0, '2021-11-24 23:49:56', '2021-11-24 23:49:56'),
(2, NULL, 'BibleChat Password Grant Client', 'srTEAfgax95LOfi6ojPK3oWsMQUo1QaluLZSkEkD', 'users', 'http://localhost', 0, 1, 0, '2021-11-24 23:49:56', '2021-11-24 23:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-11-24 23:49:56', '2021-11-24 23:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
