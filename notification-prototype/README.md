# Notification Prototype System

## Overview

This is a job posting and notification system prototype with three user types:

- **Admin** (Alice Admin - ID: 1) - Manages the system and gets notified of new job postings
- **Employer** (Bob Employer - ID: 2) - Posts jobs and manages applications
- **Jobseeker** (Charlie Jobseeker - ID: 3) - Views jobs, applies, and gets application updates

## Features

- User role-based dashboards
- Real-time notifications with polling (every 10 seconds)
- Notification bell icon with dropdown
- Easy user switching for testing
- Job posting and application management
- Automatic notifications for:
  - New job postings (sent to Admin + Jobseekers)
  - Application status updates (sent to specific Jobseeker)

## Quick Testing Workflow

### 1. Login as Employer → Post a Job

1. Go to: http://localhost/notification-prototype/public/
2. Click "Employer" in the user switcher (top right)
3. Click "Post New Job"
4. Enter a job title and submit
5. **Result**: Admin and Jobseeker get new job notifications

### 2. Login as Jobseeker → View Dashboard

1. Click "Jobseeker" in the user switcher
2. View the dashboard with available jobs
3. Apply to jobs using the "Apply" button
4. Check notifications by clicking the 🔔 bell icon
5. **Result**: Should see job posting notifications updating every 10s

### 3. Login as Employer → Update Applications

1. Click "Employer" in the user switcher
2. Click "Manage Applications"
3. If no applications exist, click "Create Sample Applications"
4. Change an application status (e.g., from "pending" to "reviewed")
5. Click "Update"
6. **Result**: The corresponding Jobseeker gets an "application_update" notification

### 4. Verify Notifications

1. Switch to "Jobseeker" user
2. Click the notification bell (🔔)
3. Should see the application update notification
4. Click on notifications to mark them as read
5. Notification count should decrease

## User Switching Links

- **Admin**: http://localhost/notification-prototype/public/?route=dashboard&switch_user=1
- **Employer**: http://localhost/notification-prototype/public/?route=dashboard&switch_user=2
- **Jobseeker**: http://localhost/notification-prototype/public/?route=dashboard&switch_user=3

## Database Schema

The system uses these main tables:

- `users` - User accounts with roles
- `jobs` - Job postings by employers
- `applications` - Job applications by jobseekers
- `notifications` - System notifications

## Technical Features

- **Real-time Updates**: JavaScript polling every 10 seconds
- **Notification System**: Bell icon with red badge count
- **Dropdown Interface**: Click bell to see notification history
- **Mark as Read**: Click notifications to mark them as read
- **Role-based Access**: Different interfaces for each user type
- **Easy Testing**: User switcher buttons for quick role changes

## Files Structure

```
public/
├── index.php          # Main entry point with routing
├── dashboard.php      # Role-based dashboard with notifications UI
├── jobs.php           # Job posting interface
├── applications.php   # Application management
└── api/
    ├── notifications.php     # API for fetching notifications
    └── read_notification.php # API for marking notifications as read

app/
├── models/
│   ├── User.php              # User data model
│   ├── Job.php               # Job data model
│   ├── Application.php       # Application data model
│   └── Notification.php      # Notification data model
├── controllers/
│   ├── JobController.php           # Job posting logic
│   ├── ApplicationController.php   # Application management
│   └── NotificationController.php  # Notification fetching
└── services/
    └── NotificationService.php     # Notification creation service
```

## Troubleshooting

1. **Database Connection Issues**: Check XAMPP MySQL is running
2. **Notifications Not Loading**: Check browser console for API errors
3. **Notifications Not Updating**: Verify polling is working (every 10s)
4. **Permission Issues**: Make sure you're using the correct user role

## API Endpoints

- `GET api/notifications.php` - Fetch user notifications
- `GET api/notifications.php?since=TIMESTAMP` - Fetch notifications since timestamp
- `POST api/read_notification.php` - Mark notification as read


mail queue system