# Loan Category Conditional Logic Implementation Summary

## Overview

This document summarizes the changes made to implement conditional logic based on loan category selection. When a user selects a loan category below ₹1,00,000 (1 Lakh), the application workflow is streamlined by skipping certain steps and hiding specific fields.

## Changes Made

### 1. UserController.php (`app/Http/Controllers/UserController.php`)

#### Modified `index()` method (lines 34-84)

- Added logic to check if loan category is below 1 lakh (`$isBelowOneLakh`)
- Modified step progression to skip Guarantor Details (Step 5) for below 1 lakh loans
- Guarantor details check is now conditional: only required if `$isBelowOneLakh` is false

#### Modified `step4()` method (lines 1330-1390)

- Added `$isBelowOneLakh` variable to determine loan category
- Passed `$isBelowOneLakh` to the view for conditional rendering

#### Modified `step4store()` method (lines 1396-1575)

- Added conditional validation rules based on loan category
- For below 1 lakh loans: only bank details are required
- For above 1 lakh loans: funding details table and sibling assistance are also required
- Modified data array construction to only save funding/sibling data for above 1 lakh loans
- Changed redirect logic: below 1 lakh loans go to step6, above 1 lakh loans go to step5

#### Modified `step5()` method (lines 1852-1880)

- Added check for below 1 lakh loans at the beginning
- If loan is below 1 lakh:
    - Auto-creates a GuarantorDetail record with `submit_status = 'skipped'` and `status = 'step5_skipped'`
    - Redirects directly to step6 (Document Upload)
- This effectively bypasses the entire Guarantor Details step for below 1 lakh loans

### 2. step1.blade.php (`resources/views/user/step1.blade.php`)

#### Modified Financial Asset Type dropdown (lines 58-94)

- Added conditional check: `@if ($type !== 'below')`
- "Foreign Financial Assistance" option is now hidden for below 1 lakh loans
- Only "Domestic" option is available for below 1 lakh loans
- This ensures Financial Asset Type is restricted to Domestic only for low loan categories

### 3. step4.blade.php (`resources/views/user/step4.blade.php`)

#### Modified Financial Asset Type dropdown (lines 164-200)

- Wrapped the entire dropdown section in `@if (!$isBelowOneLakh)` condition
- Financial Asset Type and Financial Asset For dropdowns are hidden for below 1 lakh loans
- These fields are auto-set to "Domestic" and "Graduation/Post Graduation" from step1

#### Modified Funding Details Table (lines 260-453)

- Wrapped the entire Funding Details Table section in `@if (!$isBelowOneLakh)` condition
- For below 1 lakh loans, the entire funding sources table is hidden
- This includes: Own family funding, Bank Loan, Other Assistance (1 & 2), Local Assistance

#### Modified Sibling Assistance Section (lines 458-578)

- Wrapped the entire Sibling Assistance section in `@if (!$isBelowOneLakh)` condition
- For below 1 lakh loans, sibling assistance questions are hidden
- This includes: Yes/No dropdown, sibling name, NGO details, loan status, etc.

#### Bank Details Section (lines 586+)

- Bank Details section remains visible for all loan categories
- This is the only required section for below 1 lakh loans in Step 4

### 4. step7.blade.php (`resources/views/user/step7.blade.php`)

#### Added Loan Category Detection (lines 14-18)

- Added PHP code to detect loan category type
- `$isBelowOneLakh` variable is set based on `loan_categories` table
- Used for conditional rendering of submission messages

#### Modified Submission Condition (lines 264-271)

- Changed guarantor detail check to accept both `'submited'` and `'skipped'` status
- Original condition: `$user->guarantorDetail->submit_status == 'submited'`
- New condition: `in_array($user->guarantorDetail->submit_status, ['submited', 'skipped'])`
- This allows below 1 lakh loans to be submitted even though guarantor step was skipped

#### Modified Modal Warning Message (lines 309-318)

- Added conditional message based on loan category
- Below 1 lakh: "Please submit all 5 steps first"
- Above 1 lakh: "Please submit all 6 steps first"
- Provides accurate feedback to users based on their loan category

### 5. master.blade.php (`resources/views/user/layout/master.blade.php`)

#### Added Loan Category Detection (lines 568-571)

- Added PHP code to detect loan category type in sidebar
- `$isBelowOneLakh` variable is set based on `loan_categories` table
- Used for conditional rendering of sidebar steps

#### Modified Step 5 (Guarantor Details) Sidebar Item (lines 710-737)

- Wrapped entire Step 5 sidebar item in `@if (!$isBelowOneLakh)` condition
- Step 5 is completely hidden from sidebar for below 1 lakh loans
- This provides a cleaner UI experience for users with below 1 lakh loans

#### Modified Step 6 (Documents Upload) Sidebar Item (lines 739-766)

- Updated step number to be conditional: `{{ $isBelowOneLakh ? 'Step 5' : 'Step 6' }}`
- Shows "Step 5" for below 1 lakh loans
- Shows "Step 6" for above 1 lakh loans
- Maintains correct numbering based on visible steps

#### Modified Step 7 (Review & Submit) Sidebar Item (lines 768-815)

- Updated step number to be conditional: `{{ $isBelowOneLakh ? 'Step 6' : 'Step 7' }}`
- Shows "Step 6" for below 1 lakh loans
- Shows "Step 7" for above 1 lakh loans
- Maintains correct numbering based on visible steps

## Workflow Changes

### For Loans Below ₹1,00,000:

1. **Step 1**: Personal Details - Financial Asset Type restricted to "Domestic" only
2. **Step 2**: Education Details - Standard flow
3. **Step 3**: Family Details - Standard flow
4. **Step 4**: Funding Details - **Streamlined**
    - Only Bank Details section is shown
    - Funding Details Table is hidden
    - Sibling Assistance section is hidden
    - Financial Asset Type dropdown is hidden
5. **Step 5**: Guarantor Details - **SKIPPED**
    - Auto-creates skipped record in database
    - Redirects directly to Step 6
6. **Step 6**: Document Upload - Standard flow
7. **Step 7**: Review & Submit - Standard flow
8. **Step 8**: PDC Details - Standard flow

### For Loans Above ₹1,00,000:

- All steps remain unchanged
- Full workflow with all sections and validations

## Database Changes

### GuarantorDetail Table

- New status values added: `'skipped'` for `submit_status`, `'step5_skipped'` for `status`
- These values indicate that the guarantor step was intentionally skipped for below 1 lakh loans

## Validation Changes

### Step 4 Validation

- **Below 1 Lakh**: Only bank details are validated
- **Above 1 Lakh**: Bank details + funding table + sibling assistance are validated

### Step 5 Validation

- **Below 1 Lakh**: Step is bypassed, no validation
- **Above 1 Lakh**: Full guarantor details validation

## Key Benefits

1. **Simplified User Experience**: Users applying for smaller loans have a shorter, simpler application process
2. **Reduced Documentation**: Less information required for below 1 lakh loans
3. **Faster Processing**: Fewer steps mean quicker application completion
4. **Maintained Data Integrity**: Guarantor records are still created with skipped status for consistency
5. **Flexible Architecture**: Conditional logic is cleanly separated and maintainable

## Testing Recommendations

1. Test application flow for below 1 lakh loan category
2. Verify that guarantor step is skipped and redirects to step6
3. Confirm that funding details table and sibling assistance are hidden in step4
4. Validate that only bank details are required for below 1 lakh loans
5. Test that foreign financial assistance option is not available in step1
6. Verify that above 1 lakh loans still follow the complete workflow
7. Check database records to ensure guarantor details have 'skipped' status

## Files Modified

1. `app/Http/Controllers/UserController.php`
2. `resources/views/user/step1.blade.php`
3. `resources/views/user/step4.blade.php`
4. `resources/views/user/step7.blade.php`
5. `resources/views/user/layout/master.blade.php`

## Notes

- The implementation maintains backward compatibility with existing applications
- No database migrations were required (using existing fields with new values)
- The conditional logic is based on the `type` field in the `loan_categories` table where `type === 'below'` indicates below 1 lakh loans
- All changes are non-destructive and can be easily reverted if needed
