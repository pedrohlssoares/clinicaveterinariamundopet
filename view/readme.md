# Pasta: View

A camada View é a interface gráfica com a qual o usuário final interage. Sua única responsabilidade é estruturar e exibir os dados de forma visual, além de fornecer os caminhos (formulários e botões) para que o usuário envie comandos ao sistema.

### O que deve ficar aqui?
* Telas em HTML estruturadas com dados dinâmicos do PHP (ex: listagens, formulários de cadastro).
* Arquivos parciais repetitivos (como `header.php`, `footer.php`, `menu.php`).

### Regra de Ouro:
A View não faz processamentos pesados e nunca acessa o banco de dados. Ela apenas recebe dados já mastigados pelo Controller e os exibe na tela usando tags HTML e estilizações da pasta `static`.