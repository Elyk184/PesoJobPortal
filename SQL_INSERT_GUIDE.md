# SQL Test Data Insert Instructions

## Overview
This guide helps you insert test data to populate the analytics dashboard with approval data.

## Files Created
1. **insert_test_documents.sql** - Test data for job applications (documents)
2. **insert_test_lra_sra_jobs.sql** - Test data for LRA/SRA requests and job approvals

## How to Execute

### Option 1: Using MySQL Command Line
```bash
mysql -u root -p peso_job_portal < insert_test_documents.sql
mysql -u root -p peso_job_portal < insert_test_lra_sra_jobs.sql
```

### Option 2: Using phpMyAdmin
1. Go to your database in phpMyAdmin
2. Click on "SQL" tab
3. Copy and paste the SQL from either file
4. Click "Go"

### Option 3: Using Laravel Tinker (Recommended)
```bash
cd PESOJOBPORTAL
php artisan tinker
```

Then run the SQL files via MySQL directly from the project directory.

## Expected Data After Running Both Files

### Job Applications (Document Approvals)
- 5 pending applications created on different dates
- Status: pending, admin_status: NULL
- Ready for admin approval

### LRA/SRA Requests  
- 3 pending LRA/SRA requests
- Mix of LRA and SRA types
- Dates ranging from 5 days ago to today

### Pending Job Posts
- 2 job posts with status = 'pending'
- Need admin approval before publishing

## Analytics Chart Expectations

After inserting this data, your analytics chart should show:

**Stat Cards:**
- Pending Applications: 5
- Pending Job Approvals: 2
- LRA/SRA Requests: 3
- Pending Documents: (depends on document verification setup)

**Analytics Chart (by Period):**
- **Week View**: All 4 datasets (Applications, Job Approvals, LRA/SRA, Documents) visible with historical data
- **Month View**: Weekly aggregated data
- **Year View**: Monthly aggregated data
- **Day View**: Hourly breakdown for today

## Verification Queries

Run these to verify the data was inserted correctly:

```sql
-- Check pending applications
SELECT COUNT(*) as pending_applications 
FROM job_applications 
WHERE status = 'pending' AND admin_status IS NULL;

-- Check pending job posts
SELECT COUNT(*) as pending_jobs 
FROM peso_jobs 
WHERE status = 'pending';

-- Check pending LRA/SRA
SELECT COUNT(*) as pending_lra_sra 
FROM recruitment_activity_requests 
WHERE status = 'pending';

-- Full summary
SELECT 
    (SELECT COUNT(*) FROM job_applications WHERE status = 'pending' AND admin_status IS NULL) as applications,
    (SELECT COUNT(*) FROM peso_jobs WHERE status = 'pending') as jobs,
    (SELECT COUNT(*) FROM recruitment_activity_requests WHERE status = 'pending') as lra_sra;
```

## Cleanup (Remove Test Data)

If you want to remove the test data:

```sql
-- Delete test job applications
DELETE FROM job_applications 
WHERE user_id IN (6,7,8,9,10) 
AND status = 'pending' 
AND admin_status IS NULL;

-- Delete test pending jobs
DELETE FROM peso_jobs 
WHERE status = 'pending' 
AND title IN ('System Administrator', 'Business Analyst');

-- Delete test LRA/SRA requests
DELETE FROM recruitment_activity_requests 
WHERE status = 'pending' 
AND company_id IN (11, 12);

-- Delete test users
DELETE FROM users 
WHERE email IN (
    'john.doe@example.com',
    'jane.smith@example.com',
    'mike.johnson@example.com',
    'sarah.williams@example.com',
    'alex.brown@example.com',
    'contact@techcompany.com',
    'hr@globalservices.com'
);
```

## Notes

- The passwords are hashed with bcrypt (same default as Laravel)
- Dates are created with varying time intervals to test the date range filtering
- Make sure your database is properly seeded with at least one job post and company before running these scripts
- Adjust user_id and company_id values if they differ in your database

## Troubleshooting

**Error: "company_id does not exist"**
- Create a test company first or adjust the company_id to an existing one
- Run: `SELECT id FROM users WHERE role = 'employer' LIMIT 1;`

**Error: "Duplicate entry"**
- The data might already exist, use `ON DUPLICATE KEY UPDATE` clause (already included in scripts)

**Analytics still show 0**
- Clear your browser cache and hard refresh (Ctrl+Shift+R)
- Check if admin has access to the stats data
- Verify user_id and company_id exist in database

