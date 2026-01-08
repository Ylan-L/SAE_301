<div class="contact-section">
    <div class="contact-header">
        <h2>Contactez-nous</h2>
        <p>Une question ou un projet ? Notre équipe vous répondra dans les plus brefs délais.</p>
    </div>

    <div class="contact-card">
        <form action="frontController.php?action=envoyerContact" method="POST" class="contact-form">
            <div class="form-group">
                <label for="nom">Nom complet :</label>
                <input type="text" name="nom" id="nom" placeholder="Ex: Camille Martin" required>
            </div>
            
            <div class="form-group">
                <label for="email">Votre Email :</label>
                <input type="email" name="email" id="email" placeholder="votre@email.com" required>
            </div>
            
            <div class="form-group">
                <label for="message">Votre Message :</label>
                <textarea name="message" id="message" placeholder="Comment pouvons-nous vous aider ?" rows="6" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">
                Envoyer le message
            </button>
        </form>
    </div>

    <div class="footer-test">
        <p>page test</p>
    </div>
</div>