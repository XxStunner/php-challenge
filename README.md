# PHP Challenge

Aplicação web com cadastro de usuario e checkout. Mais detalhes: https://github.com/jusbrasil/careers/blob/master/php-fullstack/challenge.md

## Tecnologias:

* Vue
* Sass
* Bootstrap
* Laravel
* MySQL / MariaDB

## Instalação:

É necessario ter o PHP 7 instalado na maquina:

- Mac: Já vem instalado com o OS.
- Linux: Já vem instalado com o OS.
- Windows: https://chocolatey.org/packages/php

Após instalar o PHP 7, é preciso instalar: 
- Composer: https://getcomposer.org/download/
- node.js: https://nodejs.org/en/download/ 
- MariaDB: https://downloads.mariadb.org ou MySQL: https://www.mysql.com/downloads/.

Depois de instalar todas as dependencias, conecte-se ao MariaDB / MySQL e crie um banco e dados chamado: **php_challenge** e em seguida, execute os comandos abaixo (na sequência):

```sh
    composer install
```

```sh
    php artisan migrate
```

```sh
    php artisan db:seed
```

```sh
    php artisan key:generate
```

Depois duplique o **.env.example** e renomeie para: **.env** e GG. Você já pode ligar a aplicação com o comando:

```sh
    php artisan serve
```

## Testing:

Para realizar os testes, crie um banco de dados chamado: **php_challenge_test** e execute o seguinte comando na raiz do projeto:

```sh
    vendor/bin/phpunit
```

## Observações:

- Cartão aceito: 2672872851579012 CCV 123
- Cartão recusado: 7339526258668625 CCV 555
- Cartão aleatorio: 5122245908042818 CCV 321

## Screenshots:

![](https://i.imgur.com/V813j6U.jpg)
![](https://i.imgur.com/oB1XKA4.jpg)
![](https://i.imgur.com/fapWfFR.jpg)
![](https://i.imgur.com/dyg3mkC.jpg)
![](https://i.imgur.com/QR7uoOE.jpg)
