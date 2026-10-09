-- Run this once when upgrading the existing TFA2 pos_database.
-- The avatar field stores the generated image filename only.
USE pos_database;

ALTER TABLE users
    ADD COLUMN avatar VARCHAR(255) NULL DEFAULT NULL AFTER created_at;
