# MinhaDespesa 💸

O **MinhaDespesa** é um sistema minimalista de gestão financeira pessoal, desenvolvido com o objetivo de proporcionar aos usuários uma maneira simples e intuitiva de acompanhar suas finanças. Controle seus gastos, planeje seu orçamento e visualize suas movimentações de forma clara e objetiva.

![cadastro final](https://github.com/user-attachments/assets/cf4fd6ea-6965-4582-b403-c939c342a562)

![login perfeito](https://github.com/user-attachments/assets/facf626a-5163-4e54-ba47-1a88631dfd6c)


## ✨ Funcionalidades Principais
*   🔐 **Criação de Conta**: Crie uma conta e salve suas receitas e despesas.
*   ✅ **Cadastro de Despesas e Receitas**: Registre todas as suas transações financeiras de forma rápida e fácil.
*   ❌ **Remoção de Lançamentos**: Edite ou exclua despesas e receitas já cadastradas com facilidade.
*   📊 **Visualização Intuitiva**: Uma interface limpa e direta para que você acesse rapidamente as informações financeiras essenciais.

## 🚀 Tecnologias Utilizadas

*   **Backend**:
    *   🐘 **PHP 8**: Linguagem de programação principal do sistema.
*   **Banco de Dados**:
    *   🐬 **MySQL**: Sistema de gerenciamento de banco de dados relacional para armazenar seus dados financeiros.
*   **Ambiente de Desenvolvimento e Implantação**:
    *   🐳 **Docker & Docker Compose**: Ferramentas para criar, gerenciar e executar a aplicação em contêineres, simplificando a configuração do ambiente.
    *   🐖 **MailHog**: Servidor SMTP para testar o envio de E-Mails ao usuário final.

## 🛠️ Como Executar o Projeto Localmente

Para colocar o **MinhaDespesa** para rodar no seu ambiente local, siga estes passos:

1.  **Pré-requisitos**:
    *   [Git](https://git-scm.com/downloads)
    *   [Docker](https://www.docker.com/products/docker-desktop/)
    *   [Docker Compose](https://docs.docker.com/compose/install/)

2.  **Clone este repositório**:
    ```bash
    git clone https://github.com/DeividSouSan/MinhaDespesa.git
    ```

3.  **Acesse a pasta do projeto**:
    ```bash
    cd MinhaDespesa
    ```

4.  **Construa e inicie os contêineres Docker**:
    Este comando irá construir as imagens (se ainda não existirem) e iniciar os serviços definidos no `docker-compose.yml`.
    ```bash
    docker compose up --build -d
    ```
    *   A flag `-d` executa os contêineres em modo "detached" (em segundo plano).

5.  **Acesse a aplicação**:
    Após a conclusão do processo, abra seu navegador e visite:
    `http://localhost:8080` (Confirme a porta no seu `docker-compose.yml` se for diferente)

6.  **Para encerrar aplicação**:
    ```bash
    docker compose down
    ```
    
## 📝 Licença

Este projeto é distribuído sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes. (Se você não tiver um arquivo LICENSE, é uma boa prática adicionar um).

---

Feito  por [DeividSouSan](https://github.com/DeividSouSan) | [LinkedIn](https://www.linkedin.com/in/deividsousan/)
