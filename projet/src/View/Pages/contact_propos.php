<div class="contact-page-wrapper">
    <div class="contact-container">
        
        <header class="contact-header">
            <h2><i class="fas fa-envelope-open-text"></i> Contactez-nous</h2>
            <p>Une question ou un projet ? Notre équipe vous répondra dans les plus brefs délais.</p>
        </header>

        <form action="frontController.php?action=envoyerContact" method="POST" class="contact-form">
            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" name="nom" id="nom" placeholder="Ex: Johan Liebert" required>
            </div>
            
            <div class="form-group">
                <label for="email">Votre Email</label>
                <input type="email" name="email" id="email" placeholder="votre@email.com" required>
            </div>
            
            <div class="form-group">
                <label for="message">Votre Message</label>
                <textarea name="message" id="message" placeholder="Comment pouvons-nous vous aider ?" rows="5" required></textarea>
            </div>
            
            <button type="submit" class="btn-submit"> 
                Envoyer le message
            </button>
        </form>

        <div class="about-section">
            <div class="separator"></div>
            
            <h3>À propos du projet</h3>
            <p class="mission-text">
                Ce site a été réalisé afin de <strong>sensibiliser les utilisateurs aux enjeux du réchauffement climatique dans l'océan</strong>. 
                À travers nos outils et nos données, nous espérons informer sur l'urgence de la situation marine.
            </p>

            <div class="team-box">
                <h4>L'équipe de développement</h4>
                <ul class="team-list">
                    <li>Mélanie Mohamed</li>
                    <li>Ilyas Lahlou</li>
                    <li>Leang Ylan</li>
                    <li>Dabo Aïcha</li>
                    <li>Thera Mariam</li>
                    <li>Moussa Toimaya</li>
                </ul>
            </div>
            
            <p class="sae-mention">Projet développé dans le cadre de la <strong>SAE 301</strong></p>
        </div>

    </div>
</div>