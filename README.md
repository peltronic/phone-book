Demo Phone Book App
by Peter S Gorgone

Download & Install:
# $ git clone git@github.com:peltronic/phone-book.git
# $ touch database/database.sqlite
# $ composer install
# $ npm install
# $ php artisan test --group=regression
# $ php artisan migrate
# $ php artisan db:seed

Notes:
* Current 'demo' implemenation only supports 'guest' access...that is there is no registration or login.
* Country codes supported at this moment: US (+1), JP (+81), and UK (+44). These are hardcoded in a PHP-side data structure. Future implemenation would move these to a database table.
* The table is currently pagainated on client-side...to be truly scalable server-based pagination would need to be implemented.
* If a phone number in the create form starts with '+', the logic will try to match it with a known country code. If a match is found, it will format the number according to the country's number format. If no match is found, the phone number will be stored 'raw'. Note that even if formatted in the form, the server stores the 'raw' (digits-only) number, along with the country if detected. Output formatting is done using a Laravel model virtual attribute, although this can be done in the client side as well at render time.

