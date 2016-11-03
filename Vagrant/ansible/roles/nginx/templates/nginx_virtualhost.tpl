server {
listen 80 default_server;
server_name fsd_dev.localhost;

return 301 https://192.168.11.3$request_uri;
}
