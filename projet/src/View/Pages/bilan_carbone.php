<?php
$results = null;
$errors = [];
$values = [
    'car_km_week' => '',
    'public_km_week' => '',
    'electricity_kwh_month' => '',
    'gas_kwh_month' => '',
    'short_flights' => '',
    'long_flights' => '',
    'diet' => 'omnivore',
];

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function readNumber($key, $label, &$errors, &$values) {
    $raw = $_POST[$key] ?? '';
    $values[$key] = $raw;
    $raw = trim($raw);
    if ($raw === '') {
        $errors[] = 'Champ requis : ' . $label . '.';
        return null;
    }
    $raw = str_replace(',', '.', $raw);
    if (!is_numeric($raw) || (float)$raw < 0) {
        $errors[] = 'Valeur invalide pour : ' . $label . '.';
        return null;
    }
    return (float)$raw;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carKm = readNumber('car_km_week', 'km en voiture par semaine', $errors, $values);
    $publicKm = readNumber('public_km_week', 'km en transport en commun par semaine', $errors, $values);
    $electricity = readNumber('electricity_kwh_month', 'kWh d\'electricite par mois', $errors, $values);
    $gas = readNumber('gas_kwh_month', 'kWh de gaz par mois', $errors, $values);
    $shortFlights = readNumber('short_flights', 'vols courts par an', $errors, $values);
    $longFlights = readNumber('long_flights', 'vols longs par an', $errors, $values);

    $diet = $_POST['diet'] ?? 'omnivore';
    $values['diet'] = $diet;

    $dietFactors = [
        'omnivore' => 2300,
        'flexi' => 1800,
        'vegetarian' => 1300,
        'vegan' => 900,
    ];

    if (!isset($dietFactors[$diet])) {
        $errors[] = 'Choisissez un regime alimentaire valide.';
    }

    if (!$errors) {
        $carFactor = 0.20;
        $publicFactor = 0.07;
        $electricityFactor = 0.06;
        $gasFactor = 0.20;
        $shortFlightFactor = 250;
        $longFlightFactor = 1100;

        $annualCar = $carKm * 52 * $carFactor;
        $annualPublic = $publicKm * 52 * $publicFactor;
        $annualElectricity = $electricity * 12 * $electricityFactor;
        $annualGas = $gas * 12 * $gasFactor;
        $annualShortFlights = $shortFlights * $shortFlightFactor;
        $annualLongFlights = $longFlights * $longFlightFactor;
        $annualDiet = $dietFactors[$diet];

        $total = $annualCar + $annualPublic + $annualElectricity + $annualGas + $annualShortFlights + $annualLongFlights + $annualDiet;

        $results = [
            'total' => $total,
            'transport' => $annualCar + $annualPublic + $annualShortFlights + $annualLongFlights,
            'home' => $annualElectricity + $annualGas,
            'diet' => $annualDiet,
            'car' => $annualCar,
            'public' => $annualPublic,
            'short_flights' => $annualShortFlights,
            'long_flights' => $annualLongFlights,
            'electricity' => $annualElectricity,
            'gas' => $annualGas,
        ];
    }
}
?>

<div class="container">
    <header class="dashboard-header">
        <h1>Bilan carbone</h1>
        <p>Test utilisateur simple pour estimer votre empreinte carbone annuelle.</p>
    </header>

    <?php if ($errors): ?>
        <div class="result-box wrong">
            <strong>Erreurs :</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($results): ?>
        <div class="result-box correct">
            <h3>Résultat estimé</h3>
            <p><strong>Total :</strong> <?= number_format($results['total'] / 1000, 2) ?> tCO2e / an</p>
            <ul>
                <li>Transport : <?= number_format($results['transport'], 0) ?> kgCO2e</li>
                <li>Logement : <?= number_format($results['home'], 0) ?> kgCO2e</li>
                <li>Alimentation : <?= number_format($results['diet'], 0) ?> kgCO2e</li>
            </ul>
        </div>

        <div class="result-box initiatives">
            <h3>Initiatives pour réduire votre empreinte carbone</h3>
            <?php
            $totalTons = $results['total'] / 1000;
            if ($totalTons < 5) {
                echo '<p>Votre empreinte carbone est faible ! Continuez sur cette voie avec ces initiatives :</p>';
                echo '<ul>';
                echo '<li>Privilégiez les transports en commun ou le vélo pour vos déplacements quotidiens.</li>';
                echo '<li>Adoptez une alimentation plus végétale pour réduire encore votre impact.</li>';
                echo '<li>Investissez dans des appareils électroménagers éco-énergétiques.</li>';
                echo '</ul>';
            } elseif ($totalTons < 10) {
                echo '<p>Votre empreinte carbone est moyenne. Voici des initiatives pour l\'améliorer :</p>';
                echo '<ul>';
                echo '<li>Réduisez vos déplacements en voiture en optant pour le covoiturage ou les transports publics.</li>';
                echo '<li>Améliorez l\'isolation de votre logement pour diminuer la consommation d\'énergie.</li>';
                echo '<li>Limitez les vols aériens et privilégiez les alternatives terrestres pour les voyages.</li>';
                echo '<li>Adoptez un régime alimentaire avec moins de produits animaux.</li>';
                echo '</ul>';
            } else {
                echo '<p>Votre empreinte carbone est élevée. Voici des initiatives prioritaires pour la réduire :</p>';
                echo '<ul>';
                echo '<li>Envisagez de changer de véhicule pour un modèle électrique ou hybride.</li>';
                echo '<li>Réduisez drastiquement vos vols aériens et optez pour des voyages en train.</li>';
                echo '<li>Installez des panneaux solaires pour produire votre propre électricité.</li>';
                echo '<li>Adoptez un régime végétarien ou vegan pour diminuer l\'impact de l\'alimentation.</li>';
                echo '<li>Compensez vos émissions restantes en investissant dans des projets carbone.</li>';
                echo '</ul>';
            }
            ?>
        </div>
    <?php endif; ?>

    <form method="post" class="contact-form">
        <div class="form-group">
            <label for="car_km_week">Km en voiture par semaine</label>
            <input type="number" step="0.1" min="0" name="car_km_week" id="car_km_week" value="<?= h($values['car_km_week']) ?>" required>
        </div>

        <div class="form-group">
            <label for="public_km_week">Km en transport en commun par semaine</label>
            <input type="number" step="0.1" min="0" name="public_km_week" id="public_km_week" value="<?= h($values['public_km_week']) ?>" required>
        </div>

        <div class="form-group">
            <label for="electricity_kwh_month">Électricité (kWh par mois)</label>
            <input type="number" step="0.1" min="0" name="electricity_kwh_month" id="electricity_kwh_month" value="<?= h($values['electricity_kwh_month']) ?>" required>
        </div>

        <div class="form-group">
            <label for="gas_kwh_month">Gaz (kWh par mois)</label>
            <input type="number" step="0.1" min="0" name="gas_kwh_month" id="gas_kwh_month" value="<?= h($values['gas_kwh_month']) ?>" required>
        </div>

        <div class="form-group">
            <label for="short_flights">Vols courts par an (moins de 3h)</label>
            <input type="number" step="1" min="0" name="short_flights" id="short_flights" value="<?= h($values['short_flights']) ?>" required>
        </div>

        <div class="form-group">
            <label for="long_flights">Vols longs par an (plus de 3h)</label>
            <input type="number" step="1" min="0" name="long_flights" id="long_flights" value="<?= h($values['long_flights']) ?>" required>
        </div>

        <div class="form-group">
            <label for="diet">Régime alimentaire</label>
            <select name="diet" id="diet" required>
                <option value="omnivore" <?= $values['diet'] === 'omnivore' ? 'selected' : '' ?>>Omnivore</option>
                <option value="flexi" <?= $values['diet'] === 'flexi' ? 'selected' : '' ?>>Peu de viande</option>
                <option value="vegetarian" <?= $values['diet'] === 'vegetarian' ? 'selected' : '' ?>>Végétarien</option>
                <option value="vegan" <?= $values['diet'] === 'vegan' ? 'selected' : '' ?>>Vegan</option>
            </select>
        </div>

        <button type="submit" class="btn-main">Calculer mon empreinte</button>
    </form>

    <p class="note">
        Estimation simplifiée à but pédagogique. Les facteurs utilisés sont approximatifs.
    </p>
    </div>