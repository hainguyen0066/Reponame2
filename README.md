### Make Symlink to Voyager assets directory:
```
cd public/voyager
ln -s ~/me/top2game/kiemtheweb/vendor/tcg/voyager/publishable/assets ./
```

### Use forked version of Voyager
```
composer install
rm -rf vendor/tcg/voyager
git clone git@github.com:trungtnm/voyager.git vendor/tcg/voyager
```

### Make change to assets while developing
Edit JS and SASS files in `vendor/tcg/voyager/resources/assets`, then compile them with
```
cd vendor/tcg/voyager/
npm install
npm run dev
# or
npm run watch
# or
npm run production
```

Symlink storage
`ln -s storage/app/public/ ./public/storage`
