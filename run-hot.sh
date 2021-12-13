#!/bin/bash

# Ref: https://stackoverflow.com/a/2173421
trap "trap - SIGTERM && kill -- -$$" SIGINT SIGTERM EXIT

# Start Laravel
php artisan serve & \

# Start webpack
npm run hot

return 0
