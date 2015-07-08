
--
-- Table structure for table `comments`
--
CREATE TABLE `requests` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expected_solution` text NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
    `username` varchar(255) NOT NULL

  
);



DROP TABLE IF EXISTS `comments`;


--
-- Dumping data for table `comments`
--
INSERT INTO `comments` VALUES (1,1,'2009-01-01 11:30:39','Kevin','I love this picture!'),(5,5,'2009-01-01 20:46:39','Doug','Pretty flowers.'),(6,5,'2009-01-01 21:08:58','Mary','I like them too.');
CREATE TABLE `comments` (
  `id` int(11) NOT NULL auto_increment,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`)
); 

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL auto_increment,
  `request_id` int(11) NOT NULL,
  `message` text,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE `photographs` (
  `id` int(11) NOT NULL auto_increment,
  `request_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);
--
-- Dumping data for table `photographs`
--
INSERT INTO `photographs` VALUES (1,'bamboo.jpg','image/jpeg',265437,'Bamboo'),(5,'flowers.jpg','image/jpeg',394552,'Flowers'),(4,'roof.jpg','image/jpeg',322870,'Roof'),(6,'buddhas.jpg','image/jpeg',261152,'Buddhas'),(7,'wall.jpg','image/jpeg',369592,'Wall'),(8,'wood.jpg','image/jpeg',353050,'Wood');

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=4;

--
-- Dumping data for table `users`
--
INSERT INTO `users` VALUES (1,'kskoglund','secretpwd','Kevin','Skoglund');
