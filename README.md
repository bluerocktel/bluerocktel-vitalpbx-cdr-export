# BlueRockTEL VitalPBX Cdr export

[VitalPBX](https://vitalpbx.org/en/free-pbx-system-based-on-asterisk-about-us/#) is a Free PBX System Based on Asterix. This script exports CDR files from a VitalPBX server to a FTP server on a daily basis.

## License

This script is released under the MIT license.
See the bundled LICENSE file for details.

## Installation

Laravel 6 application.

* Clone or download this repository to your server.
* Run ```composer install```
* Copy file .env.example to .env
* Open .env and enter your database and FTP settings right
* Run the migrations ```php artisan migrate```
* Add this line to your crontab : ```* * * * * php {pathToTheApp}/artisan schedule:run```
* Register and login to the interface, enter your Ovh settings
                               
## Author

[BlueRockTEL](https://bluerocktel.com)

The context of the subscription economy and the increasing convergence between Telecom and Cloud services brings new ways of approaching customers, selling to them, serving and charging them. BlueRockTEL is your [complete CRM and billing solution](https://en.bluerocktel.com) to do so. Our fully automated, cost effective and data driven solution will help you to reach your business goals. [Learn more](https://en.bluerocktel.com)

La généralisation de l'économie de l'abonnement et la convergence croissante entre les services Telecom et Coud apportent de nouvelles manières d'approcher les clients, de les servir et de les facturer. BlueRockTEL est [votre solution CRM et facturation complète](https://fr.bluerocktel.com) pour réussir ce challenge. Notre solution entièrement automatisée, économique et axée sur la data vous aidera à atteindre vos objectifs business. [En savoir plus](https://fr.bluerocktel.com)