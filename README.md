# Jogorizador

Um projeto constituido de um CRUD e uma API para gerenciar roms jogos e seus respectivos consoles.

# Dicas
**PHP 8.0.x**

Não se esqueça de dar as permissões conforme o repositório dos créditos

Você **precisa** criar dois arquivos de banco (development.php e production.php) no diretório `config` baseados no arquivo `config/database-example.php`.

# Roadmap
Atualmente o projeto possui o básico para funcionar, ou seja, todo o CRUD e api para consulta de roms e consoles. 
A seguir estão listados algumas features que serão implementadas num futuro breve
1. Login e Cadastro de usuários: Cada pessoa terá seus próprios dados baseados em sua própria realidade.
2. Exportação dos dados para CSV: Caso o usuário deseje salvar esses dados em seu computador ou mesmo ter um backup próprio, com essa exportação isso se torna possível.
3. Base de consoles já possuindo os principais cadastrados previamente: Evita o trabalho de cada usuário cadastrar um por um.
4. Deploy automático com Jenkins quando tiver alterações na master.

# Créditos
[Slim 4 Skeleton](https://github.com/jerfeson/slim4-skeleton/tree/feature/3.0.0)