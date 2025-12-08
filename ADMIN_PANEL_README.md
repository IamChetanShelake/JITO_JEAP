# JitoJeap Admin Panel Implementation

This document describes the admin panel implementation with separate database configuration for the JitoJeap project.

## Overview

The admin panel has been implemented with a modern, professional UI using the following color scheme:
- Primary Purple: #393185
- Red: #E31E24
- Green: #009846
- Yellow: #FBBA00
- White and Black

## Features Implemented

### 1. Separate Database Configuration

The admin panel uses a separate database connection:
- **Frontend Database**: `jitojeap`
- **Admin Panel Database**: `jitojeap_adminpanel_db`

### 2. Admin Panel Sections

#### Zone Registration
- Create, Read, Update, Delete (CRUD) operations
- Fields: Zone Name, Zone Code, State, Region, Description, Status
- List view with active/inactive status
- Detail view showing associated chapters

#### Chapter Registration
- Create, Read, Update, Delete (CRUD) operations
- Fields: Chapter Name, Chapter Code, Zone (relationship), City, District, President Name, Contact Email, Contact Phone, Description, Status
- List view with zone relationship display
- Detail view showing complete chapter information

### 3. Dashboard
- Statistics cards showing:
  - Total Zones
  - Total Chapters
  - Active Zones
  - Active Chapters
- Quick Actions for easy navigation
- Recent Zones listing

### 4. Authentication & Authorization
- Login functionality (using existing Laravel Auth)
- Logout functionality
- Admin middleware protection for all admin routes
- Proper routing structure

## Database Setup

### Environment Configuration

Add the following to your `.env` file:

```env
# Main Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jitojeap
DB_USERNAME=root
DB_PASSWORD=

# Admin Panel Database
ADMIN_DB_HOST=127.0.0.1
ADMIN_DB_PORT=3306
ADMIN_DB_DATABASE=jitojeap_adminpanel_db
ADMIN_DB_USERNAME=root
ADMIN_DB_PASSWORD=
```

### Running Migrations

1. Create both databases in MySQL:
```sql
CREATE DATABASE jitojeap;
CREATE DATABASE jitojeap_adminpanel_db;
```

2. Run migrations for the main database:
```bash
php artisan migrate
```

3. Run migrations for the admin panel database:
```bash
php artisan migrate --database=admin_panel
```

## File Structure

```
JitoJeap-main/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ZoneController.php
│   │       └── ChapterController.php
│   └── Models/
│       ├── Zone.php
│       └── Chapter.php
├── database/
│   └── migrations/
│       ├── 2025_12_01_120000_create_zones_table.php
│       └── 2025_12_01_120001_create_chapters_table.php
├── resources/
│   └── views/
│       └── admin/
│           ├── layouts/
│           │   └── master.blade.php
│           ├── zones/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   ├── edit.blade.php
│           │   └── show.blade.php
│           ├── chapters/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   ├── edit.blade.php
│           │   └── show.blade.php
│           └── home.blade.php
└── routes/
    └── web.php
```

## Routes

All admin routes are protected by `auth` and `admin` middleware:

```
GET    /admin/home                    - Admin Dashboard
GET    /admin/zones                   - List all zones
GET    /admin/zones/create            - Show create zone form
POST   /admin/zones                   - Store new zone
GET    /admin/zones/{zone}            - Show zone details
GET    /admin/zones/{zone}/edit       - Show edit zone form
PUT    /admin/zones/{zone}            - Update zone
DELETE /admin/zones/{zone}            - Delete zone
GET    /admin/chapters                - List all chapters
GET    /admin/chapters/create         - Show create chapter form
POST   /admin/chapters                - Store new chapter
GET    /admin/chapters/{chapter}      - Show chapter details
GET    /admin/chapters/{chapter}/edit - Show edit chapter form
PUT    /admin/chapters/{chapter}      - Update chapter
DELETE /admin/chapters/{chapter}      - Delete chapter
```

## UI Features

### Collapsible Sidebar
- Starts in collapsed state (70px width)
- Expands on hover (280px width)
- Can be toggled to stay expanded
- Smooth animations with cubic-bezier transitions

### Color Coded Elements
- Purple (#393185): Primary actions, sidebar, headers
- Red (#E31E24): Delete/Cancel actions
- Green (#009846): Success messages, create actions
- Yellow (#FBBA00): Warning, highlights, active states

### Responsive Design
- Mobile-friendly layout
- Bootstrap 5 grid system
- Adaptive sidebar for smaller screens

### Modern UI Elements
- Gradient backgrounds
- Card hover effects with elevation
- Smooth transitions and animations
- Font Awesome icons throughout
- Status badges (Active/Inactive)

## Models Configuration

Both `Zone` and `Chapter` models use the `admin_panel` database connection:

```php
protected $connection = 'admin_panel';
```

### Zone Model
- Relationships: hasMany Chapters
- Fillable: zone_name, zone_code, description, state, region, status
- Casts: status as boolean

### Chapter Model
- Relationships: belongsTo Zone
- Fillable: zone_id, chapter_name, chapter_code, description, city, district, president_name, contact_email, contact_phone, status
- Casts: status as boolean

## Next Steps

The following sections are marked as static for now and will be modified later:
- Zone validation rules can be enhanced
- Chapter validation rules can be enhanced
- Additional admin features can be added as needed

## Notes

- All forms include CSRF protection
- Form validation is implemented in controllers
- Success/error messages are displayed using session flash messages
- Confirmation dialogs for delete operations
- Proper error handling with invalid-feedback classes
