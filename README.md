# ShipSmart Backend

API RESTful construída com Laravel para gerenciamento de contatos e seus endereços. Suporta cadastro, edição, listagem, exclusão, exportação para Excel e envio de e-mail em fila.

## 🚀 Requisitos

- PHP 8.1+
- Composer
- Docker + Laravel Sail (ou MySQL local)
- Mailpit (para testes de e-mail)

## ⚙️ Instalação


### Clonar o projeto
```bash
git clone https://github.com/seu-usuario/shipsmart-backend.git
cd shipsmart-backend
```

### Instalar dependências
```bash
composer install
```

### Copiar e configurar o .env

```bash
cp .env.example .env
php artisan key:generate
```

### Comando para criar álias ao comando sail
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

### Subir containers
```bash
sail up -d
```

### Rodar migrations
```
sail artisan migrate
```

## 📨 E-mails em fila
Ao cadastrar um contato, um e-mail é enfileirado na fila back_emails para o endereço definido no **.env** em:

```bash
NOTIFICATION_MAIL=seu@email.com
```
## Rodar projeto
### Rodar o Work
```bash
sail artisan queue:work --queue=back_emails
```

## ✅ Testes
```bash
sail artisan test
```

**Testes incluídos em:**

- Cadastro
- Edição
- Exclusão
- Listagem
- Exportação
- E-mail em fila
