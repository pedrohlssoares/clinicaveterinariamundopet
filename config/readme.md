# Pasta: Config

Esta pasta é o ponto central de configuração do sistema. Deve isolar tudo o que o sistema precisa para se conectar e interagir com o ambiente externo de forma segura e parametrizada.

### O que deve ficar aqui?
* Arquivos de conexão com o Banco de Dados (ex: conexões PDO ou MySQL).
* Definição de constantes globais (URLs base, caminhos de diretórios).
* Configurações de exibição de erros do PHP e fusos horários (`timezone`).

### Regra de Ouro:
Nenhum outro arquivo do sistema deve tentar criar uma conexão com o banco de dados do zero. Todos devem solicitar a conexão centralizada que nasce nesta pasta.