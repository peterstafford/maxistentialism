init:
	composer install
	cd web/app/themes/maxistentialism-2019/; composer install; npm install

run:
	cd web/app/themes/maxistentialism-2019/; npm run watch

update:
	composer update
	cd web/app/themes/maxistentialism-2019/; composer update; npm install