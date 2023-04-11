-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 08:17 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `purdcs_payroll`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`wbsmconfed`@`localhost` FUNCTION `f_getclosing` (`adt_dt` DATE, `ad_acc_cd` INT(10)) RETURNS DECIMAL(10,2) NO SQL
BEGIN
    DECLARE	ld_cls_bal  	decimal(10,2);
    DECLARE	ls_acc_flag		varchar(5);
    DECLARE ldt_max_dt		date;
  
    SET ld_cls_bal = 0;
   
           Select max(balance_dt)
           into   ldt_max_dt
           From   tm_account_balance
           where  acc_code  = ad_acc_cd
           and    balance_dt <= adt_dt;
           
           Select IFNULL(balance_amt,0)
           Into   ld_cls_bal
           From   tm_account_balance
           Where  balance_dt = ldt_max_dt
           And    acc_code   = ad_acc_cd;
       
     
    return ld_cls_bal;
    
END$$

CREATE DEFINER=`wbsmconfed`@`localhost` FUNCTION `f_getopening` (`adt_dt` DATE, `ad_acc_cd` INT(10)) RETURNS DECIMAL(10,2) NO SQL
BEGIN
    DECLARE	ld_opn_bal  	decimal(10,2);
    
    DECLARE ldt_max_dt		date;
     
    
    SET ld_opn_bal = 0;
      
           Select max(balance_dt)
           into   ldt_max_dt
           From   tm_account_balance
           where  acc_code  = ad_acc_cd
           and    balance_dt < adt_dt;
           
           Select IFNULL(balance_amt,0)
           Into   ld_opn_bal
           From   tm_account_balance
           Where  balance_dt = ldt_max_dt
           And    acc_code   = ad_acc_cd;
        	
        
            
            
  
     
    return ld_opn_bal;
    
END$$

CREATE DEFINER=`wbsmconfed`@`localhost` FUNCTION `f_getparamval` (`ad_sl_no` INT) RETURNS VARCHAR(100) CHARSET latin1 NO SQL
BEGIN

	DECLARE ls_param_val varchar(100);

	select param_value
    into   ls_param_val
    from   md_parameters
    where  sl_no = ad_sl_no;
 
 RETURN (ls_param_val);
END$$

CREATE DEFINER=`wbsmconfed`@`localhost` FUNCTION `f_get_first_day` (`adt_dt` DATE) RETURNS DATE NO SQL
BEGIN
DECLARE ldt_dt   date;
DECLARE ld_month decimal(10);
DECLARE ld_year  decimal(10);

select month(adt_dt)
into   ld_month
from   dual;

select year(adt_dt)
into   ld_year
from   dual;

if ld_month >= 4 and ld_month <= 12 THEN
	
    SET ldt_dt = concat(ld_year,'-04-01');
ELSE
	SET ld_year = (ld_year - 1); 
    SET ldt_dt = concat(ld_year,'-04-01');
    
end if;
   
 
return ldt_dt;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `md_basic_pay`
--

CREATE TABLE `md_basic_pay` (
  `effective_dt` date NOT NULL,
  `emp_cd` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `band_pay` decimal(10,2) NOT NULL,
  `grade_pay` decimal(10,2) NOT NULL,
  `ir_amt` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `md_basic_pay`
--
DELIMITER $$
CREATE TRIGGER `ai_salary_increment` AFTER INSERT ON `md_basic_pay` FOR EACH ROW BEGIN

		UPDATE md_employee SET
                band_pay	=	NEW.band_pay,
                grade_pay	=	NEW.grade_pay,
                ir_pay		=	NEW.ir_amt
            
                WHERE emp_code	=	NEW.emp_cd;
     
     
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `md_branch`
--

CREATE TABLE `md_branch` (
  `id` int(10) NOT NULL COMMENT 'Here id is Disctrict Code',
  `branch_name` varchar(100) NOT NULL,
  `districts_catered` varchar(255) NOT NULL,
  `ho_flag` enum('N','Y') NOT NULL,
  `br_manager` varchar(50) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_dt` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_by` varchar(50) NOT NULL,
  `modified_dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_branch`
--

INSERT INTO `md_branch` (`id`, `branch_name`, `districts_catered`, `ho_flag`, `br_manager`, `contact_no`, `created_by`, `created_dt`, `modified_by`, `modified_dt`) VALUES
(327, 'Siliguri', '327', 'N', 'MRIDUL MONDAL', '9674746945', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(328, 'Jalpaiguri', '328', 'N', 'MRIDUL MONDAL', '9674746945', '', '2019-10-21 14:24:24', '', '2019-10-21 14:24:24'),
(329, 'Cooch Behar', '329', 'N', 'KOUSHIK CHAKRABORTY', '9674746942', '', '2019-10-21 14:24:24', '', '2019-10-21 14:24:24'),
(330, 'Uttar Dinajpur', '330', 'N', 'PRASAD MONDAL	', '9674746941', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(331, 'Dakhin Dinajpur', '331', 'N', 'MARSHAL SENGEL BASKEY	', '9674746940', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(332, 'Maldah', '332', 'N', 'ISHAN BANIK	', '9674746939', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(333, 'Murshidabad', '333', 'N', 'SUBHRA DAS	', '9674746936', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(334, 'Birbhum', '334', 'N', 'MONTU KUMAR MAJI', '9674746932', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(335, 'Purba Burdwan', '335', 'N', 'SUBRATA SEN	', '9674746928', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(336, 'Nadia', '336', 'N', 'SUBHASISH BISWAS', '9674746934', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(337, 'North 24 paragnas', '337', 'N', 'SABITA BISWAS', '9674746929', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(338, 'Hooghly', '338', 'N', 'SOMNATH KOTAL', '9674746931', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(339, 'Bankura', '339', 'N', 'KALYAN BISWAS', '9674746933', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(340, 'Purulia', '340', 'N', 'SUMAN CHAKRABORTY', '9674746938', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(341, 'Howrah', '341', 'N', 'SUBRATA CHATTOPADHYAY', '9674746944', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(342, 'Head Office', '342', 'Y', '', '', '', '2019-10-24 11:02:00', '', '2019-10-24 11:02:00'),
(343, 'South 24 Parganas', '343', 'N', 'SUSMITA NATH', '9674746930', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(344, 'Paschim Medinipur', '344', 'N', 'DEBANIK HORE', '9674746937', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(345, 'Purba Medinipur', '345', 'N', 'SUBHANU GHOSH', '9674749635', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(346, 'Alipurduar', '346', 'N', 'KOUSHIK CHAKRABORTY', '9674746942', '', '2019-10-21 14:24:24', '', '2019-10-21 14:24:24'),
(347, 'Paschim Burdwan', '347', 'N', '', '', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40'),
(348, 'Jhargram', '348', 'N', 'DEBANIK HORE', '9674746937', '', '2019-10-24 11:00:40', '', '2019-10-24 11:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `md_category`
--

CREATE TABLE `md_category` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `da` float(10,2) NOT NULL,
  `sa` float(10,2) NOT NULL,
  `hra` float(10,2) NOT NULL,
  `hra_max` float(10,2) NOT NULL,
  `pf` float(10,2) NOT NULL,
  `pf_max` float(10,2) NOT NULL,
  `pf_min` float(10,2) NOT NULL,
  `ta` float(10,2) NOT NULL,
  `ma` float(10,2) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `md_category`
--

INSERT INTO `md_category` (`id`, `category`, `da`, `sa`, `hra`, `hra_max`, `pf`, `pf_max`, `pf_min`, `ta`, `ma`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 'Permanent', 17.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 500.00, 'sss', '2022-10-31 01:49:34', 'sss', '2022-11-09 01:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `md_designation`
--

CREATE TABLE `md_designation` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(55) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_designation`
--

INSERT INTO `md_designation` (`id`, `name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'CEO', '2022-10-31 11:50:00', 'sss', '2022-11-07 08:27:28', 'sss'),
(2, 'Asst. CEO', '2022-10-31 11:50:11', 'sss', NULL, ''),
(3, 'Legal Manager', '2022-10-31 11:50:18', 'sss', NULL, ''),
(4, 'Asst. Manager', '2022-10-31 11:50:27', 'sss', NULL, ''),
(5, 'Peon', '2022-10-31 11:50:36', 'sss', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `md_district`
--

CREATE TABLE `md_district` (
  `district_code` int(5) NOT NULL,
  `district_name` varchar(50) NOT NULL,
  `dist_sort_code` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_district`
--

INSERT INTO `md_district` (`district_code`, `district_name`, `dist_sort_code`) VALUES
(327, 'DARJEELING', 'DAR'),
(328, 'JALPAIGURI', 'JPG'),
(329, 'COOCH BEHAR', 'COOH'),
(330, 'UTTAR DINAJPUR', 'NDNJ'),
(331, 'DAKSHIN DINAJPUR', 'SDNJ'),
(332, 'MALDAH', 'MLD'),
(333, 'MURSHIDABAD', 'MUR'),
(334, 'BIRBHUM', 'BRH'),
(335, 'PURBA BARDHAMAN', 'EBDN'),
(336, 'NADIA', 'NDA'),
(337, 'NORTH TWENTY FOUR PARGANAs', 'N24'),
(338, 'HOOGHLY', 'HOG'),
(339, 'BANKURA', 'BNK'),
(340, 'PURULIA', 'PUR'),
(341, 'HOWRAH', 'HWH'),
(342, 'KOLKATA', 'KOL'),
(343, 'SOUTH TWENTY FOUR PARGANAs', 'S24'),
(344, 'PASCHIM MIDNAPORE', 'WMDN'),
(345, 'PURBA MIDNAPORE', 'EMDN'),
(346, 'ALIPURDUAR', 'ALPD'),
(347, 'PASCHIM BARDHAMAN', 'WBDN'),
(348, 'JHARGRAM', 'JHG');

-- --------------------------------------------------------

--
-- Table structure for table `md_employee`
--

CREATE TABLE `md_employee` (
  `emp_code` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `emp_catg` int(10) NOT NULL,
  `emp_dist` int(10) NOT NULL,
  `dob` date DEFAULT NULL,
  `join_dt` date DEFAULT NULL,
  `ret_dt` date DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `grade` int(11) NOT NULL,
  `phn_no` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `aadhar_no` varchar(50) DEFAULT NULL,
  `emp_addr` text DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `bank_ac_no` varchar(50) DEFAULT NULL,
  `bank_ifsc` varchar(20) DEFAULT NULL,
  `pf_ac_no` varchar(50) DEFAULT NULL,
  `UAN` varchar(25) DEFAULT NULL,
  `basic_pay` decimal(10,2) DEFAULT 0.00,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `emp_status` char(1) DEFAULT 'A' COMMENT 'R=>Retired,A=>Active,S=>Suspended,RG=>Resigned',
  `remarks` varchar(255) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_employee`
--

INSERT INTO `md_employee` (`emp_code`, `emp_name`, `emp_catg`, `emp_dist`, `dob`, `join_dt`, `ret_dt`, `designation`, `department`, `grade`, `phn_no`, `email`, `pan_no`, `aadhar_no`, `emp_addr`, `bank_name`, `bank_ac_no`, `bank_ifsc`, `pf_ac_no`, `UAN`, `basic_pay`, `created_by`, `created_dt`, `emp_status`, `remarks`, `modified_by`, `modified_dt`) VALUES
(193001, 'Sukanta Kumar Mohapatra', 1, 339, '1976-08-05', '2007-07-30', '2036-08-05', '1', 'Administration-Head Office', 1, '1234567892', '', '', '', '', 'Canara Bank', '1439101026330', 'CNRB0001439', '', '', '41100.00', 'sss', '2022-10-31 02:01:28', 'A', '', 'sss', '2022-11-09 12:56:59'),
(193002, 'Mahendra Kumar Ghatuary', 1, 339, '1987-01-22', '2001-02-21', '2047-01-22', '2', 'CEO', 1, '7894561231', '', '', '', '', 'BOM', '60289349114', 'MAHB0001907', '', '', '33300.00', 'sss', '2022-11-01 06:52:12', 'A', '', 'sss', '2022-11-09 12:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `md_fin_year`
--

CREATE TABLE `md_fin_year` (
  `sl_no` int(11) NOT NULL,
  `fin_yr` varchar(30) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_fin_year`
--

INSERT INTO `md_fin_year` (`sl_no`, `fin_yr`, `created_by`, `created_dt`, `modified_by`, `modified_dt`) VALUES
(1, '2020-21', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `md_leave_allocation`
--

CREATE TABLE `md_leave_allocation` (
  `sl_no` int(10) NOT NULL,
  `type` varchar(25) NOT NULL,
  `start_month` int(2) NOT NULL,
  `end_month` int(2) NOT NULL,
  `amount` int(10) NOT NULL,
  `credit_on` date NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_month`
--

CREATE TABLE `md_month` (
  `id` int(11) NOT NULL,
  `month_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_month`
--

INSERT INTO `md_month` (`id`, `month_name`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `md_parameters`
--

CREATE TABLE `md_parameters` (
  `sl_no` int(11) NOT NULL,
  `param_desc` varchar(100) CHARACTER SET latin1 NOT NULL,
  `param_value` varchar(100) CHARACTER SET latin1 NOT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `md_parameters`
--

INSERT INTO `md_parameters` (`sl_no`, `param_desc`, `param_value`, `modified_by`, `modified_dt`) VALUES
(1, 'DA Percentage', '3', 'sss', '2022-08-25 03:50:14'),
(2, 'HRA Percentage', '12', 'sss', '2021-02-08 07:11:09'),
(3, 'Medical Allowance', '500', 'sss', '2021-02-08 07:24:55'),
(4, 'PF Percentage', '12', 'anirbanc', '2021-04-02 06:46:28'),
(5, 'Yearly increment ', '0', 'sss', '2021-02-18 03:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `md_ptax`
--

CREATE TABLE `md_ptax` (
  `id` int(10) NOT NULL,
  `st` decimal(10,2) NOT NULL DEFAULT 0.00,
  `end` decimal(10,2) NOT NULL,
  `ptax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_ptax`
--

INSERT INTO `md_ptax` (`id`, `st`, `end`, `ptax`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '0.00', '10000.00', '0.00', NULL, NULL, '2022-09-01 12:32:53', 'sss'),
(2, '10001.00', '15000.00', '110.00', NULL, NULL, NULL, NULL),
(3, '15001.00', '25000.00', '130.00', NULL, NULL, NULL, NULL),
(4, '25001.00', '40000.00', '150.00', NULL, NULL, NULL, NULL),
(5, '40001.00', '99999999.00', '200.00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `md_ptax_slab`
--

CREATE TABLE `md_ptax_slab` (
  `effective_dt` date NOT NULL,
  `sl_no` int(11) NOT NULL,
  `from_amt` decimal(10,2) NOT NULL,
  `to_amt` decimal(10,2) NOT NULL,
  `tax_amt` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_ptax_slab`
--

INSERT INTO `md_ptax_slab` (`effective_dt`, `sl_no`, `from_amt`, `to_amt`, `tax_amt`) VALUES
('2017-01-01', 1, '10000.00', '15000.00', '110.00'),
('2017-01-01', 2, '15001.00', '25000.00', '130.00'),
('2017-01-01', 3, '25001.00', '40000.00', '150.00'),
('2017-01-01', 4, '40000.00', '4000000.00', '200.00');

-- --------------------------------------------------------

--
-- Table structure for table `md_users`
--

CREATE TABLE `md_users` (
  `user_id` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` enum('U','M','A','B') NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_status` enum('A','D') NOT NULL,
  `branch_id` varchar(20) NOT NULL,
  `st` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_users`
--

INSERT INTO `md_users` (`user_id`, `password`, `user_type`, `user_name`, `user_status`, `branch_id`, `st`, `created_by`, `created_dt`, `modified_by`, `modified_dt`) VALUES
('sss', '$2y$10$FcDRYBOHqcoQMf7lD45w6ebd/EFlKXvepEr.MZ98GaU371FKHUc6.', 'A', 'Synergic', 'A', '341', 0, 'Synergic Softek', NULL, 'sss', '2022-11-07 11:31:38'),
('subham', '$2y$10$QhRjnDSvumcfcsNn0IpPuubtOIHRJ3db5fRwx3DDfaZqPS.HL.hf.', 'U', 'Subham', 'A', '', 0, 'sss', '2022-11-07 12:19:06', 'sss', '2022-11-07 12:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `td_attendance`
--

CREATE TABLE `td_attendance` (
  `trans_dt` date NOT NULL,
  `sal_year` int(11) NOT NULL,
  `sal_month` varchar(50) NOT NULL,
  `emp_cd` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `emp_catg` varchar(30) DEFAULT NULL,
  `no_of_days` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(50) NOT NULL,
  `created_dt` datetime NOT NULL,
  `modified_by` varchar(50) NOT NULL,
  `modified_dt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_audit_trail`
--

CREATE TABLE `td_audit_trail` (
  `sl_no` int(5) UNSIGNED NOT NULL,
  `login_dt` datetime DEFAULT NULL,
  `user_id` varchar(30) DEFAULT NULL,
  `terminal_name` varchar(50) DEFAULT NULL,
  `logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `td_audit_trail`
--

INSERT INTO `td_audit_trail` (`sl_no`, `login_dt`, `user_id`, `terminal_name`, `logout`) VALUES
(1, '2021-02-24 05:52:07', 'sss', '122.176.27.53', NULL),
(2, '2021-02-24 05:53:04', 'sss', '122.176.27.53', NULL),
(3, '2021-02-24 06:00:18', 'sss', '122.176.27.53', NULL),
(4, '2021-02-24 06:52:57', 'anirbanc', '182.76.175.10', NULL),
(5, '2021-02-24 10:47:49', 'anirbanc', '182.76.175.10', NULL),
(6, '2021-02-24 11:04:27', 'sss', '122.176.27.53', NULL),
(7, '2021-02-24 02:52:10', 'anirbanc', '202.142.65.118', NULL),
(8, '2021-02-25 03:11:53', 'anirbanc', '182.76.175.10', NULL),
(9, '2021-02-25 05:08:09', 'sss', '122.176.27.53', NULL),
(10, '2021-02-25 07:06:34', 'anirbanc', '182.76.175.10', NULL),
(11, '2021-02-25 10:06:49', 'sss', '122.176.27.53', NULL),
(12, '2021-02-25 02:47:13', 'anirbanc', '202.142.65.79', NULL),
(13, '2021-02-26 05:06:10', 'anirbanc', '182.76.175.10', NULL),
(14, '2021-02-27 09:57:20', 'anirbanc', '202.142.104.143', NULL),
(15, '2021-03-01 05:08:28', 'anirbanc', '182.76.175.10', NULL),
(16, '2021-03-01 05:56:45', 'anirbanc', '182.76.175.10', NULL),
(17, '2021-03-01 09:20:12', 'sss', '122.176.27.53', NULL),
(18, '2021-03-02 06:27:07', 'anirbanc', '182.76.175.10', NULL),
(19, '2021-03-03 05:52:24', 'sss', '122.176.27.53', NULL),
(20, '2021-03-03 10:58:50', 'sss', '122.176.27.53', NULL),
(21, '2021-03-03 12:41:43', 'sss', '122.176.27.53', NULL),
(22, '2021-03-03 01:09:22', 'sss', '122.176.27.53', NULL),
(23, '2021-03-05 05:13:34', 'sss', '122.176.27.53', NULL),
(24, '2021-03-05 06:44:26', 'sss', '122.176.27.53', NULL),
(25, '2021-03-08 06:16:14', 'sss', '136.232.64.10', NULL),
(26, '2021-03-09 07:17:07', 'anirbanc', '182.76.175.10', NULL),
(27, '2021-03-09 09:01:51', 'sss', '122.176.27.53', NULL),
(28, '2021-03-09 10:38:06', 'sss', '122.176.27.53', NULL),
(29, '2021-03-10 05:10:43', 'sss', '122.176.27.53', NULL),
(30, '2021-03-10 01:13:13', 'sss', '122.176.27.53', NULL),
(31, '2021-03-25 10:07:22', 'sss', '122.176.27.53', NULL),
(32, '2021-04-02 06:03:52', 'anirbanc', '223.191.48.89', NULL),
(33, '2021-04-05 06:40:28', 'sss', '122.176.27.53', NULL),
(34, '2022-02-18 11:12:14', 'sss', '122.163.123.68', NULL),
(35, '2022-03-22 11:02:44', 'anirbanc', '103.242.190.231', NULL),
(36, '2022-08-17 11:51:17', 'sss', '::1', NULL),
(37, '2022-08-18 10:20:56', 'sss', '::1', NULL),
(38, '2022-08-18 02:27:42', 'sss', '::1', NULL),
(39, '2022-08-18 02:30:54', 'sss', '::1', NULL),
(40, '2022-08-18 02:31:03', 'sss', '::1', NULL),
(41, '2022-08-18 02:51:39', 'sss', '::1', NULL),
(42, '2022-08-18 02:51:52', 'sss', '::1', NULL),
(43, '2022-08-18 03:20:44', 'sss', '::1', NULL),
(44, '2022-08-19 11:11:53', 'sss', '::1', NULL),
(45, '2022-08-22 10:53:58', 'sss', '::1', NULL),
(46, '2022-08-22 02:42:17', 'sss', '::1', NULL),
(47, '2022-08-23 03:31:51', 'sss', '::1', NULL),
(48, '2022-08-25 11:18:45', 'sss', '::1', NULL),
(49, '2022-08-25 01:11:22', 'sss', '::1', NULL),
(50, '2022-08-25 03:49:17', 'sss', '::1', NULL),
(51, '2022-08-25 04:33:06', 'sss', '::1', NULL),
(52, '2022-08-26 10:30:55', 'sss', '::1', NULL),
(53, '2022-08-26 10:45:59', 'sss', '::1', NULL),
(54, '2022-08-30 02:24:07', 'sss', '::1', NULL),
(55, '2022-08-31 10:53:26', 'sss', '::1', NULL),
(56, '2022-08-31 03:02:43', 'sss', '::1', NULL),
(57, '2022-09-01 10:31:46', 'sss', '::1', NULL),
(58, '2022-09-02 10:32:06', 'sss', '::1', NULL),
(59, '2022-09-02 11:02:16', 'sss', '::1', NULL),
(60, '2022-09-15 07:34:26', 'sss', '127.0.0.1', NULL),
(61, '2022-09-15 08:39:55', 'sss', '127.0.0.1', NULL),
(62, '2022-09-15 08:39:59', 'sss', '127.0.0.1', NULL),
(63, '2022-09-15 08:53:21', 'sss', '127.0.0.1', NULL),
(64, '2022-09-15 11:57:35', 'sss', '127.0.0.1', NULL),
(65, '2022-09-16 07:34:17', 'sss', '127.0.0.1', NULL),
(66, '2022-09-16 12:15:36', 'sss', '127.0.0.1', NULL),
(67, '2022-09-19 07:23:05', 'sss', '127.0.0.1', NULL),
(68, '2022-09-19 11:36:35', 'sss', '127.0.0.1', NULL),
(69, '2022-09-20 07:19:35', 'sss', '127.0.0.1', NULL),
(70, '2022-09-20 11:30:51', 'sss', '127.0.0.1', '2022-09-20 01:28:11'),
(71, '2022-09-20 01:41:15', 'sss', '127.0.0.1', NULL),
(72, '2022-09-21 07:41:06', 'sss', '127.0.0.1', NULL),
(73, '2022-09-21 12:46:58', 'sss', '127.0.0.1', '2022-09-21 12:49:52'),
(74, '2022-09-22 07:39:25', 'sss', '127.0.0.1', '2022-09-22 07:59:35'),
(75, '2022-09-22 10:00:42', 'sss', '127.0.0.1', NULL),
(76, '2022-09-22 12:32:49', 'sss', '127.0.0.1', NULL),
(77, '2022-09-23 07:16:29', 'sss', '127.0.0.1', NULL),
(78, '2022-09-23 09:30:02', 'sss', '127.0.0.1', NULL),
(79, '2022-09-29 07:24:48', 'sss', '127.0.0.1', NULL),
(80, '2022-10-11 08:49:34', 'sss', '127.0.0.1', NULL),
(81, '2022-10-14 01:20:47', 'sss', '127.0.0.1', NULL),
(82, '2022-10-18 11:37:04', 'sss', '127.0.0.1', NULL),
(83, '2022-10-28 10:10:50', 'sss', '127.0.0.1', NULL),
(84, '2022-10-31 11:13:58', 'sss', '127.0.0.1', '2022-10-31 11:14:33'),
(85, '2022-10-31 11:19:20', 'sss', '127.0.0.1', NULL),
(86, '2022-11-01 06:07:04', 'sss', '127.0.0.1', '2022-11-01 09:22:35'),
(87, '2022-11-01 10:42:39', 'sss', '127.0.0.1', NULL),
(88, '2022-11-01 11:01:30', 'sss', '127.0.0.1', NULL),
(89, '2022-11-01 01:38:23', 'sss', '127.0.0.1', NULL),
(90, '2022-11-07 06:13:27', 'sss', '127.0.0.1', NULL),
(91, '2022-11-07 11:30:35', 'sss', '127.0.0.1', NULL),
(92, '2022-11-09 06:37:16', 'sss', '127.0.0.1', '2022-11-09 06:41:33'),
(93, '2022-11-09 06:41:40', 'sss', '127.0.0.1', NULL),
(94, '2022-11-09 10:59:49', 'sss', '127.0.0.1', NULL),
(95, '2022-11-10 06:43:52', 'sss', '127.0.0.1', '2022-11-10 07:29:59'),
(96, '2022-11-10 07:30:04', 'sss', '127.0.0.1', '2022-11-10 07:31:22'),
(97, '2022-11-10 07:31:28', 'sss', '127.0.0.1', '2022-11-10 08:00:18'),
(98, '2022-12-07 01:48:12', 'sss', '127.0.0.1', NULL),
(99, '2022-12-09 06:17:54', 'sss', '127.0.0.1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `td_deductions`
--

CREATE TABLE `td_deductions` (
  `emp_code` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `catg_id` int(11) NOT NULL,
  `gross` float(10,2) NOT NULL,
  `pf` float(10,2) NOT NULL DEFAULT 0.00,
  `loan_emi` float(10,2) NOT NULL DEFAULT 0.00,
  `instal_no` int(11) NOT NULL,
  `p_tax` float(10,2) NOT NULL DEFAULT 0.00,
  `gici` float(10,2) NOT NULL DEFAULT 0.00,
  `income_tax_tds` float(10,2) NOT NULL DEFAULT 0.00,
  `security` float(10,2) NOT NULL DEFAULT 0.00,
  `insurance` float(10,2) NOT NULL DEFAULT 0.00,
  `other_did` float(10,2) NOT NULL DEFAULT 0.00,
  `tot_diduction` float(10,2) NOT NULL DEFAULT 0.00,
  `net_sal` float(10,2) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_dt` datetime NOT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `td_deductions`
--

INSERT INTO `td_deductions` (`emp_code`, `effective_date`, `catg_id`, `gross`, `pf`, `loan_emi`, `instal_no`, `p_tax`, `gici`, `income_tax_tds`, `security`, `insurance`, `other_did`, `tot_diduction`, `net_sal`, `created_by`, `created_dt`, `modified_by`, `modified_dt`) VALUES
(193001, '2022-11-09', 1, 55197.00, 400.00, 200.00, 2, 200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 800.00, 54397.00, 'sss', '2022-12-09 06:59:46', NULL, NULL),
(193002, '2022-11-09', 1, 44791.00, 600.00, 100.00, 1, 200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 900.00, 43891.00, 'sss', '2022-12-09 06:59:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `td_income`
--

CREATE TABLE `td_income` (
  `emp_code` int(10) NOT NULL,
  `effective_date` date NOT NULL,
  `catg_id` int(11) NOT NULL COMMENT 'md_category->id',
  `basic` float(10,2) NOT NULL DEFAULT 0.00,
  `da` float(10,2) NOT NULL DEFAULT 0.00,
  `sa` float(10,2) NOT NULL DEFAULT 0.00,
  `hra` float(10,2) NOT NULL DEFAULT 0.00,
  `ta` float(10,2) NOT NULL DEFAULT 0.00,
  `da_on_sa` float(10,2) NOT NULL DEFAULT 0.00,
  `da_on_ta` float(10,2) NOT NULL DEFAULT 0.00,
  `ma` float(10,2) NOT NULL DEFAULT 0.00,
  `cash_swa` float(10,2) NOT NULL DEFAULT 0.00,
  `gross` float(10,2) NOT NULL DEFAULT 0.00,
  `lwp` float(10,2) NOT NULL DEFAULT 0.00,
  `final_gross` float(10,2) NOT NULL DEFAULT 0.00,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `td_income`
--

INSERT INTO `td_income` (`emp_code`, `effective_date`, `catg_id`, `basic`, `da`, `sa`, `hra`, `ta`, `da_on_sa`, `da_on_ta`, `ma`, `cash_swa`, `gross`, `lwp`, `final_gross`, `created_by`, `created_dt`, `modified_by`, `modified_dt`) VALUES
(193001, '2022-11-01', 1, 41100.00, 6987.00, 0.00, 4110.00, 2500.00, 0.00, 0.00, 500.00, 0.00, 55197.00, 0.00, 55197.00, 'sss', '2022-11-01 06:56:02', NULL, NULL),
(193002, '2022-11-01', 1, 33300.00, 5661.00, 0.00, 3330.00, 2000.00, 0.00, 0.00, 500.00, 0.00, 44791.00, 0.00, 44791.00, 'sss', '2022-11-01 06:56:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `td_leave_dtls`
--

CREATE TABLE `td_leave_dtls` (
  `trans_dt` date NOT NULL,
  `trans_cd` int(10) NOT NULL,
  `trans_type` varchar(1) NOT NULL,
  `emp_no` varchar(50) NOT NULL,
  `emp_name` varchar(120) NOT NULL,
  `docket_no` varchar(100) NOT NULL,
  `leave_type` varchar(5) NOT NULL,
  `leave_mode` varchar(1) NOT NULL,
  `from_dt` date NOT NULL,
  `to_dt` date NOT NULL,
  `no_of_days` decimal(4,1) NOT NULL DEFAULT 0.0,
  `remarks` tinytext NOT NULL,
  `approval_status` varchar(1) NOT NULL,
  `approved_dt` date NOT NULL,
  `approved_by` varchar(50) NOT NULL,
  `rollback_reason` tinytext NOT NULL,
  `roll_dt` date DEFAULT NULL,
  `roll_by` varchar(50) DEFAULT NULL,
  `cl_bal` decimal(4,1) NOT NULL DEFAULT 0.0,
  `el_bal` decimal(4,1) NOT NULL DEFAULT 0.0,
  `ml_bal` decimal(4,1) NOT NULL DEFAULT 0.0,
  `od_bal` decimal(4,1) NOT NULL DEFAULT 0.0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_leave_mat`
--

CREATE TABLE `td_leave_mat` (
  `trans_dt` date NOT NULL,
  `trans_cd` int(10) NOT NULL,
  `emp_no` varchar(50) NOT NULL,
  `emp_name` varchar(120) NOT NULL,
  `docket_no` varchar(100) NOT NULL,
  `from_dt` date NOT NULL,
  `to_dt` date NOT NULL,
  `no_of_days` float(3,1) NOT NULL,
  `remarks` tinytext NOT NULL,
  `approval_status` varchar(1) NOT NULL,
  `approved_dt` date NOT NULL,
  `approved_by` varchar(50) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_pay_slip`
--

CREATE TABLE `td_pay_slip` (
  `trans_date` date NOT NULL,
  `trans_no` int(11) NOT NULL,
  `sal_month` int(10) NOT NULL,
  `sal_year` int(11) NOT NULL,
  `emp_code` int(10) NOT NULL,
  `catg_id` int(11) NOT NULL COMMENT 'md_category->id',
  `basic` float(10,2) NOT NULL DEFAULT 0.00,
  `da` float(10,2) NOT NULL DEFAULT 0.00,
  `sa` float(10,2) NOT NULL DEFAULT 0.00,
  `hra` float(10,2) NOT NULL DEFAULT 0.00,
  `ta` float(10,2) NOT NULL DEFAULT 0.00,
  `da_on_sa` float(10,2) NOT NULL DEFAULT 0.00,
  `da_on_ta` float(10,2) NOT NULL DEFAULT 0.00,
  `ma` float(10,2) NOT NULL DEFAULT 0.00,
  `cash_swa` float(10,2) NOT NULL DEFAULT 0.00,
  `lwp` float(10,2) NOT NULL DEFAULT 0.00,
  `final_gross` float(10,2) NOT NULL DEFAULT 0.00,
  `pf` float(10,2) NOT NULL DEFAULT 0.00,
  `loan_prin` float(10,2) NOT NULL DEFAULT 0.00,
  `loan_int` int(11) NOT NULL DEFAULT 0,
  `p_tax` float(10,2) NOT NULL DEFAULT 0.00,
  `gici` float(10,2) NOT NULL DEFAULT 0.00,
  `income_tax_tds` float(10,2) NOT NULL DEFAULT 0.00,
  `security` float(10,2) NOT NULL DEFAULT 0.00,
  `insurance` float(10,2) NOT NULL DEFAULT 0.00,
  `other_did` float(10,2) NOT NULL DEFAULT 0.00,
  `tot_diduction` float(10,2) NOT NULL,
  `net_sal` float(10,2) NOT NULL,
  `bank_ac_no` varchar(50) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `approval_status` varchar(5) NOT NULL DEFAULT 'U'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `td_pay_slip`
--

INSERT INTO `td_pay_slip` (`trans_date`, `trans_no`, `sal_month`, `sal_year`, `emp_code`, `catg_id`, `basic`, `da`, `sa`, `hra`, `ta`, `da_on_sa`, `da_on_ta`, `ma`, `cash_swa`, `lwp`, `final_gross`, `pf`, `loan_prin`, `loan_int`, `p_tax`, `gici`, `income_tax_tds`, `security`, `insurance`, `other_did`, `tot_diduction`, `net_sal`, `bank_ac_no`, `created_by`, `created_dt`, `modified_by`, `modified_dt`, `remarks`, `approval_status`) VALUES
('2022-11-09', 1, 5, 2022, 193001, 1, 41100.00, 6987.00, 0.00, 4110.00, 2500.00, 0.00, 0.00, 500.00, 0.00, 0.00, 55197.00, 150.00, 1000.00, 500, 200.00, 0.00, 0.00, 500.00, 0.00, 0.00, 2371.00, 52826.00, '1439101026330', NULL, NULL, NULL, NULL, 'System Generated', 'A'),
('2022-11-09', 1, 5, 2022, 193002, 1, 33300.00, 5661.00, 0.00, 3330.00, 2000.00, 0.00, 0.00, 500.00, 0.00, 0.00, 44791.00, 100.00, 200.00, 100, 200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 632.00, 44159.00, '60289349114', NULL, NULL, NULL, NULL, 'System Generated', 'A'),
('2022-11-09', 1, 6, 2022, 193001, 1, 41100.00, 6987.00, 0.00, 4110.00, 2500.00, 0.00, 0.00, 500.00, 0.00, 0.00, 55197.00, 150.00, 1000.00, 500, 200.00, 0.00, 0.00, 500.00, 1.00, 20.00, 2371.00, 52826.00, '1439101026330', NULL, NULL, NULL, NULL, 'System Generated', 'A'),
('2022-11-09', 1, 6, 2022, 193002, 1, 33300.00, 5661.00, 0.00, 3330.00, 2000.00, 0.00, 0.00, 500.00, 0.00, 0.00, 44791.00, 100.00, 200.00, 100, 200.00, 0.00, 0.00, 0.00, 2.00, 30.00, 632.00, 44159.00, '60289349114', NULL, NULL, NULL, NULL, 'System Generated', 'A'),
('2022-12-09', 1, 7, 2022, 193001, 1, 41100.00, 6987.00, 0.00, 4110.00, 2500.00, 0.00, 0.00, 500.00, 0.00, 0.00, 55197.00, 400.00, 200.00, 2, 200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 800.00, 54397.00, '1439101026330', NULL, NULL, NULL, NULL, 'System Generated', 'A'),
('2022-12-09', 1, 7, 2022, 193002, 1, 33300.00, 5661.00, 0.00, 3330.00, 2000.00, 0.00, 0.00, 500.00, 0.00, 0.00, 44791.00, 600.00, 100.00, 1, 200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 900.00, 43891.00, '60289349114', NULL, NULL, NULL, NULL, 'System Generated', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `td_salary`
--

CREATE TABLE `td_salary` (
  `trans_date` date NOT NULL,
  `trans_no` int(11) NOT NULL,
  `sal_month` int(10) NOT NULL,
  `sal_year` int(11) NOT NULL,
  `catg_cd` int(11) NOT NULL,
  `approval_status` varchar(1) NOT NULL DEFAULT 'U',
  `created_by` varchar(50) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_dt` datetime DEFAULT NULL,
  `approved_by` varchar(50) DEFAULT NULL,
  `approved_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `td_salary`
--

INSERT INTO `td_salary` (`trans_date`, `trans_no`, `sal_month`, `sal_year`, `catg_cd`, `approval_status`, `created_by`, `created_dt`, `modified_by`, `modified_dt`, `approved_by`, `approved_dt`) VALUES
('2022-03-31', 0, 3, 2022, 1, 'A', 'admin', '2022-10-11 00:00:00', NULL, NULL, 'admin', '2022-10-11 00:00:00'),
('2022-03-31', 0, 3, 2022, 2, 'A', 'admin', '2022-10-11 00:00:00', NULL, NULL, 'admin', '2022-10-11 00:00:00'),
('2022-11-07', 1, 4, 2022, 1, 'A', 'sss', '2022-11-07 01:58:47', NULL, NULL, 'sss', '2022-11-07 00:00:00'),
('2022-11-09', 1, 5, 2022, 1, 'A', 'sss', '2022-11-09 02:13:20', NULL, NULL, 'sss', '2022-11-09 00:00:00'),
('2022-11-09', 1, 6, 2022, 1, 'A', 'sss', '2022-11-09 02:17:03', NULL, NULL, 'sss', '2022-12-07 00:00:00'),
('2022-12-09', 1, 7, 2022, 1, 'A', 'sss', '2022-12-09 07:05:52', NULL, NULL, 'sss', '2022-12-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `td_stop_salary`
--

CREATE TABLE `td_stop_salary` (
  `trans_dt` date NOT NULL,
  `emp_no` int(11) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL,
  `remarks` text NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_dt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `td_stop_salary`
--
DELIMITER $$
CREATE TRIGGER `ai_stop_salary` AFTER INSERT ON `td_stop_salary` FOR EACH ROW BEGIN

		UPDATE md_employee SET
                emp_status	=	NEW.status
            
                WHERE emp_code	=	NEW.emp_no;
     
     
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tm_pf_dtls`
--

CREATE TABLE `tm_pf_dtls` (
  `trans_dt` date NOT NULL,
  `trans_no` int(11) NOT NULL DEFAULT 0,
  `sal_month` varchar(10) NOT NULL,
  `sal_year` int(11) NOT NULL,
  `emp_no` int(11) NOT NULL,
  `employee_cntr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `employer_cntr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `md_basic_pay`
--
ALTER TABLE `md_basic_pay`
  ADD PRIMARY KEY (`effective_dt`,`emp_cd`);

--
-- Indexes for table `md_branch`
--
ALTER TABLE `md_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_category`
--
ALTER TABLE `md_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `md_designation`
--
ALTER TABLE `md_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_district`
--
ALTER TABLE `md_district`
  ADD PRIMARY KEY (`district_code`);

--
-- Indexes for table `md_employee`
--
ALTER TABLE `md_employee`
  ADD PRIMARY KEY (`emp_code`);

--
-- Indexes for table `md_fin_year`
--
ALTER TABLE `md_fin_year`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `md_leave_allocation`
--
ALTER TABLE `md_leave_allocation`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `md_month`
--
ALTER TABLE `md_month`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_parameters`
--
ALTER TABLE `md_parameters`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `md_ptax`
--
ALTER TABLE `md_ptax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_ptax_slab`
--
ALTER TABLE `md_ptax_slab`
  ADD PRIMARY KEY (`effective_dt`,`sl_no`);

--
-- Indexes for table `md_users`
--
ALTER TABLE `md_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `td_attendance`
--
ALTER TABLE `td_attendance`
  ADD PRIMARY KEY (`trans_dt`,`sal_year`,`sal_month`,`emp_cd`);

--
-- Indexes for table `td_audit_trail`
--
ALTER TABLE `td_audit_trail`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `td_deductions`
--
ALTER TABLE `td_deductions`
  ADD PRIMARY KEY (`emp_code`,`effective_date`,`catg_id`) USING BTREE;

--
-- Indexes for table `td_income`
--
ALTER TABLE `td_income`
  ADD PRIMARY KEY (`emp_code`,`effective_date`,`catg_id`) USING BTREE;

--
-- Indexes for table `td_leave_dtls`
--
ALTER TABLE `td_leave_dtls`
  ADD PRIMARY KEY (`trans_dt`,`trans_cd`) USING BTREE;

--
-- Indexes for table `td_leave_mat`
--
ALTER TABLE `td_leave_mat`
  ADD PRIMARY KEY (`trans_cd`,`trans_dt`) USING BTREE;

--
-- Indexes for table `td_pay_slip`
--
ALTER TABLE `td_pay_slip`
  ADD PRIMARY KEY (`trans_date`,`sal_month`,`sal_year`,`emp_code`);

--
-- Indexes for table `td_salary`
--
ALTER TABLE `td_salary`
  ADD PRIMARY KEY (`trans_date`,`trans_no`,`sal_month`,`sal_year`,`catg_cd`) USING BTREE;

--
-- Indexes for table `td_stop_salary`
--
ALTER TABLE `td_stop_salary`
  ADD PRIMARY KEY (`trans_dt`,`emp_no`) USING BTREE;

--
-- Indexes for table `tm_pf_dtls`
--
ALTER TABLE `tm_pf_dtls`
  ADD PRIMARY KEY (`trans_dt`,`emp_no`,`sal_month`,`sal_year`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `md_branch`
--
ALTER TABLE `md_branch`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Here id is Disctrict Code', AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `md_category`
--
ALTER TABLE `md_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `md_designation`
--
ALTER TABLE `md_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `md_district`
--
ALTER TABLE `md_district`
  MODIFY `district_code` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `md_fin_year`
--
ALTER TABLE `md_fin_year`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `md_leave_allocation`
--
ALTER TABLE `md_leave_allocation`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `md_month`
--
ALTER TABLE `md_month`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `md_parameters`
--
ALTER TABLE `md_parameters`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `md_ptax`
--
ALTER TABLE `md_ptax`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `td_audit_trail`
--
ALTER TABLE `td_audit_trail`
  MODIFY `sl_no` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
