<h1>Sistema de Ouvidoria - FIPECq Vida</h1>
<p align="center"><img src="public/images/logo_ouvidoria.png" width="400"></p>

## Sobre o Sistema

Sistema de Ouvidoria FIPECq Vida desenvolvido em Laravel framework, Bootstrap, JQuery e Banco de Dados Oracle. Segue abaixo os requisitos não-funcionais para implantação do sistema no ambiente:

- PHP >= 7.2.5
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Instalação

1. Clonar o repositório do projeto no GitHub:
```
git clone https://github.com/luizrjunior/ouvidoria-fipecq.git
```
2. Criar o arquivo .env baseado no arquivo .env.example do diretório root da aplicação
3. Definir a chave da aplicação
```
php artisan key:generate
```
4. Configurar a conexão com banco de dados:
```
DB_CONNECTION=oracle
DB_HOST=192.168.12.40
DB_SERVICE_NAME=
DB_PORT=1521
DB_DATABASE=dbvida
DB_USERNAME=internet
DB_PASSWORD=caixa
```
5. Configurar a aplicação para enviar e-mail informando os dados SMTP:
```
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```
6. Instalar as dependencias da aplicação
```
composer install
```
7. Gerar as Tabelas do Banco de Dados
``` 
php artisan migrate
```
8. Gerar autoload da aplicação
```
composer dump-autoload
```
9. Popular as primeiras tabelas do sistema
```
php artisan db:seed
```
10. Criar storage link para armazenar os arquivos anexos 
```
php artisan storage:link
```
11. Criar alias ou vhost da aplicação apontando para o diretório: 
```
/public
```
12. Criar uma tarefa agendada no servidor de aplicação chamando o seguinte link:
```
http://alias-aplicacao/enviar-emails
```
13. Acesso a aplicação de acordo com o alias criado para usuários normais e anônimos
```
http://alias-aplicacao/home
```
14. Acesso a aplicação de acordo com o alias criado para usuários administratores:
```
http://alias-aplicacao/home/admin
```
