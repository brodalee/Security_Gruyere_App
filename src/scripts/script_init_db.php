#!bin/sh
<?php

require_once 'vendor/autoload.php';

use App\Model\Entity\Sauce;
use App\Model\Entity\Success;
use App\Model\Entity\User;
use App\Model\Entity\UserLikeDislikeSauce;

echo "Creating User Table ...\n";
$user = new User();
$user
    ->getRepository()
    ->customQuery('
        START TRANSACTION;
        
        CREATE TABLE `User` (
            `id` int(11) NOT NULL,
            `pseudo` varchar(64) NOT NULL,
            `password` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        ALTER TABLE `User`
            ADD PRIMARY KEY (`id`);
            
        ALTER TABLE `User`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        COMMIT;
    ');

echo "Done\n";

echo "Creating Sauce Table ...\n";
$sauce = new Sauce();
$sauce
    ->getRepository()
    ->customQuery('
        START TRANSACTION;
        
        CREATE TABLE `Sauce` (
            `id` int(11) NOT NULL,
            `name` varchar(128) NOT NULL,
            `manufacturer` varchar(128) NOT NULL,
            `description` varchar(255) NOT NULL,
            `mainPepper` varchar(128) NOT NULL,
            `imageUrl` varchar(255) NOT NULL,
            `heat` varchar(64) NOT NULL,
            `userId` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            
            ALTER TABLE `Sauce`
                ADD PRIMARY KEY (`id`),
                ADD KEY `userId` (`userId`);
                
            ALTER TABLE `Sauce`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                
            ALTER TABLE `Sauce`
                ADD CONSTRAINT `sauce_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
            COMMIT;
    ');
echo "Done\n";

echo "Creating User_Like_Dislike_Sauce Table ...\n";
$user_l_d_sauce = new UserLikeDislikeSauce();
$user_l_d_sauce
    ->getRepository()
    ->customQuery("
        START TRANSACTION;
        
        CREATE TABLE `User_Like_Dislike_Sauce` (
            `id` int(11) NOT NULL,
            `userId` int(11) NOT NULL,
            `kind` enum('LIKE','DISLIKE') NOT NULL,
            `sauceId` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            
        ALTER TABLE `User_Like_Dislike_Sauce`
            ADD PRIMARY KEY (`id`),
            ADD KEY `userId` (`userId`),
            ADD KEY `sauceId` (`sauceId`);
        
        ALTER TABLE `User_Like_Dislike_Sauce`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
            
        ALTER TABLE `User_Like_Dislike_Sauce`
            ADD CONSTRAINT `user_like_dislike_sauce_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `user_like_dislike_sauce_ibfk_2` FOREIGN KEY (`sauceId`) REFERENCES `Sauce` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        COMMIT;
    ");
echo "Done\n";

echo "Creating Success Table ...\n";
$success = new Success();
$success
    ->getRepository()
    ->customQuery("
        START TRANSACTION;
        
        CREATE TABLE `Success` (
            `id` int(11) NOT NULL,
            `name` varchar(64) NOT NULL,
            `description` varchar(512) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        ALTER TABLE `Success`
            ADD PRIMARY KEY (`id`);
            
        ALTER TABLE `Success`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
        COMMIT;
    ");
echo "Done\n";

file_put_contents('./Config/init.txt', 'OK');

echo "Script execution done.\n";
