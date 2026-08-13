# Publicar o app — do `.env` local até o Streamlit Community Cloud

Passo a passo verificado nas fontes oficiais (docs.streamlit.io) em agosto de 2026. Nomes de botão podem mudar com o tempo — se algo não bater exatamente com a tela, o caminho geral (repositório → arquivo principal → secrets) continua o mesmo.

## 1. Configurar o `.env` local

1. Copie `.env.example` para um novo arquivo chamado `.env`, na mesma pasta de `app.py`.
2. Abra o `.env` e troque `sk-cole-sua-chave-aqui` pela sua chave real da OpenAI (veja como conseguir uma chave na Aula 8, bloco "Comprar créditos na OpenAI, passo a passo").
3. **Nunca comite o `.env`** — o `.gitignore` desta pasta já está configurado para ignorá-lo, mas confira com `git status` antes do primeiro commit que ele não aparece na lista de arquivos a enviar.

## 2. Testar localmente antes de publicar

```
pip install -r requirements.txt
streamlit run app.py
```

Abre automaticamente em `http://localhost:8501`. Se aparecer o erro "chave da API OpenAI não foi encontrada", confira se o `.env` está na mesma pasta de `app.py` e se `load_dotenv()` não retornou erro.

## 3. Colocar o projeto no Git

Dentro da pasta `streamlit-app/`:

```
git init
git add .
git commit -m "Primeira versão do app de RAG com PDFs"
```

O `git add .` **não** vai incluir o `.env` (está no `.gitignore`) — mas vai incluir os dois PDFs em `pdfs/` (~9,5 MB juntos), que precisam ir para o repositório para o app funcionar depois de publicado.

## 4. Criar o repositório no GitHub e enviar

1. Em [github.com/new](https://github.com/new), crie um repositório novo (pode ser público ou privado — o Streamlit Community Cloud gratuito só permite **um** app privado por conta).
2. Sem inicializar com README/gitignore pelo GitHub (já temos os nossos).
3. Conecte e envie:
   ```
   git remote add origin https://github.com/SEU-USUARIO/SEU-REPOSITORIO.git
   git branch -M main
   git push -u origin main
   ```

## 5. Publicar no Streamlit Community Cloud

Passo a passo confirmado com capturas de tela reais (as mesmas usadas na Aula 8):

1. Acesse [share.streamlit.io](https://share.streamlit.io) e escolha o plano **Free**.
2. Entre com sua conta GitHub e clique em **"Authorize streamlit"** na tela de permissões.
3. Confirme o acesso digitando o código de verificação enviado por e-mail.
4. No painel ("My apps"), clique em **"Create app"**, no canto superior direito.
5. Na tela "What would you like to do?", escolha **"Deploy a public app from GitHub"**.
6. Na tela "Deploy an app", preencha:
   - **Repository**: `SEU-USUARIO/SEU-REPOSITORIO`
   - **Branch**: o nome da sua branch principal (`main` ou `master`, conforme o que o `git push` criou)
   - **Main file path**: `app.py`
   - **App URL** (opcional): se deixar em branco, o Streamlit gera uma a partir do repositório.
7. Clique em **"Advanced settings"** antes de publicar:
   - Escolha a versão do Python, se quiser fixar uma.
   - No campo **"Secrets"**, cole o conteúdo no formato TOML (repare que é diferente do `.env` — usa aspas e espaços ao redor do `=`):
     ```
     OPENAI_API_KEY = "sk-sua-chave-aqui"
     ```
   - Clique em **"Save"**.
8. Clique em **"Deploy"** e acompanhe o log — a maioria dos apps fica pronta em poucos minutos.
9. Ao terminar, o app fica disponível numa URL pública (`https://SEU-APP.streamlit.app`), pronta para compartilhar. Confira em **Settings → Sharing** se está marcado como público — por padrão, alguns apps ficam com "viewer authentication" ativado, exigindo login de quem for abrir o link.

## Limites do plano gratuito (verificado em docs.streamlit.io, fev/2026)

| Recurso | Faixa |
|---|---|
| CPU | 0,078 a 2 núcleos, conforme demanda |
| Memória (RAM) | 690 MB a 2,7 GB, conforme demanda |
| Armazenamento | até 50 GB |
| Apps privados | 1 por conta |
| Domínio próprio | Não disponível no plano gratuito |

**Hibernação:** um app sem nenhum acesso por 12 horas entra em repouso — qualquer pessoa que visitar a URL depois disso o reativa automaticamente (leva alguns segundos a mais na primeira visita).

**Projeto educacional:** iniciativas educacionais, sem fins lucrativos ou de código aberto podem pedir mais recursos pelo formulário oficial da Snowflake/Streamlit, se o app crescer além do plano padrão.

## Se precisar atualizar o app depois de publicado

Basta commitar e dar `git push` de novo na branch conectada — o Streamlit Community Cloud reimplanta automaticamente (limite: no máximo 5 atualizações por minuto vindas do GitHub).
