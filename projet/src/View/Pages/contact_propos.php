<div>
    <div>
        <h2>Contactez-nous</h2>
        <p>Une question ou un projet ? Notre équipe vous répondra dans les plus brefs délais.</p>
    </div>

    <div>
        <form action="/sae3_auth/web/FrontController.php?action=envoyerContact" method="POST"> 
            <div>
                <label for="nom">Nom complet :</label>
                <input type="text" name="nom" id="nom" placeholder="Ex: Camille Martin" required>
            </div>
            
            <div>
                <label for="email">Votre Email :</label>
                <input type="email" name="email" id="email" placeholder="votre@email.com" required>
            </div>
            
            <div>
                <label for="message">Votre Message :</label>
                <textarea name="message" id="message" placeholder="Comment pouvons-nous vous aider ?" rows="6" required></textarea>
            </div>
            
            <button type="submit">
                Envoyer le message
            </button>
        </form>
    </div>

    <div>
        <p>page test</p>
    </div>
</div>