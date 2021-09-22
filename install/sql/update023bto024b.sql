CREATE TABLE `widget` (
    `id` int(24) NOT NULL AUTO_INCREMENT,
    `userID` int(24) NOT NULL,
    `uniqueIDWidget` varchar(32) NOT NULL,
    `position` int(24) NOT NULL,
    PRIMARY KEY (`id`)
);