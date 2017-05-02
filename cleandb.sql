-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2017 at 08:05 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `awasdb`
--
CREATE DATABASE IF NOT EXISTS `awasdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `awasdb`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `message` varchar(255) NOT NULL,
  `post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `author`, `date`, `message`, `post`) VALUES
(1, 2, '2017-04-07 23:00:12', 'Lorem Ipsum comment', 1),
(2, 2, '2017-04-03 04:00:12', 'What is this, I don\'t know!', 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `postid` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(20000) NOT NULL,
  `date` datetime NOT NULL,
  `topic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `author`, `subject`, `message`, `date`, `topic`) VALUES
(1, 1, 'Lorem Ipsum', 'PHA+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNlY3RldHVyIGFkaXBpc2NpbmcgZWxpdC4gUGhhc2VsbHVzIHF1aXMgbWV0dXMgZXN0LiBTdXNwZW5kaXNzZSBhIGx1Y3R1cyB2ZWxpdC4gTWF1cmlzIGF0IGJsYW5kaXQgbGliZXJvLCB2ZWwgdGVtcG9yIGR1aS4gRnVzY2UgbGFjdXMgZGlhbSwgbGFjaW5pYSB2aXRhZSBtYXR0aXMgc2l0IGFtZXQsIGVsZW1lbnR1bSB2aXRhZSBhdWd1ZS4gTWFlY2VuYXMgbGFjaW5pYSBhcmN1IGVuaW0sIHF1aXMgcHJldGl1bSBsb3JlbSBwb3J0YSBldS4gUHJvaW4gZmF1Y2lidXMgZXJhdCBlZ2V0IGZlbGlzIGZpbmlidXMsIHZlaGljdWxhIGF1Y3RvciBwdXJ1cyBzYWdpdHRpcy4gTnVsbGEgdml0YWUgbWFzc2EgdmVsaXQuIFByYWVzZW50IHRlbGx1cyBuaWJoLCBpbXBlcmRpZXQgc2VkIGFsaXF1ZXQgaW4sIGZhY2lsaXNpcyBhdCBleC4gTnVuYyBncmF2aWRhIHZlaGljdWxhIG1pIHZlbCBjb25zZXF1YXQuPC9wPg0KPHA+RG9uZWMgcXVpcyB0ZWxsdXMgbW9sbGlzLCBwb3J0YSBlc3QgcXVpcywgZmF1Y2lidXMgb3JjaS4gVmVzdGlidWx1bSBkdWkgbmVxdWUsIGlhY3VsaXMgaW4gbWFzc2EgZWdldCwgYmliZW5kdW0gdmFyaXVzIGxlY3R1cy4gUHJvaW4gcGxhY2VyYXQgdml0YWUgZXN0IHZpdGFlIHZ1bHB1dGF0ZS4gUGhhc2VsbHVzIGxvYm9ydGlzIGp1c3RvIHNlZCBsaWJlcm8gZGljdHVtIGJpYmVuZHVtLiBWaXZhbXVzIGV0IGNvbnNlcXVhdCBmZWxpcy4gTnVsbGEgb3JuYXJlIHJpc3VzIHNpdCBhbWV0IG5lcXVlIGJpYmVuZHVtLCBzaXQgYW1ldCBtYWxlc3VhZGEgZXN0IHVsdHJpY2llcy4gVmVzdGlidWx1bSBmZXVnaWF0LCBsaWJlcm8gbm9uIGJpYmVuZHVtIGlhY3VsaXMsIG5lcXVlIGRpYW0gZmluaWJ1cyBlbmltLCBpbiBjb25ndWUgbGlndWxhIGVyYXQgYSBuaXNpLiBQcm9pbiBlZ2V0IHNhZ2l0dGlzIGp1c3RvLCB2ZWwgZWxlaWZlbmQgZG9sb3IuIERvbmVjIHF1aXMgbmlzbCBxdWlzIGxpYmVybyBjb252YWxsaXMgdGVtcG9yLiBBZW5lYW4gbmVjIGp1c3RvIHBvc3VlcmUsIHJ1dHJ1bSBudW5jIGFjLCBjdXJzdXMgbnVuYy4gRnVzY2UgY29tbW9kbyBvcm5hcmUgbG9ib3J0aXMuIE5hbSB2YXJpdXMgdWx0cmljZXMgaGVuZHJlcml0LiBWaXZhbXVzIHNpdCBhbWV0IG1hdXJpcyBpZCBkb2xvciBjb21tb2RvIG1vbGVzdGllIGluIHNpdCBhbWV0IGxpZ3VsYS48L3A+', '2017-04-06 22:42:12', 1),
(2, 1, 'Will robots displace humans as motorised vehicles ousted horses?', 'PHA+SU4gVEhFIGVhcmx5IDIwdGggY2VudHVyeSB0aGUgZnV0dXJlIHNlZW1lZCBicmlnaHQgZm9yIGhvcnNlIGVtcGxveW1lbnQuIFdpdGhpbiA1MCB5ZWFycyBjYXJzIGFuZCB0cmFjdG9ycyBtYWRlIHNob3J0IHdvcmsgb2YgZXF1aW5lIGxpdmVsaWhvb2RzLiBTb21lIGZ1dHVyaXN0cyBzZWUgYSBjYXV0aW9uYXJ5IHRhbGUgZm9yIGh1bWFuaXR5IGluIHRoZSBmYXRlIG9mIHRoZSBob3JzZTogaXQgd2FzIGVjb25vbWljYWxseSBpbmRpc3BlbnNhYmxlIHVudGlsIGl0IHdhc27igJl0LiBUaGUgY29tbW9uIHJldG9ydCB0byBzdWNoIGNvbmNlcm5zIGlzIHRoYXQgaHVtYW5zIGFyZSBmYXIgbW9yZSBjb2duaXRpdmVseSBhZGFwdGFibGUgdGhhbiBiZWFzdHMgb2YgYnVyZGVuLiBZZXQgYXMgcm9ib3RzIGdyb3cgbW9yZSBuaW1ibGUsIGh1bWFucyBsb29rIGluY3JlYXNpbmdseSB2dWxuZXJhYmxlLiBBIG5ldyB3b3JraW5nIHBhcGVyIGNvbmNsdWRlcyB0aGF0LCBiZXR3ZWVuIDE5OTAgYW5kIDIwMDcsIGVhY2ggaW5kdXN0cmlhbCByb2JvdCBhZGRlZCBwZXIgdGhvdXNhbmQgd29ya2VycyByZWR1Y2VkIGVtcGxveW1lbnQgaW4gQW1lcmljYSBieSBuZWFybHkgc2l4IHdvcmtlcnMuIEh1bWFuaXR5IG1heSBub3QgYmUgc2VudCBvdXQgdG8gcGFzdHVyZSwgYnV0IHRoZSBwYXJhbGxlbCB3aXRoIGhvcnNlcyBpcyBzdGlsbCB1bmNvbWZvcnRhYmx5IGNsb3NlLjwvcD4NCjxwPlJvYm90cyBhcmUganVzdCBvbmUgc21hbGwgcGFydCBvZiB0aGUgdGVjaG5vbG9naWNhbCB3YXZlIHNxdWVlemluZyBwZW9wbGUuIFRoZSBJbnRlcm5hdGlvbmFsIEZlZGVyYXRpb24gb2YgUm9ib3RpY3MgZGVmaW5lcyBpbmR1c3RyaWFsIHJvYm90cyBhcyBtYWNoaW5lcyB0aGF0IGFyZSBhdXRvbWF0aWNhbGx5IGNvbnRyb2xsZWQgYW5kIHJlLXByb2dyYW1tYWJsZTsgc2luZ2xlLXB1cnBvc2UgZXF1aXBtZW50IGRvZXMgbm90IGNvdW50LiBUaGUgd29ybGR3aWRlIHBvcHVsYXRpb24gb2Ygc3VjaCBjcmVhdHVyZXMgaXMgYmVsb3cgMm07IEFtZXJpY2EgaGFzIHNsaWdodGx5IGZld2VyIHRoYW4gdHdvIHJvYm90cyBwZXIgMSwwMDAgd29ya2VycyAoRXVyb3BlIGhhcyBhIGJpdCBtb3JlIHRoYW4gdHdvKS4gQnV0IHRoZWlyIG51bWJlcnMgYXJlIGdyb3dpbmcsIGFzIGlzIHRoZSByYW5nZSBvZiB0YXNrcyB0aGV5IGNhbiB0YWNrbGUsIHNvIGZpbmRpbmdzIG9mIHJvYm90LWRyaXZlbiBqb2IgbG9zcyBhcmUgd29ydGggdGFraW5nIHNlcmlvdXNseS48L3A+', '2017-04-06 16:15:22', 2);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`) VALUES
(1, 'Politics'),
(2, 'Economics');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `type`) VALUES
(1, 'admin', 'b03a894e101746d09277f1f255cc8a40', 'admin@localhost', 2),
(2, 'user', '9f27410725ab8cc8854a2769c7a516b8', 'user@localhost', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
