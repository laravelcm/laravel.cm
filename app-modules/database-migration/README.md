# Database Migration Module

This module provides comprehensive MySQL to PostgreSQL migration capabilities with SSH tunnel support, specifically designed for migrating data from remote MySQL databases to local PostgreSQL databases securely.

## Features

### SSH Tunnel Management
- **SSH Tunnel Creation**: Secure tunnels to remote MySQL databases
- **Status Monitoring**: Check tunnel connectivity and status
- **Auto-activation**: Optional automatic tunnel activation on application boot
- **Background Processing**: Queue-based tunnel creation for better performance

### Database Migration
- **Full Database Migration**: Migrate all tables from MySQL to PostgreSQL
- **Selective Migration**: Migrate specific tables only
- **Data Transformation**: Automatic data type conversion (MySQL → PostgreSQL)
- **Chunked Processing**: Process large datasets in configurable chunks
- **Progress Tracking**: Real-time migration progress with detailed output
- **Dry Run Mode**: Preview migration without actually transferring data
- **Verification**: Compare record counts between source and target databases

### Developer Experience
- **Artisan Commands**: Easy-to-use CLI commands for all operations
- **Exception Handling**: Custom exceptions for better error management
- **Facade Support**: Simple API access through Laravel facades
- **Comprehensive Testing**: Full test coverage with PestPHP
- **Detailed Logging**: Configurable logging for debugging and monitoring

## Installation

Since this module is integrated into the main Laravel.cm project, it's automatically available once the project is set up.

### Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=ssh-tunnel-config
```

Configure your environment variables in `.env`:

```env
# SSH Tunnel Configuration
SSH_TUNNEL_USER=your-ssh-user
SSH_TUNNEL_HOSTNAME=your-server.com
SSH_TUNNEL_LOCAL_PORT=3307
SSH_TUNNEL_BIND_PORT=3306
SSH_TUNNEL_BIND_ADDRESS=127.0.0.1

# Option 1: Utiliser un fichier de clé SSH (par défaut)
SSH_TUNNEL_IDENTITY_FILE=/path/to/your/private/key

# Option 2: Utiliser le contenu de la clé SSH via variable d'environnement (recommandé pour Docker)
SSH_TUNNEL_PRIVATE_KEY="-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAABG5vbmUAAAAEbm9uZQAAAAAAAAABAAAAFwAAAAdzc2gtcn
... (votre clé SSH privée complète ici) ...
-----END OPENSSH PRIVATE KEY-----"
SSH_TUNNEL_AUTO_ACTIVATE=false
SSH_TUNNEL_LOGGING_ENABLED=true
SSH_TUNNEL_LOGGING_CHANNEL=default

# Database Connections (already configured in config/database.php)
# Secondary connection points to MySQL via SSH tunnel
DB_HOST_SECOND=127.0.0.1
DB_PORT_SECOND=3307
DB_DATABASE_SECOND=your_mysql_database
DB_USERNAME_SECOND=your_mysql_user
DB_PASSWORD_SECOND=your_mysql_password
```

## Usage

### SSH Tunnel Management

#### Artisan Commands
```bash
# Activate the tunnel
php artisan ssh-tunnel:activate

# Check tunnel status
php artisan ssh-tunnel:activate --check

# Destroy the tunnel
php artisan ssh-tunnel:activate --destroy
```

### Database Migration

#### Full Migration
```bash
# Migrate all tables (dry run first to preview)
php artisan db:migrate-mysql-to-pgsql --dry-run

# Perform actual migration
php artisan db:migrate-mysql-to-pgsql
```

#### Selective Migration
```bash
# Migrate specific tables
php artisan db:migrate-mysql-to-pgsql --tables=users --tables=articles

# Custom chunk size for large tables
php artisan db:migrate-mysql-to-pgsql --chunk=500
```

#### Migration Options
- `--tables=table1,table2`: Migrate only specified tables
- `--chunk=1000`: Number of records to process per chunk (default: 1000)
- `--dry-run`: Preview migration without transferring data

### Programmatic Usage

#### SSH Tunnel Service
```php
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

$tunnelService = app(SshTunnelService::class);

// Activate tunnel
$status = $tunnelService->activate();

// Check if tunnel is active
$isActive = $tunnelService->isActive();

// Destroy tunnel
$destroyed = $tunnelService->destroy();
```

#### Database Migration Service
```php
use Laravelcm\DatabaseMigration\Services\DatabaseMigrationService;

$migrationService = app(DatabaseMigrationService::class);

// Get all source tables
$tables = $migrationService->getSourceTables();

// Migrate a specific table
$migrationService->migrateTable('users', 1000, function($processed, $total) {
    echo "Processed {$processed}/{$total} records\n";
});

// Verify migration
$verification = $migrationService->verifyMigration(['users', 'articles']);

// Test connections
$connectionStatus = $migrationService->testConnections();
```

#### Using Facades
```php
use Laravelcm\DatabaseMigration\Facades\SshTunnel;

// Activate tunnel
SshTunnel::activate();

// Check status
$isActive = SshTunnel::isActive();

// Destroy tunnel
SshTunnel::destroy();
```

#### Background Jobs
```php
use Laravelcm\DatabaseMigration\Jobs\CreateSshTunnel;

// Dispatch job to create tunnel in background
CreateSshTunnel::dispatch();
```

## Data Transformation

The migration service automatically handles common MySQL to PostgreSQL data transformations:

- **Boolean Fields**: MySQL tinyint(1) → PostgreSQL boolean
- **Empty Strings**: Empty strings → NULL (where appropriate)
- **Invalid Timestamps**: MySQL '0000-00-00 00:00:00' → NULL
- **Character Encoding**: Proper UTF-8 handling

## Testing

The module includes comprehensive tests using PestPHP with 16 test cases covering:

- SSH tunnel functionality
- Database migration operations
- Command-line interfaces
- Error handling scenarios

Run the module tests:

```bash
php artisan test app-modules/database-migration/tests
```

### Test Coverage
- **Unit Tests**: Service classes and core functionality
- **Feature Tests**: Artisan commands and integration scenarios
- **Mocking**: Proper isolation of external dependencies

## Configuration Options

All configuration options are available in `config/ssh-tunnel.php`:

### SSH Settings
- `ssh.user`: SSH username
- `ssh.hostname`: Remote server hostname
- `ssh.identity_file`: Path to SSH private key
- `ssh.local_port`: Local port for tunnel
- `ssh.bind_port`: Remote port to bind to
- `ssh.bind_address`: Bind address (usually 127.0.0.1)

### System Executables
- `executables.ssh`: Path to SSH binary
- `executables.ps`: Path to ps command
- `executables.grep`: Path to grep command
- `executables.awk`: Path to awk command

### Connection Settings
- `connection.max_tries`: Maximum connection retry attempts
- `connection.wait_microseconds`: Wait time between retries

### Logging
- `logging.enabled`: Enable/disable logging
- `logging.channel`: Laravel log channel to use

### Auto-activation
- `auto_activate`: Automatically activate tunnel on app boot

## Error Handling

The module includes comprehensive error handling:

### Custom Exceptions
- `SshTunnelException`: SSH tunnel-specific errors
- Detailed error messages with troubleshooting information
- Proper exception chaining and context

### Common Issues
1. **SSH Key Issues**: Ensure proper key permissions (600)
2. **Port Conflicts**: Check if local port is already in use
3. **Network Connectivity**: Verify SSH access to remote server
4. **Database Permissions**: Ensure proper MySQL user permissions

## Performance Considerations

- **Chunked Processing**: Large tables processed in configurable chunks
- **Memory Management**: Efficient memory usage for large datasets
- **Progress Tracking**: Real-time feedback for long-running operations
- **Connection Pooling**: Optimized database connection handling

## Security

- **SSH Key Authentication**: Secure key-based authentication
- **Encrypted Tunnels**: All data transfer through encrypted SSH tunnels
- **No Password Storage**: No database passwords in tunnel configuration
- **Audit Logging**: Comprehensive logging for security auditing

## Requirements

- PHP 8.4+
- Laravel 11+
- SSH client installed on the system
- Valid SSH key for remote server access
- PostgreSQL and MySQL PHP extensions
- Sufficient memory for large dataset processing

## Migration Workflow

1. **Setup**: Configure SSH tunnel and database connections
2. **Test**: Verify connections with `ssh-tunnel:activate --check`
3. **Preview**: Run migration with `--dry-run` flag
4. **Execute**: Perform actual migration
5. **Verify**: Check data integrity and record counts
6. **Cleanup**: Optionally destroy SSH tunnel
