# AluraFLix
## Sobre

O projeto consiste em uma API RESTFUL proposto pela Plataforma Alura em seu segundo Alura Challenge. O objeto é possibilitar que um usúario para adicionar, pesquisar e ver vídeos, além de criar categorias e adicionar vídeos a elas. 

## Tecnologias

<ul>
    <li>PHP com Lumen</li>
    <li>Banco de dados MySQL</li>
    <li>Composer</li>
    <li>PHPUnit</li>
    <li>Postman</li>
</ul>

## Consumindo a API

## Executando

<ol>
    <li>Clone o projeto</li>
    <li>Rode o composer</li>
    <li>Copie o arquivo .env.example para um arquivo .env</li>
    <li>Configure o banco de dados</li>
    <li>Para gerar uma key: </li>
        <pre>
            <code>
                $router->get('/key', function() {
                    return \Illuminate\Support\Str::random(32);
                });
            </code>
        </pre>
    <li>Rode php artisan migrate</li>
    <li>Acesse seu localhost</li>
</ol>

 
