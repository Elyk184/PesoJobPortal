-- Insert test data for document approvals testing

-- Insert test users (jobseekers) if needed
INSERT INTO users (name, email, password, role, is_approved, created_at, updated_at) VALUES
('John Doe', 'john.doe@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, NOW(), NOW()),
('Jane Smith', 'jane.smith@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, NOW(), NOW()),
('Mike Johnson', 'mike.johnson@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, NOW(), NOW()),
('Sarah Williams', 'sarah.williams@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, NOW(), NOW()),
('Alex Brown', 'alex.brown@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Get the peso_job_id for existing job (or create one if needed)
INSERT INTO peso_jobs (title, description, company_id, employment_type, salary_range, location, requirements, is_active, status, created_at, updated_at) VALUES
('Software Developer', 'We are looking for a skilled developer', 1, 'Full-time', '50000-70000', 'Manila', 'Degree in CS', 1, 'published', NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert job applications with pending status (these are the "documents" to approve)
INSERT INTO job_applications (user_id, peso_job_id, status, admin_status, created_at, updated_at) VALUES
(6, 1, 'pending', NULL, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(7, 1, 'pending', NULL, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(8, 1, 'pending', NULL, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
(9, 1, 'pending', NULL, NOW(), NOW()),
(10, 1, 'pending', NULL, NOW(), NOW());

-- Check the inserted records
SELECT 'Job Applications Inserted' AS status;
SELECT COUNT(*) as total_pending_applications FROM job_applications WHERE status = 'pending' AND admin_status IS NULL;
SELECT * FROM job_applications WHERE status = 'pending' AND admin_status IS NULL ORDER BY created_at DESC LIMIT 10;
