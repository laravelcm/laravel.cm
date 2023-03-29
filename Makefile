.PHONY: helpers
helpers:
	php artisan ide-helper:generate
	php artisan ide-helper:models -M
	php artisan ide-helper:meta

.PHONY: stan
stan:
	composer stan
