# Roadmap : MCP Server + Bot WhatsApp Laravel Cameroun

## Vision

Permettre aux developpeurs de la communaute d'interroger le contenu de laravel.cm depuis WhatsApp (et d'autres canaux) via un agent IA qui cherche dans les articles, discussions et threads existants, et propose un abonnement premium pour etendre la recherche sur internet.

## Architecture

```
Utilisateur WhatsApp
    → Bot WhatsApp (transport)
        → Agent IA (cerveau)
            → MCP Server laravel.cm (tools)
                → Typesense (recherche full-text)
                    → Articles, Discussions, Threads
            ← Resultats trouves ?
                OUI → Synthetise une reponse avec les sources laravel.cm
                NON → Propose l'abonnement Premium
                    → Si abonne → Appel LLM (Claude/GPT) avec recherche web
                    → Si pas abonne → Lien vers la page d'abonnement
```

## Etapes

### Phase 1 : Typesense (branche feature/typesense)

- [ ] Configurer Laravel Scout avec le driver Typesense
- [ ] Indexer les modeles : Article, Discussion, Thread
- [ ] Definir les schemas Typesense (champs searchables, filtres, facets)
- [ ] Configurer le container Typesense en production (docker-compose.prod.yml)
- [ ] Synchroniser les index (import initial + sync automatique via observers)
- [ ] Valider la recherche full-text en francais (stemming, accents, typo-tolerance)

### Phase 2 : MCP Server (branche feature/mcp-server)

- [ ] Configurer laravel/mcp (deja en dependance)
- [ ] Creer les tools MCP :
  - `search_articles` — recherche full-text dans les articles via Typesense
  - `search_discussions` — recherche dans les discussions
  - `search_threads` — recherche dans les threads du forum
  - `get_article` — recupere le contenu complet d'un article
  - `get_discussion` — recupere une discussion avec ses reponses
  - `list_tags` — liste les sujets couverts
  - `get_latest_content` — dernieres publications
- [ ] Tester le MCP avec Claude Code / Cursor en local
- [ ] Deployer le endpoint MCP en production

### Phase 3 : Bot WhatsApp (branche feature/whatsapp-bot)

- [ ] Creer un compte Meta Business et enregistrer un numero WhatsApp Business
- [ ] Obtenir le token API WhatsApp Cloud
- [ ] Creer l'agent IA qui utilise les tools MCP pour repondre aux questions
- [ ] Implementer le transport WhatsApp (webhook entrant + envoi de reponse)
- [ ] Gerer le flow de conversation (question → recherche → reponse)
- [ ] Deployer et tester en 1-to-1

### Phase 4 : Abonnement Premium (branche feature/premium-search)

- [ ] Definir le gate : recherche laravel.cm (gratuit) vs recherche web (premium)
- [ ] Integrer la verification d'abonnement dans le flow du bot
- [ ] Ajouter le fallback LLM avec recherche web pour les abonnes
- [ ] Page d'abonnement accessible depuis le lien envoye par le bot

### Phase 5 : Multi-canal (iterations futures)

- [ ] Bot Telegram ameliore (meme agent, transport Telegram)
- [ ] Chatbot embarque sur laravel.cm
- [ ] WhatsApp Channel pour les digests hebdomadaires
