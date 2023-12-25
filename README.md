## project structure:

    Root Folder
    ├── Accounts
    ├── Admin
    ├── assets
    │   ├── css
    │   ├── db
    │   │   ├── config.php
    │   │   ├── Database.php
    │   │   ├── db-config.php
    │   │   └── hms.sql
    │   ├── icons
    │   ├── images
    │   ├── js
    │   └── lib    
    ├── Authentication
    │   ├── AuthHandler.php
    ├── HostelSuper
    ├── index.php
    ├── Provost
    ├── Students
    ├── templates
    │   ├── accounts-menu.php
    │   ├── admin-menu.php
    │   ├── base.php
    │   ├── footer.php
    │   ├── hallsuper-menu.php
    │   ├── header.php
    │   ├── head-panel.php
    │   ├── left-panel.php
    │   ├── nav.php
    │   ├── provost-menu.php
    │   └── student-menu.php
    └── uploads

## Must include
In `assets/db` folder make config.php file with the given code below and fill up the necessary information based on your setup:

    <?php
    class DatabaseConfig {
        public static $host = '';
        public static $username = '';
        public static $password = '';
        public static $dbname = '';
    }


## Mail setup but doesn't work
`Authentication/SetupMail.php`

    <?php
    class MailSetup {
        public static $SMTP_HOST='smtp.example.com';
        public static $SMTP_PORT = 25;
        public static $SMTP_USERNAME = '';
        public static $SMTP_PASSWORD = '';
        public static $SMTP_ENCRYPTION='tls';
        public static $SMTP_FROM_ADDRESS='';
    }
