
--
-- Table structure for table `surat_jalan_detail`
--

CREATE TABLE `surat_jalan_detail` (
  `id` int(11) NOT NULL,
  `surat_jalan_id` varchar(200) NOT NULL,
  `source` varchar(20) NOT NULL,
  `file_address` varchar(200) NOT NULL,
  `sum_of_pages` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `jenis_kertas_id` int(11) NOT NULL,
  `peper_size` varchar(50) NOT NULL,
  `duplex` varchar(50) NOT NULL,
  `box` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surat_jalan_detail`
--
ALTER TABLE `surat_jalan_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surat_jalan_detail`
--
ALTER TABLE `surat_jalan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

-- Change box to null
ALTER TABLE `surat_jalan_detail` CHANGE `box` `box` INT(11) NULL DEFAULT '0';

-- add biaya on table surat jalan detail
ALTER TABLE `surat_jalan_detail` ADD `harga_satuan` INT NULL DEFAULT NULL AFTER `box`, ADD `harga_jumlah` INT NULL DEFAULT NULL AFTER `harga_satuan`;

-- change default o for harga_satuan and harga jumlah
ALTER TABLE `surat_jalan_detail` CHANGE `harga_satuan` `harga_satuan` INT(11) NULL DEFAULT '0', CHANGE `harga_jumlah` `harga_jumlah` INT(11) NULL DEFAULT '0';