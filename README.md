Demo Phone Book App
by Peter S Gorgone

Download & Install:
1. $ git clone git@github.com:peltronic/phone-book.git
2. $ cd phone-book
3. $ mkdir -p storage/framework/{sessions,views,cache}; chmod -R 777 storage bootstrap/cache
4. $ touch database/database.sqlite
5. $ composer install
6. $ cp dot-env.txt .env
7. $ npm install
8. $ php artisan test --group=regression
9. $ php artisan migrate
10. $ php artisan db:seed
11. $ sh ./run-hot.sh

Navigate to http://127.0.0.1:8000/ to view the demo site

Notes:
* Current 'demo' implemenation only supports 'guest' access...that is there is no registration or login.
* Seeder script is included to populate the site with 'demo' data
* Country codes supported at this moment: US (+1), JP (+81), and UK (+44). These are hardcoded in a PHP-side data structure. Future implemenation would move these to a database table.
* The table is currently pagainated on client-side...to be truly scalable server-based pagination would need to be implemented.
* If a phone number in the create form starts with '+', the logic will try to match it with a known country code. If a match is found, it will format the number according to the country's number format. If no match is found, the phone number will be stored 'raw'. Note that even if formatted in the form, the server stores the 'raw' (digits-only) number, along with the country if detected. Output formatting is done using a Laravel model virtual attribute, although this can be done in the client side as well at render time.
* Multiple phone numbers per contact supported. Seeder populates some contacts with multiple numbers, however the UI currently does not support adding more than one number per contact.


