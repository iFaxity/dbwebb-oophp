--
-- Create scheme for database oophp.
-- By chnc16 for course oophp.
-- 2019-05-08
--

DROP TABLE IF EXISTS movies;
CREATE TABLE movies
(
    `id`    INT AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `year`  INT NOT NULL DEFAULT 1900,
    `image` VARCHAR(100) DEFAULT NULL,

    PRIMARY KEY(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


DELETE FROM movies;
INSERT INTO movies (`title`, `year`, `image`) VALUES
    ('Pulp fiction', 1994, 'pulp-fiction.jpg'),
    ('American Pie', 1999, 'american-pie.jpg'),
    ('Pokémon The Movie 2000', 1999, 'pokemon.jpg'),
    ('Kopps', 2003, 'kopps.jpg'),
    ('From Dusk Till Dawn', 1996, 'from-dusk-till-dawn.jpg')
;
