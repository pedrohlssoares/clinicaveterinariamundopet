# Pasta: Controller

Os Controllers funcionam como os "maestros" ou as "rotas" do sistema. Eles recebem as requisições enviadas pelo usuário através do navegador (como os cliques e envios de formulários), processam a lógica de controle e decidem o que fazer em seguida.

### O que deve ficar aqui?
* Arquivos que capturam dados enviados via `$_POST` ou `$_GET`.
* Validações iniciais de segurança e fluxo.
* Chamadas para os Models e DAOs para salvar ou buscar informações.
* Redirecionamentos de página (`header("Location: ...")`).

### Regra de Ouro:
O Controller não deve conter código HTML (View) e nem códigos SQL (Model/DAO). Ele serve estritamente como uma ponte de comunicação entre essas camadas.