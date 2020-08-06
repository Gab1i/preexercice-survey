--
-- Database: `survey`
--
CREATE DATABASE IF NOT EXISTS `survey` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `survey`;

CREATE USER 'user_exercice' IDENTIFIED BY 'bawZnAdtHuez9rF6';
GRANT USAGE ON *.* TO 'user_exercice'@'%';
GRANT ALL PRIVILEGES ON `survey`.* TO 'user_exercice'@'%';

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id_user` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id_question` int(11) NOT NULL,
  `question_order` mediumint(9) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `mail` varchar(320) NOT NULL,
  `answer_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id_user`,`id_question`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);


--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`);
