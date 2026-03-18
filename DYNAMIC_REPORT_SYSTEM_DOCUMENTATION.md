# Dynamic Report System - Documentation

## Overview

The Dynamic Report System is an Excel-style reporting solution that allows administrators to generate custom reports by selecting specific fields from the database. Instead of creating hundreds of fixed reports, users can dynamically choose which fields they want to include in their reports.

## Features

### 1. **Dynamic Field Selection**
- Choose from ~50+ available fields across multiple categories
- Fields are organized by category (Student Information, Family Details, Education Details, etc.)
- Click to select/deselect fields
- Visual feedback for selected fields

### 2. **Predefined Reports**
- 10 built-in predefined reports for common use cases:
  - Student Summary
  - Payment Summary
  - Chapter Report
  - Family Details Report
  - Education Details Report
  - Workflow Status Report
  - 15-Day Report
  - Monthly Report
  - Complete Student Profile
  - Disbursement Report

### 3. **Custom Report Templates**
- Save your field selections as templates
- Load existing templates to modify or reuse
- Delete custom templates (predefined reports cannot be deleted)
- Organize templates by category (Student, Payment, Donor, Chapter, Other)

### 4. **Advanced Filtering**
- Add multiple filters to narrow down report data
- Support for various operators: Equals, Not Equals, Contains, Greater Than, Less Than
- Apply filters to any selected field

### 5. **Excel Export**
- Generate professional Excel reports with:
  - Styled headers (blue background, white text)
  - Auto-sized columns
  - Alternate row coloring
  - Frozen header row
  - Proper date formatting (DD-MM-YYYY)
  - Currency formatting for financial fields

## Database Schema

### Table: `report_templates`

```sql
CREATE TABLE report_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    selected_fields JSON NOT NULL,
    filters JSON NULL,
    is_predefined TINYINT(1) DEFAULT 0,
    category VARCHAR(255) NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
);
```

**Fields:**
- `name`: Template name
- `description`: Optional description of the template
- `selected_fields`: JSON array of selected field keys
- `filters`: JSON array of filter conditions
- `is_predefined`: Boolean flag (1 = predefined, 0 = custom)
- `category`: Category for organization (student, payment, donor, chapter, other)
- `created_by`: Admin user ID who created the template
- `deleted_at`: Soft delete timestamp

## Available Fields

### Student Information
- ID, Student Name, Email, Mobile, Application Number
- Date of Birth, Gender, Religion, Caste, Sub Caste
- Aadhaar Number, PAN Number, Address, City, State, Pincode
- Postal Address, Application Status, Created At, Updated At

### Family Details
- Father Name, Father Mobile, Father Occupation, Father Annual Income
- Mother Name, Mother Mobile, Mother Occupation, Mother Annual Income
- Total Family Members, Annual Family Income

### Education Details
- Course Name, Course Type, Institution Name, University Name
- Start Year, Expected Year, Course Duration
- Tuition Fee, Hostel Fee, Total Fee, SGPA, Percentage

### Funding Details
- Loan Amount Requested, Loan Category, Funds Arranged
- Funds Source, Scholarship Amount

### Workflow Status
- Current Stage, Workflow Status, Final Status, Assistance Amount

### PDC Details
- Courier Receive Status, Courier Receive Date, Hold Remark

### Approval Details
- Meeting No, Disbursement System, Approved Amount

### Chapter Details
- Chapter Name, Zone

## API Endpoints

### 1. Get Report Index Page
```
GET /admin/reports
```
Returns the dynamic report builder page with predefined and custom reports.

### 2. Get Available Fields
```
GET /admin/reports/fields
```
Returns JSON of all available fields organized by category.

**Response:**
```json
{
    "Student Information": {
        "name": "Student Name",
        "mobile": "Mobile",
        ...
    },
    "Family Details": {
        "family.father_name": "Father Name",
        ...
    }
}
```

### 3. Generate Dynamic Report
```
POST /admin/reports/generate
```
Generates and downloads an Excel report based on selected fields and filters.

**Request Body:**
```json
{
    "selected_fields": ["name", "mobile", "education.course_name"],
    "filters": [
        {
            "field": "application_status",
            "operator": "=",
            "value": "Approved"
        }
    ]
}
```

### 4. Save Report Template
```
POST /admin/reports/templates
```
Saves a new report template.

**Request Body:**
```json
{
    "name": "My Custom Report",
    "description": "Report for monthly review",
    "category": "student",
    "selected_fields": ["name", "mobile", "education.course_name"],
    "filters": []
}
```

### 5. Load Report Template
```
GET /admin/reports/templates/{id}
```
Loads a specific report template.

**Response:**
```json
{
    "success": true,
    "template": {
        "id": 1,
        "name": "Student Summary",
        "selected_fields": [...],
        "filters": [...]
    }
}
```

### 6. Export from Template
```
GET /admin/reports/templates/{id}/export
```
Generates and downloads an Excel report from a saved template.

### 7. Delete Report Template
```
DELETE /admin/reports/templates/{id}
```
Deletes a custom report template (predefined reports cannot be deleted).

## User Interface

### Report Builder Layout

**Left Panel - Available Fields:**
- Scrollable list of all available fields
- Organized by category with section headers
- Click to select/deselect fields
- Visual indicators for selected fields (green background)

**Right Panel - Selected Fields:**
- Shows currently selected fields
- Remove individual fields with X button
- Clear All button to reset selection
- Generate Report button (disabled until fields selected)
- Save Template button (disabled until fields selected)

**Filters Section:**
- Add Filter button to create new filter
- Each filter has:
  - Field dropdown (populated with selected fields)
  - Operator dropdown (=, !=, like, >, <)
  - Value input field
  - Remove button

### Predefined Reports Section
- Displays all predefined reports as cards
- Each card shows:
  - Report name
  - Description
  - Export button

### Custom Reports Section
- Displays all saved custom reports as cards
- Each card shows:
  - Report name
  - Description
  - Export button
  - Load button (to edit)
  - Delete button

## Usage Examples

### Example 1: Create a Simple Student Report

1. Navigate to `/admin/reports`
2. In the left panel, click on:
   - Student Name
   - Mobile
   - Application Number
   - Course Name
3. Click "Generate Report"
4. Excel file downloads with selected data

### Example 2: Create a Filtered Payment Report

1. Navigate to `/admin/reports`
2. Select fields:
   - Student Name
   - Application Number
   - Loan Amount Requested
   - Approved Amount
3. Click "Add Filter"
4. Set filter:
   - Field: Approved Amount
   - Operator: Greater Than
   - Value: 100000
5. Click "Generate Report"
6. Excel file downloads with filtered data

### Example 3: Save and Reuse a Template

1. Create a report with your desired fields
2. Click "Save Template"
3. Enter template details:
   - Name: "Monthly Student Report"
   - Description: "Report for monthly board meeting"
   - Category: "student"
4. Click "Save Template"
5. Template appears in "Saved Custom Reports" section
6. Later, click "Load" to reuse or "Export" to generate report

### Example 4: Use a Predefined Report

1. Navigate to `/admin/reports`
2. Find "Student Summary" in Predefined Reports section
3. Click "Export"
4. Excel file downloads with predefined fields

## Technical Implementation

### Model: `ReportTemplate`
- Connection: `admin_panel`
- Uses soft deletes
- JSON casting for `selected_fields` and `filters`
- Scopes: `predefined()`, `custom()`, `byCategory()`

### Export Class: `DynamicReportExport`
- Implements Laravel Excel interfaces:
  - `FromCollection`
  - `WithHeadings`
  - `WithMapping`
  - `WithStyles`
- Dynamic query building based on selected fields
- Automatic relationship eager loading
- Filter application support
- Professional Excel styling

### Controller: `ReportController`
- Methods:
  - `index()` - Display report builder
  - `getAvailableFields()` - Return field definitions
  - `generateDynamicReport()` - Generate and export report
  - `saveTemplate()` - Save new template
  - `loadTemplate()` - Load existing template
  - `exportFromTemplate()` - Export from template
  - `deleteTemplate()` - Delete custom template
  - `jeapDisbursement()` - Existing JEAP disbursement report

## File Structure

```
app/
├── Exports/
│   ├── DynamicReportExport.php      # Dynamic report export class
│   └── JeapDisbursementReportExport.php
├── Http/Controllers/
│   └── ReportController.php          # Report controller
└── Models/
    └── ReportTemplate.php            # Report template model

database/
├── migrations/
│   └── 2026_03_12_000001_create_report_templates_table.php
└── seeders/
    └── ReportTemplateSeeder.php      # Predefined reports seeder

resources/views/admin/reports/
└── index.blade.php                   # Report builder UI

routes/
└── web.php                           # Report routes
```

## Security Considerations

1. **Authentication**: All report routes are protected by admin middleware
2. **Authorization**: Only authenticated admin users can access reports
3. **Input Validation**: All inputs are validated before processing
4. **SQL Injection Prevention**: Uses Laravel's Eloquent ORM with parameter binding
5. **CSRF Protection**: All forms include CSRF tokens

## Performance Optimization

1. **Eager Loading**: Relationships are loaded based on selected fields to prevent N+1 queries
2. **Query Optimization**: Only selected fields are queried from database
3. **Indexing**: Consider adding indexes to frequently filtered columns
4. **Pagination**: For large datasets, consider adding pagination support

## Future Enhancements

1. **Scheduled Reports**: Auto-generate and email reports on schedule
2. **Report Sharing**: Share reports with other admin users
3. **Chart Generation**: Visual charts/graphs from report data
4. **PDF Export**: Additional PDF export option
5. **Advanced Filters**: Date range filters, multi-select filters
6. **Report History**: Track when reports were generated and by whom
7. **Custom Calculations**: Add calculated fields to reports
8. **Data Visualization**: Dashboard with key metrics

## Troubleshooting

### Issue: Report generation is slow
**Solution**: 
- Reduce number of selected fields
- Add filters to limit data
- Consider adding database indexes

### Issue: Excel file doesn't download
**Solution**:
- Check browser popup blocker settings
- Verify Laravel Excel package is properly installed
- Check file permissions in storage directory

### Issue: Fields not showing data
**Solution**:
- Verify field names match database columns
- Check relationships are properly defined
- Ensure data exists in related tables

### Issue: Template not saving
**Solution**:
- Check database connection to `admin_panel`
- Verify `report_templates` table exists
- Check user has write permissions

## Support

For issues or questions about the Dynamic Report System:
1. Check this documentation
2. Review Laravel Excel documentation
3. Check application logs in `storage/logs/laravel.log`
4. Contact development team

## Version History

- **v1.0.0** (2026-03-12): Initial release
  - Dynamic field selection
  - Predefined reports
  - Custom templates
  - Excel export
  - Basic filtering