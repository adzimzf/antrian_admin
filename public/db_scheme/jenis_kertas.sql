
CREATE TABLE `jenis_kertas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `size` varchar(50) NOT NULL,
  `is_banner` int(11) NOT NULL DEFAULT '0',
  `des` text NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_kertas`
--
ALTER TABLE `jenis_kertas`
  ADD PRIMARY KEY (`id`);
