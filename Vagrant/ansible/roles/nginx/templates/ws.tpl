description "Empire WebSocket Server"
author      "FSD"

# Events
start on startup
stop on shutdown

# Automatically respawn
respawn
respawn limit 20 5

# Run the script!
# Note, in this example, if your PHP script returns
# the string "ERROR", the daemon will stop itself.
script
[ $(exec php  -f /var/www/fsd_dev/app/console empire:websocket:socket-server --profile --env=prod ) = 'ERROR' ] && ( stop; exit 1; )
end script