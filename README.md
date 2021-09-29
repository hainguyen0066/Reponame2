##Symlink storage
`ln -s storage/app/public/ ./public/storage`

# Run
php artisan serve --host `ip`

# Kill process manual by port
`sudo kill -9 $(sudo lsof -t -i:8000)`