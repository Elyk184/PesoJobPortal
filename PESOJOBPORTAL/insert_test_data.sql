-- Test Data Insert for Analytics Dashboard
-- Insert test jobseeker users
INSERT INTO users (name, email, password, role, is_approved, created_at, updated_at) VALUES
('John Doe', 'john.doe@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
('Jane Smith', 'jane.smith@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
('Mike Johnson', 'mike.johnson@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
('Sarah Williams', 'sarah.williams@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
('Alex Brown', 'alex.brown@example.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'jobseeker', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert test job applications (pending approval)
INSERT INTO job_applications (user_id, peso_job_id, status, admin_status, created_at, updated_at) VALUES
(4, 1, 'pending', NULL, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(5, 1, 'pending', NULL, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(6, 2, 'pending', NULL, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
(7, 2, 'pending', NULL, NOW(), NOW()),
(8, 3, 'pending', NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert test employers
INSERT INTO users (name, email, password, role, is_approved, created_at, updated_at) VALUES
('Tech Company Inc', 'contact@techcompany.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'employer', 1, NOW(), NOW()),
('Global Services Ltd', 'hr@globalservices.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'employer', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert pending job posts
INSERT INTO peso_jobs (employer_id, title, description, location, job_type, vacancies, salary_range, requirements, status, created_at, updated_at) VALUES
(9, 'System Administrator', 'Manage company IT infrastructure', 'Makati', 'full_time', 2, '45000-65000', 'Networking knowledge required', 'pending', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(10, 'Business Analyst', 'Analyze and improve business processes', 'BGC', 'full_time', 1, '55000-75000', 'Data analysis skills', 'pending', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY))
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert LRA/SRA requests (pending approval)
INSERT INTO recruitment_activity_requests (employer_id, activity_type, letter_of_intent_path, company_profile_path, status, created_at, updated_at) VALUES
(9, 'lra', 'files/loi1.pdf', 'files/cp1.pdf', 'pending', DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY)),
(9, 'sra', 'files/loi2.pdf', 'files/cp1.pdf', 'pending', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(10, 'lra', 'files/loi3.pdf', 'files/cp2.pdf', 'pending', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY))
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Verification Query
SELECT
    (SELECT COUNT(*) FROM job_applications WHERE status = 'pending' AND admin_status IS NULL) as pending_applications,
    (SELECT COUNT(*) FROM peso_jobs WHERE status = 'pending') as pending_jobs,
    (SELECT COUNT(*) FROM recruitment_activity_requests WHERE status = 'pending') as pending_lra_sra;
