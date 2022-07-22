
#Lista todos os produtos
![Listar](https://user-images.githubusercontent.com/87495655/180374257-0f40f182-80f2-4268-b842-809a2d45e119.png)

#Busca todos os produtos por Id ou Nome
![Pesquisar](https://user-images.githubusercontent.com/87495655/180374564-3fd14de7-cadc-4faf-9ae7-e927c6830b18.png)

#Cria um novo produto
![Adicionar](https://user-images.githubusercontent.com/87495655/180374821-31298c38-ba5b-44de-84d3-06a7e3cc0ff4.png)

#Edita um produto
![Editar](https://user-images.githubusercontent.com/87495655/180374999-8dc8d231-b04b-4b25-897f-0624345593dd.png)

#Exclui um produto
![Excluir](https://user-images.githubusercontent.com/87495655/180375136-aaebbe34-755a-434f-86c0-203563e97a1e.png)


## CRUD com Laravel, Vue e MySQL.
Olá avaliador, tudo bem? A aplicação foi feita seguindo os parâmetros informados, uma aplicação APIRest e um front em Vue.js conforme anexo enviado.  

## Banco de dados
Crie o banco de dados "sg" e execute as migrates com o comando abaixo para criar as tabelas necessárias:
```shell
 php artisan migrate
 php artisan db:seed --class=Cidades
```

## Configuração
As credenciais do banco de dados estão no arquivo `./app/Db/Database.php` e você deve alterar para as configurações do seu ambiente (HOST, NAME, USER e PASS).

## Composer
Para a aplicação funcionar, é necessário rodar o Composer para que sejam criados os arquivos responsáveis pelo autoload das classes.

## Laravel 
Projeto foi desenvolvido no laravel versão 8.X

## PHP
A versão usada do PHP foi a  7.4.6
