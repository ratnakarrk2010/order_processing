-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2021 at 12:46 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `order_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` int(11) NOT NULL,
  `client_name` varchar(300) DEFAULT NULL,
  `type_of_customer` text DEFAULT NULL,
  `email_id` varchar(300) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact1` varchar(10) DEFAULT NULL,
  `contact_person1` varchar(300) DEFAULT NULL,
  `contact2` varchar(10) DEFAULT NULL,
  `contact_person2` varchar(300) DEFAULT NULL,
  `is_deleted` char(2) DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`id`, `client_name`, `type_of_customer`, `email_id`, `address`, `contact1`, `contact_person1`, `contact2`, `contact_person2`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Client Name', 'EXISITNG (OLD)', 'client@gmail.com', 'Address', '9089099098', 'Contact Person1', NULL, NULL, 'N', '2021-01-28 06:54:56', 1, '2021-02-11 03:06:53', 1),
(2, 'Client Name1', 'NEW', 'client@gmail.com', 'Address', '9089099090', 'Contact Person1', NULL, NULL, 'N', '2021-01-28 06:59:12', 1, '2021-01-31 06:17:45', 1),
(3, 'Client Name2', 'EXISITNG (OLD)', 'client@gmail.com', 'Address', '9089099090', 'Contact Person1', NULL, NULL, 'N', '2021-01-28 07:00:54', 1, '2021-01-28 07:00:54', NULL),
(4, 'Client Name3', 'EXISITNG (OLD)', 'client@gmail.com', 'Address', '9089099090', 'Contact Person1', NULL, NULL, 'N', '2021-01-28 07:01:06', 1, '2021-01-28 07:01:06', NULL),
(5, 'Client Name4', 'EXISITNG (OLD)', 'client@gmail.com', 'Address', '9089099090', 'Contact Person1', NULL, NULL, 'Y', '2021-01-28 07:17:22', 1, '2021-01-31 06:25:03', NULL),
(6, 'Client1 Name5', 'EXISITNG (OLD)', 'client@gmail.com', 'Address676', '9089099090', 'Contact Person1', NULL, NULL, 'N', '2021-01-28 07:17:44', 1, '2021-01-28 07:17:44', NULL),
(7, 'Client2 Name6', 'EXISITNG (OLD)', 'client2@gmail.com', 'Address675', '9889099090', 'Contact Person1', NULL, NULL, 'Y', '2021-01-28 07:25:41', 1, '2021-01-31 06:22:57', 1),
(9, 'Ganesh Kale', 'NEW', 'ganesh@gmail.com', 'Address', '8596236368', 'Dinesh Javale', '8596236365', 'Dinesh Patil', 'N', '2021-02-12 03:57:06', 1, '2021-02-12 03:57:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `installation_details`
--

CREATE TABLE `installation_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `installation_assigned_to` text DEFAULT NULL,
  `installation_assigned_to_id` int(11) DEFAULT NULL,
  `installation_start_date` datetime DEFAULT NULL,
  `installation_completion_date` datetime DEFAULT NULL,
  `doc_completed` char(3) DEFAULT 'No',
  `installation_serivice_completed` char(3) DEFAULT 'No',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `installation_details`
--

INSERT INTO `installation_details` (`id`, `order_id`, `customer_id`, `installation_assigned_to`, `installation_assigned_to_id`, `installation_start_date`, `installation_completion_date`, `doc_completed`, `installation_serivice_completed`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 7, 2, 'Rakesh Mane', 10, '2021-02-11 00:00:00', '2021-02-24 00:00:00', NULL, 'No', 1, '2021-02-12 03:42:00', NULL, '2021-02-12 03:42:00'),
(2, 10, 3, 'Rakesh Mane', 10, '2021-02-10 00:00:00', '2021-02-18 00:00:00', 'Yes', 'No', 1, '2021-02-19 13:07:26', NULL, '2021-02-19 13:07:26'),
(3, 9, 3, 'Rakesh Mane', 10, '2021-02-10 00:00:00', '2021-02-18 00:00:00', 'Yes', 'Yes', 1, '2021-02-19 13:09:48', NULL, '2021-02-19 13:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `opf_no` int(11) DEFAULT NULL,
  `opf_date` date DEFAULT NULL,
  `po_no` int(11) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `installation_address` text DEFAULT NULL,
  `order_collected_by` varchar(300) DEFAULT NULL,
  `order_collected_by_id` int(11) DEFAULT NULL,
  `warranty_period` varchar(300) DEFAULT NULL,
  `sales_initiator_by` varchar(300) DEFAULT NULL,
  `sales_initiator_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(300) DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `total_po_value` int(100) DEFAULT NULL,
  `payment_terms` text DEFAULT NULL,
  `material_procurement_date` date DEFAULT NULL,
  `qc_testting_result` text DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `invoice_no` varchar(200) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `is_installation_done` tinyint(1) DEFAULT 0,
  `is_payment_done` tinyint(1) DEFAULT 0,
  `is_deleted` char(2) DEFAULT 'N',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `opf_no`, `opf_date`, `po_no`, `po_date`, `customer_id`, `installation_address`, `order_collected_by`, `order_collected_by_id`, `warranty_period`, `sales_initiator_by`, `sales_initiator_by_id`, `approved_by`, `approved_by_id`, `total_po_value`, `payment_terms`, `material_procurement_date`, `qc_testting_result`, `dispatch_date`, `invoice_no`, `invoice_date`, `remarks`, `is_installation_done`, `is_payment_done`, `is_deleted`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(7, 139, '2021-02-12', 133, '2021-02-02', 2, 'Installation Address', 'Sales Person', 5, '3Yr', 'Manager Name', 7, 'Ratnakar Kulkarni', 8, 50000, '80% advance 20% against delivery', '2021-02-02', 'Testing Result', NULL, '12345', '2021-02-10', 'remarks', 1, 0, 'N', 1, '2021-02-01 05:56:53', 1, '2021-02-12 03:42:00'),
(8, 111, '2021-02-10', 135, '2021-02-25', 2, 'address', 'Sales Person', 5, '2Yr', 'Manager Name', 7, 'Ratnakar Kulkarni', 8, 50000, 'End of month', '2021-02-13', 'Testing Result', '2021-02-19', '45678', '2021-02-19', 'Remark if any', 0, 0, 'N', 1, '2021-02-11 05:19:48', 1, '2021-02-12 03:54:45'),
(9, 789, '2021-02-12', 1213, '2021-02-24', 3, '204, Gargi, MaharajaComplex', 'Sales Person', 5, '2Yr', 'Manager Name', 7, '', 9, 50000, 'Payment 30 days after invoice date', '2021-02-25', 'Testing Result  QC', '2021-02-09', '14589', '2021-02-10', 'Remark if any', 1, 0, 'N', 1, '2021-02-19 12:40:39', NULL, '2021-02-19 13:09:48'),
(10, 124, '2021-02-05', 456, '2021-02-16', 3, 'Installation Address', 'Sales Person', 5, '2Yr', 'Mananger Name', 7, 'Katre Sir', 9, 50000, 'Payment seven days after invoice date', '2021-02-27', 'Testing Result', '2021-02-18', '14588', '2021-02-19', 'Remark if any', 1, 0, 'N', 1, '2021-02-19 12:50:35', NULL, '2021-02-19 13:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `materials` text DEFAULT NULL,
  `quantity` int(100) DEFAULT NULL,
  `dc_no` varchar(300) DEFAULT NULL,
  `dc_date` date DEFAULT NULL,
  `product_serial_no` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `customer_id`, `order_id`, `materials`, `quantity`, `dc_no`, `dc_date`, `product_serial_no`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 7, 'Material1', 10, '123', '2021-02-17', '1111', '2021-02-01 05:56:53', 1, '2021-02-02 06:35:55', NULL),
(2, 2, 7, 'Material15', 10, '123', '2021-02-16', '1115', '2021-02-01 05:56:53', 1, '2021-02-02 06:35:55', NULL),
(3, 2, 7, 'Material134', 10, '128', '2021-02-17', '1119', '2021-02-02 06:38:10', 1, '2021-02-02 06:38:10', NULL),
(4, 2, 8, 'Material 1', 2, '125', '2021-02-25', '1115', '2021-02-11 05:19:48', 1, '2021-02-12 03:54:28', NULL),
(5, 2, 8, 'Material2', 10, '110', '2021-02-04', '9850', '2021-02-12 03:54:28', 1, '2021-02-12 03:54:28', NULL),
(6, 3, 9, 'Material1345', 1, '6565', '2021-02-17', '7898', '2021-02-19 12:40:39', 1, '2021-02-19 12:40:39', NULL),
(7, 3, 9, 'Material1346', 23, '788', '2021-03-09', '7896', '2021-02-19 12:40:39', 1, '2021-02-19 12:40:39', NULL),
(8, 3, 10, 'Material186', 56, '128', '2021-02-24', '1117', '2021-02-19 12:50:35', 1, '2021-02-19 12:50:35', NULL),
(9, 3, 10, 'Material186', 34, '345', '2021-02-10', '4787', '2021-02-19 12:50:35', 1, '2021-02-19 12:50:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `payment_terms` text DEFAULT NULL,
  `os_days` varchar(200) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(200) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_received` varchar(200) DEFAULT NULL,
  `balance_payment` varchar(200) DEFAULT NULL,
  `payment_received_date` date DEFAULT NULL,
  `is_final_payment` tinyint(1) DEFAULT 0,
  `final_payment_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `payment_terms`, `os_days`, `order_id`, `invoice_no`, `customer_id`, `payment_received`, `balance_payment`, `payment_received_date`, `is_final_payment`, `final_payment_date`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, '80% advance 20% against delivery', NULL, 7, NULL, 2, '5000', '45000', '2021-02-10', 0, NULL, 1, '2021-02-10 02:47:18', NULL, '2021-02-10 02:47:18'),
(2, '80% advance 20% against delivery', NULL, 7, NULL, 2, '10000', '35000', '2021-02-14', 0, NULL, 1, '2021-02-12 03:42:45', NULL, '2021-02-12 03:42:45'),
(3, 'Payment seven days after invoice date', '20', 10, '14588', 3, '10000', '40000', '2021-02-20', 0, NULL, 1, '2021-02-19 13:18:08', NULL, '2021-02-19 13:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(300) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Admin', 1, '2021-01-28 09:25:28', NULL, NULL),
(2, 'Sales Person', 1, '2021-01-28 09:44:22', NULL, NULL),
(3, 'Support', 1, '2021-01-28 09:44:34', NULL, NULL),
(4, 'Accountant', 1, '2021-01-28 09:44:52', NULL, NULL),
(5, 'Installation Person', 1, '2021-02-19 08:59:26', NULL, NULL),
(6, 'Manager', 1, '2021-02-19 09:10:13', NULL, NULL),
(7, 'Management', 1, '2021-02-19 09:10:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(300) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `first_name` varchar(300) DEFAULT NULL,
  `last_name` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` int(2) DEFAULT 1,
  `is_deleted` char(2) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `first_name`, `last_name`, `email`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_active`, `is_deleted`) VALUES
(1, 1, 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'Admin', 'User', 'admin@gmail.com', 1, '2021-01-28 05:17:05', 1, '2021-02-14 00:57:50', 1, 'N'),
(2, 4, 'account@gmail.com', '$2y$10$loUh5SdJalqI59B2HmsVJeTiYAbSFVb50CbtBTo/HbRhaHSlmMym2', 'Account', 'Person', 'account@gmail.com', 2, '2021-01-28 04:48:08', 1, '2021-01-31 05:12:22', 0, 'N'),
(5, 2, 'sales@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sales', 'Person', 'sales@gmail.com', 1, '2021-02-02 03:50:52', 1, '2021-02-11 03:58:02', 0, 'N'),
(6, 3, 'support@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Support', 'Person', 'support@gmail.com', 1, '2021-02-12 03:59:14', 1, '2021-02-12 04:00:00', 1, 'N'),
(7, 6, 'manager@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Mananger', 'Name', '123456', 1, '2021-02-19 03:53:36', 1, '2021-02-19 03:53:36', 1, 'N'),
(8, 7, 'ratnakark@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ratnakar', 'Kulkarni', 'ratnakark@gmail.com', 1, '2021-02-19 03:54:34', 1, '2021-02-19 03:54:34', 1, 'N'),
(9, 7, 'katre@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Katre', 'Sir', 'katre@gmail.com', 1, '2021-02-19 03:57:55', 1, '2021-02-19 03:57:55', 1, 'N'),
(10, 5, 'rakesh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rakesh', 'Mane', 'rakesh@gmail.com', 1, '2021-02-19 05:51:00', 1, '2021-02-19 05:51:00', 1, 'N');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_orders_info`
-- (See below for the actual view)
--
CREATE TABLE `v_orders_info` (
);

-- --------------------------------------------------------

--
-- Structure for view `v_orders_info`
--
DROP TABLE IF EXISTS `v_orders_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_orders_info`  AS SELECT `o`.`id` AS `ORDER_ID`, `o`.`opf_no` AS `OPF_NO`, `o`.`opf_date` AS `OPF_DATE`, `o`.`po_no` AS `PO_NO`, `o`.`po_date` AS `PO_DATE`, `cd`.`client_name` AS `CUSTOMER`, `cd`.`type_of_customer` AS `TYPE_OF_CUSTOMER`, `cd`.`email_id` AS `CUSTOMER_EMAIL`, `cd`.`address` AS `CUSTOMER_ADDRESS`, `cd`.`contact_person1` AS `CONTACT_PERSON_1`, `cd`.`contact1` AS `CONTACT_NO_1`, `cd`.`contact_person2` AS `CONTACT_PERSON_2`, `cd`.`contact2` AS `CONTACT_NO_2`, `o`.`installation_address` AS `INSTALLATION_ADDRESS`, `o`.`order_collected_by` AS `ORDER_COLLECTED_BY`, `o`.`warranty_period` AS `WARRANTY_PERIOD`, `o`.`os_days` AS `OS_DAYS`, `o`.`sales_initiator_by` AS `SALES_INITIATED_BY`, `o`.`approved_by` AS `APPROVED_BY`, `o`.`total_po_value` AS `TOTAL_PO_VALUE`, `o`.`material_procurement_date` AS `MATERIAL_PROCUREMENT_DATE`, `o`.`qc_testting_result` AS `QC TESTING_RESULT`, `o`.`dispatch_date` AS `DISPATCH_DATE`, `o`.`remarks` AS `REMARKS`, if(`o`.`is_installation_done` is true,'YES','NO') AS `INSTALLATION_DONE`, if(`o`.`is_payment_done` is true,'YES','NO') AS `FINAL_PAYMENT_DONE`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `ORDER_CREATED_BY`, date_format(`u`.`created_at`,'%m/%d/%Y') AS `ORDER_CREATED_AT`, `oid`.`installation_assigned_to` AS `INSTALLATION_ASSIGNED_TO`, `oid`.`installation_start_date` AS `INSTALLATION_START_DATE`, `oid`.`installation_completion_date` AS `INSTALLTION_COMPLETION_DATE`, `oid`.`inv_no` AS `INVOICE_NO`, `oid`.`installation_alert` AS `INSTALLATION_ALERT`, `oid`.`amc_alert` AS `AMC_ALERT`, concat(`idu`.`first_name`,' ',`idu`.`last_name`) AS `INSTALLATION_CREATED_BY`, `oid`.`created_at` AS `INSTALLATION_CREATED_AT` FROM ((((`orders` `o` join `users` `u` on(`u`.`id` = `o`.`created_by`)) join `customer_details` `cd` on(`cd`.`id` = `o`.`customer_id`)) left join `installation_details` `oid` on(`oid`.`order_id` = `o`.`id`)) left join `users` `idu` on(`idu`.`id` = `oid`.`created_by`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installation_details`
--
ALTER TABLE `installation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `installation_details`
--
ALTER TABLE `installation_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
