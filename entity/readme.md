# Pasta: Model

A camada Model guarda todo o coração do sistema: as regras de negócio, a estrutura das informações e a comunicação direta com o banco de dados. Para fins de organização, ela é dividida internamente em dois conceitos:

### 1. Entities (Entidades)
São as classes que representam os objetos do mundo real na memória do PHP (ex: `Pet.php`, `Veterinario.php`). É onde ficam os atributos, o **construtor** para garantir que o objeto nasça de forma válida e os métodos específicos daquele objeto. Não sabem da existência de bancos de dados.

### 2. DAO (Data Access Object)
São as classes responsáveis por executar a persistência dos dados (ex: `PetDAO.php`, `VeterinarioDAO.php`). É aqui dentro que ficam escritas as consultas SQL (`INSERT`, `SELECT`, `UPDATE`, `DELETE`). O DAO pega uma Entidade da memória e a salva no banco, ou puxa os dados do banco e usa o construtor para recriar a Entidade no PHP.

### Regra de Ouro:
Toda a inteligência e manipulação de dados acontecem aqui. Os Controllers e as Views nunca escrevem SQL diretamente; eles sempre pedem para um DAO fazer isso.