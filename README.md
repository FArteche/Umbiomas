# 🌿 Sistema UmBiomas

> Uma plataforma integrada para educação ambiental e gestão de conhecimento sobre os biomas brasileiros.

## 📖 Sobre o Projeto

O **Sistema UmBiomas** é uma solução de software desenvolvida como Trabalho de Conclusão de Curso (TCC), com o objetivo de auxiliar o ensino de biomas por meio de conteúdos colaborativos e gamificação. O projeto une tecnologia e educação através de uma arquitetura cliente-servidor robusta.

O sistema é composto por dois módulos principais:

1. **Aplicativo Mobile (Flutter):** Uma interface voltada para estudantes e entusiastas, onde é possível explorar informações detalhadas dos biomas, além de permitir criação de posts e testar conhecimentos através de Quizzes interativos com rankings semanais.

2. **Painel Administrativo Web (Laravel):** Uma interface de gerenciamento de conteúdo restrita a administradores/professores, permitindo o cadastro, edição, moderação de posts e curadoria de todo o material didático disponibilizado no aplicativo.

---

## 🚀 Tecnologias Utilizadas

O desenvolvimento do sistema seguiu as melhores práticas de engenharia de software, utilizando uma stack moderna e escalável.

### 📱 Mobile (Cliente)

* **Flutter:** Framework UI para construção da interface nativa híbrida.
* **Dart:** Linguagem de programação tipada e otimizada para UI.
* **Arquitetura em Camadas:** Separação clara entre UI, Services (API) e Models.
* **Integração REST:** Consumo de API via protocolo HTTP.

### 💻 Backend & Web (Servidor)

* **PHP 8.3:** Linguagem base do lado do servidor.
* **Laravel Framework:** Framework PHP robusto utilizado para a construção da API RESTful e do Painel Web.
* **Laravel Breeze:** Scaffolding para sistema de autenticação seguro.
* **Blade Templates:** Motor de renderização para as views do painel administrativo.
* **Tailwind CSS:** Framework de utilitários CSS para estilização responsiva e moderna do painel.
* **Pest / PHPUnit:** Frameworks para testes automatizados (Unidade e Integração).

### 🗄️ Banco de Dados

* **MySQL:** Sistema gerenciador de banco de dados relacional (RDBMS) para persistência segura dos dados do sistema.

## ⚙️ Arquitetura do Sistema

O sistema opera em uma arquitetura **MVC (Model-View-Controller)** no Backend, expondo endpoints **API JSON** que são consumidos pelo Frontend Mobile. Todo o ambiente é orquestrado via Docker, contendo serviços isolados para a Aplicação (App), Servidor Web (Nginx) e Banco de Dados (DB).

## Como executar: Sistema UmBiomas (Docker 🐋)

Este documento descreve os passos necessários para executar a API e o Painel Web do sistema UmBiomas utilizando Docker.
Pré-requisitos

    Docker e Docker Compose instalados na máquina.

    Portas 8000 (Web) e 3306 (MySQL) livres.

## Instalação (Web e API)

### Passo 1: Configuração de Ambiente

Na raiz do projeto, duplique o arquivo .env.example e renomeie-o para .env.

Abra o arquivo .env e configure a conexão com o banco de dados para apontar para o container do Docker (host: db):

Exemplo

    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=umbiomas_db
    DB_USERNAME=usuario
    DB_PASSWORD=senhausuario

### Passo 2: Construir e Iniciar os Containers

Abra o terminal na raiz do projeto e execute o comando abaixo para construir as imagens e subir os serviços (App, Nginx e Banco de Dados):

```bash
docker-compose up -d --build
```

Aguarde até que todos os containers estejam com o status "Started" ou "Running".

### Passo 3: Instalação e Configuração Inicial

Após os containers estarem rodando, execute a sequência de comandos abaixo uma única vez para configurar o Laravel, gerar chaves, criar o banco de dados e corrigir permissões de arquivos.

Copie e cole os comandos no seu terminal (um por um):

#### 1. Gerar a chave de criptografia da aplicação:

```bash
docker-compose exec app php artisan key:generate
```

#### 2. Criar as tabelas no banco e popular com dados iniciais (Seeders):

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

#### 3. Criar o link simbólico para imagens (Storage): 

* Este passo é essencial para que as imagens de upload fiquem visíveis publicamente.

```bash
docker-compose exec app php artisan storage:link
```

#### 4. Ajustar permissões de pasta: 

* Necessário para garantir que o sistema consiga salvar novas imagens na pasta de armazenamento

```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chmod -R 775 /var/www/storage
```

#### 5. Limpar caches de configuração:

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

### Passo 4: Acessar o Sistema

O sistema estará disponível no navegador através do endereço:

    URL: http://localhost:8000

    Login Admin (Padrão): admin@admin.com

    Senha: password

### Comandos Úteis

#### Parar a aplicação:

```bash    
docker-compose down
```

#### Parar a aplicação e apagar o banco de dados:

```bash    
docker-compose down -v
```

#### Verificar logs (caso algo dê errado):

```bash
docker-compose logs -f
```

#### Acessar o terminal do container PHP:

```bash
docker-compose exec app bash
```

## Guia de Compilação: Aplicativo Mobile (Flutter📱)

Este documento descreve os passos para configurar, rodar e compilar o aplicativo mobile do sistema UmBiomas.
Pré-requisitos

Para compilar o projeto, o ambiente deve possuir:

    Flutter SDK instalado e configurado no PATH.

    Android Studio (com Android SDK e Build-Tools) ou VS Code com extensões Flutter.

    Um dispositivo físico (Android) ou Emulador configurado.

### Passo 1: Configuração da API (Importante)

Como o aplicativo precisa se comunicar com a API que está rodando no seu computador (Docker), é necessário ajustar a URL base antes de compilar.

Abra o arquivo de configuração da API localizado em `lib/api/api_constants.dart`.
Altere a constante da URL base dependendo de onde o app será testado:

#### Opção A: Rodando em Emulador Android 

* O endereço `10.0.2.2` é um alias especial que permite ao emulador acessar o localhost do seu computador.

* Se o Docker estiver na porta 8000, altere o baseUrl para:

```bash
static const String baseUrl = 'http://10.0.2.2:8000/api/v1';
```

#### Opção B: Rodando em Dispositivo Físico (Celular) via USB

* Se o Docker estiver na porta 8000, altere o baseUrl para:

```bash
static const String baseUrl = 'http:localhost:8000/api/v1';
```

Com o dispositivo conectado, use o comando no terminal 
```bash
adb reverse tcp:8000 tcp:8000
```

### Passo 2: Instalar Dependências

#### No terminal, navegue até a pasta raiz do projeto mobile e execute:

```bash
flutter pub get
```

Isso baixará todas as bibliotecas listadas no pubspec.yaml.

### Passo 3: Executar em Modo Debug

#### Para testar o aplicativo rapidamente sem gerar um arquivo final:

Abra seu emulador ou conecte o celular via USB. Execute:
```bash
flutter run
```

### Passo 4: Gerar o APK (Build Final)

Para gerar o arquivo instalável (.apk), execute o comando de build:
```bash
flutter build apk --release
```

#### Localizar o arquivo: 

* Após o término do processo, o APK estará disponível em: `build/app/outputs/flutter-apk/app-release.apk`

### Passo 5: Resolução de Problemas Comuns

#### Erro de Conexão (Connection Refused):

* Verifique se o container Docker está rodando (docker-compose ps).

* Verifique se o IP configurado no Passo 1 está correto.

* Se estiver usando celular físico, garanta que o celular está conectado, em modo de desenvolvedor e se executou o comando `adb reverse tcp:8000 tcp:8000`.

#### Erro de Gradle/Java:

* Execute flutter doctor para verificar se há pendências na instalação do Android Studio.

* Tente limpar o cache de build com flutter clean e depois flutter pub get.