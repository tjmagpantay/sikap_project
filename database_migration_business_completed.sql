-- Add business_completed column to employers_business table
-- This column will track whether a business profile is fully completed

ALTER TABLE employers_business 
ADD COLUMN business_completed TINYINT(1) DEFAULT 0 
COMMENT 'Indicates if the business profile is completed (1) or not (0)';

-- Update existing records - set business_completed to 1 if essential fields are filled
UPDATE employers_business 
SET business_completed = 1 
WHERE business_name IS NOT NULL 
  AND business_desc IS NOT NULL 
  AND business_type IS NOT NULL 
  AND business_industry IS NOT NULL 
  AND business_address IS NOT NULL 
  AND business_contact IS NOT NULL 
  AND business_size IS NOT NULL 
  AND business_established_year IS NOT NULL;

-- Note: After running this migration, restart your application
-- so that the business completion status is properly updated 
-- for all existing employers.
