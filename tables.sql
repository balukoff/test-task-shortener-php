create database short;
CREATE TABLE IF NOT EXISTS short_url (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  wide_url VARCHAR(255) NOT NULL,
  short_url VARBINARY(20) NOT NULL,
  date_added INTEGER UNSIGNED NOT NULL,
  counter INTEGER UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY short_url (short_url)
)
ENGINE=InnoDB;