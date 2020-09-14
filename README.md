``` bash

cd backend
composer install

Caso houver falha na instalação das depêndencias no composer: 
composer install --ignore-platform-reqs

1-Deve ser criado um arquivo dentro da pasta backend chamada: .env
2-Copie os dados que estão no arquivo: .envexample 
3-Cole os dados no arquivo: .env
4-Altere os seguintes dados no arquivo: DB_DATABASE:Nome do banco, DB_USERNAME:user, DB_PASSWORD:pass
5-Certifique-se que estejam de acordo com os dados referentes ao seu gerenciador de banco de dados
6-Os gerenciadores de DB utilizados no projeto: Xampp(no Windows), MySQL(no Ubuntu)

Criação das tabelas e inserção de dados: 
php artisan migrate:refresh --seed


cd frontend
npm install


#run

backend: php artisan serve
frontend: npm run dev
```
