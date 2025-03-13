# Docs.Sucuri.net (knowledgebase) WordPress Website
URL - https://docs.sucuri.net 

## Repository Summary

```text
Local Environment:          DDEV
Staging Environment:        Pagely: Staging (only accessible behind gogogo)
Production Environment:     Pagely: Production

Deployment Strategy:        GitHub Actions
```
## Local Environment Summary

DDEV and its prerequisites (Orbstack or Docker Desktop) must be installed first. [See DDEV documentation](https://ddev.readthedocs.io/en/latest/users/install/).

To start DDEV container, run the following command from within the repository root folder:
```bash
ddev start
```

### URL
* Local Homepage - https://docs-sucuri-net.ddev.site
* Local Admin Interface - https://docs-sucuri-net.ddev.site/wp-login.php

## Local-Sync (not completed yet)

Working on bash scripts that will do the following:
1. Pull assets (wp-content/uploads) from Pagely Prod or Staging.
2. Push assets (wp-content/uploads) to Pagely Prod or Staging.
3. Pull db from Pagely.
4. Push db to Pagely.

## Deployments

This project uses github actions for deployments to Pagely. 

- Staging - https://staging.docs.sucuri.net:
    - Pagely (automatically merge in 'staging' branch)
- Production - https://docs.sucuri.net:
    - Pagely (automatically merge in 'main' branch)
