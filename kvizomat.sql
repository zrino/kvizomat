/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.14 : Database - matura
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Data for the table `app_users` */

insert  into `app_users`(`id`,`username`,`password`,`email`,`is_active`) values (1,'Zrino','$2a$06$a/ZJjy1hkTWImjVq5/CXE.J7O571CEy/L9I9UEjLG5gZ3U3gdt79C','zrino.pernar@gmail.com',1),(2,'TestUser1','$2y$13$DvtRcBbi9E57jbMDDRBdyO9C3AvKJbonoelkCemXsmaPRMEPG.uBm','testuser@gmail.com',1);

/*Data for the table `quiz` */

insert  into `quiz`(`id`,`title`,`id_user`) values (13,'Hrvatski matura 2012/2013 A razina',1),(14,'Hrvatski matura 2012/2013 B razina',1),(12,'My new quiz',1);

/*Data for the table `quiz_answers` */

insert  into `quiz_answers`(`id`,`id_question`,`is_correct`,`text`) values (6,1,0,'Lorem ipsum dolor sit amet'),(7,1,0,'Incorrect answer'),(8,1,1,'New answer'),(10,5,0,'Mali rasist'),(11,5,0,'Skrublord'),(12,5,0,'Nigger'),(13,5,0,'lel'),(14,6,0,'Answer 1'),(15,6,0,'Answer 2');

/*Data for the table `quiz_questions` */

insert  into `quiz_questions`(`id`,`id_section`,`question_text`,`type`) values (1,7,'Lorem ipsum?',0),(2,6,'My second question with variable number of answers',0),(3,5,'updated question 1',0),(5,5,'Tko je Toni Pernar',0),(6,11,'Test test test?',0);

/*Data for the table `quiz_sections` */

insert  into `quiz_sections`(`id`,`id_quiz`,`section_text`,`type`,`name`) values (5,12,'Cras ultricies ligula sed magna dictum porta. Nulla quis lorem ut libero malesuada feugiat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.',0,'Section 1'),(6,12,NULL,0,'Newest'),(7,12,NULL,0,'My best section yet'),(8,13,NULL,0,'Gramatika'),(10,13,NULL,0,'Pravopis'),(11,14,NULL,1,'Section 1');

/*Data for the table `test_table` */

insert  into `test_table`(`cijena`) values (0),(435);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
