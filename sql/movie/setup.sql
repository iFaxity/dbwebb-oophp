--
-- Setup database for database oophp.
-- By chnc16 for course oophp.
-- 2019-05-08
--

-- Skapa databasen.
-- Om den redan finns så återskapas den
DROP DATABASE IF EXISTS oophp;

CREATE DATABASE oophp;

-- Skapa en användare som vi kan använda
CREATE USER IF NOT EXISTS 'user'@'%'
  IDENTIFIED BY 'pass'
;

-- Ge användaren alla rättigheter på 'skolan'.
GRANT ALL PRIVILEGES
    ON skolan.*
    TO 'user'@'%'
;

-- Visa alla tillåtelse användaren har
SHOW GRANTS FOR 'user'@'%';
