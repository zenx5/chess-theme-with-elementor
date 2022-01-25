CREATE TABLE IF NOT EXISTS 'boards' (
  'id' INT NOT NULL,
  'name' VARCHAR(45) NULL,
  'light_square' VARCHAR(45) NULL,
  'dark_square' VARCHAR(45) NULL,
  'width' VARCHAR(45) NULL,
  PRIMARY KEY ('id'),
  UNIQUE INDEX 'name_UNIQUE' ('name' ASC) VISIBLE)

CREATE TABLE IF NOT EXISTS 'moves' (
  'id' INT NOT NULL,
  'id_board' INT NULL,
  'moves' VARCHAR(45) NULL,
  'fen' VARCHAR(45) NULL,
  PRIMARY KEY ('id'),
  INDEX 'fk_board' ('id_board' ASC) VISIBLE,
  CONSTRAINT 'fk_moves_1'
    FOREIGN KEY ('id_board')
    REFERENCES 'mydb'.'boards' ('id')
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB