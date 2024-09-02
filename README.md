![Screenshot: Running tests on VS Code](docs/img/motorez-logo.png)

# Teste prático para a trabalhar na empresa
## Integração de Estoque de Veículos de Terceiros

Imagine que você trabalhe para uma startup que precisa integrar o estoque de veículos dos
seus clientes. O sistema deve periodicamente coletar os dados de veículos de várias fontes
diferentes (Webmotors, OLX, etc.) e internamente padroniza esses dados em uma base
própria para uso em análises e exibição.

Neste texto, explico o raciocínio por trás da solução proposta para o teste, com base em alguns pontos cruciais. Considerando que cada cliente (tenant) terá seus próprios veículos e integrações, e que estamos lidando com um sistema SaaS (Software as a Service), a estrutura da aplicação exige uma análise e planejamento mais cuidadosos.

Um sistema SaaS não é uma aplicação comum. Ele deve ser projetado para funcionar como um serviço alugado para múltiplos clientes, cada um com suas próprias necessidades e dados isolados. Diante disso, é necessário decidir entre duas abordagens principais para o armazenamento de dados dos clientes: o uso de um único banco de dados compartilhado (single database) ou múltiplos bancos de dados separados (multi-database).

No contexto deste desafio, onde o sistema deve mapear e converter os dados de cada fornecedor para um formato padronizado em uma base própria, optei por implementar uma arquitetura de múltiplos bancos de dados. Essa abordagem garante que cada cliente tenha sua própria base de dados, separada dos demais, proporcionando maior segurança e flexibilidade na gestão dos dados.
## Back End
#### Link do [`FrontEnd em Nextjs - V14`](https://github.com/Danielwebgit/motorez-front)

1. **Mult Database**  
   Implementação de suporte a múltiplos bancos de dados.
> [`tenancyforlaravel`](https://tenancyforlaravel.com/docs/v3/introduction/): Principal pacote usado.
2. **Autenticação e Autorização**  
   - **JWT**: Gerenciamento de recursos de acesso para o sistema.

3. **Padrões de Projeto**  
   - **Service Repository Pattern**: Implementação de padrões de design para separar lógica de negócios e acesso a dados.

4. **Otimização e Indexação de Consultas**  
   - Indexação de tabelas para melhorar o desempenho das consultas.
   - Análise e otimização de queries SQL.

6. **Monitoramento e Logging**  
   - Configuração de monitoramento com Prometheus e Grafana.

7. **Provisionamento do Ambiente**  
   - **Docker Compose**: Configuração e gerenciamento de ambientes com Docker.

8. **Métricas com Prometheus**  
   - Quantidade de compras.

**Tecnologias e Bibliotecas Usadas no Back End:**
- MySQL
- Nginx
- Servidor Linux
- Next.js
- Docker (Docker Compose)
- Xdebug

---


**Comandos e Configurações:**

- **Execução dos containers dockers:**  
  ```bash
     docker compose up -d --build

- **Acessando o container do projeto para rodar os próximos comandos:**  
  ```bash
     docker exec -it motorez-back-motorez-1 bash

- **Execução de Migrações e Seeders para o usuário central:**  
  ```bash
  php artisan db:seed UsersSeeder

- **Execução de Migrações e Seeders para Tenants:**
  ```bash
  php artisan db:seed TenantsWithDomainsSeeder

- **Execução de Teste Unitário desenvolvido para testar a importação dos documentos xml e json:**
    ```bash
  php artisan test --filter=FileImportsDataVehiclesServiceTest
