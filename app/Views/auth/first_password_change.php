<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Première Connexion - INFP Madagascar</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* Ligne de couleur du drapeau en haut de l'écran */
        .flag-top-bar {
            height: 6px;
            display: flex;
            width: 100%;
        }
        .flag-red { background-color: #fc3d21; flex: 1; }
        .flag-white { background-color: #ffffff; flex: 1; }
        .flag-green { background-color: #007e3a; flex: 1; }

        .login-card {
            max-width: 440px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            overflow: hidden;
            background: #ffffff;
        }
        .login-header {
            background-color: #007e3a;
            color: white;
            padding: 22px 20px;
            text-align: center;
        }
        /* Bouton un peu moins haut et plus harmonieux */
        .btn-success-custom {
            background-color: #007e3a;
            border: none;
            padding: 10px 16px;
            font-weight: 500;
        }
        .btn-success-custom:hover {
            background-color: #056631;
        }
        /* Labels en noir */
        .form-label {
            color: #000000 !important;
            font-weight: 600;
            font-size: 0.85rem;
        }
        /* Sous-titre CRFRP ajusté */
        .subtitle-crfrp {
            font-size: 0.7rem;
            letter-spacing: 0.8px;
            color: #6c757d;
        }
        /* Alerte d'erreur / succès personnalisée */
        .alert-custom-error {
            background-color: #fff5f5;
            border: 1px solid #f8d7da;
            color: #dc3545;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .alert-custom-success {
            background-color: #d1e7dd;
            border: 1px solid #badbcc;
            color: #0f5132;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        /* Drapeau miniature */
        .malagasy-flag {
            width: 52px;
            height: 34px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            display: flex;
            overflow: hidden;
            margin: 0 auto 8px auto;
        }
        .flag-vertical-stripe {
            width: 35%;
            height: 100%;
            background-color: #ffffff;
        }
        .flag-horizontal-stripes {
            width: 65%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .flag-stripe-red {
            height: 50%;
            background-color: #fc3d21;
        }
        .flag-stripe-green {
            height: 50%;
            background-color: #007e3a;
        }

        /* Contour vert au focus */
        .form-control:focus {
            border-color: #007e3a !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 126, 58, 0.15) !important;
        }

        /* Œil intégré à l'input mot de passe */
        .password-container {
            position: relative;
        }
        .password-container .form-control {
            padding-right: 40px;
        }
        .password-toggle-icon {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }
        .password-toggle-icon:hover {
            color: #007e3a;
        }
    </style>
</head>
<body>

    <!-- Barre supérieure aux couleurs du drapeau -->
    <div class="flag-top-bar">
        <div class="flag-white"></div>
        <div class="flag-red"></div>
        <div class="flag-green"></div>
    </div>

    <div class="container d-flex flex-column align-items-center justify-content-center py-5" style="min-height: 95vh;">
        
        <!-- En-tête institutionnel identique -->
        <div class="text-center mb-4">
            <div class="malagasy-flag">
                <div class="flag-vertical-stripe"></div>
                <div class="flag-horizontal-stripes">
                    <div class="flag-stripe-red"></div>
                    <div class="flag-stripe-green"></div>
                </div>
            </div>
            <h3 class="fw-bold text-dark mb-1" style="font-size: 1.5rem;">INFP Madagascar</h3>
            <p class="text-uppercase mb-0 subtitle-crfrp">SYSTÈME DE GESTION CRFRP</p>
        </div>

        <!-- Carte Principale -->
        <div class="card login-card w-100">
            <div class="login-header">
                <h4 class="fw-bold mb-1" style="font-size: 1.1rem;">Première connexion</h4>
                <p class="mb-0 small text-white-50" style="font-size: 0.8rem;">Personnalisation obligatoire du mot de passe</p>
            </div>

            <div class="card-body p-4">
                <form id="passwordForm" action="/changer-mot-de-passe-initial/update" method="POST">
                    
                    <!-- Messages flash backend -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div id="backendError" class="alert-custom-error mb-3 d-flex align-items-center">
                            <i class="bi bi-circle-fill text-danger me-2" style="font-size: 7px;"></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div id="backendSuccess" class="alert-custom-success mb-3 d-flex align-items-center">
                            <i class="bi bi-circle-fill text-success me-2" style="font-size: 7px;"></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Alerte dynamique Frontend (5 secondes) -->
                    <div id="alertBox" class="d-none mb-3 d-flex align-items-center">
                        <i id="alertDot" class="bi bi-circle-fill text-danger me-2" style="font-size: 7px;"></i>
                        <span id="alertText"></span>
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div class="mb-3">
                        <label for="nouveau_password" class="form-label">Nouveau mot de passe</label>
                        <div class="password-container">
                            <input type="password" class="form-control py-2" id="nouveau_password" name="nouveau_motdepasse" required placeholder="Min. 8 caractères">
                            <i class="bi bi-eye-slash password-toggle-icon" onclick="togglePassword('nouveau_password', this)"></i>
                        </div>
                    </div>

                    <!-- Confirmer le mot de passe -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                        <div class="password-container">
                            <input type="password" class="form-control py-2" id="confirm_password" name="confirm_motdepasse" required placeholder="Répéter le mot de passe">
                            <i class="bi bi-eye-slash password-toggle-icon" onclick="togglePassword('confirm_password', this)"></i>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success-custom text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-check me-2"></i> Enregistrer et accéder au système
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Scripts JavaScript pour l'œil et la gestion des alertes (5 secondes) -->
    <script>
        function togglePassword(inputId, iconElement) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);

            iconElement.classList.toggle('bi-eye');
            iconElement.classList.toggle('bi-eye-slash');
        }

        function showAlert(message, type = 'error') {
            const alertBox = document.getElementById('alertBox');
            const alertText = document.getElementById('alertText');
            const alertDot = document.getElementById('alertDot');

            alertText.textContent = message;
            alertBox.className = type === 'error' ? 'alert-custom-error mb-3 d-flex align-items-center' : 'alert-custom-success mb-3 d-flex align-items-center';
            alertDot.className = type === 'error' ? 'bi bi-circle-fill text-danger me-2' : 'bi bi-circle-fill text-success me-2';

            setTimeout(() => {
                alertBox.className = 'd-none';
            }, 5000);
        }

        // Disparition automatique des messages flash backend après 5 secondes
        window.addEventListener('DOMContentLoaded', () => {
            const backendError = document.getElementById('backendError');
            const backendSuccess = document.getElementById('backendSuccess');

            if (backendError) {
                setTimeout(() => { backendError.style.display = 'none'; }, 5000);
            }
            if (backendSuccess) {
                setTimeout(() => { backendSuccess.style.display = 'none'; }, 5000);
            }
        });

        // Validation front-end lors de la soumission
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const pass = document.getElementById('nouveau_password').value;
            const confirm = document.getElementById('confirm_password').value;

            if (pass.length < 8) {
                e.preventDefault();
                showAlert('Le mot de passe doit comporter au moins 8 caractères.', 'error');
                return;
            }

            if (pass !== confirm) {
                e.preventDefault();
                showAlert('Les deux mots de passe ne correspondent pas.', 'error');
                return;
            }
        });
    </script>
</body>
</html>