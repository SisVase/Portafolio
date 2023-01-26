ALTER TABLE support_tickets ADD COLUMN phone varchar(40) AFTER email;
DELETE FROM email_sms_templates WHERE act = 'EVER_CODE';
DELETE FROM email_sms_templates WHERE act = 'SVER_CODE'