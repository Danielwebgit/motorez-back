# Teste prático
## Integração de Estoque de Veículos de Terceiros

Imagine que você trabalhe para uma startup que precisa integrar o estoque de veículos dos
seus clientes. O sistema deve periodicamente coletar os dados de veículos de várias fontes
diferentes (Webmotors, OLX, etc.) e internamente padroniza esses dados em uma base
própria para uso em análises e exibição.
## Back End

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

## Front End

**Tecnologias e Bibliotecas Usadas no Front End:**
- [`nextui-org`](https://nextui.org/): Biblioteca de UI para Next.js.
- [`sweetalert2`](https://sweetalert2.github.io/): Biblioteca para exibição de alertas.
- [`react-hook-form`](https://react-hook-form.com/): Biblioteca para gerenciamento de formulários em React.
- [`nookies`](https://github.com/hoangvvo/nookies): Manipulação de cookies no Next.js.
- [`axios`](https://axios-http.com/): Cliente HTTP para fazer requisições.
- [`@svgr/webpack`](https://github.com/gregberge/svgr/tree/master/packages/webpack): Transformação de SVGs em componentes React.
- [`react-toastify`](https://fkhadra.github.io/react-toastify/): Biblioteca para exibição de notificações toast.

**Comandos e Configurações:**
- **Execução de Migrações e Seeders para Tenants:**  
  ```bash
  php artisan tenancy:migrate --tenants=foo,bar
