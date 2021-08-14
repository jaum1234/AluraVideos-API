# AluraFLix
## Sobre

O projeto consiste em uma API RESTFUL proposto pela Plataforma Alura em seu segundo Alura Challenge. O objeto é possibilitar que um usúario para adicionar, pesquisar e ver vídeos, além de criar categorias e adicionar vídeos a elas. 

## Tecnologias


- PHP com Lumen
- Banco de dados MySQL
- Composer
- PHPUnit
- Postman


## Consumindo a API
Documentaçao: https://documenter.getpostman.com/view/16256795/Tzz7PyCf
## Executando

1. Clone o projeto
2. Rode o composer
3. Copie o arquivo .env.example para um arquivo .env
4. Configure o banco de dados
5. Para gerar uma key: 
```php
$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});
```   
6. Rode php artisan migrate
7. Acesse seu localhost


 
