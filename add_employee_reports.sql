USE clock_system;

-- 0‑A  Users table (add UNIQUE email if missing and role enum)
ALTER TABLE users
    MODIFY email VARCHAR(160) UNIQUE,
    MODIFY role ENUM('founder','admin','head','employee') NOT NULL DEFAULT 'employee';

-- 0‑B  clock_entries already has project_id FK from previous module.

-- 0‑C  reports table (store generated PDFs if desired)
CREATE TABLE IF NOT EXISTS reports (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    period_from DATE NOT NULL,
    period_to   DATE NOT NULL,
    pdf_path    VARCHAR(255) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
