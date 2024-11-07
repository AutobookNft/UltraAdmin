# Request Validator

## Teoria
Il Request Validator è responsabile della validazione di ogni richiesta in ingresso. 
Implementa multiple strategie di validazione per garantire la sicurezza delle richieste.

### Funzionalità Chiave
1. **Rate Limiting**
   - Protezione contro attacchi DDoS
   - Limitazione richieste per IP/utente
   - Finestre temporali configurabili

2. **Validazione Input**
   - Sanitizzazione parametri
   - Protezione contro SQL Injection
   - Validazione tipo dati

## Implementazione
