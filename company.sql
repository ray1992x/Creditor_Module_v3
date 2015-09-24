-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2015 at 10:32 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `company`
--

-- --------------------------------------------------------

--
-- Table structure for table `batchheader`
--

CREATE TABLE IF NOT EXISTS `batchheader` (
`id` int(10) NOT NULL,
  `BatchType` varchar(15) NOT NULL,
  `BatchNumber` varchar(11) NOT NULL,
  `BatchDate` varchar(25) NOT NULL,
  `BatchPeriod` decimal(65,0) NOT NULL,
  `BatchTotal` decimal(65,0) NOT NULL,
  `CheckTotal` decimal(65,0) NOT NULL,
  `Difference` int(10) unsigned NOT NULL,
  `TransactionCount` decimal(65,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batchheader`
--

INSERT INTO `batchheader` (`id`, `BatchType`, `BatchNumber`, `BatchDate`, `BatchPeriod`, `BatchTotal`, `CheckTotal`, `Difference`, `TransactionCount`) VALUES
(5, 'Invoice', 'IB201505001', '2015-05-01', '12', '20000', '0', 0, '20'),
(6, 'Auto Payment', 'AB201505001', '2015-05-26', '7', '12200', '1', 12200, '1'),
(7, 'Invoice', 'IB201505002', '2015-05-28', '10', '9000', '1', 0, '2'),
(8, 'Auto Payment', 'AB201505002', '2015-05-27', '10', '4500', '1', 4500, '1'),
(9, 'Credit Note', 'CB201505002', '2015-05-01', '7', '1000', '0', 1000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cndetailtable`
--

CREATE TABLE IF NOT EXISTS `cndetailtable` (
`id` int(10) NOT NULL,
  `CNnumber` varchar(10) NOT NULL,
  `ReferenceNumber` varchar(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `Narrative` decimal(65,0) NOT NULL,
  `Amount` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `creditctrltable`
--

CREATE TABLE IF NOT EXISTS `creditctrltable` (
`id` int(10) NOT NULL,
  `interfacetoGL` varchar(50) NOT NULL,
  `balance` decimal(65,0) NOT NULL,
  `period` varchar(25) NOT NULL,
  `batchentry` varchar(50) NOT NULL,
  `creditGLcode` int(15) NOT NULL,
  `bankGLcode` int(15) NOT NULL,
  `bankcode` varchar(50) NOT NULL,
  `amount` decimal(65,0) NOT NULL,
  `POprinting` varchar(15) NOT NULL,
  `POtype` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `creditnote`
--

CREATE TABLE IF NOT EXISTS `creditnote` (
`id` int(15) NOT NULL,
  `CNnumber` varchar(10) NOT NULL,
  `BatchNumber` varchar(10) NOT NULL,
  `SequenceNumber` int(10) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL,
  `CreditNoteAmount` int(15) NOT NULL,
  `CreditNoteDate` date NOT NULL,
  `CreditNoteDesc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `creditor`
--

CREATE TABLE IF NOT EXISTS `creditor` (
  `CreditorCode` varchar(10) NOT NULL,
  `CreditorName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `creditormaster`
--

CREATE TABLE IF NOT EXISTS `creditormaster` (
`id` int(15) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL,
  `CreditorName` varchar(12) NOT NULL,
  `CreditorType` varchar(12) NOT NULL,
  `ShortName` varchar(10) NOT NULL,
  `CompanyNumber` varchar(10) NOT NULL,
  `CreditPeriod` int(15) NOT NULL,
  `Remark` varchar(20) NOT NULL,
  `PaymentYTD` int(20) NOT NULL,
  `LastPaymentDate` date NOT NULL,
  `InvoiceYTD` int(20) NOT NULL,
  `LastInvoiceDate` date NOT NULL,
  `CreditorBalance` int(20) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `ContactName` varchar(12) NOT NULL,
  `Telephone1` int(12) NOT NULL,
  `Fax` int(12) NOT NULL,
  `Telephone2` int(12) NOT NULL,
  `Email` varchar(12) NOT NULL,
  `StartActiveDate` date NOT NULL,
  `LastOnHoldDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `credittypetable`
--

CREATE TABLE IF NOT EXISTS `credittypetable` (
`id` int(10) NOT NULL,
  `CRtype` varchar(12) NOT NULL,
  `CRdesc` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credittypetable`
--

INSERT INTO `credittypetable` (`id`, `CRtype`, `CRdesc`) VALUES
(1, 'Secured', 'secured');

-- --------------------------------------------------------

--
-- Table structure for table `docctrlnumtable`
--

CREATE TABLE IF NOT EXISTS `docctrlnumtable` (
`id` int(10) NOT NULL,
  `doctype` varchar(50) NOT NULL,
  `docprefix` varchar(5) NOT NULL,
  `docnum` int(50) NOT NULL,
  `docyear` int(2) NOT NULL,
  `docdesc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
`id` int(10) NOT NULL,
  `InvNumber` varchar(10) NOT NULL,
  `BatchNumber` varchar(11) NOT NULL,
  `SequenceNumber` int(100) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL,
  `InvoiceDescription` varchar(50) NOT NULL,
  `InvoiceTotal` int(15) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `DatePaymentDue` date NOT NULL,
  `PONumber` varchar(10) NOT NULL,
  `POType` varchar(25) NOT NULL,
  `BatchValue` int(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `InvNumber`, `BatchNumber`, `SequenceNumber`, `CreditorCode`, `InvoiceDescription`, `InvoiceTotal`, `InvoiceDate`, `DatePaymentDue`, `PONumber`, `POType`, `BatchValue`) VALUES
(2, 'I001', 'IB201505001', 1, 'C001', 'Furniture', 12200, '2015-03-05', '2015-03-09', 'P001', 'PSO', 77050),
(3, 'I002', 'IB201505001', 2, 'C002', 'Computers', 29100, '2015-03-10', '2015-03-14', 'P002', 'PSO', 77050),
(4, 'I003', 'IB201505001', 3, 'C003', 'Books', 6350, '2015-04-06', '2015-04-11', 'P003', 'PSO', 77050),
(5, 'C004', 'IB201505001', 4, 'C004', 'Machinery', 29400, '2015-05-01', '2015-05-10', 'P004', 'PSO', 77050),
(7, 'I006', 'IB201505002', 1, 'C006', 'Material', 4500, '2015-05-27', '2015-06-02', 'P006', 'PSO', 9000);

-- --------------------------------------------------------

--
-- Table structure for table `ivdetailtable`
--

CREATE TABLE IF NOT EXISTS `ivdetailtable` (
`id` int(10) NOT NULL,
  `InvNumber` varchar(10) NOT NULL,
  `PONumber` varchar(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `UOM` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` int(11) NOT NULL,
  `ItemPrice` int(11) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ivdetailtable`
--

INSERT INTO `ivdetailtable` (`id`, `InvNumber`, `PONumber`, `itemid`, `Description`, `UOM`, `Quantity`, `UnitPrice`, `ItemPrice`, `CreditorCode`) VALUES
(10, 'I001', 'P001', 1, 'Chairs', 0, 160, 20, 3200, 'C001'),
(11, 'I001', 'P001', 2, 'Table', 0, 40, 100, 4000, 'C001'),
(12, 'I001', 'P001', 3, 'Bookshelves', 0, 20, 250, 5000, 'C001'),
(14, 'I002', 'P002', 1, 'CPU', 0, 20, 1000, 20000, 'C002'),
(15, 'I002', 'P002', 2, 'Monitor', 0, 20, 400, 8000, 'C002'),
(16, 'I002', 'P002', 3, 'Mouse', 0, 20, 15, 300, 'C002'),
(17, 'I002', 'P002', 4, 'Keyboard', 0, 20, 20, 400, 'C002'),
(18, 'I002', 'P002', 5, 'Ethernet Cable', 0, 1, 100, 100, 'C002'),
(19, 'I002', 'P002', 6, 'Pad Lock', 0, 20, 15, 300, 'C002'),
(22, 'I003', 'P003', 1, 'Book 1', 0, 10, 150, 1500, 'C003'),
(23, 'I003', 'P003', 2, 'Book 2', 0, 20, 30, 600, 'C003'),
(24, 'I003', 'P003', 3, 'Book 3', 0, 15, 60, 900, 'C003'),
(25, 'I003', 'P003', 4, 'Book 4', 0, 5, 70, 350, 'C003'),
(26, 'I003', 'P003', 5, 'Book 5', 0, 30, 100, 3000, 'C003'),
(30, 'C004', 'P004', 1, 'Printer', 0, 3, 2700, 8100, 'C004'),
(31, 'C004', 'P004', 2, 'Fax Machine', 0, 2, 650, 1300, 'C004'),
(32, 'C004', 'P004', 3, 'Air Conditioner', 0, 2, 10000, 20000, 'C004'),
(33, '', 'P001', 1, 'Chairs', 0, 160, 20, 3200, 'C001'),
(34, '', 'P001', 2, 'Table', 0, 40, 100, 4000, ''),
(35, '', 'P001', 3, 'Bookshelves', 0, 20, 250, 5000, ''),
(36, '', 'P002', 1, 'CPU', 0, 20, 1000, 20000, 'C002'),
(37, '', 'P002', 2, 'Monitor', 0, 20, 400, 8000, ''),
(38, '', 'P002', 3, 'Mouse', 0, 20, 15, 300, ''),
(39, '', 'P002', 4, 'Keyboard', 0, 20, 20, 400, ''),
(40, '', 'P002', 5, 'Ethernet Cable', 0, 1, 100, 100, ''),
(41, '', 'P002', 6, 'Pad Lock', 0, 20, 15, 300, ''),
(42, '', 'P003', 1, 'Book 1', 0, 10, 150, 1500, 'C003'),
(43, '', 'P003', 2, 'Book 2', 0, 20, 30, 600, ''),
(44, '', 'P003', 3, 'Book 3', 0, 15, 60, 900, ''),
(45, '', 'P003', 4, 'Book 4', 0, 5, 70, 350, ''),
(46, '', 'P003', 5, 'Book 5', 0, 30, 100, 3000, ''),
(47, '', 'P004', 1, 'Printer', 0, 3, 2700, 8100, 'C004'),
(48, '', 'P004', 2, 'Fax Machine', 0, 2, 650, 1300, ''),
(49, '', 'P004', 3, 'Air Conditioner', 0, 2, 10000, 20000, ''),
(64, 'I006', 'P006', 1, 'Pipe', 0, 30, 100, 3000, 'C006'),
(65, 'I006', 'P006', 2, 'Screw', 0, 100, 15, 1500, '');

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
`id` int(10) NOT NULL,
  `JournalNo` varchar(11) NOT NULL,
  `JournalDate` date NOT NULL,
  `JournalAmount` int(20) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL,
  `JournalRef` varchar(10) NOT NULL,
  `TransType` varchar(10) NOT NULL,
  `RefAmount` int(10) NOT NULL,
  `BatchNo` varchar(10) NOT NULL,
  `SequenceNo` int(10) NOT NULL,
  `BatchAmount` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`id`, `JournalNo`, `JournalDate`, `JournalAmount`, `CreditorCode`, `JournalRef`, `TransType`, `RefAmount`, `BatchNo`, `SequenceNo`, `BatchAmount`) VALUES
(6, 'J201505001', '2015-05-09', 6350, 'C003', 'I003', 'Invoice', 6350, 'JB20150500', 1, 6350);

-- --------------------------------------------------------

--
-- Table structure for table `j_invoice_details`
--

CREATE TABLE IF NOT EXISTS `j_invoice_details` (
`id` int(10) NOT NULL,
  `InvNumber` varchar(15) NOT NULL,
  `BatchNumber` varchar(11) NOT NULL,
  `SequenceNumber` int(100) NOT NULL,
  `CreditorCode` varchar(11) NOT NULL,
  `InvoiceDescription` varchar(50) NOT NULL,
  `InvoiceTotal` int(15) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `DatePaymentDue` date NOT NULL,
  `PONumber` varchar(10) NOT NULL,
  `POType` varchar(25) NOT NULL,
  `BatchValue` int(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `j_invoice_details`
--

INSERT INTO `j_invoice_details` (`id`, `InvNumber`, `BatchNumber`, `SequenceNumber`, `CreditorCode`, `InvoiceDescription`, `InvoiceTotal`, `InvoiceDate`, `DatePaymentDue`, `PONumber`, `POType`, `BatchValue`) VALUES
(4, 'I003', 'IB201505001', 3, 'C003', 'Books', 6350, '2015-04-06', '2015-04-11', 'P003', 'PSO', 77050);

-- --------------------------------------------------------

--
-- Table structure for table `j_invoice_info_details`
--

CREATE TABLE IF NOT EXISTS `j_invoice_info_details` (
`id` int(10) NOT NULL,
  `InvNumber` varchar(15) NOT NULL,
  `PONumber` varchar(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `Description` varchar(15) NOT NULL,
  `UOM` decimal(65,0) NOT NULL,
  `Quantity` decimal(65,0) NOT NULL,
  `UnitPrice` decimal(65,0) NOT NULL,
  `ItemPrice` decimal(65,0) NOT NULL,
  `CreditorCode` varchar(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `j_invoice_info_details`
--

INSERT INTO `j_invoice_info_details` (`id`, `InvNumber`, `PONumber`, `itemid`, `Description`, `UOM`, `Quantity`, `UnitPrice`, `ItemPrice`, `CreditorCode`) VALUES
(22, 'I003', 'P003', 1, 'Book 1', '0', '10', '150', '1500', 'C003'),
(23, 'I003', 'P003', 2, 'Book 2', '0', '20', '30', '600', 'C003'),
(24, 'I003', 'P003', 3, 'Book 3', '0', '15', '60', '900', 'C003'),
(25, 'I003', 'P003', 4, 'Book 4', '0', '5', '70', '350', 'C003'),
(26, 'I003', 'P003', 5, 'Book 5', '0', '30', '100', '3000', 'C003');

-- --------------------------------------------------------

--
-- Table structure for table `paydetailtable`
--

CREATE TABLE IF NOT EXISTS `paydetailtable` (
`id` int(10) NOT NULL,
  `CRCode` varchar(10) NOT NULL,
  `No` int(15) NOT NULL,
  `date` date NOT NULL,
  `period` int(15) NOT NULL,
  `invoice_no` varchar(10) NOT NULL,
  `po_number` varchar(10) NOT NULL,
  `invoice_amount` decimal(65,0) NOT NULL,
  `paid_period` varchar(25) NOT NULL,
  `payment_amount` decimal(65,0) NOT NULL,
  `ChequeNo` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paydetailtable`
--

INSERT INTO `paydetailtable` (`id`, `CRCode`, `No`, `date`, `period`, `invoice_no`, `po_number`, `invoice_amount`, `paid_period`, `payment_amount`, `ChequeNo`) VALUES
(2, 'C001', 0, '2015-03-05', 2147483647, 'I001', 'P001', '12200', '12200', '12200', '1234'),
(3, 'C002', 0, '2015-03-10', 2147483647, 'I002', 'P002', '29100', '', '29100', ''),
(4, 'C003', 0, '2015-04-06', 2147483647, 'I003', 'P003', '6350', '', '6350', ''),
(5, 'C004', 0, '2015-05-01', 2147483647, 'C004', 'P004', '29400', '', '29400', ''),
(6, 'C001', 0, '2015-03-05', 2147483647, 'I001', 'P001', '12200', '', '12200', ''),
(7, 'C002', 0, '2015-03-10', 2147483647, 'I002', 'P002', '29100', '', '29100', ''),
(8, 'C003', 0, '2015-04-06', 2147483647, 'I003', 'P003', '6350', '', '6350', ''),
(9, 'C004', 0, '2015-05-01', 2147483647, 'C004', 'P004', '29400', '', '29400', ''),
(10, 'C006', 0, '2015-05-27', 2147483647, 'I006', 'P006', '4500', '4500', '4500', '12342');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
`id` int(10) NOT NULL,
  `PaymentType` varchar(25) NOT NULL,
  `BankCode` varchar(25) NOT NULL,
  `CreditorCode` varchar(15) NOT NULL,
  `ChequeNumber` varchar(20) NOT NULL,
  `PaymentNo` decimal(65,0) NOT NULL,
  `PaymentAmount` int(10) NOT NULL,
  `DatePaid` date NOT NULL,
  `BatchNumber` varchar(15) NOT NULL,
  `SequenceNumber` int(15) NOT NULL,
  `BatchValue` decimal(65,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `PaymentType`, `BankCode`, `CreditorCode`, `ChequeNumber`, `PaymentNo`, `PaymentAmount`, `DatePaid`, `BatchNumber`, `SequenceNumber`, `BatchValue`) VALUES
(8, 'Auto', 'RHB9001', 'C001', '1234', '0', 12200, '2015-05-28', 'AB201505001', 1, '12200'),
(10, 'Auto', 'RHB9001', 'C006', '12342', '0', 4500, '2015-05-29', 'AB201505002', 1, '4500');

-- --------------------------------------------------------

--
-- Table structure for table `podetailtable`
--

CREATE TABLE IF NOT EXISTS `podetailtable` (
`id` int(11) NOT NULL,
  `POtemp` varchar(10) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `itemid` int(15) NOT NULL,
  `booktitle` varchar(25) NOT NULL,
  `author` varchar(15) NOT NULL,
  `price` varchar(15) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `podetailtable`
--

INSERT INTO `podetailtable` (`id`, `POtemp`, `Description`, `itemid`, `booktitle`, `author`, `price`, `CreditorCode`) VALUES
(1, 'P001', 'Chairs', 1, '160', '20', '3200', 'C001'),
(2, 'P001', 'Table', 2, '40', '100', '4000', ''),
(3, 'P001', 'Bookshelves', 3, '20', '250', '5000', ''),
(4, 'P002', 'CPU', 1, '20', '1000', '20000', 'C002'),
(5, 'P002', 'Monitor', 2, '20', '400', '8000', ''),
(6, 'P002', 'Mouse', 3, '20', '15', '300', ''),
(7, 'P002', 'Keyboard', 4, '20', '20', '400', ''),
(8, 'P002', 'Ethernet Cable', 5, '1', '100', '100', ''),
(9, 'P002', 'Pad Lock', 6, '20', '15', '300', ''),
(10, 'P003', 'Book 1', 1, '10', '150', '1500', 'C003'),
(11, 'P003', 'Book 2', 2, '20', '30', '600', ''),
(12, 'P003', 'Book 3', 3, '15', '60', '900', ''),
(13, 'P003', 'Book 4', 4, '5', '70', '350', ''),
(14, 'P003', 'Book 5', 5, '30', '100', '3000', ''),
(15, 'P004', 'Printer', 1, '3', '2700', '8100', 'C004'),
(16, 'P004', 'Fax Machine', 2, '2', '650', '1300', ''),
(17, 'P004', 'Air Conditioner', 3, '2', '10000', '20000', ''),
(18, 'P006', 'Pipe', 1, '30', '100', '3000', 'C006'),
(19, 'P006', 'Screw', 2, '100', '15', '1500', '');

-- --------------------------------------------------------

--
-- Table structure for table `potypetable`
--

CREATE TABLE IF NOT EXISTS `potypetable` (
`id` int(10) NOT NULL,
  `POtype` varchar(5) NOT NULL,
  `POdesc` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `potypetable`
--

INSERT INTO `potypetable` (`id`, `POtype`, `POdesc`) VALUES
(1, 'PSO', 'Purchase Service Order'),
(2, 'MSO', 'Maintenance Service Order'),
(3, 'LPO', 'Local Purchase Order');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
`Id` int(11) NOT NULL,
  `CreditorCode` varchar(10) NOT NULL,
  `POtemp` varchar(10) NOT NULL,
  `PODate` date NOT NULL,
  `POType` varchar(5) NOT NULL,
  `POAmount` int(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`Id`, `CreditorCode`, `POtemp`, `PODate`, `POType`, `POAmount`) VALUES
(1, 'C001', 'P001', '2015-03-02', 'PSO', 12200),
(2, 'C002', 'P002', '2015-03-05', 'PSO', 29100),
(3, 'C003', 'P003', '2015-04-02', 'PSO', 6350),
(4, 'C004', 'P004', '2015-05-01', 'PSO', 29400),
(5, 'C006', 'P006', '2015-05-26', 'PSO', 4500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batchheader`
--
ALTER TABLE `batchheader`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cndetailtable`
--
ALTER TABLE `cndetailtable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creditctrltable`
--
ALTER TABLE `creditctrltable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creditnote`
--
ALTER TABLE `creditnote`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creditormaster`
--
ALTER TABLE `creditormaster`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credittypetable`
--
ALTER TABLE `credittypetable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docctrlnumtable`
--
ALTER TABLE `docctrlnumtable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ivdetailtable`
--
ALTER TABLE `ivdetailtable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `j_invoice_details`
--
ALTER TABLE `j_invoice_details`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `InvNumber` (`InvNumber`);

--
-- Indexes for table `j_invoice_info_details`
--
ALTER TABLE `j_invoice_info_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paydetailtable`
--
ALTER TABLE `paydetailtable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `podetailtable`
--
ALTER TABLE `podetailtable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `potypetable`
--
ALTER TABLE `potypetable`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
 ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batchheader`
--
ALTER TABLE `batchheader`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cndetailtable`
--
ALTER TABLE `cndetailtable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `creditctrltable`
--
ALTER TABLE `creditctrltable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `creditnote`
--
ALTER TABLE `creditnote`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `creditormaster`
--
ALTER TABLE `creditormaster`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `credittypetable`
--
ALTER TABLE `credittypetable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `docctrlnumtable`
--
ALTER TABLE `docctrlnumtable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ivdetailtable`
--
ALTER TABLE `ivdetailtable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `j_invoice_details`
--
ALTER TABLE `j_invoice_details`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `j_invoice_info_details`
--
ALTER TABLE `j_invoice_info_details`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `paydetailtable`
--
ALTER TABLE `paydetailtable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `podetailtable`
--
ALTER TABLE `podetailtable`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `potypetable`
--
ALTER TABLE `potypetable`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
