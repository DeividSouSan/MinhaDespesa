# MinhaDespesa

> O **MinhaDespesa** é um sistema minimalista de gestão financeira pessoal, desenvolvido com o objetivo de proporcionar aos usuários uma maneira simples e intuitiva de acompanhar suas finanças. O foco principal é oferecer uma visão clara e objetiva da situação financeira, evitando complexidade desnecessária.
> ![image](https://github.com/user-attachments/assets/32c030a4-8c95-426c-8901-caca230a2e90)


## Funcionalidades

- [x] **Cadastro de Despesas e Receitas**: Permite o registro de despesas realizadas e receitas, facilitando o acompanhamento dos fluxos de caixa.
- [ ] **Planejamento de Despesas Futuras**: Oferece a possibilidade de projetar despesas futuras, auxiliando no planejamento financeiro.
- [ ] **Atualização e Remoção de Receitas e Despesas**: Permite ao usuário a possibilidade de atualizar e remover receitas e despesas já cadastradas.
- [ ] **Visualização Intuitiva**: Fornece uma interface limpa e direta, garantindo que os usuários possam acessar rapidamente as informações financeiras essenciais.

## Tecnologias Utilizadas

- **PHP 8**: Linguagem de programação utilizada para o desenvolvimento do sistema.
- **MySQL**: Sistema de gerenciamento de banco de dados relacional empregado para armazenar dados financeiros.
- **Docker Compose**: Ferramenta utilizada para definir e executar aplicações Docker multi-contêiner, simplificando o ambiente de desenvolvimento e implantação.

## Como Executar o Projeto

Para executar o **MinhaDespesa** em seu ambiente local, siga os passos abaixo:

1. **Clone este repositório**:

   ```bash
   git clone https://github.com/DeividSouSan/MinhaDespesa.git
   ```


2. **Acesse a pasta do projeto**:

   ```bash
   cd MinhaDespesa
   ```


3. **Certifique-se de que o Docker e o Docker Compose estão instalados** em seu sistema. Caso não estejam, siga as instruções de instalação disponíveis nos sites oficiais.

4. **Construa e inicie os contêineres**:

   ```bash
   docker compose up --build
   ```


5. **Acesse a aplicação**: Após a conclusão do processo, abra seu navegador e visite `http://localhost/8080` para utilizar o sistema.
