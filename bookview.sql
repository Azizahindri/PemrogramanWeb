-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 01:40 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookview`
--

-- --------------------------------------------------------

--
-- Table structure for table `crud_041`
--

CREATE TABLE `crud_041` (
  `User` varchar(100) NOT NULL,
  `Judul_Buku` varchar(100) NOT NULL,
  `Review` text NOT NULL,
  `Rating` int(5) NOT NULL,
  `Tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crud_041_book`
--

CREATE TABLE `crud_041_book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(100) DEFAULT NULL,
  `genre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `review_page_url` varchar(255) DEFAULT NULL,
  `id_book` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crud_041_book`
--

INSERT INTO `crud_041_book` (`id`, `title`, `price`, `genre`, `description`, `image_url`, `review_page_url`, `id_book`) VALUES
(7, 'Selada', 15000, 'Sayuran', 'Selada hidroponik adalah pilihan sempurna bagi mereka yang mencari sayuran segar dengan tekstur renyah dan rasa yang ringan. Dibudidayakan dengan sistem hidroponik, selada ini bebas dari pestisida berbahaya dan kaya akan vitamin K serta serat yang baik untuk pencernaan.', 'images/selada.jpg', NULL, 'book_4cefa404-30db-11f0-b74f-7cd30a82ec7f'),
(8, 'Bayam', 17000, 'Sayuran', 'Bayam hidroponik memiliki daun hijau pekat yang kaya akan zat besi dan antioksidan. Tanaman ini tumbuh dalam lingkungan yang terkontrol sehingga menghasilkan daun yang lebih bersih dan bebas residu tanah, cocok untuk berbagai jenis masakan sehat.', 'images/bayam.jpg', NULL, 'book_4cefed47-30db-11f0-b74f-7cd30a82ec7f'),
(9, 'Kangkung', 18000, 'Sayur', 'Kangkung hidroponik dikenal dengan batangnya yang renyah dan daunnya yang lezat. Ditanam tanpa menggunakan tanah, kangkung ini bebas dari kontaminasi dan memiliki rasa yang lebih segar, ideal untuk ditumis atau dibuat sup.', 'images/kangkung.jpg', NULL, 'book_4cefef3f-30db-11f0-b74f-7cd30a82ec7f'),
(10, 'Pakcoy', 0, 'Sayuran', 'Pakcoy hidroponik merupakan pilihan sempurna untuk sayuran hijau dengan tekstur lembut dan kaya vitamin A serta C. Cocok untuk digunakan dalam berbagai hidangan, mulai dari sup, tumisan, hingga hidangan rebusan.', 'images/pakcoy.jpg', NULL, 'book_4ceff05c-30db-11f0-b74f-7cd30a82ec7f'),
(11, 'Sawi', 0, 'Sayuran', 'Sawi hidroponik memiliki daun hijau segar dengan rasa sedikit pahit yang kaya akan manfaat kesehatan. Ditanam dengan metode hidroponik modern, sayuran ini bebas dari zat kimia dan kaya akan serat serta antioksidan.', 'images/sawi.jpg', NULL, 'book_4ceff157-30db-11f0-b74f-7cd30a82ec7f'),
(12, 'Tomat', 0, 'Buah', 'Tomat hidroponik memiliki warna merah cerah dengan kandungan likopen tinggi yang baik untuk kesehatan jantung. Rasanya manis dan segar, cocok untuk salad, jus, atau sebagai tambahan dalam berbagai hidangan.', 'images/tomat.jpg', NULL, 'book_4ceff24f-30db-11f0-b74f-7cd30a82ec7f'),
(13, 'Cabe', 0, 'Buah', 'Cabe hidroponik ditanam dalam lingkungan yang optimal untuk menghasilkan buah dengan tingkat kepedasan yang stabil. Dengan warna merah menyala dan rasa pedas yang kuat, cabe ini cocok untuk masakan pedas favoritmu.', 'images/cabai.jpg', NULL, 'book_4ceff348-30db-11f0-b74f-7cd30a82ec7f'),
(14, 'Brokoli', 0, 'Sayuran', 'Brokoli hidroponik menawarkan kandungan antioksidan tinggi yang baik untuk kesehatan tubuh. Dengan tekstur renyah dan rasa khas, brokoli ini cocok untuk dikukus, ditumis, atau dijadikan bahan dalam makanan sehat.', 'images/brokoli.jpg', NULL, 'book_4ceff432-30db-11f0-b74f-7cd30a82ec7f'),
(15, 'Wortel', 0, 'Sayuran', 'Wortel hidroponik memiliki warna oranye cerah dan rasa manis alami. Sayuran ini kaya akan beta-karoten yang baik untuk kesehatan mata dan memiliki tekstur renyah, sempurna untuk dikonsumsi mentah atau dimasak.', 'images/wortel.jpg', NULL, 'book_4ceff79e-30db-11f0-b74f-7cd30a82ec7f'),
(16, 'Seledri', 0, 'Sayuran', 'Seledri hidroponik adalah tanaman yang kaya manfaat dengan aroma segar dan rasa sedikit pahit. Cocok untuk jus kesehatan atau sebagai pelengkap dalam berbagai hidangan berkuah.', 'images/seledri.jpg', NULL, 'book_4ceff89c-30db-11f0-b74f-7cd30a82ec7f'),
(17, 'Semangka', 0, 'Buah', 'Semangka hidroponik memiliki daging buah yang manis dan kaya air, menjadikannya pilihan sempurna untuk hidrasi alami. Tanaman ini bebas dari pestisida dan memiliki kualitas unggul dibandingkan semangka konvensional.', 'images/semangka.jpg', NULL, 'book_4ceff9a1-30db-11f0-b74f-7cd30a82ec7f'),
(18, 'Melon', 0, 'Buah', 'Melon hidroponik memiliki tekstur lembut dan rasa manis alami. Dipanen pada waktu yang tepat untuk kesegaran maksimal, melon ini cocok sebagai camilan sehat atau bahan dalam jus buah.', 'images/melon.jpg', NULL, 'book_4ceffa7f-30db-11f0-b74f-7cd30a82ec7f'),
(19, 'Stroberi', 0, 'Buah', 'Stroberi hidroponik merah cerah dan manis, kaya vitamin C dan antioksidan yang baik untuk kesehatan. Tanaman ini bebas dari pestisida dan memiliki rasa yang lebih alami dibandingkan stroberi biasa.', 'images/stoberi.jpg', NULL, 'book_27707e6b-30dc-11f0-b74f-7cd30a82ec7f'),
(20, 'Matahari', 0, 'Bunga', 'Bunga matahari hidroponik adalah pilihan dekorasi yang cerah dan penuh energi. Tanaman ini tumbuh dengan optimal dalam lingkungan hidroponik dan memiliki kelopak besar yang memancarkan keindahan.', 'images/matahari.jpg', NULL, 'book_4ceffc44-30db-11f0-b74f-7cd30a82ec7f'),
(21, 'Amarilys', 0, 'Bunga', 'Amarilis hidroponik adalah bunga yang mencolok dengan kelopak besar berwarna merah atau pink. Tanaman ini dikenal karena daya tahannya yang baik dan keindahannya saat mekar penuh.', 'images/amarylis.jpg', NULL, 'book_27702a81-30dc-11f0-b74f-7cd30a82ec7f'),
(22, 'Iris', 0, 'Bunga', 'Bunga iris hidroponik memiliki kelopak berwarna ungu, kuning, atau putih yang elegan dan berstruktur unik. Tumbuhan ini sering digunakan sebagai simbol kebijaksanaan dan harapan.', 'images/iris.jpg', NULL, 'book_4ceffe34-30db-11f0-b74f-7cd30a82ec7f'),
(23, 'Daffodils', 0, 'Bunga', 'Daffodils atau bunga bakung hidroponik terkenal dengan kelopak kuning cerahnya yang melambangkan awal musim semi dan harapan baru. Tanaman ini memiliki aroma lembut yang menyenangkan.', 'images/daffodils.jpg', NULL, 'book_4cefff27-30db-11f0-b74f-7cd30a82ec7f'),
(24, 'Freesia', 0, 'Bunga', 'Freesia hidroponik adalah bunga dengan aroma wangi yang kuat dan kelopak berwarna-warni. Cocok untuk dekorasi ruangan karena bentuknya yang indah dan warnanya yang menarik.', 'images/freesia.jpg', NULL, 'book_4cf0000e-30db-11f0-b74f-7cd30a82ec7f'),
(25, 'Anggrek', 0, 'Bunga', 'Anggrek hidroponik adalah bunga eksotis dengan berbagai warna dan bentuk unik. Tumbuhan ini dikenal karena daya tahannya yang baik dan keindahan kelopaknya yang elegan.', 'images/anggrek.jpg', NULL, 'book_4cf00108-30db-11f0-b74f-7cd30a82ec7f');

--
-- Triggers `crud_041_book`
--
DELIMITER $$
CREATE TRIGGER `before_insert_book` BEFORE INSERT ON `crud_041_book` FOR EACH ROW BEGIN
    -- Menghasilkan id_book dengan format book_[id_random]
    SET NEW.id_book = CONCAT('book_', UUID());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `crud_041_book_reviews`
--

CREATE TABLE `crud_041_book_reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `date` date NOT NULL,
  `book_id` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `crud_041_book_reviews`
--

INSERT INTO `crud_041_book_reviews` (`id`, `name`, `review`, `rating`, `date`, `book_id`, `username`, `password`) VALUES
(15, 'mutia', 'iniiiiiiiii enakkkk, fresh bgttt rasanyaaaa bakal repeat order sihh', 5, '2025-05-15', 'book_4cefa404-30db-11f0-b74f-7cd30a82ec7f', '', ''),
(16, 'naf', 'enaaaaaaaakk, melonnya manissss bgtttt', 5, '2025-05-01', 'book_4ceffa7f-30db-11f0-b74f-7cd30a82ec7f', '', ''),
(17, 'yayaa', 'bunganya kurang baguss, mungkin karena terlalu lama pengiriman', 3, '2025-05-15', 'book_4cf0000e-30db-11f0-b74f-7cd30a82ec7f', '', ''),
(18, 'Mutia', 'huuuuuuu wangiiiiii, ndi tolongin ndi', 5, '2025-05-15', 'book_4cefff27-30db-11f0-b74f-7cd30a82ec7f', '', ''),
(19, 'indi', 'kangkungnya enaaaakk crispyyyyy mantap', 5, '2025-05-23', 'book_4cefef3f-30db-11f0-b74f-7cd30a82ec7f', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','seller') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'azizah', 'indri', 'azizahindri26@gmail.com', '$2y$10$fZMSNGvAltHZITsDnqYBcuS6wyfIcpg8Tk6Kp8wvDyH2pc8yAgQ0m', 'user'),
(2, 'Syazwani', '2', 'syazwani@gmail.com', '$2y$10$Uir2HE1AskCVkpAQT9H7ueZLc54pky3G6OtJoMg9jGYfTt92IpT2m', 'user'),
(3, 'alysa', 'meliana', 'alysameliana@gmail.com', '$2y$10$rucUFkDVGalZmZECTwjT7.QqA8N2Dzh2ZwiEXfz3Buauf0lueJK5i', 'user'),
(4, 'mutia', 'cantik', 'mutiacantik@gmail.com', '$2y$10$1vvbrGcHhfg/cprREAY0nuDNiYuajCeVONRtgmyapFbL8k885TOg6', 'user'),
(6, 'admin', '1', 'admin1@gmail.com', '$2y$10$Qh6RBUx3X8iFLPlRT5.CkuadVErI7G3CIFjnOfwV0QAUySLLpSy5e', 'admin'),
(8, 'seller', '1', 'seller1@gmail.com', '$2y$10$XhoURHQEikgiNm5BwHZL6uni4FdrzPB/4EQToSEryT9YjMHEOCpIu', 'seller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crud_041_book`
--
ALTER TABLE `crud_041_book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_book` (`id_book`);

--
-- Indexes for table `crud_041_book_reviews`
--
ALTER TABLE `crud_041_book_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crud_041_book`
--
ALTER TABLE `crud_041_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `crud_041_book_reviews`
--
ALTER TABLE `crud_041_book_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crud_041_book_reviews`
--
ALTER TABLE `crud_041_book_reviews`
  ADD CONSTRAINT `fk_book_id` FOREIGN KEY (`book_id`) REFERENCES `crud_041_book` (`id_book`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
