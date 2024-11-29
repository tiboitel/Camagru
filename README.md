```
/camagru-web-app
│
├── /src                          # Core application files
│   ├── /assets                   # Frontend assets (images, fonts, etc.)
│   │   ├── /images               # Image resources (e.g., overlays, icons)
│   │   └── /styles               # Stylesheets (CSS/SCSS)
│   │       ├── main.css          # Main stylesheet (or main.scss if using SASS)
│   │       └── _variables.css    # Optional: Variables or config for themes
│   │
│   ├── /controllers              # PHP Controllers (handles routes and logic)
│   │   ├── UserController.php    # User registration, login, profile
│   │   ├── ImageController.php   # Image uploads, overlays, deletion
│   │   ├── CommentController.php # Handling comments on images
│   │   └── GalleryController.php # Gallery pagination and display
│   │
│   ├── /models                   # PHP Models (interact with the database)
│   │   ├── User.php              # User model
│   │   ├── Image.php             # Image model
│   │   ├── Comment.php           # Comment model
│   │   └── Like.php              # Like model
│   │
│   ├── /views                    # HTML templates or PHP Views
│   │   ├── layout.php            # Main layout (header, footer, common elements)
│   │   ├── home.php              # Homepage view
│   │   ├── gallery.php           # Image gallery view
│   │   ├── login.php             # Login page
│   │   ├── register.php          # Registration page
│   │   ├── profile.php           # User profile page
│   │   └── edit-image.php        # Image editing page (webcam preview)
│   │
│   ├── /public                   # Public assets served by the web server
│   │   ├── /uploads              # User-uploaded images
│   │   ├── /js                   # JavaScript files
│   │   │   ├── main.js           # Main JS file
│   │   │   └── gallery.js        # JS for image gallery interactions
│   │   ├── /css                  # CSS files (compiled version of /assets/styles)
│   │   └── /images               # Public images (logo, etc.)
│   │
│   └── /config                   # Configuration files
│       ├── config.php            # Global config (DB, app settings, etc.)
│       └── routes.php            # Application routes (routing logic)
│
├── /database                     # Database migrations and seeders
│   ├── migrations                # Database migration scripts
│   └── seeds                     # Database seeder scripts (e.g., initial data for dev)
│
├── /scripts                      # Scripts for project setup, deployment, etc.
│   ├── setup.sh                  # Setup script (initial environment setup)
│   └── deploy.sh                 # Deployment script (deploy to production)
│
├── /tests                        # Unit tests and integration tests
│   ├── /UserTest.php             # Test user-related functionality
│   ├── /ImageTest.php            # Test image upload/editing
│   ├── /CommentTest.php          # Test comment functionality
│   └── /GalleryTest.php          # Test gallery features
│
├── /docker                       # Docker-related files for containerization
│   ├── Dockerfile                # Dockerfile to build the PHP environment
│   ├── docker-compose.yml        # Docker Compose file to manage containers
│   └── .dockerignore             # Files and directories to ignore in the Docker container
│
├── /logs                         # Log files (errors, app logs)
│   └── app.log                   # Application logs
│
├── /node_modules                 # NPM modules (if using a build tool like Webpack)
│
├── .env                          # Environment variables (e.g., database credentials, app secrets)
├── .gitignore                    # Files and folders to ignore in Git
├── .dockerignore                 # Docker-specific ignored files
├── composer.json                 # PHP Composer dependencies
├── package.json                  # Node.js dependencies (if using build tools)
├── README.md                     # Project overview and documentation
└── index.php                     # Entry point for the PHP application (front controller)
``
