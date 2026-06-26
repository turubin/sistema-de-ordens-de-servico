# sistema_ordens_de_servico

## Como rodar o sistema

1. Abra o terminal no diretório do projeto.
2. Crie o arquivo do banco de dados SQLite com o nome desejado. Por exemplo:

```bash
sqlite3 nome_do_banco.sqlite
```

3. Dentro do prompt do SQLite, crie as tabelas necessárias usando comandos DDL. 

4. Após a criação do banco e tabelas necessárias, saia do prompt do SQLite:

```bash
.quit
```

5. Abra o arquivo `conecta.php` e configure a variável `$nome_banco` com o nome do arquivo do banco criado:

```php
$nome_banco = 'nome_do_banco.sqlite';
```

6. Execute o servidor PHP embutido:

```bash
php -S localhost:8000
```

7. Clique no botão de notificação “Abrir no navegador” que aparece quando a porta é exposta ou use a aba `PORTAS` para abrir o link da porta `8000` clicando no ícone do globo.
