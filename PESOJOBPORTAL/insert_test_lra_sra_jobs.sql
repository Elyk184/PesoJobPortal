-- Insert test data for LRA/SRA and Job Approvals

-- Insert test employers if needed
INSERT INTO users (name, email, password, role, is_approved, created_at, updated_at) VALUES
('Tech Company Inc', 'contact@techcompany.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'employer', 1, NOW(), NOW()),
('Global Services Ltd', 'hr@globalservices.com', '$2y$12$Kh7BwIZCJQw8j/VLqJZ1WeYfWL8QRDczjR9l0NkgSLHVJQbFLLVIG', 'employer', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert pending job posts (these need approval)
INSERT INTO peso_jobs (title, description, company_id, employment_type, salary_range, location, requirements, is_active, status, created_at, updated_at) VALUES
('System Administrator', 'Manage company IT infrastructure', 11, 'Full-time', '45000-65000', 'Makati', 'Networking knowledge required', 1, 'pending', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
('Business Analyst', 'Analyze and improve business processes', 12, 'Full-time', '55000-75000', 'BGC', 'Data analysis skills', 1, 'pending', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY))
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Insert LRA/SRA requests (Recruitment Activity Requests)
INSERT INTO recruitment_activity_requests (company_id, activity_type, requested_date, status, created_at, updated_at) VALUES
(11, 'LRA', NOW(), 'pending', DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY)),
(11, 'SRA', NOW(), 'pending', DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(12, 'LRA', NOW(), 'pending', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY))
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Verify the data
SELECT 'LRA/SRA Requests' AS data_type, COUNT(*) as count FROM recruitment_activity_requests WHERE status = 'pending'
UNION ALL
SELECT 'Pending Job Posts', COUNT(*) FROM peso_jobs WHERE status = 'pending'
UNION ALL
SELECT 'Pending Applications', COUNT(*) FROM job_applications WHERE status = 'pending' AND admin_status IS NULL;

-- Show details
SELECT 'Pending Job Posts' as type, title as details, created_at FROM peso_jobs WHERE status = 'pending'
UNION ALL
SELECT 'LRA/SRA Requests', activity_type, created_at FROM recruitment_activity_requests WHERE status = 'pending'
ORDER BY created_at DESC;
