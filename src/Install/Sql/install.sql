CREATE TABLE IF NOT EXISTS `PREFIX_ad_videoblock` (
    `id_ad_videoblock` int(11) NOT NULL AUTO_INCREMENT,
    `id_category` int(11) NOT NULL,
    `title` varchar(255) DEFAULT NULL,
    `subtitle` varchar(255) DEFAULT NULL,
    `url` varchar(255) NOT NULL,
    `description` varchar(255) DEFAULT NULL,
    `options` varchar(255) DEFAULT NULL,
    `fullscreen` tinyint(1) NOT NULL,
    `active` tinyint(1) NOT NULL,
    PRIMARY KEY  (`id_ad_videoblock`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
