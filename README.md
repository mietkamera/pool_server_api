# pool_server_api
HTTP API for access of images and videos located on pool servers.

## Deployment

### Example htaccess File

'cat <<EOF >>
RedirectMatch 404 /\.git
RedirectMatch 404 /\.gitignore

RewriteEngine On

RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

Options -Indexes -MultiViews -Includes

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]

<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpg "access plus 1 year"
  ExpiresByType image/jpeg "access plus 1 year"
</IfModule>

<IfModule mod_headers.c>
  # Caching
  Header set Cache-Control "public"
  # X-Frame Embedding

  Header set X-Frame-Options SAMEORIGIN
  Header set X-Content-Type-Options nosniff
  Header always set Content-Security-Policy "frame-ancestors 'self' https://mietkamera.de https://rolix.de"

</IfModule>
EOF' 