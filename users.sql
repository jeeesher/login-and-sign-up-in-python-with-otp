CREATE TABLE `users` (
  `Id` int(11) PRIMARY KEY NOT NULL,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `otp` int(50) DEFAULT NULL,
  `status` int(50) NOT NULL
);

ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;
