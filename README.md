# leaderboardPI

questo plugin alla fine dello sviluppo dovrà presentarsi come un sistema di punteggistica e mostrare una leaderboard al pubblico interattiva che si aggiorna senza riaggiornare la pagina web.

al momento sono riuscito a visualizzare una leaderboard da backend dove recupero i nomi utente ed i relativi punti e rank.

in un sottomenu del plugin visualizzo 3 form:
1 form per assegnazione punteggio al singolo utente manualmente 

2 form per selezionare i punti base da assegnare agli utenti della squadra vincente e detrarli alla squadra perdente in caso di vittoria o sconfitta

3- devo creare un form personalizzabile per la creazione della formula con cui calcolare automaticamente il punteggio da assegnare agli utenti dopo aver cliccato il pulsante che assegna la vittoria o la sconfitta,la formula di default dovrebbe tenere conto del rank avversario e assegnare piu o meno punti se il rank avversario appunto è di minore o maggiore livello (i rank delle squadre vanno dalla A alla F quindi A vs B e vince la squadra con rank B essendo piu basso guadagnerà il 10% dei punti in piu rispetto alla vittoria contro un rank di stesso livello e viceversa quindi lo stesso vale per la sconfitta, deve essere cosi per tutti i rank  alcuni esempi: A vs C vince rank C vengono assegnati il 20% dei punti in piu rispetto ai punti base vittoria e tolti il 20% dei punti in piu ai componenti della squadra di rank A; A vs D vince rank D vengono assegnati il 30% in piu e viceversa cosi via...

4- raggruppamento utenti in squadre ed assegnazione punteggio automatico tramite due pulsanti (vittoria squadra 1 e vittoria squadra 2 ) selezionandone uno determino la coppia di utenti vincitori ed assegno loro i punti base vittoria e detraggo automaticamente anche i punti base sconfitta alla coppia di utenti perdenti se le squadre sono di pari livello altrimenti entra in gioco la formula descritta nel punto 3.. Questo form presenta dopo il titolo "squadra 1" e "squadra 2" la dicitura rank che dovrebbe aggiornarsi automaticamente una volta che vengono inseriti gli utenti calcolando il rank squadra 1 come segue (punteggio utente1 +punteggio utente2 /2 = rank squadra) il rank delle squadre dovra funzionare esattamente come l'assegnazione del rank all'utente. na volta determinato il rank della squadra,quando verrà cliccato ad esempio il pulsante vittoria squadra 1 dovrà calcolarsi automaticamente il punteggio da assegnare ai rispettivi utenti tenendo in considerazione la formula matematica descritta nel form personalizzabile 
